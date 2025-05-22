<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Division;
use App\Models\Section;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        $data['main_menu']              = 'employee-management';
        $data['child_menu']             = 'designation-list';
        $data['sections']               = Section::get();
        $designation   =  Designation::where('status',1);

        if($request->section_id){
            $designation->where('section_id',$request->section_id);
            $data['designation_data']  =  $designation->get();
        }else{
            $data['designation_data'] = $designation->paginate(20);
        }

        return view('hrm.basic_settings.designation',$data);
    }

    public function store(Request $request){
        $request->validate([
            'name'                  => 'required'
        ]);

        $model = new Designation();
        $model->name                = $request->post('name');
        $model->section_id          = $request->post('section_id');
        $model->save();

        $msg="Designation Inserted.";
        //$request->session()->flash('message',$msg);

        return redirect('designation-list')->with('status', $msg);
    }

    function status_update(Request $request,$status=1,$id=null){

        $model                  = Designation::find($id);
        $model->status          = $status;
        $model->save();

        $msg="Designation Status Updated.";
        //$request->session()->flash('message',$msg);

        return redirect('designation-list')->with('status', $msg);
    }

    function update(Request $request){
        $request->validate([
            'name'     => 'required'
        ]);
        //dd($request->post());

        $model = Designation::find($request->post('id'));
        $model->name      = $request->post('name');
        $model->section_id = $request->post('section_id');

        $model->save();

        $msg="Designation Updated.";
        //$request->session()->flash('message',$msg);

        return redirect('designation-list')->with('status', $msg);
    }

    public function getDesignationsBySection($section_id)
        {
            $designations = Designation::where('section_id', $section_id)->get();
            return response()->json($designations);
        }
}
