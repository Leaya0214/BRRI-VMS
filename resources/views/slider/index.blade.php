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
                            Slider
                        </h3>
                        <button class="text-end col-sm-1 btn btn-success btn-sm" data-toggle="modal"
                            data-target="#exampleModal">+Add</button>
                    </div> <!-- /.card-body -->
                    <div class="card-body p-3">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-info">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    {{-- <th>Position</th> --}}
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($slider as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{$item->title }}</td>
                                        {{-- <td>{{$item->position}}</td> --}}
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset($item->image) }}" alt="Slider Image" width="100">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>
                                            <a data-toggle="modal" data-target=".update-modal-{{ $item->id }}"
                                                style="padding:2px; color:white" class="btn btn-xs btn-info  mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('sliders-delete', $item->id) }}"
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
                    <h5>Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('sliders-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row pt-3">
                            <label for="title" class="col-sm-3 col-form-label">Title</label>
                            <label for="title" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-8">
                                <input name="title" type="text" class="form-control">
                            </div>
                        </div>
                        {{-- <div class="form-group row pt-3">
                            <label for="position" class="col-sm-3 col-form-label">position</label>
                            <label for="position" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-8">
                                <input name="position" type="text" class="form-control">
                            </div>
                        </div> --}}
                        <div class="form-group row pt-3">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            <label for="image" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-8">
                                <input name="image" type="file" class="form-control">
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

    @foreach ($slider as $item)
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
                    <form action="{{ route('sliders-update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group row pt-3">
                                <label for="title" class="col-sm-3 col-form-label">Title</label>
                                <label for="title" class="col-sm-1 col-form-label">:</label>
                                <div class="col-sm-8">
                                    <input name="title" type="text" class="form-control" value="{{$item->title}}">
                                </div>
                            </div>
                            {{-- <div class="form-group row pt-3">
                                <label for="position" class="col-sm-3 col-form-label">position</label>
                                <label for="position" class="col-sm-1 col-form-label">:</label>
                                <div class="col-sm-8">
                                    <input name="position" type="text" class="form-control" value="{{$item->position}}">
                                </div>
                            </div> --}}
                            <div class="form-group row pt-3">
                                <label for="image" class="col-sm-3 col-form-label font-weight-bold">Image</label>
                                <label for="image" class="col-sm-1 col-form-label">:</label>
                                <div class="col-sm-8">
                                    <input name="image" type="file" class="form-control">
                                    <!-- Display the current image below the input field with styling -->
                                    @if ($item->image)
                                        <div class="mt-3 p-2 border rounded bg-light">
                                            <p class="text-muted mb-2">Current Image:</p>
                                            <img src="{{ asset( $item->image) }}" alt="Current Image" class="img-thumbnail" width="150">
                                        </div>
                                    @endif
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
