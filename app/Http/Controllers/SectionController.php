<?php
/**
 * Author: Tushar Das
 * Sr. Software Engineer
 * tushar2499@gmail.com
 * 01815920898
 * STITBD
 * 06/10/2021
 */
namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $data['main_menu']              = 'employee-management';
        $data['child_menu']             = 'section-list';
        $data['section_data']            = Section::paginate(20);

        return view('hrm.basic_settings.section',$data);
    }

    public function store(Request $request){
        $request->validate([
            'name'                  => 'required',
        ]);

        $model = new Section();
        $model->section_name                = $request->post('name');
        $model->created_by                  = auth()->user()->id;
        $model->save();

        $msg="Section Inserted.";

        return redirect('section-list')->with('status', $msg);
    }

    function status_update(Request $request, $status=1, $id = null){

        $model                  = Section::find($id);
        $model->section_status  = $status;
        $model->save();

        $msg="Section Status Updated.";
        //$request->session()->flash('message',$msg);

        return redirect('section-list')->with('status', $msg);
    }

    function update(Request $request){
        $request->validate([
            'name'     => 'required'
        ]);
        //dd($request->post());

        $model = Section::find($request->post('id'));
        $model->section_name                = $request->post('name');

        $model->save();

        $msg="Section Updated.";

        return redirect('section-list')->with('status', $msg);
    }
}
