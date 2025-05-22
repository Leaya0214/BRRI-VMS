@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('content')
    <style>
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            background-color: #0bab2b;
            color: #ffffff;
            padding: 6px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section h5 {
            font-weight: bold;
            color: #495057;
            margin-bottom: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="container">
        <div class="form-container">
            <div class="form-header">যানবাহন ব্যবহারের অনুরোধপত্র </div>
            <form action="{{ route('vehicle.requisition.store') }}" method="POST">
                @csrf
                <fieldset>
                    <legend>অনুরোধের তথ্যাবলী</legend>

                    <div class="form-section p-2">
                        {{-- <h5><u>আবেদনের প্রকারভেদ</u></h5> --}}
                        <div class="row g-3 pl-3">
                            <label for="" class="col-md-3">আবেদনের প্রকার &nbsp; :</label>
                            <div class="col-md-2 d-flex align-items-center">
                                <label for="applicantTypeGov" class="form-label me-2 mb-0">সরকারি</label>
                                <input type="radio" name="applicant_type" id="applicantTypeGov" value="সরকারি"
                                    class="form-check-input">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label for="applicantTypePrivate" class="form-label me-2 mb-0">বেসরকারি</label>
                                <input type="radio" name="applicant_type" id="applicantTypePrivate" value="বেসরকারি"
                                    class="form-check-input">
                            </div>
                        </div>
                        <div class="row g-3 pl-3 pt-3">
                            <label for="" class="col-md-2 form-label">ব্যবহারের তারিখ &nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <input type="date" name="usage_date" id="usage_date" value="" class="form-control">
                            </div>

                            <label for="" class="col-md-2 form-label">আবেদনের তারিখ &nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <input type="date" name="requisition_date" id="" value="{{ date('Y-m-d') }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row g-3 pl-3 pt-3">
                            <label for="" class="col-md-2 form-label">সময় থেকে &nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <input type="time" name="from_time" id="" value="" class="form-control"
                                    required>
                            </div>

                            <label for="" class="col-md-2 form-label">সময় পর্যন্ত &nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <input type="time" name="to_time" id="" value="" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="row g-3 pl-3 pt-3">
                            <label for="" class="col-md-2 form-label">গন্তব্য বিভাগ&nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <select name="division_id" class="form-control " id="division-id">
                                    <option value="">Select One</option>
                                    @foreach ($division as $item)
                                        <option value="{{ $item->id }}">{{ $item->division_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" class="col-md-2 form-label">গন্তব্য জেলা&nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <select name="district_id" class="form-control " id="district-id">
                                    <option value="">Select One</option>
                                    @foreach ($district as $v_district)
                                        <option value="{{ $v_district->id }}"  data-division-id="{{ $v_district->division_id }}">{{ $v_district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row  pl-3 pt-2">
                            <label for="" class="col-md-2 form-label">গন্ধব্য স্থান&nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <input type="text" name="to_location" id="" value="" class="form-control"
                                    required>
                            </div>

                            <label for="" class="col-md-3 form-label">অনুমানিক মোট মাইলেজ &nbsp; :</label>
                            <div class="col-md-3 d-flex ">
                                <input type="text" name="total_miles" id="" value="" class="form-control">
                            </div>
                        </div>
                        <div class="row  pl-3 pt-2">
                            <label for="" class="col-md-2 ">খরচের খাত &nbsp; :</label>
                            <div class="col-md-2 d-flex">
                                <label for="applicantTypeGov" class="form-label  mb-0">রাজস্ব</label>
                                <input type="radio" name="expense_type" id="type2" value="রাজস্ব"
                                    class="form-check-input">
                            </div>
                            <div class="col-md-2 d-flex">
                                <label for="applicantTypePrivate" class="form-label  mb-0">প্রকল্প</label>
                                <input type="radio" name="expense_type" id="type2" value="প্রকল্প"
                                    class="form-check-input">
                            </div>

                            <label for="" class="col-md-2 form-label">প্রকল্পের নাম &nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <input type="text" name="name_of_project" id="" value=""
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row  pl-3 pt-2">
                            <label for="" class="col-md-2">যানবাহনের প্রকার &nbsp; :</label>
                            <div class="col-md-3 d-flex">
                                <select name="type_id" id="" class="form-control">
                                    <option value="">Select One</option>
                                    @foreach ($vehicle_type as $type)
                                        <option value="{{ $type->id }}">{{ $type->vehicle_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" class="col-md-2 form-label">যাত্রী সংখ্যা &nbsp; :</label>
                            <div class="col-md-2 d-flex ">
                                <input type="text" name="number_of_passenger" id="" value=""
                                    class="form-control">
                            </div>
                            <div class="col-md-">
                                <button type="button" class="btn btn-success btn-md add-btn" onclick="addMore()">+অন্য
                                    কর্মচারী নির্বাচন করুন</button>
                                </button>
                            </div>
                        </div>

                        <div class="row pt-2 pl-3" id="new_div">

                        </div>
                        <div class="row  pl-3 pt-2">
                            <label for="tripPurpose" class="form-label col-md-2">ব্যবহারের উদ্দেশ্য</label>
                            <div class="col-md-4 d-flex">
                                <textarea name="purpose" class="form-control" id="" rows="3" required></textarea>
                            </div>
                            <label for="" class="col-md-2 form-label">বিশেষ বক্তব্য (যদি থাকে) &nbsp; :</label>
                            <div class="col-md-4 d-flex ">
                                <textarea class="form-control" id="note" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                    <!-- Submit Button -->
                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-success">অনুরোধ জমা দিন</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
@push('script_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        //    document.addEventListener('DOMContentLoaded', function() {
        //     // Initialize Flatpickr with custom format
        //     flatpickr("#usage_date", {
        //         dateFormat: "d-m-Y",  // Custom format (e.g., 11-06-2022)
        //         altInput: true,  // Use alternate input to show the formatted date
        //         altFormat: "F j, Y",  // Show full date in alternate input (e.g., November 6, 2022)
        //     });
        // });

        var employees = @json($employee);
        var sections = @json($section);


        let i = 0; // Initialize a counter

        function convertToBanglaNumber(number) {
            const banglaNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
            return number.toString().split('').map(digit => {
                return isNaN(digit) ? digit : banglaNumbers[digit];
            }).join('');
        }

        function addMore() {
            // Increment the counter to create a unique ID
            i++;
            let banglaCounter = convertToBanglaNumber(i);

            const container = document.getElementById("new_div");

            let html = `
        <div class="row mb-3" id="employee-div-${i}">
            <div class="col-lg-5">
                <label for="section">বিভাগ নির্বাচন ${banglaCounter}:</label>
                <select name="section_id[]" class="form-control select2" id="section-id-${i}" onchange="filterEmployees(${i})">
                    <option value="">নির্বাচন করুন</option>`;

            // Loop through sections to add options
            sections.forEach(section => {
                html += `<option value="${section.id}">${section.section_name}</option>`;
            });

            html += `
                </select>
            </div>
            <div class="col-lg-5">
                <label for="head">কর্মকর্তা নির্বাচন ${banglaCounter}:</label>
                <select name="other_employee_id[]" class="form-control select2" id="employee-id-${i}">
                    <option value="">নির্বাচন করুন</option>`;

            // Loop through employees to add options
            employees.forEach(employee => {
                html += `<option value="${employee.id}">${employee.name}</option>`;
            });

            html += `
                </select>
            </div>
            <div class="col-lg-2 mt-4">
                <button type="button" class="remove btn btn-md btn-danger text-center" onclick="removeElement(${i})">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>`;

            // Create a new div element and set its innerHTML to the generated HTML
            const newDiv = document.createElement("div");
            newDiv.className = "col-md-12 mb-3";
            newDiv.innerHTML = html;

            // Append the new div to the container
            container.appendChild(newDiv);

            // Initialize select2 on the newly added selects
            $(`#employee-div-${i} .select2`).select2();
        }

        function filterEmployees(id) {
                const sectionId = document.getElementById(`section-id-${id}`).value;
                const employeeSelect = document.getElementById(`employee-id-${id}`);

                // Clear previous employee options
                employeeSelect.innerHTML = '<option value="">নির্বাচন করুন</option>';

                // Filter employees based on selected section
                let filteredEmployees = employees.filter(employee => employee.section_id == sectionId);

                // Loop through filtered employees and add options
                filteredEmployees.forEach(employee => {
                    const option = document.createElement('option');
                    option.value = employee.id;
                    option.textContent = employee.name;
                    employeeSelect.appendChild(option);
                });

                // Reinitialize select2
                $(employeeSelect).select2();
        }

        function removeElement(id) {
            // Find the element by its unique id and remove it
            const element = document.getElementById(`employee-div-${id}`);
            if (element) {
                element.remove();
            }
        }


        function removeEmployee(id) {
            const divToRemove = document.getElementById(`employee-div-${id}`);
            if (divToRemove) {
                divToRemove.remove();
            }
        }


        var districts = @json($district);


var districts = @json($district);

function filterDistrictsByDivision(divisionSelectId, districtSelectId) {
    var divisionSelect = document.getElementById(divisionSelectId);
    var districtSelect = document.getElementById(districtSelectId);

    divisionSelect.addEventListener('change', function() {
        var divisionId = this.value;  // Get selected division id

        districtSelect.innerHTML = '<option value="">Select One</option>';

        var filteredDistricts = districts.filter(function(district) {
            return district.division_id == divisionId || divisionId === '';
        });

        filteredDistricts.forEach(function(district) {
            var option = document.createElement('option');
            option.value = district.id;
            option.textContent = district.name;
            districtSelect.appendChild(option);
        });
            $(districtSelect).select2();
            $(districtSelect).trigger('change');
    });
}

filterDistrictsByDivision('division-id', 'district-id');


    </script>

@endpush
