@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice__display{
        padding-left: 15px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover{
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
                        Item Size/Type List
                    </h3>
                    <button class="text-end col-sm-1 btn btn-success btn-sm"  data-toggle="modal"
                    data-target="#exampleModal" >+Add</button> 
                </div> <!-- /.card-body -->
                <div class="card-body p-3">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-info">
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Size/Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                          @foreach($itemSizeType as $type)
                          <tr>
                            <td>{{++$i}}</td>
                            <td>{{$type->item->name}}</td>
                            <td>{{$type->size_type}}</td>
                            <td>
                                <a data-toggle="modal"
                                    data-target=".update-modal-{{$type->id}}"
                                    style="padding:2px; color:white" class="btn btn-xs btn-info  mr-1">
                                   <i class="fas fa-edit"></i>
                                </a>
                                @if($type->status == 1)
                                    <a href="{{route('size-type-status',$type->id)}}"
                                        onclick="return confirm('Are you sure you want to change status?');"
                                        style="padding: 2px;" class=" btn btn-xs btn-success  mr-1">
                                        <i class="fas fa-arrow-up"></i>
                                    </a>
                                @else
                                    <a href="{{route('size-type-status',$type->id)}}"
                                        onclick="return confirm('Are you sure you want to change status?');"
                                        style="padding: 2px;" class=" btn btn-xs btn-danger  mr-1">
                                        <i class="fas fa-arrow-down"></i>
                                    </a>
                                @endif
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

<div class="modal fade create_modal" id="exampleModal"
    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-center">
                <h5 >Add Item Category</h5>
                <button type="button" class="close"
                data-dismiss="modal">&times;</button>
            </div>
            <form action="{{route('itemSizeType.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body"> 
                   <div class="form-group row pt-3">
                        <label for="item_id" class="col-sm-3 col-form-label">Item <i class="text-danger">*</i></label>
                        <label for="" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-8">
                            <select name="item_id" id="" class="form-control chosen-select" required>
                                <option value="">Select One</option>
                                @foreach($item as $v_item)
                                    <option value="{{$v_item->id}}">{{$v_item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row pt-3">
                  
                        <label for="size" class="col-sm-3 col-form-label">Size/Type Name <i class="text-danger">*</i></label>
                        <label for="" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-8">
                            <input name="size" type="text" class="form-control" placeholder="Size/Type............" required>
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

@foreach($itemSizeType as $s_type)
<div class="modal fade update update-modal-{{$s_type->id}}" id="exampleModal"
    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-center">
                <h5 >Edit Capital Category</h5>
                <button type="button" class="close"
                data-dismiss="modal">&times;</button>
            </div>
            <form action="{{route('itemSizeType.update',$s_type->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body"> 
                    <div class="form-group row pt-3">
                        <label for="item_id" class="col-sm-3 col-form-label">Item <i class="text-danger">*</i></label>
                        <label for="" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-8">
                            <select name="item_id" id="" class="form-control chosen-select" required>
                                @foreach($item as $v_item)
                                    <option value="{{$v_item->id}}" {{$v_item->id == $s_type->item_id ? 'selected' : ''}}>{{$v_item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   <div class="form-group row pt-3">
                        <label for="category_name" class="col-sm-3 col-form-label">Size/Type</label>
                        <label for="" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-8">
                            <input name="size_type" type="text" class="form-control" value="{{$s_type->size_type}}" placeholder="">
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
@push('script_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.create_modal').on('shown.bs.modal', function () {
            $(".chosen-select").chosen();
        });
        // $('.update').on('shown.bs.modal', function () {
        //     $('.js-example-basic-multiple').select2();
        // });
    });
</script>

@endpush