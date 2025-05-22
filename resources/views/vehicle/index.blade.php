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
                            Vehicle Information
                        </h3>
                        
                    </div> <!-- /.card-body -->
                    <div class="card-body p-3">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-info">
                            <tr>
                                <th>ID</th>
                                <th>Vehicle Type</th>
                                <th>Purchase Value</th>
                                <th>Present Value</th>
                                <th>Model Year</th>
                                <th>Enginee No</th>
                                <th>Registration No</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach ($vehicle as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->typef ? $item->typef->vehicle_type : 'N/A' }}</td>
                                    <td>{{ $item->purchase_value }}</td>
                                    <td>{{ $item->present_value }}</td>
                                    <td>{{ $item->model_year }}</td>
                                    <td>{{ $item->enginee_no }}</td>
                                    <td>{{ $item->reg_no }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('vehicles.edit', $item->id) }}"
                                            style="padding:2px; color:white" class="btn btn-xs btn-info mr-1">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('vehicles-delete', $item->id) }}"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            style="padding: 2px;" class="delete btn btn-xs btn-danger mr-1">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>

                    <div class="row pt-3">
                        <div class="col-lg-12">

                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

