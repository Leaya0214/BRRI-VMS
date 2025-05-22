<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CheckUserTypeController extends Controller
{
    public function employeeLogin()
    {
        return view('auth.employee_login');
    }

    public function submitLogin(Request $request)
    {
        // Validate input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // Find the employee by email
        $employee = Employee::where('email', $request->input('email'))->first();

        // Check if employee exists and the password matches
        if ($employee && Hash::check($request->input('password'), $employee->password)) {
            Session::put('employee_id', $employee->id);
            Session::put('employee_name', $employee->name); // optional if you need name
            Session::put('employee_email', $employee->email);
            Session::put('employee_role', $employee->role);
            Session::put('is_head', $employee->is_head);

            return redirect()->route('employee.profile');
        } else {
            // Redirect back with an error message
            return redirect()->route('checkUser')->withErrors(['login_error' => 'Invalid email or password.']);
        }
    }

    public function logout()
    {
        // Clear employee session data
        Session::forget('employee_id');
        return redirect()->route('checkUser')->with('status', 'Logged out successfully.');
    }
}
