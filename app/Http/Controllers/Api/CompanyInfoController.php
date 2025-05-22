<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    public function systemInfo()  {
        try {
            $info = Company::first();
            $companyLogoUrl = url('upload_images/company_logo/' . $info->logo); 
            $govtLogoUrl = url('upload_images/company_logo/' . $info->govt_logo);
            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $info->id,
                    'name' => $info->name,
                    'address' => $info->address,
                    'email' => $info->email,
                    'logo' => $companyLogoUrl,
                    'govt_logo' => $govtLogoUrl,
                    'status' => $info->status,
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
}
