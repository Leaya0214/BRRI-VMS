@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
@section('content')
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        Admin List
                        <button class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modal-add">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </button>
                    </h3>
                </div> <!-- /.card-body -->
                <div class="card-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-info text-center">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user_data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ ($item->role) }}</td>
                            {{-- <td>
                                @if ($item->company != null)
                                    {{$item->company->name}}
                                @else
                                    ALL
                                @endif
                            </td>  --}}
                            {{-- <td>
                                @if ($item->project != null)
                                {{$item->project->name}}
                            @else
                                ALL
                            @endif
                            </td> --}}
                            <td>
                                @if ($item->status == '1')
                                    <a href="{{ route('change-user-status',['0',$item->id]) }}" class="text-success text-bold">Active</a>
                                @else
                                    <a href="{{ route('change-user-status',['1',$item->id]) }}" class="text-danger text-bold">Inactive</a>
                                @endif
                            </td>
                            <td>
                                <button data-toggle="modal" onclick="load_edit_body('{{$item->id}}','{{$item->name}}','{{$item->email}}','{{$item->role}}','{{$item->company_id}}','{{$item->project_id}}')" data-target="#modal-edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div><!-- /.card-body -->
              </div>
        </div>
    </div>
</div>

<style>
    fieldset{
        border: 1.5px solid rgb(59, 175, 59) !important;
    }

</style>

<!-- Add Modal -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Add Admin</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('save-user') }}" method="post"  enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            <fieldset>
                <legend class="text-center">Admin Information</legend>
            <div class="row" style="padding: 12px">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"
                            placeholder="Name" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                            placeholder="Email" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="password"
                            placeholder="Type password" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" id="user_role" class="form-control" onchange="isSiteManager();" required>
                               <option value="SuperAdmin">Super Admin</option>
                                <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="col-lg-6" >
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id"  id="project_id" class="form-control form-select chosen-select">
                            <option value="">Select Project</option>
                            @foreach($projects as $v_project)
                                <option value="{{$v_project->id}}">{{$v_project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <input type="hidden" name="company_id" value="1">

                    </div>
                </div>
            </div>
        </fieldset>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- /.modal -->



<!-- Edit Modal -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Update Admin</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('update-user') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id"  id="user_id">
        <div class="modal-body">
            <fieldset>
                <legend class="text-center">Update Admin Information</legend>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" name="name"
                                placeholder="Your name">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"  id="email" class="form-control" name="email"
                                placeholder="Your email">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" name="password"
                                placeholder="Your password">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control"  id="role">
                                <option value="SuperAdmin">Super Admin</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-lg-6" id="project_edit_div">
                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-control form-select chosen-select" id="project_edit_id" >
                                <option value="">All</option>
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    {{-- <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Company</label>
                            <select name="company_id" class="form-control" id="company_id">
                                @foreach ($company as $item)
                                <option value="{{ $item->id }}">{{ $item->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div> --}}
                </div>
        </fieldset>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

  <!-- /.modal -->
  @push('script_js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script>
    $('#project_div').hide();
    $('#project_edit_div').hide();
    $( document ).ready(function() {
        $(".chosen-select").chosen({
            width: '100%'
        });

    });

    function isSiteManager(){
        $role = $('#user_role').val();

        if($role === 'SiteManager'){
            $('#project_div').show();
            $('#project_id').prop('required',true);

        }else{
            $('#project_div').hide();
            $('#project_id').prop('required',false);
        }
    }

    function load_edit_body(user_id,name,email,role,company_id,project_id){
        $('#user_id').val(user_id);
        $('#name').val(name);
        $('#email').val(email);
        $('#role').val(role);
        $('#company_id').val(company_id);
        // console.log(project_id);
        //if(role === 'SiteManager'){
            $('#project_edit_div').show();
            $('#project_edit_id').val(project_id).trigger("chosen:updated");;

        // }else{
        //     $('#project_edit_div').hide();
        // }
    }
</script>
@endpush

