
@extends('layouts.app')

@section('content')
<div class="container pl-4">
    <div class="row mb-4 mt-4">
        <div class="col-md-12">
            <h2>কর্মকর্তা/কর্মচারী যানবাহন অনুরোধের তালিকা</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
    </div>

    <div class="row table-responsive">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ক্রমিক নং</th>
                        <th>আবেদনের প্রকার </th>
                        <th>ব্যবহারের তারিখ</th>
                        <th>আবেদনের তারিখ</th>
                        <th>সময়</th>
                        <th>কর্মকর্তা/কর্মচারী</th>
                        <th>গন্তব্য জেলা</th>
                        {{-- <th>Total Miles</th> --}}
                        {{-- <th>Expense Type</th> --}}
                        <th>প্রকল্পের নাম</th>
                        <th>যানবাহনের প্রকার</th>
                        <th>যাত্রী সংখ্যা </th>
                        <th>ব্যবহারের উদ্দেশ্য</th>
                        {{-- <th>Note</th> --}}
                        <th>অনুমোদনের অবস্থা</th>
                        {{-- <th>Status</th> --}}
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requisitions as $requisition)
                        <tr>
                            <td>{{ $requisition->id }}</td>
                            <td>{{ $requisition->applicant_type == 'সরকারি' ? 'সরকারি' : 'বেসরকারি' }}</td>
                           <td>{{ \Carbon\Carbon::parse($requisition->usage_date)->format('d/m/Y') ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($requisition->requisition_date)->format('d/m/Y') ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($requisition->from_time)->format('h:i A') }}-{{ \Carbon\Carbon::parse($requisition->from_time)->format('h:i A') }}</td>
                            <td>{{ $requisition->employee->name ?? 'N/A' }}</td>
                            <td>{{ $requisition->district->name ?? 'N/A' }}</td>
                            {{-- <td>{{ $requisition->total_miles }}</td> --}}
                            {{-- <td>{{ $requisition->expense_type }}</td> --}}
                            <td>{{ $requisition->name_of_project }}</td>
                            <td>{{ $requisition->type->vehicle_type ?? 'N/A' }}</td>
                            <td>{{ $requisition->number_of_passenger }}</td>
                            <td>{{ $requisition->purpose }}</td>
                            {{-- <td>{{ $requisition->note }}</td> --}}
                            <td>
                                @if($requisition->forward_status == 1)
                                    <span class="text-bold" style="color: green">Stay On Director</span>
                                @elseif($requisition->forward_status == 2)
                                    <span class="text-bold" style="color: green">Stay On DGM</span>
                                @elseif($requisition->forward_status == 3)
                                    <span class="text-bold" style="color: green">Stay On TSO</span>
                                @else
                                    <span class="text-bold" style="color: green">Approved</span>
                                @endif
                                {{-- {{ $requisition->forward_status ? 'Forwarded' : 'Not Forwarded' }} --}}
                            </td>
                            {{-- <td>{{ $requisition->status ? 'Active' : 'Inactive' }}</td> --}}
                            <td>
                                <button data-toggle="modal" onclick="load_body('{{$requisition->id}}')" data-target="#modal-view" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                <a href="{{ route('requisition.forward', $requisition->id) }}" class="btn btn-secondary btn-sm">Forward</a>
                                <a href="{{ route('requisition.reject', $requisition->id) }}" class="btn btn-secondary btn-danger">Reject</a>
                                {{-- <a href="{{ route('requisitions.edit', $requisition->id) }}" class="btn btn-primary btn-sm">Edit</a> --}}
                                {{-- <form action="{{ route('requisitions.destroy', $requisition->id) }}" method="POST" style="display:inline;"> --}}
                                    {{-- @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this requisition?');">Delete</button> --}}
                                {{-- </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="18" class="text-center">No requisitions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $requisitions->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Employee Profile</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="view_modal">

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function load_body(id){
      url = '{{ route('load_requisition_view', ":id") }}';
      url = url.replace(':id', id);
      $.ajax({
        cache   : false,
        type    : "GET",
        error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
        url : url,
        success : function(response){
            $('#view_modal').html(response);
        }
    })
  }
</script>
@endsection

