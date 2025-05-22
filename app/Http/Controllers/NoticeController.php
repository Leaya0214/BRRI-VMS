<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(){
        $data['main_menu']  = 'basic_settings';
        $data['child_menu'] = 'mannage-notice';
        $data['notice'] = Notice::paginate(15);
        return view('notice.index',$data);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string',
            // 'details' => 'nullable|string',
            'date' => 'nullable|date',
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

        Notice::create([
            'title' => $request->title,
            'details' => $request->details,
            'date' => $request->date,
            'attachment' => $document,

        ]);
        return redirect()->back()->with('status', 'Data created successfully');
    }

    public function update(Request $request,$id)
    {   
        // Validate the request data
        $request->validate([
           'title' => 'required|string',
            // 'details' => 'nullable|string',
            'date' => 'nullable|date',
        ]);
        $data=Notice::findOrFail($id);

        if ($request->hasFile('document')) {
            if (!empty($data->attachment)) {
                $oldImagePath = public_path($data->attachment);
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
            $data->attachment = $path . $filename;
        }
     
       
        $data->update([
            'title' => $request->title,
            'details' => $request->details,
            'date' => $request->date,
        ]);
        return redirect()->back()->with('status', 'Data updated successfully');
    }

    
    public function delete($id){
        $data = Notice::find($id);
       
        $data->delete();
        return redirect()->route('notices')->with('status','Data Deleted Successfully');
    }
}
