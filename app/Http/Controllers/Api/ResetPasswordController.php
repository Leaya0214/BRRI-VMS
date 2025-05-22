<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{

    public function requestOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:employees,email']);

        $otp = random_int(1000, 9999);

        Session::put('otp', $otp);
        Session::put('otp_email', $request->email);

        $to = $request->email;
        $subject = "Password Reset OTP";
        $message = "Your OTP for password reset is: $otp";
        $headers = "From: info@brrivms.softwaresale.xyz" . "\r\n" .
                "Reply-To: info@brrivms.softwaresale.xyz" . "\r\n" .
                "Content-Type: text/plain; charset=UTF-8";

        // Step 5: Send the email and capture the result
        $mailSent = mail($to, $subject, $message, $headers);

        // Check if the email was sent
        if ($mailSent) {
            return response()->json(['message' => 'OTP has been sent to your email.'], 200);
        } else {
            return response()->json(['error' => 'Failed to send OTP. Please check your server configuration or try again later.'], 500);
        }

        // Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($request) {
        //     $message->to($request->email)
        //         ->subject('Password Reset OTP');
        // });

        // return response()->json(['message' => 'OTP has been sent to your email.'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = Session::get('otp_email');
        $sessionOtp = Session::get('otp');

        if ($request->otp != $sessionOtp) {
            return response()->json(['error' => 'Invalid OTP.'], 400);
        }

        $employee = Employee::where('email', $email)->first();
        if ($employee) {
            $employee->password = Hash::make($request->password);
            $employee->save();

            Session::forget('otp');
            Session::forget('otp_email');

            return response()->json(['message' => 'Password has been reset successfully.'], 200);
        }

        return response()->json(['error' => 'Employee not found.'], 404);
    }

}
