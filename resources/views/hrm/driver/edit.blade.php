@extends('layouts.app')

@section('content')
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
                        Edit Driver
                    </h3>
                </div> <!-- /.card-body -->
                <div class="card-body">
                    <form action="{{ route('update-employee') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $employee->id }}"/>
                          <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-success card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title text-success text-center text-bold">
                                                    Driver Information
                                                </h3>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-2 col-form-label">Name<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control"
                                                            placeholder="Employee Name" name="name" value="{{$employee->name}}" required>
                                                    </div>
                                                    <label for="card_id" class="col-sm-2 col-form-label">Email </label>
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" placeholder="Email" value="{{$employee->email}}"
                                                            name="email" >
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                     <label for="card_id" class="col-sm-2 col-form-label">Password</label>
                                                    <div class="col-sm-4">
                                                        <input type="password" class="form-control" placeholder="Password" value=""
                                                            name="password">
                                                    </div>
                                                    <label for="name" class="col-sm-2 col-form-label">Mobile No.<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control"
                                                            placeholder="Mobile No." name="mobile_no" value="{{$employee->mobile_no}}" required>
                                                    </div>

                                                </div>


                                                <div class="form-group row">
                                                    <label for="designation_id"
                                                        class="col-sm-2 col-form-label">Designation<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select name="designation_id" class="form-control" required>
                                                            <option value="">Select A Designation</option>
                                                            @foreach ($designation as $item)
                                                                <option value="{{ $item->id }}" {{ $item->id == $employee->designation_id ? 'selected' : ''}}>{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label for="section_id" class="col-sm-2 col-form-label">Division<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select name="section_id" class="form-control" id="section_id">
                                                            <option value="">Select A Division</option>
                                                            @foreach ($section as $v_section)
                                                                <option value="{{ $v_section->id }}"  {{ $v_section->id == $employee->section_id ? 'selected' : ''}}>
                                                                    {{ $v_section->section_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                      <label for="card_id" class="col-sm-2 col-form-label">Office ID<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" placeholder="Office ID" value="{{$employee->office_id}}"
                                                            name="office_id" required>
                                                    </div>

                                                    <label for="nid" class="col-sm-2 col-form-label">NID/Smart
                                                        ID<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="nid" name="nid" class="form-control" placeholder="NID" value="{{$employee->nid}}"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="joining_date" class="col-sm-2 col-form-label">Joining
                                                        Date</label>
                                                    <div class="col-sm-4">
                                                        <input type="date" name="joining_date" class="form-control" value="{{$employee->joining_date}}" />
                                                    </div>

                                                    <label for="job_location" class="col-sm-2 col-form-label">PRL Date
                                                        <span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="date" name="prl_date" class="form-control" value="{{$employee->prl_date}}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label for="gross_salary" class="col-sm-2 col-form-label">Blood
                                                        Group<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="blood_group" placeholder="Blood Group" value="{{$employee->blood_group}}">
                                                    </div>
                                                    <label for="job_location" class="col-sm-2 col-form-label"> Role
                                                        <span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select name="role" class="form-control" id="">
                                                            <option value="">Select One</option>
                                                            <option value="Director" {{$employee->role == 'Director'? 'selected' : ''}}>Director</option>
                                                            <option value="DGM" {{$employee->role == 'DGM'? 'selected' : ''}}>DGM</option>
                                                            <option value="TSO" {{$employee->role == 'TSO'? 'selected' : ''}}>TSO</option>
                                                            <option value="Staff" {{$employee->role == 'Staff'? 'selected' : ''}}>Staff</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="signature" class="col-sm-2 col-form-label">
                                                         Signature 
                                                    </label>
                                                    <div class="col-sm-4">
                                                        @if($employee->signature) 
                                                            <img src="{{ asset('employee/' . $employee->signature) }}" alt="Employee Signature" style="width: 150px; height: auto;"/>
                                                        @else
                                                            <p>No signature uploaded</p> 
                                                        @endif
                                                
                                                        <input type="file" class="form-control" name="signature" accept="image/*">
                                                    </div>

                                                    <label for="signature" class="col-sm-2 col-form-label"> Image<span class="text-danger"></span></label>
                                                    <div class="col-sm-4">
                                                        @if($employee->image) 
                                                            <img src="{{ asset('employee/' . $employee->image) }}" alt="Employee Signature" style="width: 150px; height: auto;"/>
                                                        @else
                                                            <p>No Image uploaded</p> 
                                                        @endif
                                                       <input type="file" class="form-control" name="image" placeholder="">
                                                    </div>
                                                    
                                                </div>
                                            <div class="card-footer">
                                                <button class="btn btn-success btn-block" type="submit">
                                                    <i class="fa fa-check"></i> Update Employee
                                                </button>
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


<script>

let currentValue = parseInt(document.getElementById('inputField').value);
console.log(currentValue);

    if (currentValue === 1) {
        document.querySelector('.btn-custom.yes').classList.add('active');
    } else if (currentValue === 0) {
        document.querySelector('.btn-custom.no').classList.add('active');
    }
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

<script>
    function load_department(company_id){
        url = '{{ route('load_department_by_company_id', ":company_id") }}';
        url = url.replace(':company_id', company_id);
        //alert(url);
        $.ajax({
          cache   : false,
          type    : "GET",
          error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
          url : url,
          success : function(response){
            response_data = JSON.parse(response);
            if(response_data.status == 'success'){
              $('#department_id').html(response_data.options);

            }
          }
      })
    }
    function load_branch(company_id){
        url = '{{ route('load_branch_by_company_id', ":company_id") }}';
        url = url.replace(':company_id', company_id);
        //alert(url);
        $.ajax({
          cache   : false,
          type    : "GET",
          error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
          url : url,
          success : function(response){
            response_data = JSON.parse(response);
            if(response_data.status == 'success'){
              $('#branch_id').html(response_data.options);
            }
          }
      })
    }
    function load_section(company_id){
        url = '{{ route('load_section_by_company_id', ":company_id") }}';
        url = url.replace(':company_id', company_id);
        //alert(url);
        $.ajax({
          cache   : false,
          type    : "GET",
          error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
          url : url,
          success : function(response){
            response_data = JSON.parse(response);
            if(response_data.status == 'success'){
              $('#section_id').html(response_data.options);

            }
          }
      })
    }
</script>
@endsection

