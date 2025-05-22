<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
     public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email'=> 'required|email|max:50',
            'password' => 'required',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                "message" => "Invalid Data given",
                "errors" => $validator->getMessageBag()
            ], 422);
        }

        $credentials = [
            'email' => $request->input("email"),
            'password' => $request->input("password"),
        ];
        // $token = Auth::guard('memberapi')->attempt($credentials);
        // dd($token);

        if($token = Auth::guard('employeeapi')->attempt($credentials)){
            // dd($token);
            $employee = Employee::where('id', Auth::guard('employeeapi')->id())->first();

            if ($employee->status == 0) {
                // auth('api')->logout();
                return response()->json([
                    'status' => 401,
                    "message" => "Sorry, you are Deactivated!"
                ], 401);
            }
            return response()->json([
                'status' => 200,
                "message" => "Login successful!",
                "data" => [
                    'role'=> $employee->role,
                    'token' => $token,
                    "employee" => $employee,
                ]

            ], 200);

        }else {
            return response()->json([
                'status' => 401,
                "message" => "Wrong Credentials!",
            ], 401);
        }

    }

    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 36000000
        ]);
    }
}
