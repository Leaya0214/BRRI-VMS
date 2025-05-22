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
    <style>
        .import-button {
            background-color: #007bff;
            /* Blue background */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }

        .import-button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }
    </style>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Manage Employee
                        </h3>
                    </div> <!-- /.card-body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <form id="importForm" action="{{ route('employee.import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" id="fileInput" style="display: none;" required>
                                    <button type="button" class="import-button" onclick="triggerFileImport()">Import
                                        Employees</button>
                                </form>
                            </div>
                        </div>
                            {{-- <div class="col-md-3">
                            <label>Company</label>
                            <select name="company_id" id="company_id" class="form-control" onchange="load_department(this.value); load_section(this.value); load_branch(this.value);">
                                <option value="all">All</option>
                                @foreach ($company as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                            {{-- <div class="col-md-3">
                            <label>Department</label>
                            <select name="department_id" id="department_id" class="form-control">
                                <option value="all">All</option>

                            </select>
                        </div> --}}
                            <form action="{{ route('manage-employee') }}" method="get">
                                <div class="row mb-2 p-2">

                                <div class="col-md-3">
                                    <label>Employee</label>
                                    <select name="employee" id="" class="form-control select2">
                                        <option value="all">All</option>
                                        @foreach ($allEmployee as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Section</label>
                                    <select name="section_id" id="" class="form-control select2" onchange="loadDesignationsBySection(this.value)">
                                        <option value="all">All</option>
                                        @foreach ($section as $item)
                                            <option value="{{ $item->id }}">{{ $item->section_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Designation</label>
                                    <select name="designation_id" id="designation_id" class="form-control select2">
                                        <option value="all">All</option>
                                        @foreach ($designation as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
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

                            {{-- <div class="col-md-3">
                            <label>Branch Office</label>
                            <select name="branch_id" id="branch_id" class="form-control">
                                <option value="all">All</option>

                            </select>
                        </div> --}}

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-info">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Div/Section/RS</th>
                                    <th>Designation</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Office ID</th>
                                    <th>Joining Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="details_table_body">
                                @foreach ($employee as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>

                                        <td>
                                            @if ($item->section != null)
                                                {{ $item->section->section_name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->designation != null)
                                                {{ $item->designation->name }}
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->mobile_no != null)
                                                {{ $item->mobile_no }}
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->email != null)
                                                {{ $item->email }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->office_id != null)
                                                {{ $item->office_id }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->joining_date != null)
                                                {{ date('d/m/Y', strtotime($item->joining_date)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == '1')
                                                <a href="{{ route('change-employee-status', ['0', $item->id]) }}"
                                                    class="text-success text-bold">Active</a>
                                            @else
                                                <a href="{{ route('change-employee-status', ['1', $item->id]) }}"
                                                    class="text-danger text-bold">Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <button data-toggle="modal" onclick="load_edit_body('{{ $item->id }}')"
                                                data-target="#modal-view" class="btn btn-sm btn-success"><i
                                                    class="fa fa-eye"></i></button>
                                            <a href="{{ route('edit-employee', [$item->id]) }}"
                                                class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            @if($employee instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $employee->links() }}
                            @endif
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="modal-view">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Employee Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="view_modal">

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        function triggerFileImport() {
            const fileInput = document.getElementById('fileInput');

            // Trigger file selection dialog
            fileInput.click();

            // When a file is selected, submit the form
            fileInput.onchange = function() {
                if (fileInput.files.length > 0) {
                    document.getElementById('importForm').submit();
                }
            };
        }
    </script>

    <script>

        function loadDesignationsBySection(sectionId) {
            const designationSelect = document.getElementById('designation_id');
            console.log(designationSelect);

            designationSelect.innerHTML = '<option value="">Select Designation</option>';

            if (!sectionId) return;

            fetch(`/designations-by-section/${sectionId}`)
                .then(response => response.json())
                .then(designations => {
                    designations.forEach(designation => {
                        const option = document.createElement('option');
                        option.value = designation.id;
                        option.textContent = designation.name;
                        designationSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching designations:', error);
                });
        }

        // function search() {
        //     var section_id = $('#section_id').val();
        //     var designation_id = $('#designation_id').val();

        //     url = '{{ route('search-employee') }}';
        //     $.ajax({
        //         cache: false,
        //         type: "post",
        //         data: {
        //             section_id,
        //             designation_id,
        //         },
        //         error: function(xhr) {
        //             alert("An error occurred: " + xhr.status + " " + xhr.statusText);
        //         },
        //         url: url,
        //         success: function(response) {
        //             $('#details_table_body').html(response);
        //         }
        //     })
        // }

        function load_edit_body(employee_id) {
            url = '{{ route('load_employee_view', ':employee_id') }}';
            url = url.replace(':employee_id', employee_id);
            $.ajax({
                cache: false,
                type: "GET",
                error: function(xhr) {
                    alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                },
                url: url,
                success: function(response) {
                    $('#view_modal').html(response);
                }
            })
        }

        function load_department(company_id) {
            url = '{{ route('load_department_by_company_id', ':company_id') }}';
            url = url.replace(':company_id', company_id);
            //alert(url);
            $.ajax({
                cache: false,
                type: "GET",
                error: function(xhr) {
                    alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                },
                url: url,
                success: function(response) {
                    response_data = JSON.parse(response);
                    if (response_data.status == 'success') {
                        $('#department_id').html(response_data.options);

                    }
                }
            })
        }

        function load_branch(company_id) {
            url = '{{ route('load_branch_by_company_id', ':company_id') }}';
            url = url.replace(':company_id', company_id);
            //alert(url);
            $.ajax({
                cache: false,
                type: "GET",
                error: function(xhr) {
                    alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                },
                url: url,
                success: function(response) {
                    response_data = JSON.parse(response);
                    if (response_data.status == 'success') {
                        $('#branch_id').html(response_data.options);
                    }
                }
            })
        }

        function load_section(company_id) {
            url = '{{ route('load_section_by_company_id', ':company_id') }}';
            url = url.replace(':company_id', company_id);
            //alert(url);
            $.ajax({
                cache: false,
                type: "GET",
                error: function(xhr) {
                    alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                },
                url: url,
                success: function(response) {
                    response_data = JSON.parse(response);
                    if (response_data.status == 'success') {
                        $('#section_id').html(response_data.options);

                    }
                }
            })
        }
    </script>
@endsection
