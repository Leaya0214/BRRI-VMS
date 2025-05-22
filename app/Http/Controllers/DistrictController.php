<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
     public function index(){
        $data['main_menu']             = 'basic_settings';
        $data['child_menu']            = 'district';
        $data['divisions']             = Division::where('division_status',1)->get();
        $data['districts']             = District::paginate(15);
        return view('district.manage_district',$data);
    }


    public function store(Request $request){
        $data = [
            'name' => $request->name,
            'division_id' => $request->division_id,
            'status' => 1,
            'created_by' =>auth()->user()->id
        ];
        District::create($data);
        $msg = "District Created Successfully";
        return redirect()->back()->with('status',$msg);
    }

    public function update(Request $request, $id){
        $district = District::where('id',$id)->first();
        $data = [
            'name' => $request->name,
            'division_id' => $request->division_id,
            'status' => 1,
            'updated_by' =>auth()->user()->id
        ];
        $district->update($data);
        $msg = "Data Updated Successfully";
        return redirect()->back()->with('status',$msg);
    }


    public function delete($id){
        $district_id = District::find($id);
        $district_id->delete();
        return redirect()->route('district')->with('status','Data Deleted Successfully');
    }
}
