<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $data['main_menu']              = 'basic_settings';
        $data['child_menu']             = 'division-list';
        $data['division_data']          = Division::paginate(20);

        return view('district.division',$data);
    }

    public function store(Request $request){
        $request->validate([
            'name'                  => 'required',
        ]);

        $model = new Division();
        $model->division_name               = $request->post('name');
        $model->created_by                  = auth()->user()->id;
        $model->save();

        $msg="Division Inserted.";

        return redirect('division-list')->with('status', $msg);
    }

    function status_update(Request $request, $status=1, $id = null){

        $model                   = Division::find($id);
        $model->division_status  = $status;
        $model->save();

        $msg="Division Status Updated.";
        //$request->session()->flash('message',$msg);

        return redirect('division-list')->with('status', $msg);
    }

    function update(Request $request){
        $request->validate([
            'name'     => 'required'
        ]);
        //dd($request->post());

        $model = Division::find($request->post('id'));
        $model->division_name                = $request->post('name');

        $model->save();

        $msg="Division Updated.";

        return redirect('division-list')->with('status', $msg);
    }
}
