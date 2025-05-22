@php
    use App\Models\Expense;
    use App\Models\Income;
    use App\Models\Payment;
@endphp


@extends('layouts.print')

@section('date')
    <h6 style="text-align:right !important;">Date: {{$start_date ?  date('d/m/Y',strtotime($start_date))  : date('d/m/Y')}}</h6>
@endsection

@section('content')


{{-- <p  style="text-align:center !important">Punam Palace, Holding: 464, Badurtala, 1st Kandirpar, Cumilla - 3500</p> --}}

<h1 class="text-center"  style="text-align:center !important">Project List</h1>

<table class="table table-bordered table-striped">
    <thead>
        <tr class="bg-info text-center">
            <th>ID</th>
            {{-- <th>Company</th> --}}
            <th>Name</th>
            <!--<th>Location</th>-->

            <th>Tender ID</th>
             <!--<th>Description</th>-->
            <!--<th>Authority</th>-->
            <th>Start Date</th>
            <th>End Date</th>
            <th>Contact Amount</th>

            <th>Estimated Cost</th>

            <th>Project Recived Amt </th>

            <th>Project Expance Amt</th>

            <th>Profit/loss</th>

            <!--<th>Status</th>-->
        </tr>
    </thead>
    <tbody>
        @php
            $total_contact_amount = 0;
            $total_estimated_cost = 0;
            $total_receive_amount = 0;
            $total_expense_amount = 0;
            $total_profit_loss = 0;
        @endphp
        @foreach ($project_data as $item)
        @php
           $income = Income::where('project_id', $item->id)
                        ->where('status', 1);

            $expense = Expense::where('project_id', $item->id)
                ->where('status', 1);

            $payment = Payment::where('project_id', $item->id)
                ->where('status', 1);


            if($start_date && $end_date){
                $income->whereBetween('payment_date',[$start_date,$end_date]);
                $expense->whereBetween('payment_date',[$start_date,$end_date]);
                $payment->whereBetween('payment_date',[$start_date,$end_date]);
            }

            $income  = $income->sum('amount');
            $expense = $expense->sum('amount');
            $payment = $payment->sum('amount');
            $profit = $income - ($expense + $payment);

            $total_contact_amount += $item->project_amount;
            $total_estimated_cost += $item->estimated_cost;
            $total_receive_amount += $income;
            $total_expense_amount += $expense;
            $total_profit_loss += $profit;
        @endphp
        <tr>
            <td>{{ $item->id }}</td>
            {{-- <td>{{ $item->company->name }}</td> --}}
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }} </td>
            <!--<td>{{ $item->location }}</td>-->
            <!--<td>{{ $item->description }}</td>-->
            <!--<td>{{ $item->authority }}</td>-->
            <td>{{ $item->start_date ? date('d/m/Y',strtotime($item->start_date)) : '' }}</td>
            <td>{{ $item->end_date ? date('d/m/Y',strtotime($item->end_date)) : '' }}</td>
            <td>{{ $item->project_amount }}</td>
            <td>{{ $item->estimated_cost }} </td>
            <td>{{ $income > 0 ? $income :'' }}</td>
            <td>{{ $expense >0 ? $expense :'' }}</td>
            <td>{{ $profit }}</td>
            <!--<td>-->
            <!--    @if ($item->status == '1')-->
            <!--        <span class="btn btn-block btn-outline-info">Not Started</span>-->
            <!--    @elseif ($item->status == '2')-->
            <!--        <span class="btn btn-block btn-outline-primary">In Progress</span>-->
            <!--    @elseif ($item->status == '3')-->
            <!--        <span class="btn btn-block btn-outline-warning">On Hold</span>-->
            <!--    @elseif ($item->status == '4')-->
            <!--        <span class="btn btn-block btn-outline-danger">Canceled</span>-->
            <!--    @elseif ($item->status == '5')-->
            <!--        <span class="btn btn-block btn-outline-success">Completed</span>-->
            <!--    @endif-->
            <!--</td>-->

        </tr>
        @endforeach
        <tr>
            <th colspan="5" >Total</th>
            <th>{{ $total_contact_amount}}</th>
            <th>{{ $total_estimated_cost}}</th>
            <th>{{ $total_receive_amount}}</th>
            <th>{{ $total_expense_amount}}</th>
            <th>{{ $total_profit_loss}}</th>
        </tr>
    </tbody>

  </table>
@endsection
