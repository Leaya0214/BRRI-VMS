<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Section;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function employeeProfile()
    {
        try {
            $employee = Auth::guard('employeeapi')->user();

            $employee_data = [
                'name' => $employee->name,
                'email' => $employee->email,
                'mobile_no' => $employee->mobile_no,
                'designation_id' => $employee->designation_id,
                'designation' => $employee->designation->name,
                'section_id' => $employee->section_id,
                'section' => $employee->section->section_name,
                'office_id' => $employee->office_id,
                'nid' => $employee->nid,
                'joining_date' => $employee->joining_date,
                'prl_date' => $employee->prl_date,
                'blood_group' => $employee->blood_group,
                'role' => $employee->role,
                'image' => $employee->image != null ? url('employee/' . $employee->image) : '',
                'signature' => $employee->signature != null ? url('employee/' . $employee->signature) : '',
                'status' => $employee->status,
            ];

            return response()->json([
                'status' => 200,
                'data' => [
                    'employee' => $employee_data,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                "message" => "Something went wrong!",
                "error" => $e->getMessage(),
            ], 400);
        }
        // dd($employee);
    }

    public function updateProfileImage(Request $request)
    {
        $auth = Auth::guard('employeeapi')->user();
        $employee = Employee::find($auth->id); 

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (!empty($employee->image)) {
                $oldImagePath = public_path($employee->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $newImageName = 'employee_' . uniqid() . '.' . $extension;
            $request->image->move(public_path('employee/'), $newImageName);
            $employee->image = $newImageName;
            $employee->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image updated successfully!',
                'profile_image' => url('employee/' . $employee->image), // Return the full URL of the image
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No image file provided.',
        ], 400); // Bad Request
    }

    public function sectionwiseEmployee($id)
    {
        try {
            $info = Employee::where('status', 1)->where('section_id', $id)->get();
            // dd($info);
            $customizedData = $info->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'mobile_no' => $item->mobile_no,
                    // 'license_no' => $item->license_no,
                    'nid' => $item->nid,
                    // 'issue_date' => $item->issue_date,
                    // 'document' => url($item->document),
                ];
            });
            return response()->json([
                'status' => 200,
                'data' => $customizedData,

            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                "message" => "Something went wrong!",
                "error" => $e->getMessage(),
            ], 400);
        }

    }

    public function updateSignature(Request $request)
    {
        $auth = Auth::guard('employeeapi')->user();
        $employee = Employee::find($auth->id); // Retrieve the Eloquent model instance

        if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
            if (!empty($employee->signature)) {
                $oldImagePath = public_path($employee->signature);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('signature');
            $extension = $file->getClientOriginalExtension();
            $newImageName = 'employee_' . uniqid() . '.' . $extension;
            $request->signature->move(public_path('employee/'), $newImageName);
            $employee->signature = $newImageName;
            $employee->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Signature updated successfully!',
                'signature' => url('employee/' . $newImageName), // Return the full URL of the image
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No image file provided.',
        ], 400); // Bad Request
    }

    public function getAllEmployee()
    {
        try {
            $info = Employee::where('status', 1)->get();
            // dd($info);
            $customizedData = $info->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'mobile_no' => $item->mobile_no,
                    // 'license_no' => $item->license_no,
                    'nid' => $item->nid,
                    // 'issue_date' => $item->issue_date,
                    // 'document' => url($item->document),
                ];
            });
            return response()->json([
                'status' => 200,
                'data' => $customizedData,

            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                "message" => "Something went wrong!",
                "error" => $e->getMessage(),
            ], 400);
        }

    }

    public function getAllDivision()
    {
        try {
            $division = Division::get();
            return response()->json([
                'status' => 200,
                'data' => [
                    'division' => $division,
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
    public function getAllSection()
    {
        try {
            $data = Section::get();
            return response()->json([
                'status' => 200,
                'data' => [
                    'division' => $data,
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

    public function divisionwiseDistrict($id)
    {
        try {
            $data = District::where('division_id', $id)->get();
            return response()->json([
                'status' => 200,
                'data' => [
                    'division' => $data,
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

    public function getAllDistrict()
    {
        try {
            $district = District::get();
            return response()->json([
                'status' => 200,
                'data' => [
                    'district' => $district,
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

    public function driverList()
    {
        try {
            $info = Employee::where('status', 1)->whereIn('designation_id', [154, 173])->get();
            // dd($info);
            $customizedData = $info->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'mobile_no' => $item->mobile_no,
                    // 'license_no' => $item->license_no,
                    'nid' => $item->nid,
                    // 'issue_date' => $item->issue_date,
                    // 'document' => url($item->document),
                ];
            });
            return response()->json([
                'status' => 200,
                'data' => $customizedData,

            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                "message" => "Something went wrong!",
                "error" => $e->getMessage(),
            ], 400);
        }
    }

    public function vehicleList()
    {
        try {
            $info = Vehicle::with('typef')->where('vchl_status', 1)->get();
            $customizedData = $info->map(function ($item) {
                return [
                    'id' => $item->id,
                    'model' => $item->vchl_model,
                    'model_year' => $item->model_year,
                    'type_id' => $item->type_id,
                    'vehicle_type' => $item->typef->vehicle_type,
                ];
            });
            return response()->json([
                'status' => 200,
                'data' => $customizedData,

            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                "message" => "Something went wrong!",
                "error" => $e->getMessage(),
            ], 400);
        }
    }

}
