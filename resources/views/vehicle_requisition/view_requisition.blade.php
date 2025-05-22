@php
    $company = App\Models\Company::first();
@endphp

<div class="row">
    <div class="col-sm-12 text-right">
        @php $date = date('d/m/Y'); @endphp
        <button class="mt-2 col-sm-2 btn btn-info"
            onClick="document.title = '{{ $company->name }}-Requisition form-{{ $date }}'; printArea('printableArea');"
            style="">
            <i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div id="printableArea">

            <style>
                .view-container {
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #000;
                }

                .form-group label {
                    font-size: 15px !important;
                }

                .header-text,
                .sub-header-text {
                    text-align: center;
                    font-weight: bold;
                }

                .header-text {
                    font-size: 1.2em;
                }

                .sub-header-text {
                    font-size: 1.1em;
                    text-decoration: underline;
                }

                .table-c .table-bordered td,
                .table-c .table-bordered th {
                    border: 1px solid #000 !important;
                }

                .form-group label {
                    font-weight: bold;
                }

                .section-title {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-top: 10px;
                }

                .signature-section {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 20px;
                }

                .signature-box {
                    text-align: center;
                }

                .signature-img {
                    max-width: 100%;
                    /* Ensures the image scales within the box */
                    max-height: 60px;
                    /* Adjust the max height of the signature image */
                    /* border-bottom: 1px solid #000;  Optional: add a line at the bottom of the image */
                }

                .signature-line {
                    margin-top: 10px;
                    border-top: 1px solid #000;
                    width: 100%;
                }

                /* Custom checkbox style */
                .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
                    background-color: black;
                    /* Bright green */
                    border-color: black;
                }

                .custom-checkbox .custom-control-label::before {
                    border: 2px solid #ccc;
                }

                /* Print specific styles */
                @media print {
                    body {
                        margin: 0;
                        padding: 0;
                    }

                    .btn-warning {
                        display: none;
                        /* Hide print button during printing */
                    }

                    .container {
                        width: 100%;
                        /* Full width during print */
                        padding: 10px;
                    }

                    .row {
                        page-break-inside: avoid;
                        /* Prevent row breaks */
                    }

                    .table-bordered {
                        border: 1px solid #000 !important;
                    }

                    .view-container {
                        padding: 10px;
                        border: none;
                    }

                    .signature-section {
                        display: block;
                        margin-top: 20px;
                    }

                    /* Adjust top margin for print */
                    .row {
                        margin-top: 15px;
                    }

                    /* Custom checkbox for print */

                    .custom-control-input:checked {
                        background-color: black !important;
                        border-color: black;
                        -webkit-print-color-adjust: exact;
                    }

                    .custom-control-label::before {
                        border-color: black !important;
                        -webkit-print-color-adjust: exact;
                        border-width: 2px;
                    }

                    .custom-control-label {
                        font-size: 12px;
                        color: black !important;
                        -webkit-print-color-adjust: exact;
                    }
                }
            </style>


            <div class="container view-container">
                <!-- Header with company logos and info -->
                <div class="row mb-3 mt-4">
                    <div class="col-sm-2">
                        <img src="{{ $company->logo ? asset('upload_images/company_logo/' . $company->logo) : '' }}"
                            width="100px" />
                    </div>
                    <div class="col-sm-8 text-center">
                        <h2>{{ $company->name }}</h2>
                        <p>{{ $company->address }}</p>
                    </div>
                    <div class="col-sm-2">
                        <img src="{{ $company->govt_logo ? asset('upload_images/company_logo/' . $company->govt_logo) : '' }}"
                            width="100px" />
                    </div>
                </div>

                <!-- Form fields displaying requisition data -->
                <div class="form-group row">
                    <div class="col-sm-6 d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">সরকারি:</label>
                        <div class="col-sm-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="govt-checkbox"
                                    {{ $requisition->applicant_type == 'সরকারি' ? 'checked' : '' }} disabled>
                                <label class="custom-control-label" for="govt-checkbox"></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">বেসরকারী:</label>
                        <div class="col-sm-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="private-checkbox"
                                    {{ $requisition->applicant_type == 'বেসরকারি' ? 'checked' : '' }} disabled>
                                <label class="custom-control-label" for="private-checkbox"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Date, Time, From, and To -->
                <div class="row mt-2 mb-2">
                    <label class="col-sm-3">ব্যবহারের তারিখ:</label>
                    <div class="col-sm-2">
                        <label>{{ $requisition->usage_date->format('d/m/Y') }}</label>
                    </div>
                    <label class="col-sm-1">সময়:</label>
                    <div class="col-sm-2">
                        <p>{{ \Carbon\Carbon::parse($requisition->from_time)->format('h:i A') }}</p>
                    </div>
                    <label class="col-sm-1">থেকে:</label>
                    <div class="col-sm-2">
                        <p>{{ \Carbon\Carbon::parse($requisition->to_time)->format('h:i A') }}</p>
                    </div>
                    <label class="col-sm-1">পযর্ন্ত</label>
                </div>

                <!-- Serial Table for Employee Information -->
                <table class="table table-c table-bordered mb-2 mt-2">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%;">ক্রমিক</th>
                            <th scope="col">ব্যবহারকারীর নাম</th>
                            <th scope="col" style="width: 20%;">পদবি</th>
                            <th scope="col" style="width: 20%;">বিভাগ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $requisition->employee->name }}</td>
                            <td>{{ $requisition->employee->designation->name }}</td>
                            <td>{{ $requisition->employee->section->section_name }}</td>
                        </tr>
                        @forelse ($requisition->other_employee as $v_employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $v_employee->employee->name }}</td>
                                <td>{{ $v_employee->employee->designation->name }}</td>
                                <td>{{ $v_employee->employee->section->section_name }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>

                <!-- Destination -->
                <div class="form-group row mt-2 mb-2">
                    <label class="col-sm-2 col-form-label">গন্তব্যস্থান :</label>
                    <div class="col-sm-10" style="border-bottom: 1px dotted black;">
                        <p>{{ $requisition->district ? $requisition->district->name : '' }}-{{ $requisition->destination }}
                        </p>
                    </div>
                </div>

                <!-- Estimated Mileage -->
                <div class="form-group row mt-1">
                    <label class="col-sm-3 col-form-label">ভ্রমণের আনুমানিক মোট মাইলেজ :</label>
                    <input type="text" class="form-control col-sm-4" value="{{ $requisition->total_miles }}"
                        readonly>
                </div>

                <!-- Expense Field -->
                <div class="form-group row mt-2">
                    <label class="col-sm-2 col-form-label">খরচের খাত:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control"
                            value="{{ $requisition->expense_type == 'রাজস্ব' ? 'রাজস্ব' : '' }}" readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control"
                            value="{{ $requisition->expense_type == 'প্রকল্প' ? 'প্রকল্প' : '' }}" readonly>
                    </div>
                    <p class="col-sm-2" style="font-weight: bold;">(প্রকল্পের নাম)</p>
                    <div class="col-sm-4" style="border-bottom: 1px dotted black;">
                        <p>{{ $requisition->name_of_project }}</p>
                    </div>
                </div>

                <!-- Purpose of Use -->
                <div class="form-group mt-2">
                    <label>ব্যবহারের উদ্দেশ্য :</label>
                    <textarea class="form-control" rows="2" readonly>{{ $requisition->purpose }}</textarea>
                </div>

                <!-- Vehicle Type and Number -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3">যানবাহনের প্রকার :</label>
                    <div class="col-sm-4">
                        {{ $requisition->type->vehicle_type }}
                    </div>
                    <label class="col-sm-2">যাত্রী সংখ্যা :</label>
                    <div class="col-sm-2">
                        {{ $requisition->number_of_passenger }}
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="signature-section row mt-2 ">
                    <div class="col-sm-6">
                        @if ($requisition->head && $requisition->head->signature != null)
                            <img src="{{ asset('employee/' . ($requisition->head->signature ?? '')) }}"
                                alt="Employee Signature" class="signature-img" width="100px">
                        @endif <br>
                        <span>বিভাগীয় প্রধানের স্বাক্ষর
                        </span><br>
                        <span>তারিখ : {{ \Carbon\Carbon::parse($requisition->approved_date)->format('d/m/Y') ?? '' }}
                        </span>
                    </div>
                    <div class=" col-sm-6 text-center">
                        @if ($requisition->employee && $requisition->employee->signature != null)
                            <img src="{{ asset('employee/' . ($requisition->employee->signature ?? '')) }}"
                                alt="Employee Signature" class="signature-img" width="100px">
                        @endif <br>
                        <span>ব্যবহারকারীর স্বাক্ষর
                        </span><br>
                        <span>তারিখ :
                            {{ \Carbon\Carbon::parse($requisition->requisition_date)->format('d/m/Y') ?? '' }}
                        </span>

                        {{-- <div class="signature-line"></div> --}}
                    </div>
                </div>

                <div class="row mt-4 mb-2">
                    <div class="col-sm-12 mb-2">
                        <strong>গাড়ি ব্যবহারকারীর প্রতি নির্দেশ (সরকারি)</strong>
                    </div>
                    <div class="col-md-12">
                        <p>১। লগ বইয়ের ৫নং কলামে গাড়ি ব্যবহারকারীর প্রতিটি ভ্রমণ লিপিবদ্ধ করবেন।
                        </p>
                    </div>
                    <div class="col-md-12">
                        <p>২। লগ বইয়ের ৭নং কলামে ভ্রমণের কারণ বিশেষভাবে উল্লেখ করবেন, কেবল সরকারি কাজ উল্লেখ করলেই
                            যথেষ্ট নয়।
                        </p>
                    </div>
                    <div class="col-md-12">
                        <p>৩। লগ বইয়ের ১১নং কলামে গাড়ি ব্যবহারকারী তার পদবী, তারিখ ও গাড়ি ছাড়ার সময়সহ দস্তখত করবেন
                        </p>
                    </div>
                </div>
            </div>
            @if ($requisition->assign_status == 1)
                <div class="row">
                    <div class="col-md-12">
                        চালকের তথ্যাবলী
                    </div>
                </div>
                <div class="container view-container">
                    <div class="row">
                        <div class="col-md-6">
                            চালকের নাম: &nbsp;
                            <strong>{{ $requisition->assign->driver ? $requisition->assign->driver->name : '' }}</strong><br>
                            যানবাহনের প্রকার: &nbsp;
                            <strong>{{ $requisition->type ? $requisition->type->vehicle_type : '' }}</strong><br>
                            প্লেট নং: &nbsp;
                            <strong>{{ $requisition->assign->vehicle ? $requisition->assign->vehicle->chassis_no : '' }}</strong><br>
                            চালকের নাম্বার: &nbsp;
                            <strong>{{ $requisition->assign->driver ? $requisition->assign->driver->mobile_no : '' }}
                            </strong><br>
                            চালকের পদবী: &nbsp;
                            <strong>{{ $requisition->assign->driver ? $requisition->assign->driver->designation->name : '' }}</strong><br>
                            ব্যবহারের তারিখ: &nbsp;
                            <strong>{{ \Carbon\Carbon::parse($requisition->usage_date)->format('d/m/Y') ?? '' }}</strong>
                        </div>
                        <div class="col-md-6 text-right">
                            @if ($requisition->assign->assign_admin && $requisition->assign->assign_admin->signature != null)
                                <img src="{{ asset('employee/' . ($requisition->assign->assign_admin->signature ?? '')) }}"
                                    alt="Employee Signature" class="signature-img" width="100px">
                            @endif <br>
                            <span>যানবাহন কর্মকর্তার স্বাক্ষর
                            </span><br>
                            <span>তারিখ :
                                {{ \Carbon\Carbon::parse($requisition->assign->assign_date)->format('d/m/Y') ?? '' }}
                            </span>
                        </div>
                    </div>

                </div>
            @endif
        </div>
        <script>
            // Custom print function to print the content of printableArea
            function printArea(divId) {
                var printContents = document.getElementById(divId).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;

                window.location.reload();

            }
        </script>
