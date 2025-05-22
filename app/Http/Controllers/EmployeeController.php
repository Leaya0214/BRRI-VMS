<?php
/**
 * Author: Tushar Das
 * Sr. Software Engineer
 * tushar2499@gmail.com
 * 01815920898
 * STITBD
 * 09/10/2021
 */
namespace App\Http\Controllers;

use App\Imports\EmployeeImport;
use App\Models\Company;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $data['main_menu'] = 'employee-management';
        $data['child_menu'] = 'manage-employee';
        $data['company'] = Company::all();
        $data['designation'] = Designation::where('status', 1)->get();
        $data['section'] = Section::where('section_status', 1)->get();
        $data['allEmployee'] = Employee::where('status', 1)->get();

        $employee = Employee::with('section', 'designation')->where('status', 1);

        if ($request->employee != 'all' && $request->employee != null) {
            $data['employee'] = $request->employee;
            $employee->where('id',$request->employee);
        }

        if ($request->section_id != 'all' && $request->section_id != null) {
            $data['section_id'] = $request->section_id;
            $employee->where('section_id',$request->section_id);
        }
        if ($request->designation_id != 'all' && $request->designation_id != null) {
            $data['designation_id'] = $request->designation_id;
            $employee->where('designation_id',$request->designation_id);
        }

        if ($request->section_id != 'all' && $request->section_id != null ||
            $request->designation_id != 'all' && $request->designation_id != null||
            $request->employee != 'all' && $request->employee != null) {
            $data['employee'] = $employee->get();
        } else {
            $data['employee'] = Employee::with('section', 'designation')->paginate(20);
        }
        return view('hrm.employee.manage', $data);
    }

    public function load_employee_view($id)
    {
        $data['employee'] = Employee::with('section', 'designation')->find($id);
        return view('hrm.employee.view', $data);
    }

    public function create()
    {
        $data['main_menu'] = 'hrm';
        $data['child_menu'] = 'employee-create';
        $data['company'] = Company::all();
        $data['designation'] = Designation::all();
        $data['section'] = Section::all();
        return view('hrm.employee.create', $data);
    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'name' => 'required',
            // 'email'                 => 'required',
            'designation_id' => 'required',
            'section_id' => 'required',
            'office_id' => 'required',
            'nid' => 'required',
            // 'joining_date' => 'required',
        ]);

        $model = new Employee();

        if ($request->signature != null) {
            $newImageName = 'employee_' . uniqid() . '.' . $request->signature->extension();
            $request->signature->move(public_path('employee/'), $newImageName);
            $model->signature = $newImageName;
        }
        if ($request->image != null) {
            $imageName = 'employee_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('employee/'), $imageName);
            $model->image = $imageName;
        }

        $model->name = $request->post('name');
        $model->email = $request->post('email');
        $model->password = Hash::make($request->post('password'));
        $model->mobile_no = $request->post('mobile_no');
        $model->opt_mobile_no = $request->post('opt_mobile_no');
        $model->office_id = $request->post('office_id');
        $model->nid = $request->post('nid');
        $model->section_id = $request->post('section_id');
        $model->designation_id = $request->post('designation_id');
        $model->joining_date = $request->post('joining_date');
        $model->prl_date = $request->post('prl_date');
        $model->blood_group = $request->post('blood_group');
        $model->role = $request->post('role');
        $model->is_head = $request->post('is_head') ?? 0;

        $model->created_by = auth()->user()->id;
        $model->save();

        $msg = "Data Created Successfully.";

        return redirect()->back()->with('status', $msg);

    }

    public function edit($id)
    {
        $data['main_menu'] = 'hrm';
        $data['child_menu'] = 'manage-employee';
        $data['company'] = Company::all();
        $data['designation'] = Designation::all();
        $data['section'] = Section::all();
        $data['employee'] = Employee::with('section', 'designation')->find($id);
        return view('hrm.employee.edit', $data);
    }

    public function update(Request $request)
    {
        //dd($request);
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'designation_id' => 'required',
        ]);

        $model = Employee::find($request->post('id'));

        if ($request->signature != null) {
            $newImageName = 'employee_' . uniqid() . '.' . $request->signature->extension();
            $request->signature->move(public_path('employee/'), $newImageName);
            $model->signature = $newImageName;
        } else

        if ($request->image != null) {
            $imageName = 'employee_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('employee/'), $imageName);
            $model->image = $imageName;
        }

        $model->name = $request->post('name');
        $model->email = $request->post('email');
        $model->password = $request->post('password') ? Hash::make($request->post('password')) : $model->password;
        $model->mobile_no = $request->post('mobile_no');
        $model->opt_mobile_no = $request->post('opt_mobile_no');
        $model->office_id = $request->post('office_id');
        $model->nid = $request->post('nid');
        $model->section_id = $request->post('section_id');
        $model->designation_id = $request->post('designation_id');
        $model->joining_date = $request->post('joining_date');
        $model->prl_date = $request->post('prl_date');
        $model->blood_group = $request->post('blood_group');
        $model->role = $request->post('role');
        $model->is_head = $request->post('is_head') ?? 0;

        $model->updated_by = auth()->user()->id;
        $model->save();

        $msg = "Data update.";
        //$request->session()->flash('message',$msg);

        return redirect()->back()->with('status', $msg);
    }

    public function profile($id)
    {
        $data['main_menu'] = 'hrm';
        $data['child_menu'] = 'manage-employee';
        $data['employee'] = Employee::with('section', 'designation')->find($id);
        return view('hrm.employee.profile', $data);
    }

    public function status_update(Request $request, $status = 1, $id = null)
    {

        $model = Employee::find($id);
        $model->status = $status;
        $model->save();

        $msg = "Employee Status Updated.";

        return redirect('manage-employee')->with('status', $msg);
    }

    public function search(Request $request)
    {
        $data = array();
        // if($request->company_id != 'all' && $request->company_id != null){ $data['company_id'] = $request->company_id; }
        // if($request->department_id != 'all' && $request->department_id != null){ $data['department_id'] = $request->department_id; }
        if ($request->section_id != 'all' && $request->section_id != null) {$data['section_id'] = $request->section_id;}
        // if($request->branch_id != 'all' && $request->branch_id != null){ $data['branch_id'] = $request->branch_id; }
        if ($request->designation_id != 'all' && $request->designation_id != null) {$data['designation_id'] = $request->designation_id;}
        // if($request->grade_id != 'all' && $request->grade_id != null){ $data['grade_id'] = $request->grade_id; }
        // if($request->schedule_id != 'all' && $request->schedule_id != null){ $data['schedule_id'] = $request->schedule_id; }
        // if($request->paymnet_type_id != 'all' && $request->paymnet_type_id != null){ $data['paymnet_type_id'] = $request->paymnet_type_id; }
        //var_dump($data); exit;
        $data['employee'] = Employee::with('section', 'designation')->where($data)->get();
        return view('hrm.employee.search', $data);
    }

    public function load_department_by_company_id($company_id)
    {
        if ($company_id != null) {
            $model = Department::where(['company_id' => $company_id])->get();
            if ($model != null) {
                $options = '<option value="">Select One</option>';
                foreach ($model as $item) {
                    $options .= '<option value="' . $item->id . '">' . $item->name . '</option>';
                }
                echo json_encode(['status' => 'success', 'message' => 'Data found', 'data' => $model, 'options' => $options]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'This ID Not Found In DB.']);
            }

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Empty ID']);
        }
    }
    // function load_branch_by_company_id($company_id){
    //     if($company_id != null){
    //         $model = Branch::where(['company_id'=>$company_id])->get();
    //         if($model != null){
    //             $options = '<option value="">Select One</option>';
    //             foreach($model as $item){
    //                 $options .='<option value="'.$item->id.'">'.$item->name.'</option>';
    //             }
    //             echo json_encode(['status'=>'success','message'=>'Data found','data'=>$model,'options'=>$options]);
    //         }
    //         else{
    //             echo json_encode(['status'=>'error','message'=>'This ID Not Found In DB.']);
    //         }

    //     }
    //     else{
    //         echo json_encode(['status'=>'error','message'=>'Empty ID']);
    //     }
    // }

    public function load_section_by_company_id($company_id)
    {
        if ($company_id != null) {
            $model = Section::where(['company_id' => $company_id])->get();
            if ($model != null) {
                $options = '<option value="">Select One</option>';
                foreach ($model as $item) {
                    $options .= '<option value="' . $item->id . '">' . $item->name . '</option>';
                }
                echo json_encode(['status' => 'success', 'message' => 'Data found', 'data' => $model, 'options' => $options]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'This ID Not Found In DB.']);
            }

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Empty ID']);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $data = Excel::toArray(new EmployeeImport, $request->file('file'));

        \Log::info($data);

        Excel::import(new EmployeeImport, $request->file('file'));

        return redirect()->back()->with('success', 'Employees imported successfully.');
    }

    public function driverList()
    {
        $data['main_menu'] = 'employee-management';
        $data['child_menu'] = 'manage-driver';
        $data['company'] = Company::all();
        $data['designation'] = Designation::where('status', 1)->get();
        $data['section'] = Section::where('section_status', 1)->get();
        $data['driver'] = Employee::with('section', 'designation')->whereIn('designation_id', [125, 154, 173])->paginate(40);

        return view('hrm.driver.manage_driver', $data);
    }

    public function createDriver()
    {
        $data['main_menu'] = 'employee-management';
        $data['child_menu'] = 'manage-driver';
        $data['company'] = Company::all();
        $data['designation'] = Designation::all();
        $data['section'] = Section::all();
        return view('hrm.driver.create', $data);
    }

    public function editDriver($id)
    {
        $data['main_menu'] = 'employee-management';
        $data['child_menu'] = 'manage-driver';
        $data['company'] = Company::all();
        $data['designation'] = Designation::all();
        $data['section'] = Section::all();
        $data['employee'] = Employee::with('section', 'designation')->find($id);
        return view('hrm.driver.edit', $data);
    }

}
