<?php

namespace App\Http\Controllers\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\ExpenseDetails;
use App\Models\ExpenseMaster;
use App\Models\Vehicle;
use App\Models\VehicleExpenseCategory;
use App\Models\VehicleExpenseHead;
use Illuminate\Http\Request;

class ExpenseDetailsController extends Controller
{
    public function index()
    {
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'expense-details';
        $data['vehicle'] = Vehicle::all();
        $data['expenseCategories'] = VehicleExpenseCategory::all();
        $data['expenseHeads'] = VehicleExpenseHead::all();
        // Calculate the total amount for all expense details
        
        $data['expenseMaster'] = ExpenseMaster::with(['vehicelInfo', 'expenseDetails'])->get();
       
        return view('expense_details.show_expense_details', $data);
    }
    public function addExpense()
    {
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'add-expense-details';
        $data['vehicle'] = Vehicle::all();
        $data['expenseCategories'] = VehicleExpenseCategory::all();
        $data['expenseHeads'] = VehicleExpenseHead::all();
        $data['expenseMaster'] = ExpenseMaster::all();
        return view('expense_details.index', $data);
    }

    public function getExpenseHead($id)
    {
        $head = VehicleExpenseHead::where('category_id', $id)->get();
        return response()->json($head);
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'to_date' => 'required|date',
            'from_date' => 'required|date',
            'details' => 'nullable|string',
            'date*' => 'required|date',
            'category_id.*' => 'required|integer|exists:vehicle_expense_categories,id', // Validate project IDs
            'head_id.*' => 'required|integer|exists:vehicle_expense_heads,id', // Validate project IDs
            'note.*' => 'nullable|string', // Validate notes
            'amount.*' => 'required|integer|min:0'

        ]);
        $expense = ExpenseMaster::latest()->first();

        if ($expense) {
            $invoice_no = 'EXP-00' . $expense->id + 1;
        } else {
            $invoice_no = 'EXP-001';
        }


        $master = ExpenseMaster::create([
            'master_invoice' => $invoice_no,
            'vehicle_id' => $request->vehicle_id,
            'to_date' => $request->to_date,
            'from_date' => $request->from_date,
            'details' => $request->details,
        ]);

        $categoryIds = $request->input('category_id');
        $date = $request->input('date', []);
        $heads = $request->input('head_id', []);
        $notes = $request->input('note', []);
        $amount = $request->input('amount', []);
        foreach ($categoryIds as $index => $dataId) {
            ExpenseDetails::create([
                'category_id' => $dataId,
                'head_id' => $heads[$index],
                'expense_master_id' => $master->id,
                'date' => $date[$index],
                'note' => $notes[$index] ?? null, // Use null if note is not provided
                'amount' => $amount[$index] ?? null, // Use null if note is not provided
            ]);
        }
        return redirect()->route('expense-details-add')->with('status', 'Data created successfully');
    }
    public function edit($id)
    {
        $data['main_menu']  = 'vehicle-management';
        $data['child_menu'] = 'expense-details';


        $data['vehicles'] = Vehicle::all();
        $data['expenseCategories'] = VehicleExpenseCategory::all();
        $data['expenseHeads'] = VehicleExpenseHead::all();

        // Retrieve the expense master entry by ID
        $data['expenseMaster'] = ExpenseMaster::with('vehicelInfo')->findOrFail($id);

        // Retrieve associated expense details, ensure it's an array even if empty
        $data['expenseDetails'] = $data['expenseMaster']->expenseDetails ?: [];

        return view('expense_details.edit_expense_details', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'to_date' => 'required|date',
            'from_date' => 'required|date',
            'details' => 'nullable|string',
            'date*' => 'required|date',
            'category_id.*' => 'required|integer|exists:vehicle_expense_categories,id', // Validate project IDs
            'head_id.*' => 'required|integer|exists:vehicle_expense_heads,id', // Validate project IDs
            'note.*' => 'nullable|string', // Validate notes
            'amount.*' => 'required|integer|min:0'
        ]);
        $data = ExpenseMaster::findOrFail($id);

        $data->update([
            'vehicle_id' => $request->input('vehicle_id'),
            'to_date' => $request->input('to_date'),
            'from_date' => $request->input('from_date'),
            'details' => $request->input('details'),
        ]);

        ExpenseDetails::where('expense_master_id', $data->id)->delete();

        $categoryIds = $request->input('category_id');
        $date = $request->input('date', []);
        $heads = $request->input('head_id', []);
        $notes = $request->input('note', []);
        $amount = $request->input('amount', []);
        foreach ($categoryIds as $index => $dataId) {
            ExpenseDetails::create([
                'category_id' => $dataId,
                'head_id' => $heads[$index],
                'expense_master_id' => $data->id,
                'date' => $date[$index],
                'note' => $notes[$index] ?? null, // Use null if note is not provided
                'amount' => $amount[$index] ?? null, // Use null if note is not provided
            ]);
        }
        return redirect()->route('expense-details-index')->with('status', 'Data updated successfully');
    }
}
