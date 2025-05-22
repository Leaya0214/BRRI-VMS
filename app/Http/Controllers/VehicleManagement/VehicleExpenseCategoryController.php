<?php

namespace App\Http\Controllers\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\VehicleExpenseCategory;
use Illuminate\Http\Request;

class VehicleExpenseCategoryController extends Controller
{
    public function index(){
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'vehicle-expense-category';
        $data['vehicleExpenseCategory'] = VehicleExpenseCategory::paginate(15);
        return view('vehicle_expense_category.index',$data);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
        ]);
        
        VehicleExpenseCategory::create([
            'name' => $request->name,
            'status' =>1
        ]);
        return redirect()->back()->with('status', 'Data created successfully');
    }

    public function update(Request $request,$id)
    {   
        // Validate the request data
        $request->validate([
           'name' => 'required|string',
        ]);
        $data=VehicleExpenseCategory::findOrFail($id);
     
       
        $data->update([
            'name' => $request->name,
        ]);
        return redirect()->back()->with('status', 'Data updated successfully');
    }

    
    public function delete($id){
        $data = VehicleExpenseCategory::find($id);
        $data->delete();
        return redirect()->route('vehicle-expense-categories')->with('status','Data Deleted Successfully');
    }
}
