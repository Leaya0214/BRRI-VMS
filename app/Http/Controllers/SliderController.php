<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
        $data['main_menu']  = 'basic_settings';
        $data['child_menu'] = 'slider';
        $data['slider'] = Slider::paginate(15);
        return view('slider.index',$data);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string',
            // 'position' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imgPath = null;
        if ($request->hasFile('image')) {
            // Store the new document
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/document/';
            $file->move(public_path($path), $filename);
            $imgPath = $path . $filename;
        }



        Slider::create([
            'title' => $request->title,
            // 'position' => $request->position,
            'image' => $imgPath
        ]);
        return redirect()->back()->with('status', 'Data created successfully');
    }

    public function update(Request $request, $id)
    {   
        // Validate the request data
        $request->validate([
            'title' => 'nullable|string',
            // 'position ' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Find the existing Slider record
        $data = Slider::findOrFail($id);
    
        if ($request->hasFile('image')) {
            if (!empty($data->image)) {
                $oldImagePath = public_path($data->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Store the new image
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = '/document/';
            $file->move(public_path($path), $filename);
            $data->image = $path . $filename;
        }
    
        // Save the updated data
        $data->update([
            'title' => $request->input('title'),
            // 'position' => $request->input('position'),
        ]);
    
        return redirect()->back()->with('status', 'Data updated successfully');
    }

    
    public function delete($id){
        $data = Slider::find($id);
        if (!empty($data->image)) {
            $oldImagePath = public_path($data->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $data->delete();
        return redirect()->route('sliders')->with('status','Data Deleted Successfully');
    }
}
