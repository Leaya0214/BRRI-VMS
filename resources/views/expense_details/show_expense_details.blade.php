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

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }
</style>

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title col-sm-11">
                            All Expenses
                        </h3>
                    </div> 
                    <div class="card-body p-3">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Expense Invoice</th>
                                    <th>Vehicle Name</th>
                                    <th>Total Amount</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($expenseMaster as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->master_invoice }}</td>
                                        <td>{{ $item->vehicelInfo->vchl_model }}</td>
                                        <td>{{ $item->total_expense_amount }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->from_date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->to_date)->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('expense-details-edit', $item->id) }}" class="btn btn-info btn-xs mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a data-toggle="modal" data-target=".view-modal-{{ $item->id }}" class="btn btn-primary btn-xs mr-1">
                                                <i class="fa fa-list"></i>
                                            </a>
                                            <a href="{{ route('expense-details-edit', $item->id) }}" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($expenseMaster as $expense)
        <div class="modal fade view-modal-{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Expense Details</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="3" class="bg-info text-white text-center">Vehicle Expense</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Vehicle Model</th>
                                                <td>:</td>
                                                <td>{{ $expense->vehicelInfo->vchl_model }}</td>
                                            </tr>
                                            <tr>
                                                <th>Registration No.</th>
                                                <td>:</td>
                                                <td>{{ $expense->vehicelInfo->reg_no }}</td>
                                            </tr>
                                            <tr>
                                                <th>Expense From Date</th>
                                                <td>:</td>
                                                <td>{{ \Carbon\Carbon::parse($expense->from_date)->format('d-m-Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Expense To Date</th>
                                                <td>:</td>
                                                <td>{{ \Carbon\Carbon::parse($expense->to_date)->format('d-m-Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Expense Details</th>
                                                <td>:</td>
                                                <td>{{ $expense->details }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <h6 class="text-info text-center mt-4">Vehicle Expense Details</h6>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Expense Category Name</th>
                                            <th>Expense Head Name</th>
                                            <th>Amount</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 0; @endphp
                                        @foreach ($expense->expenseDetails as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                                <td>{{ $item->expenseCategory->name }}</td>
                                                <td>{{ $item->expenseHead->name }}</td>
                                                <td>{{ $item->amount }}</td>
                                                <td>{{ $item->note }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total Amount</th>
                                            <th>{{ $expense->total_expense_amount }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
