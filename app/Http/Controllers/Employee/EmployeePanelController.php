<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Notice;
use App\Models\VehicleRequisition;
use Illuminate\Support\Facades\Session;

class EmployeePanelController extends Controller
{
    public function profile()
    {
        $user_id = session()->get('employee_id');
        $user = Employee::with('designation', 'section')->where('id', $user_id)->first();
        $total_requisition = VehicleRequisition::where('employee_id', $user_id)->count();
        $total_approved_requisition = VehicleRequisition::where('employee_id', $user_id)->where('assign_status', 1)->count();
        $total_rejected_requisition = VehicleRequisition::where('employee_id', $user_id)->where('forward_status', 5)->count();
        $total_notice = Notice::count();
        return view('employee_home', compact('user', 'total_requisition', 'total_approved_requisition', 'total_rejected_requisition', 'total_notice'));
    }
}
