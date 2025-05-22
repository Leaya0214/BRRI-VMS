@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title col-sm-10">
                        Division List
                    </h3>
                    <button class="text-end col-sm-2 btn btn-sm btn-success " data-toggle="modal" data-target="#modal-add">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                </div> <!-- /.card-body -->
                <div class="card-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-info text-center">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($division_data); --}}
                        @foreach ($division_data as $item)
                        <tr class="text-center">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->division_name }}</td>
                            {{-- <td>{{ ($item->company->name) }}</td> --}}
                            <td>
                                @if ($item->division_status == 1)
                                    <a href="{{ route('change-division-status', ['status' => 0, 'id' => $item->id]) }}" class="text-success text-bold">Active</a>
                                @else
                                    <a href="{{ route('change-division-status',['status' => 0, 'id' => $item->id]) }}" class="text-danger text-bold">Inactive</a>
                                @endif
                            </td>
                            <td>
                                <button data-toggle="modal" onclick="load_edit_body('{{$item->id}}','{{$item->name}}','{{$item->company_id}}')" data-target="#modal-edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                   <div class="d-flex justify-content-center">
                    @if ($division_data)

                        {{ $division_data->links() }}

                    @endif
                    </div>
                </div><!-- /.card-body -->
              </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Add Division</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('save-division') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"
                            placeholder="Your division name">
                    </div>
                </div>
            </div>
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
          <h4 class="modal-title">Update Division</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('update-division') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id"  id="id">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name"
                            placeholder="Your division name">
                    </div>
                </div>
            </div>
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

<script>
    function load_edit_body(id,name,company_id){
        $('#id').val(id);
        $('#name').val(name);
        $('#company_id').val(company_id);
    }
</script>
@endsection

