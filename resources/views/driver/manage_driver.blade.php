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
                            Driver List
                        </h3>
                        <button class="text-end col-sm-1 btn btn-success btn-sm" data-toggle="modal"
                            data-target="#exampleModal">+Add</button>
                    </div> <!-- /.card-body -->
                    <div class="card-body p-3">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-info">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($drivers as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a data-toggle="modal" data-target=".update-modal-{{ $item->id }}"
                                                style="padding:2px; color:white" class="btn btn-xs btn-info  mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('drivers-delete', $item->id) }}"
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
                    <h5>Add Driver Information</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('drivers-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row pt-3">
                            <div class="col-md-6 my-2">
                                <div class="row">
                                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                                    <label for="" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-8">
                                        <input name="name" type="text" class="form-control" placeholder="Driver name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="row">
                                    <label for="mobile_number" class="col-sm-3 col-form-label">Mobile Number</label>
                                    <label for="" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-8">
                                        <input name="mobile_number" type="number" class="form-control"
                                            placeholder="Mobile Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="row">
                                    <label for="nid" class="col-sm-3 col-form-label">Nid</label>
                                    <label for="" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-8">
                                        <input name="nid" type="number" class="form-control" placeholder="Nid number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="row">
                                    <label for="license_no" class="col-sm-3 col-form-label">License No</label>
                                    <label for="" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-8">
                                        <input name="license_no" type="number" class="form-control"
                                            placeholder="License No">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="row">
                                    <label for="issue_date" class="col-sm-3 col-form-label">Issue Date</label>
                                    <label for="" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-8">
                                        <input name="issue_date" type="date" class="form-control"
                                            placeholder="License No">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="row">
                                    <label for="document" class="col-sm-4 col-form-label">Document</label>
                                    <div class="col-sm-8">
                                        <input name="document" type="file" class="form-control-file">
                                    </div>
                                </div>
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

    @foreach ($drivers as $item)
        @php

        @endphp

        <div class="modal fade update update-modal-{{ $item->id }}" id="exampleModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-center">
                        <h5>Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('drivers-update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group row pt-3">
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                                        <label for="" class="col-sm-1 col-form-label">:</label>
                                        <div class="col-sm-8">
                                            <input name="name" type="text" class="form-control"
                                                placeholder="Driver name" value="{{ $item->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <label for="mobile_number" class="col-sm-3 col-form-label">Mobile Number</label>
                                        <label for="" class="col-sm-1 col-form-label">:</label>
                                        <div class="col-sm-8">
                                            <input name="mobile_number" type="number" class="form-control"
                                                placeholder="Mobile Number" value="{{ $item->mobile_number }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <label for="nid" class="col-sm-3 col-form-label">Nid</label>
                                        <label for="" class="col-sm-1 col-form-label">:</label>
                                        <div class="col-sm-8">
                                            <input name="nid" type="number" class="form-control"
                                                placeholder="Nid number" value="{{ $item->nid }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <label for="license_no" class="col-sm-3 col-form-label">License No</label>
                                        <label for="" class="col-sm-1 col-form-label">:</label>
                                        <div class="col-sm-8">
                                            <input name="license_no" type="number" class="form-control"
                                                placeholder="License No" value="{{ $item->license_no }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <label for="issue_date" class="col-sm-3 col-form-label">Issue Date</label>
                                        <label for="" class="col-sm-1 col-form-label">:</label>
                                        <div class="col-sm-8">
                                            <input name="issue_date" type="date" class="form-control"
                                                value="{{ $item->issue_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <label for="document" class="col-sm-4 col-form-label">Document</label>
                                        <div class="col-sm-8">
                                            <input name="document" type="file" class="form-control-file">
                                        </div>
                                        @if (isset($item->document) && !empty($item->document))
                                            <div class="mt-2">
                                                <a href="{{ asset($item->document) }}" target="_blank"
                                                    class="document-icon">
                                                    <i class="fas fa-file-pdf"></i> <!-- PDF Icon -->
                                                    View Document
                                                </a>
                                            </div>
                                        @endif
                                    </div>
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
