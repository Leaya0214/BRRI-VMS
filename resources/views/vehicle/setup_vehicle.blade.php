@extends('layouts.app')
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
    .modal-content {
        border-radius: 10px;
        padding: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    h6.text-info {
        border-bottom: 1px solid #17a2b8;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    .modal-footer {
        justify-content: center;
    }
</style>
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title col-sm-11">
                            Set-up Vehicle
                        </h3>
                    </div> <!-- /.card-body -->
                    <form action="{{ route('vehicles-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="container-fluid">
                                <!-- Vehicle Information Section -->
                               
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <h6 class="text-info">Vehicle Information</h6>
                                        <div>
                                            <label for="vehicle_type" class="col-sm-4 col-form-label">Vehicle Type</label>
                                            <div class="">
                                                <select name="type_id" class="form-control">
                                                    <option value="" selected>Select Vehicle Type</option>
                                                    @foreach ($vehicle_type as $item)
                                                        <option value="{{ $item->id }}">{{ $item->vehicle_type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="vchl_model" class="col-sm-4 col-form-label">Vehicle Model</label>
                                            <div class="">
                                                <input name="vchl_model" type="text" class="form-control" placeholder="Vehicle Model">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="model_year" class="col-sm-4 col-form-label">Model Year</label>
                                            <div class="">
                                                <input name="model_year" type="text" class="form-control" placeholder="Model Year">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="enginee_no" class="col-sm-4 col-form-label">Engine Number</label>
                                            <div class="">
                                                <input name="enginee_no" type="text" class="form-control" placeholder="Engine Number">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="chassis_no" class="col-sm-4 col-form-label">Chassis Number</label>
                                            <div class="">
                                                <input name="chassis_no" type="text" class="form-control" placeholder="Chassis Number">
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <h6 class="text-info">Additional Information</h6>
                                        <div>
                                            <label for="reg_no" class="col-sm-4 col-form-label">Registration Number</label>
                                            <div class="">
                                                <input name="reg_no" type="number" class="form-control" placeholder="Registration Number">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="registration_card" class="col-sm-4 col-form-label">Registration Card</label>
                                            <div class="">
                                                <input name="registration_card" type="file" class="form-control-file">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="purchase_date" class="col-sm-4 col-form-label">Purchase Date</label>
                                            <div class="">
                                                <input name="purchase_date" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="activated_date" class="col-sm-4 col-form-label">Activated Date</label>
                                            <div class="">
                                                <input name="activated_date" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="area" class="col-sm-4 col-form-label">Area</label>
                                            <div class="">
                                                <input name="area" type="text" class="form-control" placeholder="Area">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <h6 class="text-info">Insurance Information</h6>
                                        <div>
                                            <label for="insurance_document" class="col-sm-4 col-form-label">Insurance
                                                Document</label>
                                            <div>
                                                <input name="insurance_document" type="file" class="form-control-file">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="insurance_issue_date" class="col-sm-4 col-form-label">Insurance Issue
                                                Date</label>
                                            <div>
                                                <input name="insurance_issue_date" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="insurance_exp_date" class="col-sm-4 col-form-label">Insurance Expiry
                                                Date</label>
                                            <div>
                                                <input name="insurance_exp_date" type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-info">Tax Information</h6>
                                        <div>
                                            <label for="tax_document" class="col-sm-4 col-form-label">Tax Document</label>
                                            <div>
                                                <input name="tax_document" type="file" class="form-control-file">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="tax_issue_date" class="col-sm-4 col-form-label">Tax Issue Date</label>
                                            <div>
                                                <input name="tax_issue_date" type="date" class="form-control">
                                            </div>
                                        </div>
        
                                        <div>
                                            <label for="tax_expiry_date" class="col-sm-4 col-form-label">Tax Expiry Date</label>
                                            <div>
                                                <input name="tax_expiry_date" type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <!-- Fitness Information Section -->
                              
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <h6 class="text-info">Fitness Information</h6>
                                        <div>
                                            <label for="fitness_document" class="col-sm-4 col-form-label">Fitness Document</label>
                                            <div>
                                                <input name="fitness_document" type="file" class="form-control-file">
                                            </div>
                                        </div>
        
                                        <div>
                                            <label for="fitness_issue_date" class="col-sm-4 col-form-label">Fitness Issue
                                                Date</label>
                                            <div>
                                                <input name="fitness_issue_date" type="date" class="form-control">
                                            </div>
                                        </div>
        
                                        <div>
                                            <label for="fitness_expiry_date" class="col-sm-4 col-form-label">Fitness Expiry
                                                Date</label>
                                            <div>
                                                <input name="fitness_expiry_date" type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-info">Financial Information</h6>
                                        <div>
                                            <label for="purchase_value" class="col-sm-4 col-form-label">Purchase Value</label>
                                            <div>
                                                <input name="purchase_value" type="number" step="0.01" class="form-control"
                                                    placeholder="Purchase Value">
                                            </div>
                                        </div>
        
                                        <div>
                                            <label for="depreciation" class="col-sm-4 col-form-label">Depreciation</label>
                                            <div>
                                                <input name="depreciation" type="number" step="0.01" class="form-control"
                                                    placeholder="Depreciation">
                                            </div>
                                        </div>
        
                                        <div>
                                            <label for="present_value" class="col-sm-4 col-form-label">Present Value</label>
                                            <div>
                                                <input name="present_value" type="number" step="0.01" class="form-control"
                                                    placeholder="Present Value">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                


                                {{-- <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="model_year" class="col-form-label">Model Year</label>
                                        <input name="model_year" type="text" class="form-control"
                                            placeholder="Model Year">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="enginee_no" class="col-form-label">Engine Number</label>
                                        <input name="enginee_no" type="text" class="form-control"
                                            placeholder="Engine Number">
                                    </div>
                                </div> --}}



                            </div> <!-- End of container-fluid -->
                        </div> <!-- End of modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Vehicle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
