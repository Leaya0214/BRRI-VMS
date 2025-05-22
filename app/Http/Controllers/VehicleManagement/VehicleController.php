<?php

namespace App\Http\Controllers\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'vehicle';
        $data['vehicle_type'] = VehicleType::all();
        $data['vehicle'] = Vehicle::with('typef')->paginate(15);
        return view('vehicle.index', $data);
    }

    public function setup()
    {
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'setup-vehicle';
        $data['vehicle_type'] = VehicleType::all();
        return view('vehicle.setup_vehicle', $data);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'type_id' => 'required|exists:vehicle_types,id',
            'insurance_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'insurance_issue_date' => 'nullable|date',
            'insurance_exp_date' => 'nullable|date|after:insurance_issue_date',
            'tax_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tax_issue_date' => 'nullable|date',
            'tax_expiry_date' => 'nullable|date|after:tax_issue_date',
            'fitness_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'fitness_issue_date' => 'nullable|date',
            'fitness_expiry_date' => 'nullable|date|after:fitness_issue_date',
            'area' => 'nullable|string|max:255',
            'purchase_value' => 'nullable|numeric|min:0',
            'depreciation' => 'nullable|numeric|min:0',
            'present_value' => 'nullable|numeric|min:0',
            'company_contribution' => 'nullable|numeric|min:0',
            'loan_amount' => 'nullable|integer|min:0',
            'total_payable_amount' => 'nullable|integer|min:0',
            'per_installment_amount' => 'nullable|integer|min:0',
            'total_active_months' => 'nullable|integer|min:0',
            'total_paid_months' => 'nullable|integer|min:0',
            'replacement_of' => 'nullable|integer',
            'vchl_model' => 'nullable|string|max:255',
            'model_year' => 'nullable|string|max:4',
            'enginee_no' => 'nullable|string|max:255',
            'chassis_no' => 'nullable|string|max:255',
            'reg_no' => 'nullable|string|max:255',
            'registration_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'purchase_date' => 'nullable|date',
            'activated_date' => 'nullable|date',
            'vchl_status' => 'nullable|boolean',
            'avilable_status' => 'nullable|boolean',
        ]);

        $insuranceDocument=null;
        if ($request->hasFile('insurance_document')) {
            // Store the new document
            $file = $request->file('insurance_document');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/vehicle-managemant/document/';
            $file->move(public_path($path), $filename);
            $insuranceDocument = $path . $filename;
        }

        $taxDocument=null;
        if ($request->hasFile('tax_document')) {
            // Store the new image
            $file = $request->file('tax_document');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/document/';
            $file->move(public_path($path), $filename);
            $taxDocument = $path . $filename;
        }


        $fitnessDocument=null;
        if ($request->hasFile('fitness_document')) {
            // Store the new image
            $file = $request->file('fitness_document');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/vehicle-managemant/document/';
            $file->move(public_path($path), $filename);
            $fitnessDocument = $path . $filename;
        }


        $registrationCard=null;
        if ($request->hasFile('registration_card')) {
            // Store the new image
            $file = $request->file('registration_card');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/vehicle-managemant/document/';
            $file->move(public_path($path), $filename);
            $registrationCard = $path . $filename;
        }

        Vehicle::create([
            'type_id' => $request->type_id,
            'insurance_document' => $insuranceDocument,
            'insurance_issue_date' => $request->insurance_issue_date,
            'insurance_exp_date' => $request->insurance_exp_date,
            'tax_document' => $taxDocument,
            'tax_issue_date' => $request->tax_issue_date,
            'tax_expiry_date' => $request->tax_expiry_date,
            'fitness_document' => $fitnessDocument,
            'fitness_issue_date' => $request->fitness_issue_date,
            'fitness_expiry_date' => $request->fitness_expiry_date,
            'area' => $request->area,
            'purchase_value' => $request->purchase_value,
            'depreciation' => $request->depreciation,
            'present_value' => $request->present_value,
            'company_contribution' => $request->company_contribution,
            'loan_amount' => $request->loan_amount,
            'per_installment_amount' => $request->per_installment_amount,
            'total_payable_amount' => $request->total_payable_amount,
            'total_active_months' => $request->total_active_months,
            'total_paid_months' => $request->total_paid_months,
            'replacement_of' => $request->replacement_of,
            'vchl_model' => $request->vchl_model,
            'model_year' => $request->model_year,
            'enginee_no' => $request->enginee_no,
            'chassis_no' => $request->chassis_no,
            'reg_no' => $request->reg_no,
            'registration_card' => $registrationCard,
            'purchase_date' => $request->purchase_date,
            'activated_date' => $request->activated_date,
            'vchl_status' => 1,
            'avilable_status' => 1,
        ]);
        return redirect()->back()->with('status', 'Data created successfully');
    }

    // public function update(Request $request,$id)
    // {   
    //     // Validate the request data
    //     $request->validate([
    //         'vehicle_type' => 'required|string',
    //     ]);
    //     $data=VehicleType::findOrFail($id);
    //     $data->update([
    //         'vehicle_type' => $request->input('vehicle_type'),
    //     ]);
    //     return redirect()->back()->with('success', 'Data created successfully');
    // }




    // public function delete($id){
    //     $vehicle_type_id = VehicleType::find($id);
    //     $vehicle_type_id->delete();
    //     return redirect()->route('vehicle-types')->with('status','Data Deleted Successfully');
    // }

}
