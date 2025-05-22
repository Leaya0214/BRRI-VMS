@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Custom styles for modal and form -->
<style>
    /* ... Your existing styles ... */
</style>

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title col-sm-11">
                            Edit Vehicle Expense
                        </h3>
                    </div>
                    <form id="editForm" method="POST" action="{{ route('expense-details-update', $expenseMaster->id) }}"
                        enctype="multipart/form-data" class="form-horizontal p-4 shadow rounded bg-light">
                        @csrf
                        @method('PUT')
                        <div class="container">
                            <h4 class="text-center border-bottom pb-3 mb-4" style="color: #17a2b8"><strong>Edit Vehicle
                                    Expenses</strong></h4>

                            <!-- Existing fields for vehicle, from_date, to_date, details -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-secondary" for="vehicle_id">Select
                                    Vehicle</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="vehicle_id" id="vehicle_id">
                                        <option value="">Select Vehicle</option>
                                        @foreach ($vehicles as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $expenseMaster->vehicle_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->vchl_model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-secondary" for="from_date">From Date</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" name="from_date" id="from_date"
                                        value="{{ $expenseMaster->from_date }}">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-secondary" for="to_date">To Date</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" name="to_date" id="to_date"
                                        value="{{ $expenseMaster->to_date }}">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-sm-3 col-form-label text-secondary" for="details">Expense Details</label>
                                <div class="col-sm-8">
                                    <textarea name="details" class="form-control" id="details" cols="30" rows="4"
                                        placeholder="Write details...">{{ $expenseMaster->details }}</textarea>
                                </div>
                            </div>

                            <!-- Table for Expense Details -->
                            <h5 class="text-center border-bottom pb-3 mb-4" style="color: #17a2b8"><strong>Edit Vehicle
                                    Expense Details</strong></h5>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Date</th>
                                            <th>Expense Category</th>
                                            <th>Expense Head</th>
                                            <th>Amount</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="field_wrapper">
                                        @foreach ($expenseMaster->expenseDetails as $detail)
                                            <tr>
                                                <td><input type="date" class="form-control" name="date[]"
                                                        value="{{ $detail->date }}"></td>
                                                <td>
                                                    <select class="form-control category-select" name="category_id[]">
                                                        <option value="" disabled>Select Expense Category</option>
                                                        @foreach ($expenseCategories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $detail->category_id == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control head-select" name="head_id[]">
                                                        <option value="" disabled>Select Expense Head</option>
                                                        @foreach ($expenseHeads as $head)
                                                            <option value="{{ $head->id }}"
                                                                {{ $detail->head_id == $head->id ? 'selected' : '' }}>
                                                                {{ $head->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control" placeholder="Amount"
                                                        name="amount[]" value="{{ $detail->amount }}" min="0"
                                                        step="0.01"></td>
                                                <td><input type="text" class="form-control" name="note[]"
                                                        value="{{ $detail->note }}" placeholder="Write note..."></td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-row">-</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group text-center mt-4">
                                <button type="button" id="add-new-more" title="Add field"
                                    class="btn btn-outline-primary btn-sm">Add More</button>
                                <button type="submit" name="btnSubmit" title="Save"
                                    class="btn btn-success btn-sm ml-2">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('change', '.category-select', function() {
            let categoryId = $(this).val();
            let $row = $(this).closest('tr');

            if (categoryId) {
                $.ajax({
                    url: '/get-expense-head/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let $headSelect = $row.find('.head-select');
                        $headSelect.empty().append('<option value="">Select Expense Head</option>');
                        $.each(data, function(key, value) {
                            $headSelect.append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                    }
                });
            } else {
                $row.find('.head-select').empty();
            }
        });
        document.getElementById('add-new-more').addEventListener('click', function() {
            var fieldWrapper = document.getElementById('field_wrapper');
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="date" class="form-control" name="date[]"></td>
                <td>
                    <select class="form-control category-select" name="category_id[]">
                        <option value="" disabled selected>Select Expense Category</option>
                        @foreach ($expenseCategories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control head-select" name="head_id[]">
                        <option value="" disabled selected>Select Expense Head</option>
                    </select>
                </td>
                <td><input type="number" class="form-control" placeholder="Amount" name="amount[]" min="0" step="0.01"></td>
                <td><input type="text" class="form-control" name="note[]" placeholder="Write note..."></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                </td>
            `;

            fieldWrapper.appendChild(newRow);

            // Add event listener for the remove button in the newly added row
            newRow.querySelector('.remove-row').addEventListener('click', function() {
                newRow.remove();
            });
        });

        // Remove row functionality
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    </script>
@endsection
