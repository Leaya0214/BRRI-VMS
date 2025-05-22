<?php

namespace App\Http\Controllers\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index(){
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'vehicle-type';
        $data['vehicleType'] = VehicleType::paginate(15);
        return view('vehicle_type.index',$data);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'vehicle_type' => 'required|string',
        ]);
      
        VehicleType::create([
            'vehicle_type' => $request->vehicle_type,
        ]);
        return redirect()->back()->with('success', 'Data created successfully');
    }

    public function update(Request $request,$id)
    {   
        // Validate the request data
        $request->validate([
            'vehicle_type' => 'required|string',
        ]);
        $data=VehicleType::findOrFail($id);
        $data->update([
            'vehicle_type' => $request->input('vehicle_type'),
        ]);
        return redirect()->back()->with('success', 'Data created successfully');
    }

   

    
    public function delete($id){
        $vehicle_type_id = VehicleType::find($id);
        $vehicle_type_id->delete();
        return redirect()->route('vehicle-types')->with('status','Data Deleted Successfully');
    }

}
