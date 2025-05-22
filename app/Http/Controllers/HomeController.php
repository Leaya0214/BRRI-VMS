<?php
namespace App\Http\Controllers;


use Session;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Session::get('company_id')){
            $data = [];

            return view('home',$data);
        }
        else{
            // if(auth()->user()->company_id != null  && auth()->user()->role != 'SuperAdmin') {
                //dd('exist');
                $company = Company::first();
                $company_data['company_id'] = $company->id;
                $company_data['company_name'] = $company->name;
                $company_data['company_logo'] = $company->logo;
                $company_data['company_address'] = $company->address;
                $company_data['company_email'] = $company->email;
                $company_data['company_phone'] = $company->phone;

                Session::put($company_data);

                return redirect('home');
            // }
            // else{
            //     $data['companies']  = Company::all();
            //     return view('select_company',$data);
            // }
        }


        //dd(auth()->user()->company_name);
    }

    public function select_company($company_id){
        $company = Company::find($company_id);
        $company_data['company_id'] = $company->id;
        $company_data['company_name'] = $company->name;
        $company_data['company_logo'] = $company->logo;
        $company_data['company_address'] = $company->address;
        $company_data['company_email'] = $company->email;
        $company_data['company_phone'] = $company->phone;

        Session::put($company_data);

        return redirect('home');
    }
}
