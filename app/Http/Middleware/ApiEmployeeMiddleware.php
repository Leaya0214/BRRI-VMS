<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('employeeapi')->check()){
            if (Auth::guard('employeeapi')){
                return $next($request);
            }
            else{
                return response()->json([
                    'success' => false,
                    "message" => "Access Denied..! You are not student.",
                ], 400);
            }
        }
        else{
            return response()->json([
                'success' => false,
                "message" => "Please login first..!",
            ], 400);
        }
    }
}
