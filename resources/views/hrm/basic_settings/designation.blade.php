@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            padding-left: 15px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background: transparent;
            color: white;
        }
    </style>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header row">
                        <h3 class="card-title col-sm-10">
                            Designation List

                        </h3>
                        <button class="btn btn-sm btn-success col-sm-2" data-toggle="modal" data-target="#modal-add">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Designation
                        </button>
                    </div> <!-- /.card-body -->
                    <div class="card-body">

                         <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('designation-list') }}" method="get">
                                <div class="row mb-2 p-2">

                                <div class="col-md-3">
                                    <label>Section</label>
                                    <select name="section_id" id="" class="form-control select2">
                                        <option value="all">All</option>
                                        @foreach ($sections as $item)
                                            <option value="{{ $item->id }}">{{ $item->section_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Search</label>
                                    <button onclick="search();" class="btn btn-success btn-block ">
                                        <i class="fa fa-search"></i>
                                        Search
                                    </button>
                                </div>
                            </div>

                            </form>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-info text-center">
                                    <th>ID</th>
                                    <th>Div/Saction/RS</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designation_data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->section ? $item->section->section_name : '' }}</td>
                                        <td>{{ $item->name }}</td>

                                        <td>
                                            @if ($item->status == '1')
                                                <a href="{{ route('change-designation-status', ['0', $item->id]) }}"
                                                    class="text-success text-bold">Active</a>
                                            @else
                                                <a href="{{ route('change-designation-status', ['1', $item->id]) }}"
                                                    class="text-danger text-bold">Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <button data-toggle="modal"
                                                onclick="load_edit_body('{{ $item->id }}','{{ $item->name }}','{{ $item->section_id }}')"
                                                data-target="#modal-edit" class="btn btn-sm btn-info"><i
                                                    class="fas fa-edit"></i> Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            @if($designation_data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $designation_data->links() }}
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
                    <h4 class="modal-title">Add Designation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('save-designation') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="section_id">Div/Section/RS</label>
                                    <select name="section_id" class="form-control select2" id="create-select">
                                        <option value="">Select One</option>
                                        @foreach ($sections as $v_section)
                                            <option value="{{ $v_section->id }}">{{ $v_section->section_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Your designation_id name">
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
                    <h4 class="modal-title">Update Designation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update-designation') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="designation_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="section_id">Div/Section/RS</label>
                                    <select name="section_id" class="form-control select2" id="update-select">
                                        <option value="">Select One</option>
                                        @foreach ($sections as $v_section)
                                            <option value="{{ $v_section->id }}">{{ $v_section->section_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" id="name" class="form-control" name="name"
                                        placeholder="Your department name">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for create modal
            $('#modal-add').on('shown.bs.modal', function() {
                $('#create-select').select2({
                    placeholder: 'Select an option',
                    width: '100%'
                });
            });

            // Initialize Select2 for update modal
            $('#modal-edit').on('shown.bs.modal', function() {
                $('#update-select').select2({
                    placeholder: 'Select an option',
                    width: '100%'
                });
            });
        });

        function load_edit_body(designation_id, name, section_id) {
            $('#designation_id').val(designation_id);
            $('#update-select').val(section_id);
            $('#name').val(name);
        }
    </script>
@endsection
