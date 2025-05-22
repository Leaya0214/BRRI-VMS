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
        .btn-group {
            display: flex;
            gap: 5px;
        }

        .btn-custom {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            background-color: #f0f0f0;
            transition: background-color 0.3s;
        }

        .btn-custom.active {
            background-color: #4CAF50;
            color: white;
        }

        .btn-custom.no.active {
            background-color: #f44336;
        }
    </style>

    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Create New Employee
                        </h3>
                    </div> <!-- /.card-body -->
                    <div class="card-body">
                        <form action="{{ route('save-employee') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-success card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title text-success text-center text-bold">
                                                    Employee Information
                                                </h3>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-2 col-form-label">Name<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control"
                                                            placeholder="Employee Name" name="name" required>
                                                    </div>
                                                    <label for="card_id" class="col-sm-2 col-form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" placeholder="Email"
                                                            name="email" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="card_id" class="col-sm-2 col-form-label">Password <span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="password" class="form-control" placeholder="Password"
                                                            name="password" required>
                                                    </div>

                                                    <label for="name" class="col-sm-2 col-form-label">Mobile No.<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" placeholder="Mobile No."
                                                            name="mobile_no" required>
                                                    </div>

                                                </div>


                                                <div class="form-group row">
                                                    <label for="section_id" class="col-sm-2 col-form-label">Division<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select name="section_id" class="form-control  select2"
                                                            id="section_id"
                                                            onchange="loadDesignationsBySection(this.value)">
                                                            <option value="">Select A Division</option>
                                                            @foreach ($section as $v_section)
                                                                <option value="{{ $v_section->id }}">
                                                                    {{ $v_section->section_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label for="designation_id"
                                                        class="col-sm-2 col-form-label">Designation<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select name="designation_id" id="designation_id"
                                                            class="form-control select2" required>
                                                            <option value="">Select A Designation</option>
                                                            @foreach ($designation as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="card_id" class="col-sm-2 col-form-label">Office ID<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" placeholder="Office ID"
                                                            name="office_id" required>
                                                    </div>

                                                    <label for="nid" class="col-sm-2 col-form-label">NID/Smart
                                                        ID<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="nid" name="nid"
                                                            class="form-control" placeholder="NID" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="joining_date" class="col-sm-2 col-form-label">Joining
                                                        Date</label>
                                                    <div class="col-sm-4">
                                                        <input type="date" name="joining_date" class="form-control" />
                                                    </div>

                                                    <label for="prl_date" class="col-sm-2 col-form-label">PRL Date
                                                        <span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="date" name="prl_date" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="gross_salary" class="col-sm-2 col-form-label">Blood
                                                        Group<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="blood_group"
                                                            placeholder="Blood Group">
                                                    </div>
                                                    <label for="gross_salary" class="col-sm-2 col-form-label">User
                                                        Role<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select name="role" class="form-control" id="">
                                                            <option value="">Select One</option>
                                                            <option value="Director">Director</option>
                                                            <option value="DGM">DGM</option>
                                                            <option value="TSO">TSO</option>
                                                            <option value="Staff">Staff</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="signature" class="col-sm-2 col-form-label">Employee
                                                        Signature<span class="text-danger"></span></label>
                                                    <div class="col-sm-4">
                                                        <input type="file" class="form-control" name="signature"
                                                            placeholder="">
                                                    </div>
                                                    <label for="signature" class="col-sm-2 col-form-label">Employee
                                                        Image<span class="text-danger"></span></label>
                                                    <div class="col-sm-4">
                                                        <input type="file" class="form-control" name="image"
                                                            placeholder="">
                                                    </div>

                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="is_head" class="col-md-2">Is Department Head:</label>
                                                    <select name="is_head" id="is_head" class="form-control col-md-4">
                                                        <option value="1">Yes</option>
                                                        <option value="0" selected>No</option>
                                                    </select>

                                                    {{-- <input type="hidden" name="is_head" id="" placeholder="" style="margin-right: 10px;">
                                                    <div class="btn-group">
                                                        <div class="btn-custom yes" onclick="setYes()">Yes</div>
                                                        <div class="btn-custom no" onclick="setNo()">No</div>
                                                    </div>                                                 --}}
                                                </div>

                                                <div class="card-footer">
                                                    <button class="btn btn-success btn-block" type="submit">
                                                        <i class="fa fa-check"></i> Create Employee
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script>
        $(function() {
            $('.select2').select2();
        });
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
                    designationSelect.trigger('change');
                })
                .catch(error => {
                    console.error('Error fetching designations:', error);
                });
        }
    </script>
    <script>
        function setYes() {
            document.querySelector('.btn-custom.yes').classList.add('active');
            document.querySelector('.btn-custom.no').classList.remove('active');
            document.getElementById('inputField').value = '1';
        }

        function setNo() {
            document.querySelector('.btn-custom.no').classList.add('active');
            document.querySelector('.btn-custom.yes').classList.remove('active');
            document.getElementById('inputField').value = '0';
        }
    </script>
@endsection
