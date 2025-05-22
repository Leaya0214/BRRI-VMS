<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(){
        $data['main_menu']  = 'employee-management';
        $data['child_menu'] = 'mannage-driver';
        $data['drivers'] = Driver::paginate(15);
        return view('driver.manage_driver',$data);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'mobile_number' => 'required|numeric|digits_between:8,15',
            'license_no' => 'required|numeric',
            'nid' => 'required|numeric',
            'issue_date' => 'nullable|date',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $document = null;
        if ($request->hasFile('document')) {
            // Store the new document
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/document/';
            $file->move(public_path($path), $filename);
            $document = $path . $filename;
        }


        Driver::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'license_no' => $request->license_no,
            'nid' => $request->nid,
            'issue_date' => $request->issue_date,
            'document' => $document,
        ]);
        return redirect()->back()->with('status', 'Data created successfully');
    }

    public function update(Request $request,$id)
    {   
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'mobile_number' => 'nullable|numeric|digits_between:8,15',
            'license_no' => 'nullable|numeric',
            'nid' => 'nullable|numeric',
            'issue_date' => 'nullable|date',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        $data=Driver::findOrFail($id);
         //   thumbnail_image  
         if ($request->hasFile('document')) {
            if (!empty($data->document)) {
                $oldImagePath = public_path($data->document);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Store the new image
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/document/';
            $file->move(public_path($path), $filename);
            $data->document = $path . $filename;
        }

       
        $data->update([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'license_no' => $request->license_no,
            'nid' => $request->nid,
            'issue_date' => $request->issue_date,
        ]);
        return redirect()->back()->with('status', 'Data updated successfully');
    }

    
    public function delete($id){
        $driver = Driver::find($id);
        if (!empty($driver->document)) {
            $oldImagePath = public_path($driver->document);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $driver->delete();
        return redirect()->route('drivers')->with('status','Data Deleted Successfully');
    }
}
