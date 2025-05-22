@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        Item List
                        <button class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modal-add">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Item
                        </button>
                    </h3> 
                </div> <!-- /.card-body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{url('item-print')}}" target="_blank" class="btn btn-warning float-end m-2">
                                <i class="fa fa-print" aria-hidden="true"></i> Print 
                            </a>
                            <a href="{{url('item-pdf')}}" target="_blank" class="btn  btn-danger float-end m-2">
                                <i class="fas fa-file-pdf" aria-hidden="true"></i> Pdf 
                            </a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info text-center">
                                <th>SL</th>
                                <th>Code No.</th>
                                <th>Company</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Size/Type</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach ($item_data as $item)
                            {{-- @dd($item) --}}
                            <tr>
                                <td> @php
                                    $i = ($item_data instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($loop->iteration + ($item_data->perPage() * ($item_data->currentPage() - 1)))  : ++$i;
                                @endphp {{$i}}
                                </td>
                                <td>{{ $item->code_no }}</td>
                                <td>{{ $item->company->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->category_name }}</td>
                                <td>{{ $item->size_type }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>
                                    @if ($item->status == '1')
                                        <a href="{{ route('change-item-status',['0',$item->id]) }}" class="text-success text-bold">Active</a>
                                    @else
                                        <a href="{{ route('change-item-status',['1',$item->id]) }}" class="text-danger text-bold">Inactive</a>
                                    @endif
                                </td>
                                <td>
                                    <button data-toggle="modal" onclick="load_edit_body('{{$item->id}}','{{$item->name}}','{{$item->company_id}}','{{$item->size_type}}','{{$item->unit}}','{{$item->category_id}}','{{$item->code_no}}')" data-target="#modal-edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row pt-3">
                        <div class="col-lg-12">
                            @if($item_data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $item_data->links() }}
                            @endif
                        </div>
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
          <h4 class="modal-title">Add Item</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('save-item') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Name/Description</label>
                        <input type="text" class="form-control" name="name"
                            placeholder="Enter item name">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Category</label>
                        <select name="category_id" id="category" class="form-control" onchange="generateCode()">
                            <option value="">Select a Category</option>
                            @foreach($item_category as $v_category)
                                <option value="{{$v_category->id}}"> {{$v_category->category_name}} </option>
                            @endforeach
                            {{-- <option value="Electronics">Electronics</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Tools and Equipment">Tools and Equipment</option>
                            <option value="Consumables">Consumables</option> --}}
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Code</label>
                        <input type="text" class="form-control" name="code_no" id="code_no" 
                            placeholder="generate the item code">
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Size/Type</label>
                        <input type="text" class="form-control" name="size_type"
                            placeholder="Item size/type">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Unit Of Measure</label>
                        <select name="unit" class="select2 form-control" id="">
                           <option value="">Select Unit</option>
                           <option value="Kilogram">Kilogram</option>
                           <option value="Meter">Meter</option>
                           <option value="Piece">Piece</option>
                           <option value="Box">Box</option>
                           <option value="Packet">Packet</option>
                           <option value="Pcs">Pcs</option>
                           <option value="Inch">Inch</option>
                           <option value="Kg">Kg</option>
                           <option value="Bag">Bag</option>
                           <option value="Mm">Mm</option>
                           <option value="Cft">Cft</option>
                           <option value="Ton">Ton</option>
                           <option value="Litter">Litter</option>
                        </select>

                    </div>
                </div>
                {{-- <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Asset Type</label>
                        <select name="asset_type" class="form-control">
                            <option value="Current">Current</option>
                            <option value="Fixed">Fixed</option>
                        </select>
                    </div>
                </div> --}}
                
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
          <h4 class="modal-title">Update Item</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('update-item') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="item_id">
            <div class="modal-body">
            <div class="row">
               <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Name/Description</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter item name">
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Category</label>
                        <select name="category" id="category_id" class="form-control" onchange="generateCode()">
                            <option value="">Select a Category</option>
                            @foreach($item_category as $v_category)
                                <option value="{{$v_category->id}}"> {{$v_category->category_name}} </option>
                            @endforeach
                            {{-- <option value="Electronics">Electronics</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Tools and Equipment">Tools and Equipment</option>
                            <option value="Consumables">Consumables</option> --}}
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Code</label>
                        <input type="text" class="form-control" name="code_no" id="code_no_edit"
                            placeholder="generate the item code">
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Item Size/Type</label>
                        <input type="text" class="form-control" name="size_type"
                            placeholder="Item size/type" id="size_type">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Unit Of Measure</label>
                        <select name="unit" class="select2 form-control " id="edit_unit">
                           
                                <option value="">Select Unit</option>
                                <option value="Kilogram">Kilogram</option>
                                <option value="Meter">Meter</option>
                                <option value="Piece">Piece</option>
                                <option value="Box">Box</option>
                                <option value="Packet">Packet</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Inch">Inch</option>
                                <option value="Kg">Kg</option>
                                <option value="Bag">Bag</option>
                                <option value="Mm">Mm</option>
                                <option value="Cft">Cft</option>
                                <option value="Ton">Ton</option>
                                <option value="Litter">Litter</option>
                            
                        </select>
                    </div>
                </div>
                {{-- <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Asset Type</label>
                        <select name="asset_type" class="form-control">
                            <option value="Current">Current</option>
                            <option value="Fixed">Fixed</option>
                        </select>
                    </div>
                </div> --}}
                
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
<script>
    function load_edit_body(item_id,name,company_id,size_type,unit,category,code_no){
        $('#item_id').val(item_id);
        $('#code_no_edit').val(code_no);
        $('#name').val(name);
        $('#size_type').val(size_type);
        $('#edit_unit').val(unit);
        $('#category_id').val(category);
    }
</script>
@endsection

@push('script_js')
<script>
    function generateCode() {
        var category_id = document.getElementById('category').value;
            if (category_id) {
            var lastId = {{$item_code ?? 0}}; // Set lastItem Id to 0 if it's not available
            // console.log(lastId);
            var nextId = lastId + 1; // Increment last Item ID or start from 1 if no previous item
            var code = '#ITEM00-' + nextId;
            document.getElementById('code_no').value = code;
            } else {
                document.getElementById('code_no').value = ''; // Reset if no category selected
            }
        }
</script>

<script>
	$(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush

