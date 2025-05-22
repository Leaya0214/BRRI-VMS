<?php

namespace App\Http\Controllers\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\VehicleExpenseCategory;
use App\Models\VehicleExpenseHead;
use Illuminate\Http\Request;

class VehicleExpenseHeadController extends Controller
{
    public function index(){
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'vehicle-expense-head';
        $data['vehicleCategory'] = VehicleExpenseCategory::all();
        $data['vehicleExpenseHead'] = VehicleExpenseHead::with('expenseCategory')->paginate(15);
        return view('vehicle_expense_head.index',$data);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'category_id' => 'required|exists:vehicle_expense_categories,id',
            'name' => 'required|string',
        ]);
        
        VehicleExpenseHead::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'status' =>1
        ]);
        return redirect()->back()->with('status', 'Data created successfully');
    }

    public function update(Request $request,$id)
    {   
        // Validate the request data
        $request->validate([
            'category_id' => 'required|exists:vehicle_expense_categories,id',
            'name' => 'required|string',
        ]);
        $data=VehicleExpenseHead::findOrFail($id);
        
        
        $data->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
        ]);
        return redirect()->back()->with('status', 'Data updated successfully');
    }

    
    public function delete($id){
        $data = VehicleExpenseHead::find($id);
        $data->delete();
        return redirect()->route('vehicle-expense-heads')->with('status','Data Deleted Successfully');
    }
}
