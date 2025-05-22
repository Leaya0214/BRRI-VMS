<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Employee;
use App\Models\RequisitionOtherEmployee;
use App\Models\VehicleAssign;
use App\Models\VehicleRequisition;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf as Pdf ;
use Illuminate\Support\ViewErrorBag;

class VehicleController extends Controller
{
    public function vehicleType()
    {
        try {
            $types = VehicleType::get();
            return response()->json([
                'status' => 200,
                'data' => [
                    'type' => $types,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                "message" => "Something went wrong!",
                "error" => $e->getMessage(),
            ], 400);
        }
    }

    public function submitRequisition(Request $request)
    {
        $employee = Auth::guard('employeeapi')->user();
        // dd($employee);

        // dd($request->applicant_type);
        $applicant_type = $request->applicant_type ?? '';
        $usage_date = $request->usage_date ?? '';
        $requisition_date = $request->requisition_date ?? '';
        $district_id = $request->district_id ?? '';
        $from_location = $request->from_location ?? '';
        $to_location = $request->to_location ?? '';
        $from_time = $request->from_time ?? '';
        $to_time = $request->to_time ?? '';
        $total_miles = $request->total_miles ?? '';
        $expense_type = $request->expense_type ?? '';
        $type_id = $request->type_id ?? 0;
        $name_of_project = $request->name_of_project ?? '';
        $number_of_passenger = $request->number_of_passenger ?? '';
        $purpose = $request->purpose ?? '';
        $note = $request->note ?? '';
        $forward_status = 1;

        $other_employee_id = $request->other_employee_id;
        // dd($other_employee_id);

        if ($employee && $employee->is_head == 1) {

            $district = District::where('id', $district_id)->first();
            if ($district && $district->is_required == 1) {
                $forward_status = 2;
            } else {
                $forward_status = 3;
            }
        }

        if ($employee && $employee->role == 'Director' || $employee->role == 'DGM') {

            $forward_status = 4;
        }

        $storeData = [
            'applicant_type' => $applicant_type,
            'usage_date' => $usage_date,
            'requisition_date' => $requisition_date,
            'from_time' => $from_time,
            'to_time' => $to_time,
            'employee_id' => $employee->id,
            'district_id' => $district_id,
            'from_location' => $from_location,
            'to_location' => $to_location,
            'total_miles' => $total_miles,
            'expense_type' => $expense_type,
            'name_of_project' => $name_of_project,
            'type_id' => $type_id,
            'number_of_passenger' => $number_of_passenger,
            'purpose' => $purpose,
            'note' => $note,
            'forward_status' => $forward_status,
            'status' => 1,

        ];

        // dd($storeData);

        $requisition = VehicleRequisition::create($storeData);

        if (count($other_employee_id) > 0) {
            foreach ($other_employee_id as $employee_id) {
                RequisitionOtherEmployee::create([
                    'requisition_id' => $requisition->id,
                    'employee_id' => $employee_id,
                ]);
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Requisition created successfully!',
            'data' => $requisition,
        ], 201);
    }

    public function showEmployeeRequisitionList()
    {
        $employee = Auth::guard('employeeapi')->user();

        $requisition = VehicleRequisition::where('employee_id', $employee->id)->with(['district', 'type', 'employee'])->get();

        if (!$requisition) {
            return response()->json(['message' => 'Requisition not found'], 404);
        }

        $customizedData = $requisition->map(function ($item) {
            $otherEmployee = "";
            if ($item->other_employee) {
                $others = $item->other_employee;
                $otherEmployee = $others->map(function ($info) {
                    return [
                        'employee_name' => $info->employee->name,
                        'division' => $info->employee->section->section_name,
                        'designation' => $info->employee->designation->name,
                    ];
                });
            }

            // dd($item->assign);

            return [
                'id' => $item->id,
                'applicant_type' => $item->applicant_type,
                'usage_date' => Carbon::parse($item->usage_date)->format('d/m/Y'),
                'requisition_date' => Carbon::parse($item->requisition_date)->format('d/m/Y'),
                'from_time' => $item->from_time,
                'to_time' => $item->to_time,
                'district_id' => $item->district_id,
                'district_name' => $item->district->name,
                'to_location' => $item->to_location,
                'total_miles' => $item->total_miles,
                'expense_type' => $item->expense_type,
                'name_of_project' => $item->name_of_project,
                'type_id' => $item->type_id,
                'vehicle_type' => $item->type->vehicle_type,
                'number_of_passenger' => $item->number_of_passenger,
                'employee_name' => $item->employee->name,
                'forward_status' => $item->forward_status,
                'dept_head_signature' => $item->head ? ($item->head->signature ? url('employee/' . $item->head->signature) : null) : null,
                'approved_date' => $item->approved_date,
                'assign_status' => $item->assign_status,
                'vehicle_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->vehicle->vchl_model : '',
                'plate_no' => ($item->assign && $item->assign_status == 1) ? $item->assign->vehicle->chassis_no : '',
                'driver_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->name : '',
                'driver_mobile_no' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->mobile_no : '',
                'driver_designation' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->designation->name : '',
                'tso_signature' => ($item->assign && $item->assign_status == 1 && $item->assign->assign_admin && $item->assign->assign_admin->signature)
                ? url('employee/' . $item->assign->assign_admin->signature)
                : '',
                'assign_date' => ($item->assign && $item->assign_status == 1) ? $item->assign->assign_date : '',
                'status' => $item->status,
                'purpose' => $item->purpose,
                'note' => $item->note,
                'other_employee' => $otherEmployee,

            ];
        });

        return response()->json([
            'status' => 200,
            'data' => $customizedData,
        ], 201);
    }

    public function staffRequisitionAtDeptHead()
    {
        $employee = Auth::guard('employeeapi')->user();
        if ($employee && $employee->is_head == 1) {
            $requisition = VehicleRequisition::where('forward_status', 1)
                ->whereHas('employee', function ($query) use ($employee) {
                    $query->where('section_id', $employee->section_id);
                })
                ->with(['district', 'type', 'employee'])->get();

            // dd($requisition);

            $customizedData = $requisition->map(function ($item) {
                $otherEmployee = "";
                if ($item->other_employee) {
                    $others = $item->other_employee;
                    $otherEmployee = $others->map(function ($info) {
                        return [
                            'employee_name' => $info->employee->name,
                            'division' => $info->employee->section->section_name,
                            'designation' => $info->employee->designation->name,
                        ];
                    });
                }

                return [
                    'id' => $item->id,
                    'applicant_type' => $item->applicant_type,
                    'usage_date' => Carbon::parse($item->usage_date)->format('d/m/Y'),
                    'requisition_date' => Carbon::parse($item->requisition_date)->format('d/m/Y'),
                    'from_time' => $item->from_time,
                    'to_time' => $item->to_time,
                    'district_id' => $item->district_id,
                    'district_name' => $item->district->name,
                    'to_location' => $item->to_location,
                    'total_miles' => $item->total_miles,
                    'expense_type' => $item->expense_type,
                    'name_of_project' => $item->name_of_project,
                    'type_id' => $item->type_id,
                    'vehicle_type' => $item->type->vehicle_type,
                    'number_of_passenger' => $item->number_of_passenger,
                    'employee_name' => $item->employee->name,
                    'forward_status' => $item->forward_status,
                    'dept_head_signature' => $item->head ? ($item->head->signature ? url('employee/' . $item->head->signature) : null) : null,
                    'approved_date' => $item->approved_date,
                    'assign_status' => $item->assign_status,
                    'vehicle_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->vehicle->vchl_model : '',
                    'driver_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->name : '',
                    'tso_signature' => ($item->assign && $item->assign_status == 1 && $item->assign->assign_admin && $item->assign->assign_admin->signature)
                    ? url('employee/' . $item->assign->assign_admin->signature)
                    : '',
                    'assign_date' => ($item->assign && $item->assign_status == 1) ? $item->assign->assign_date : '',
                    'status' => $item->status,
                    'purpose' => $item->purpose,
                    'note' => $item->note,
                    'other_employee' => $otherEmployee,

                ];
            });

            return response()->json([
                'status' => 200,
                'data' => $customizedData,
            ], 201);
        }
    }

    public function staffRequisitionAtDirector()
    {
        $employee = Auth::guard('employeeapi')->user();

        if ($employee) {
            $requisition = VehicleRequisition::where('forward_status', 2)->with(['district', 'type', 'employee'])->get();

            if (!$requisition) {
                return response()->json(['message' => 'Requisition not found'], 404);
            }

            $customizedData = $requisition->map(function ($item) {
                $otherEmployee = "";
                if ($item->other_employee) {
                    $others = $item->other_employee;
                    $otherEmployee = $others->map(function ($info) {
                        return [
                            'employee_name' => $info->employee->name,
                            'division' => $info->employee->section->section_name,
                            'designation' => $info->employee->designation->name,
                        ];
                    });
                }

                return [
                    'id' => $item->id,
                    'applicant_type' => $item->applicant_type,
                    'usage_date' => Carbon::parse($item->usage_date)->format('d/m/Y'),
                    'requisition_date' => Carbon::parse($item->requisition_date)->format('d/m/Y'),
                    'from_time' => $item->from_time,
                    'to_time' => $item->to_time,
                    'district_id' => $item->district_id,
                    'district_name' => $item->district->name,
                    'to_location' => $item->to_location,
                    'total_miles' => $item->total_miles,
                    'expense_type' => $item->expense_type,
                    'name_of_project' => $item->name_of_project,
                    'type_id' => $item->type_id,
                    'vehicle_type' => $item->type->vehicle_type,
                    'number_of_passenger' => $item->number_of_passenger,
                    'employee_name' => $item->employee->name,
                    'forward_status' => $item->forward_status,
                    'dept_head_signature' => $item->head ? ($item->head->signature ? url('employee/' . $item->head->signature) : null) : null,
                    'approved_date' => $item->approved_date,
                    'assign_status' => $item->assign_status,
                    // 'vehicle_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->vehicle->vchl_model : '',
                    // 'driver_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->name : '',
                    // 'tso_signature' => ($item->assign && $item->assign_status == 1 && $item->assign->assign_admin && $item->assign->assign_admin->signature)
                    // ? url('employee/' . $item->assign->assign_admin->signature)
                    // : '',
                    // 'assign_date' => ($item->assign && $item->assign_status == 1) ? $item->assign->assign_date : '',
                    'status' => $item->status,
                    'purpose' => $item->purpose,
                    'note' => $item->note,
                    'other_employee' => $otherEmployee,

                ];
            });

            return response()->json([
                'status' => 200,
                'data' => $customizedData,
            ], 201);

        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Please Login First',
            ], 201);

        }

    }
    public function staffRequisitionAtDGM()
    {
        $employee = Auth::guard('employeeapi')->user();

        if ($employee) {
            $requisition = VehicleRequisition::where('forward_status', 3)->with(['district', 'type', 'employee'])->get();

            if (!$requisition) {
                return response()->json(['message' => 'Requisition not found'], 404);
            }

            $customizedData = $requisition->map(function ($item) {
                $otherEmployee = "";
                if ($item->other_employee) {
                    $others = $item->other_employee;
                    $otherEmployee = $others->map(function ($info) {
                        return [
                            'employee_name' => $info->employee->name,
                            'division' => $info->employee->section->section_name,
                            'designation' => $info->employee->designation->name,
                        ];
                    });
                }

                return [
                    'id' => $item->id,
                    'applicant_type' => $item->applicant_type,
                    'usage_date' => Carbon::parse($item->usage_date)->format('d/m/Y'),
                    'requisition_date' => Carbon::parse($item->requisition_date)->format('d/m/Y'),
                    'from_time' => $item->from_time,
                    'to_time' => $item->to_time,
                    'district_id' => $item->district_id,
                    'district_name' => $item->district->name,
                    'to_location' => $item->to_location,
                    'total_miles' => $item->total_miles,
                    'expense_type' => $item->expense_type,
                    'name_of_project' => $item->name_of_project,
                    'type_id' => $item->type_id,
                    'vehicle_type' => $item->type->vehicle_type,
                    'number_of_passenger' => $item->number_of_passenger,
                    'employee_name' => $item->employee->name,
                    'forward_status' => $item->forward_status,
                    'dept_head_signature' => $item->head ? ($item->head->signature ? url('employee/' . $item->head->signature) : null) : null,
                    'approved_date' => $item->approved_date,
                    'assign_status' => $item->assign_status,
                    // 'vehicle_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->vehicle->vchl_model : '',
                    // 'driver_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->name : '',
                    // 'tso_signature' => ($item->assign && $item->assign_status == 1 && $item->assign->assign_admin && $item->assign->assign_admin->signature)
                    // ? url('employee/' . $item->assign->assign_admin->signature)
                    // : '',
                    // 'assign_date' => ($item->assign && $item->assign_status == 1) ? $item->assign->assign_date : '',
                    'status' => $item->status,
                    'purpose' => $item->purpose,
                    'note' => $item->note,
                    'other_employee' => $otherEmployee,

                ];
            });

            return response()->json([
                'status' => 200,
                'data' => $customizedData,
            ], 201);

        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Please Login First',
            ], 201);

        }

    }

    public function staffRequisitionAtTSO()
    {
        $employee = Auth::guard('employeeapi')->user();

        $requisition = VehicleRequisition::whereIn('forward_status', [4, 5])->with(['district', 'type', 'employee'])->get();

        if (!$requisition) {
            return response()->json(['message' => 'Requisition not found'], 404);
        }

        $customizedData = $requisition->map(function ($item) {
            $otherEmployee = "";
            if ($item->other_employee) {
                $others = $item->other_employee;
                $otherEmployee = $others->map(function ($info) {
                    return [
                        'employee_name' => $info->employee->name,
                        'division' => $info->employee->section->section_name,
                        'designation' => $info->employee->designation->name,
                    ];
                });
            }

            return [
                'id' => $item->id,
                'applicant_type' => $item->applicant_type,
                'usage_date' => Carbon::parse($item->usage_date)->format('d/m/Y'),
                'requisition_date' => Carbon::parse($item->requisition_date)->format('d/m/Y'),
                'from_time' => $item->from_time,
                'to_time' => $item->to_time,
                'district_id' => $item->district_id,
                'district_name' => $item->district->name,
                'to_location' => $item->to_location,
                'total_miles' => $item->total_miles,
                'expense_type' => $item->expense_type,
                'name_of_project' => $item->name_of_project,
                'type_id' => $item->type_id,
                'vehicle_type' => $item->type->vehicle_type,
                'number_of_passenger' => $item->number_of_passenger,
                'employee_name' => $item->employee->name,
                'forward_status' => $item->forward_status,
                'dept_head_signature' => $item->head ? ($item->head->signature ? url('employee/' . $item->head->signature) : null) : null,
                'approved_date' => $item->approved_date,
                'assign_status' => $item->assign_status,
                'vehicle_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->vehicle->vchl_model : '',
                'plate_no' => ($item->assign && $item->assign_status == 1) ? $item->assign->vehicle->chassis_no : '',
                'driver_name' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->name : '',
                'driver_mobile_no' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->mobile_no : '',
                'driver_designation' => ($item->assign && $item->assign_status == 1) ? $item->assign->driver->designation->name : '',
                'tso_signature' => ($item->assign && $item->assign_status == 1 && $item->assign->assign_admin && $item->assign->assign_admin->signature)
                ? url('employee/' . $item->assign->assign_admin->signature)
                : '',
                'assign_date' => ($item->assign && $item->assign_status == 1) ? $item->assign->assign_date : '',
                'status' => $item->status,
                'purpose' => $item->purpose,
                'note' => $item->note,
                'other_employee' => $otherEmployee,

            ];
        });

        return response()->json([
            'status' => 200,
            'data' => $customizedData,
        ], 201);
    }

    public function forwardToDgOrDir(Request $request)
    {
        $employee = Auth::guard('employeeapi')->user();
        $id = $request->requisition_id;
        $approve_date = $request->approve_date;
        $requisition = VehicleRequisition::findOrFail($id);
        $district = District::where('id', $requisition->district_id)->first();
        $forward_status = 1;

        if ($district && $district->is_required == 1) {
            $forward_status = 2;
        } else {
            $forward_status = 3;
        }

        if ($employee && $employee->is_head == 1) {
            $requisition->update([
                'forward_status' => $forward_status,
                'approved_date' => $approve_date,
                'dept_head_id' => $employee->id,
            ]);

            if ($forward_status == 2) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Requisition Forwarded Successfully To Director',
                ], 200);
            }

            if ($forward_status == 3) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Requisition Forwarded Successfully To DG',
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                "message" => "Something Went Wrong!",
            ], 400);
        }
    }

    public function forward(Request $request)
    {
        $employee = Auth::guard('employeeapi')->user();
        $id = $request->requisition_id;
        $approve_date = $request->approve_date;
        $forward_status = 1;
        // dd($forward_status);

        $requisition = VehicleRequisition::findOrFail($id);
        $district = District::where('id', $requisition->district_id)->first();

        if ($employee && $employee->role == 'Staff' && $employee->is_head == 1 && $forward_status == 1) {

            $forward_status = 1;
            if ($district && $district->is_required == 1) {
                $forward_status = 2;
            } else {
                $forward_status = 3;
            }

            $requisition->update([
                'forward_status' => $forward_status,
                'approved_date' => $approve_date,
                'dept_head_id' => $employee->id,
            ]);

            if ($forward_status == 2) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Requisition Forwarded Successfully To Director',
                ], 200);
            }

            if ($forward_status == 3) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Requisition Forwarded Successfully To DG',
                ], 200);
            }
        }

        if ($employee && $employee->role == 'Director') {
            $requisition->update([
                'forward_status' => 4,
                'dr_approve_date' => $approve_date,
            ]);
            // $requisition->save();

            return response()->json([
                'status' => 200,
                'message' => 'Requisition Forwarded Successfully to TSO',
            ], 200);

        }
        if ($employee && $employee->role == 'DGM') {
            // dd($employee);
            $requisition->update([
                'forward_status' => 4,
                'dr_approve_date' => $approve_date,
            ]);
            // $requisition->save();
            return response()->json([
                'status' => 200,
                'message' => 'Requisition Forwarded Successfully to TSO',
            ], 200);
        }
        // Return a response
    }

    public function approvedByTSO(Request $request)
    {
        $employee = Auth::guard('employeeapi')->user();
        $id = $request->requisition_id;
        $approve_date = $request->approve_date;
        $forward_status = $request->forward_status;
        $requisition = VehicleRequisition::findOrFail($id);
        if ($employee->role == 'TSO') {
            $requisition->update([
                'forward_status' => $forward_status,
                'approved_date' => $approve_date,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Requisition Approved Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                "message" => "Opps You are not TSO!",
            ], 400);
        }
    }

    public function assignVehicle(Request $request, $id)
    {
        $employee = Auth::guard('employeeapi')->user();
        if ($employee->role == 'TSO') {
            $requisition = VehicleRequisition::findOrFail($id);
            if ($requisition->forward_status !== 4) {
                return response()->json(['error' => 'Requisition is not approved for vehicle assignment'], 400);
            }

            $driver = Employee::where('id', $request->driver_id)->first();

            $employee_mobile_no = $requisition->employee ? $requisition->employee->mobile_no : '';
            $driver_mobile_no = $driver ? $driver->mobile_no : '';

            $emp_message = 'Hi there!';
            $driver_message = 'Hi there!';

            $convertedEmpNumber = convertToEnglishNumbers($employee_mobile_no);
            $convertedDriverNumber = convertToEnglishNumbers($driver_mobile_no);

            $assignment = VehicleAssign::create([
                'requisition_id' => $id,
                'vehicle_id' => $request->vehicle_id,
                'driver_id' => $request->driver_id,
                'assign_date' => $request->assign_date,
                'assigned_by' => $employee->id,
                'status' => 1,
            ]);

            $requisition->update(['assign_status' => 1]);

            if ($convertedEmpNumber) {
                send_bl_sms($convertedEmpNumber, $emp_message);
            }

            if ($convertedDriverNumber) {
                send_bl_sms($convertedDriverNumber, $driver_message);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Vehicle Assign Successfully...',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                "message" => "Opps You are not TSO!",
            ], 400);
        }

    }

    public function rejectRequisition(Request $request)
    {
        $employee = Auth::guard('employeeapi')->user();

        if ($employee) {
            $id = $request->requisition_id;
            $requisition = VehicleRequisition::find($id);

            if (!$requisition) {
                return response()->json(['message' => 'Requisition not found.'], 404);
            }

            if ($requisition->forward_status === 6) {
                return response()->json(['message' => 'Requisition is already rejected.'], 400);
            }

            $requisition->forward_status = 6;
            $requisition->save();

            return response()->json([
                'status' => 200,
                'message' => 'Requisition rejected successfully.',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Please login first',
            ], 400);
        }
    }
    // $requisition->save();

    // public function generatePdfAndSendLink($requisition_id)
    //     {
    //         $requisition = VehicleRequisition::find($requisition_id);

    //         if (!$requisition) {
    //             return response()->json(['message' => 'Requisition not found.'], 404);
    //         }

    //         $data = ['requisition' => $requisition, 'errors' => new ViewErrorBag()];

    //         $pdf = Pdf::loadView('pdf.requisition', $data);

    //         $pdf->setPaper('A4', 'portrait');

    //         $fileName = 'requisition_' . $requisition_id . '.pdf';
    //         $filePath = public_path('pdfs/' . $fileName);

    //         // Ensure the directory exists
    //         if (!file_exists(public_path('pdfs'))) {
    //             mkdir(public_path('pdfs'), 0777, true);
    //         }

    //         $pdf->save($filePath);

    //         $pdfLink = url('pdfs/' . $fileName);

    //         return response()->json([
    //             'status' => 200,
    //             'pdf_link' => $pdfLink
    //         ]);
    //     }

   public function generatePdfAndSendLink($requisition_id)
    {
        $fileName = 'requisition_' . $requisition_id . '_' . time() . '.pdf';
        $filePath = public_path('pdfs/' . $fileName);

        if (file_exists($filePath)) {
            return response()->json([
                'status' => 200,
                'pdf_link' => url('pdfs/' . $fileName),
            ]);
        }

        $requisition = VehicleRequisition::find($requisition_id);

        if (!$requisition) {
            return response()->json(['message' => 'Requisition not found.'], 404);
        }

        $data = ['requisition' => $requisition, 'errors' => new ViewErrorBag()];
        $view = view('pdf.test');

        $mpdf = Pdf::loadView('pdf.test', $data);


        if (!file_exists(public_path('pdfs'))) {
            mkdir(public_path('pdfs'), 0777, true);
        }
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        return response()->json([
            'status' => 200,
            'pdf_link' => url('pdfs/' . $fileName),
        ]);
    }


}
