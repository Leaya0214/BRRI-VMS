@extends('layouts.print')
@section('content')
<h1 class="text-center"  style="text-align:center !important">Item List</h1>

<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr class="bg-info text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Company</th>
            <th>Size/Type</th>
            <th>Unit</th>
            <th>Asset Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($item_data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->company->name }}</td>
            <td>{{ $item->size_type }}</td>
            <td>{{ $item->unit }}</td>
            <td>{{ $item->asset_type }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection