<?php

namespace App\Http\Controllers\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\RequisitionOtherEmployee;
use App\Models\Section;
use App\Models\Vehicle;
use App\Models\VehicleAssign;
use App\Models\VehicleRequisition;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleRequisitionController extends Controller
{
    public function requisitionFrom()
    {
        $data = [];
        $data['main_menu'] = 'vehicle-requisition';
        $data['child_menu'] = 'vehicle-requisition-form';
        $data['division'] = Division::all();
        $data['district'] = District::all();
        $data['vehicle_type'] = VehicleType::all();
        $data['employee'] = Employee::where('status', 1)->get();
        $data['section'] = Section::where('section_status', 1)->get();

        return view('vehicle_requisition.vehicle_requisition_form', $data);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'applicant_type' => 'required|in:সরকারি,বেসরকারি',
            'usage_date' => 'required|date',
            'requisition_date' => 'required|date',
            'from_time' => 'nullable|date_format:H:i',
            'to_time' => 'nullable|date_format:H:i',
            'district_id' => 'required|exists:districts,id', // assumes a 'districts' table exists
            // 'total_miles' => 'nullable|string|max:255',
            'expense_type' => 'nullable|string|max:255',
            'name_of_project' => 'nullable|string|max:255',
            'type_id' => 'required|exists:vehicle_types,id', // assumes a 'types' table exists
            // 'number_of_passenger' => 'nullable|integer|min:1',
            'purpose' => 'nullable|string',
        ]);

        $other_employee_id = $request->other_employee_id;
        // dd($other_employee);

        // dd($validatedData);

        // try {
        $employee = Employee::where('id', session()->get('employee_id'))->first();
        $forward_status = 1;
        $district = District::where('id', $validatedData['district_id'])->first();

        if ($employee && $employee->is_head == 1) {
            // $district = District::where('id', $requisition->district_id)->first();
            if ($district && $district->is_required == 1) {
                $forward_status = 2;
            } else {
                $forward_status = 3;
            }
        }

        if ($employee && $employee->role == 'Director' || $employee->role == 'DGM') {

            $forward_status = 4;
        }

        $requisition = new VehicleRequisition;
        $requisition->applicant_type = $validatedData['applicant_type'];
        $requisition->usage_date = $validatedData['usage_date'];
        $requisition->requisition_date = $validatedData['requisition_date'];
        $requisition->from_time = $validatedData['from_time'];
        $requisition->to_time = $validatedData['to_time'];
        $requisition->employee_id = session()->get('employee_id');
        $requisition->district_id = $validatedData['district_id'];
        $requisition->total_miles = $request->total_miles;
        $requisition->expense_type = $validatedData['expense_type'];
        $requisition->name_of_project = $validatedData['name_of_project'];
        $requisition->type_id = $validatedData['type_id'];
        $requisition->number_of_passenger = $request->number_of_passenger;
        $requisition->purpose = $validatedData['purpose'];
        $requisition->note = $request->note;
        $requisition->forward_status = $forward_status; // default value if null
        $requisition->status = 1; // default value if null

        $requisition->save();

        if (count($other_employee_id) > 0) {
            foreach ($other_employee_id as $employee_id) {
                RequisitionOtherEmployee::create([
                    'requisition_id' => $requisition->id,
                    'employee_id' => $employee_id,
                ]);
            }
        }

        return redirect()->back()
            ->with('status', 'অনুরোধ সফলভাবে তৈরি করা হয়েছে।');

        // } catch (\Exception $e) {
        //     // Log the error for debugging
        //     \Log::error('Failed to create requisition: ' . $e->getMessage());

        //     // Return an error response
        //     return redirect()->back()
        //         ->with('error', 'Failed to create requisition. Please try again later.');
        // }
    }

    public function requisitionShow(Request $request)
    {

    }

    public function requisitionEdit()
    {

    }

    public function employeeReequisitionList()
    {
        $data = [];
        $data['main_menu']    = 'vehicle-requisition';
        $data['child_menu']   = 'vehicle-requisition-list';
        $data['vehicle_type'] = VehicleType::all();
        $data['district'] = District::all();
        $data['employee'] = Employee::where('status', 1)->get();
        $data['requisitions'] = VehicleRequisition::where('employee_id', session()->get('employee_id'))->paginate(10);

        return view('vehicle_requisition.vehicle_reqisition_list', $data);

    }

    public function allEmployeeRequisitionList(Request $request)
    {
        $data = [];
        $data['main_menu'] = 'vehicle-requisition';
        $data['child_menu'] = 'all-vehicle-requisition-list';
        $data['district'] = District::all();
        $data['employee'] = Employee::where('status', 1)->get();
        $data['vehicle_type'] = VehicleType::all();

        $query = VehicleRequisition::query();

        if ($request->employee_id && $request->employee_id !== 'all') {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->district_id && $request->district_id !== 'all') {
            $query->where('district_id', $request->district_id);
        }

        if ($request->forward_status) {
            $query->where('forward_status', $request->forward_status);
        }

        if ($request->from_date) {
            $query->whereDate('requisition_date', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('requisition_date', '<=', $request->to_date);
        }

        // Paginate or get results
        $data['requisitions']  = $query->paginate(10);

        // $data['requisitions'] = VehicleRequisition::where('status', 1)->paginate(10);

        return view('vehicle_requisition.all_vehicle_requisition_list', $data);

    }

    public function employeeRequisitionTOHead()
    {
        $data = [];
        $data['main_menu'] = 'vehicle-requisition';
        $data['child_menu'] = 'director-vehicle-requisition-list';
        $data['district'] = District::all();
        $data['vehicle_type'] = VehicleType::all();
        $data['requisitions'] = VehicleRequisition::where('forward_status', 1)->paginate(10);

        return view('vehicle_requisition.head_vehicle_requisition_list', $data);
    }

    public function employeeRequisitionTOdirector()
    {
        $data = [];
        $data['main_menu'] = 'vehicle-requisition';
        $data['child_menu'] = 'director-vehicle-requisition-list';
        $data['district'] = District::all();
        $data['vehicle_type'] = VehicleType::all();
        $data['requisitions'] = VehicleRequisition::where('forward_status', 2)->paginate(10);

        return view('vehicle_requisition.director_vehicle_requisition_list', $data);
    }
    public function employeeRequisitionToDGM()
    {
        $data = [];
        $data['main_menu'] = 'vehicle-requisition';
        $data['child_menu'] = 'director-vehicle-requisition-list';
        $data['district'] = District::all();
        $data['vehicle_type'] = VehicleType::all();
        $data['requisitions'] = VehicleRequisition::where('forward_status', 3)->paginate(10);

        return view('vehicle_requisition.dgm_vehicle_requisition_list', $data);
    }
    public function employeeRequisitionTSO()
    {
        $data = [];
        $data['main_menu'] = 'vehicle-requisition';
        $data['child_menu'] = 'director-vehicle-requisition-list';
        $data['district'] = District::all();
        $data['vehicle_type'] = VehicleType::all();
        $data['requisitions'] = VehicleRequisition::whereIn('forward_status', [4, 5])->paginate(10);

        return view('vehicle_requisition.tso_vehicle_requisition_list', $data);
    }

    public function load_requisition_view($id)
    {
        $data['requisition'] = VehicleRequisition::with('employee', 'type', 'district')->find($id);
        return view('vehicle_requisition.view_requisition', $data);
    }

    public function forwardRequisition($id)
    {
        $requisition = VehicleRequisition::find($id);

        $district = District::where('id', $requisition->district_id)->first();

        if ($requisition->forward_status == 1) {
            $forward_status = 1;
            if ($district->is_required == 1) {
                $forward_status = 2;
            } else {
                $forward_status = 3;
            }
            $requisition->update([
                'forward_status' => $forward_status,
                'approved_date' => date('d/m/Y'),
                'dept_head_id' => session()->get('employee_id'),
            ]);

            return redirect()->back()
                ->with('status', 'অনুরোধ ফরোয়ার্ড সফলভাবে সম্পন্ন হয়েছে.');

        } else if ($requisition->forward_status == 2 || $requisition->forward_status == 3) {
            $requisition->update([
                'forward_status' => 4,
                'dr_approve_date' => date('d/m/Y'),
            ]);

            return redirect()->back()
                ->with('status', 'অনুরোধটি সফলভাবে TSO-তে ফরোয়ার্ড করা হয়েছে।');

        }

    }

    public function vehicleAssignForm($requistion_id)
    {
        $data['requisition'] = VehicleRequisition::find($requistion_id);
        $data['vehicles'] = Vehicle::where('type_id', $data['requisition']->type_id)->get();
        $data['drivers'] = Employee::with('section', 'designation')->whereIn('designation_id', [125, 154, 173])->paginate(40);
        return view('vehicle_requisition.requisition_vehicle_assign', $data);
    }

    public function assignVehicle(Request $request, $id)
    {

        $requisition = VehicleRequisition::findOrFail($id);
        if ($requisition->forward_status !== 4) {
            return response()->json(['error' => 'Requisition is not approved for vehicle assignment'], 400);
        }

        // $vehicle = Vehicle::findOrFail($request->vehicle_id);
        // if ($vehicle->status !== 'available') {
        //     return response()->json(['error' => 'Vehicle is not available for assignment'], 400);
        // }

        // Step 4: Create the vehicle assignment record

        $requisition = VehicleRequisition::with('employee')->where('id', $id)->first();
        $driver = Employee::where('id', $request->driver_id)->first();

        $employee_mobile_no = $requisition->employee ? $requisition->employee->mobile_no : '';
        $driver_mobile_no = $driver ? $driver->mobile_no : '';

        $emp_message = 'Hi there!';
        $driver_message = 'Hi there!';


        $convertedEmpNumber = convertToEnglishNumbers($employee_mobile_no);
        $convertedDriverNumber = convertToEnglishNumbers($driver_mobile_no);
        // dd($convertedEmpNumber);

        // echo $convertedNumber;

        $assignment = VehicleAssign::create([
            'requisition_id' => $id,
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => $request->driver_id,
            'assign_date' => $request->assignment_date,
            'assigned_by' => session()->get('employee_id'),
            'status' => 1,
            // 'remarks' => $request->remarks,
        ]);

        if ($convertedEmpNumber) {
            send_bl_sms($convertedEmpNumber, $emp_message);

        }

        if ($convertedDriverNumber) {
            send_bl_sms($convertedDriverNumber, $driver_message);
        }

        $requisition->update(['assign_status' => 1]);
    }

    public function rejectRequisition($id)
    {
        $requisition = VehicleRequisition::find($id);

        if (!$requisition) {
            return response()->json(['message' => 'Requisition not found.'], 404);
        }

        if ($requisition->forward_status === 5) {
            return response()->json(['message' => 'Requisition is already rejected.'], 400);
        }

        $requisition->forward_status = 5;
        $requisition->save();

        return redirect()->back()
    ->with('status', 'অনুরোধ প্রত্যাখ্যান করা হল ');

    }

}
