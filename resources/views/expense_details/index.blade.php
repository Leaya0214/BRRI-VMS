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
<style>
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
</style>
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title col-sm-11">
                            Set-up Vehicle
                        </h3>
                    </div> <!-- /.card-body -->
                    <form id="myForm" method="POST" action="{{ route('expense-details-store') }}" enctype="multipart/form-data" class="form-horizontal p-4 shadow rounded bg-light">
                        @csrf
                        <div class="container">
                            <h4 class="text-center border-bottom pb-3 mb-4" style="color: #17a2b8"><strong>Add Vehicle
                                    Expenses</strong></h4>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-secondary" for="vehicle_id">Select
                                    Vehicle</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="vehicle_id" id="vehicle_id"
                                        data-placeholder="Choose a vehicle...">
                                        <option value="">Select Vehicle</option>
                                        @foreach ($vehicle as $item)
                                            <option value="{{ $item->id }}">{{ $item->vchl_model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-secondary" for="from_date">From Date</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" name="from_date" id="from_date">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-secondary" for="to_date">To Date</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" name="to_date" id="to_date">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-sm-3 col-form-label text-secondary" for="details">Expense Details</label>
                                <div class="col-sm-8">
                                    <textarea name="details" class="form-control" id="details" cols="30" rows="4"
                                        placeholder="Write details..."></textarea>
                                </div>
                            </div>

                            <!-- Expense Details Table -->
                            <h5 class="text-center border-bottom pb-3 mb-4" style="color: #17a2b8"><strong>Add Vehicle
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
                                            <th>Add</th>
                                        </tr>
                                    </thead>
                                    <tbody id="field_wrapper">
                                        <tr>
                                            <td><input type="date" class="form-control" name="date[]"></td>
                                            <td>
                                                <select class="form-control category-select" id="category_id" name="category_id[]">
                                                    <option value="" disabled selected>Select Expense Category
                                                    </option>
                                                    @foreach ($expenseCategories as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control head-select" id="head_id" name="head_id[]">
                                                    <option value="" disabled selected>Select Expense Head</option>

                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control" placeholder="Amount"
                                                    id="amount_1" name="amount[]" min="0" step="0.01"></td>
                                            <td><input type="text" class="form-control" name="note[]"
                                                    placeholder="Write note..."></td>
                                            <td class="text-center">
                                                <a id="add-more" title="Add field"
                                                    class="text-primary font-weight-bold">+</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group text-center mt-4">
                                <button type="button" id="add-new-more" title="Add field"
                                    class="btn btn-outline-primary btn-sm">Add More</button>
                                <button type="submit" name="btnSubmit" title="Save"
                                    class="btn btn-success btn-sm ml-2">Save</button>
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
            var categoryId = $(this).val();
            var $row = $(this).closest('tr'); // Find the closest row to apply changes within that row only

            if (categoryId) {
                $.ajax({
                    url: '/get-expense-head/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var $headSelect = $row.find(
                        '.head-select'); // Target the head select in the same row
                        $headSelect.empty();
                        $headSelect.append('<option value="">Select Expense Head</option>');
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

        document.getElementById('add-more').addEventListener('click', function() {
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
    </script>
@endsection
