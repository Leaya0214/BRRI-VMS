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
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title col-sm-11">
                            Vehicle Expense Head
                        </h3>
                        <button class="text-end col-sm-1 btn btn-success btn-sm" data-toggle="modal"
                            data-target="#exampleModal">+Add</button>
                    </div> <!-- /.card-body -->
                    <div class="card-body p-3">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-info">
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Head</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($vehicleExpenseHead as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->expenseCategory->name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a data-toggle="modal" data-target=".update-modal-{{ $item->id }}"
                                                style="padding:2px; color:white" class="btn btn-xs btn-info  mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('vehicle-expense-heads-delete', $item->id) }}"
                                                onclick="return confirm('Are you sure you want to delete?');"
                                                style="padding: 2px;" class="delete btn btn-xs btn-danger  mr-1">
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

    <div class="modal fade create_modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-center">
                    <h5>Add Vehicle Expense Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('vehicle-expense-heads-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group row pt-3">
                            <label for="category_id" class="col-sm-3 col-form-label">Vehicle Expense Category</label>
                            <label for="" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-8">
                                <select name="category_id" class="form-control">
                                    <option value="" selected>Select Vehicle Expense Category</option>
                                    @foreach ($vehicleCategory as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row pt-3">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <label for="" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-8">
                                <input name="name" type="text" class="form-control" placeholder="Category Name">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @foreach ($vehicleExpenseHead as $head)
        @php

        @endphp

        <div class="modal fade update update-modal-{{ $head->id }}" id="exampleModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-center">
                        <h5>Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('vehicle-expense-heads-update', $head->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group row pt-3">
                                <label for="vehicle_type" class="col-sm-4 col-form-label">Vehicle Expense Head</label>
                                <div class="col-sm-8">
                                    <select name="category_id" class="form-control">
                                        <option value="" selected>Select Vehicle Expense Head</option>
                                        @foreach ($vehicleCategory as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $head->category_id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                <label for="" class="col-sm-1 col-form-label">:</label>
                                <div class="col-sm-8">
                                    <input name="name" type="text" class="form-control" value="{{ $item->name }}"
                                        placeholder="Head Name">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script>
    $(document).ready(function() {
        $('.create_modal').on('shown.bs.modal', function() {
            $('.js-example-basic-multiple').select2();
        });
        $('.update').on('shown.bs.modal', function() {
            $('.js-example-basic-multiple').select2();
        });
    });

    function updateValue() {
        let checkbox = document.getElementById('yes');
        checkbox.value = checkbox.checked ? 1 : 0;
    }
</script>
