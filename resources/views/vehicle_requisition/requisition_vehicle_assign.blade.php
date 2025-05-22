@extends('layouts.app')

@section('content')
<div class="container mt-4 pl-4">
    <h2>রিকুইজিশনের জন্য গাড়ি বরাদ্দ করুন</h2>

    <form action="{{ route('requisition.assignVehicle', ['requisition_id' => $requisition->id]) }}" method="POST">
        @csrf
        <!-- Vehicle Selection -->
        <div class="form-group">
            <label for="vehicle_id">যানবাহন নির্বাচন করুন:</label>
            <select name="vehicle_id" id="vehicle_id" class="form-control" required>
                <option value="">-- নির্বাচন করুন --</option>
                @foreach($vehicles as $vehicle)
                    {{-- @if($vehicle->isAvailable()) --}}
                        <option value="{{ $vehicle->id }}">{{ $vehicle->vchl_model }} ({{ $vehicle->model_year }})</option>
                    {{-- @endif --}}
                @endforeach
            </select>
        </div>

        <!-- Driver Selection -->
        <div class="form-group">
            <label for="driver_id">ড্রাইভার নির্বাচন করুন:</label>
            <select name="driver_id" id="driver_id" class="form-control" required>
                <option value="">-- নির্বাচন করুন --</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Assignment Date -->
        <div class="form-group">
            <label for="assignment_date">অ্যাসাইনমেন্টের তারিখ:</label>
            <input type="date" name="assignment_date" id="assignment_date" class="form-control" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">যানবাহন বরাদ্দ করুন</button>
    </form>
</div>
@endsection
