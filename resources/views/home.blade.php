@php
    $total_employee = App\Models\Employee::count(); // Total employees
    $total_requisition = App\Models\VehicleRequisition::count(); // Total requisitions
    $total_requisition_at_head = App\Models\VehicleRequisition::where('forward_status', 1)->count(); // Total requisitions
    $total_requisition_at_director = App\Models\VehicleRequisition::where('forward_status', 2)->count(); // Total requisitions
    $total_requisition_at_dgm = App\Models\VehicleRequisition::where('forward_status', 3)->count(); // Total requisitions
    $total_requisition_at_tso = App\Models\VehicleRequisition::where('forward_status', 4)->count(); // Total requisitions
    $total_requisition_approve = App\Models\VehicleRequisition::where('assign_status', 1)->count(); // Total requisitions
    $total_driver = App\Models\Employee::whereIn('designation_id', [125, 154, 173])->count(); // Total drivers (assuming a Driver model)
    $total_notice = App\Models\Notice::count();
@endphp

@extends('layouts.app')

<style>
    .custom-card {
        border: 1px solid #e0e0e0;
        overflow: hidden;
        height: 100px;
    }

    .custom-card .icon {
        font-size: 2.5rem;
        padding: 29%;
    }

    .custom-card .title {
        font-size: 1rem;
        font-weight: bold;
        color: #656564;
    }

    .custom-card .count {
        font-size: 1.8rem;
        font-weight: bold;
    }
</style>

@section('content')
    <div class="row p-4">
        <!-- Total Employee Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #1691c2; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-users icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Employee</span>
                            <p class="count">{{ $total_employee }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Requisition Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #d7263d; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-file-alt icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Requisition</span>
                            <p class="count">{{ $total_requisition }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Requisition Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #26bfd7; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-file-alt icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Requisition at Head</span>
                            <p class="count">{{ $total_requisition_at_head }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Requisition Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #2679d7; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-file-alt icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Requisition at Director</span>
                            <p class="count">{{ $total_requisition_at_director }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Requisition Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #d7263d; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-file-alt icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Requisition at DGM</span>
                            <p class="count">{{ $total_requisition_at_dgm }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Requisition Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #90d726; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-file-alt icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Requisition at TSO</span>
                            <p class="count">{{ $total_requisition_at_tso }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Requisition Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #979213; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-file-alt icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Approved Requisition</span>
                            <p class="count">{{ $total_requisition_approve }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Driver Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #8ac926; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-truck icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Driver</span>
                            <p class="count">{{ $total_driver }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Notice Card -->
        <div class="col-lg-3">
            <div class="card custom-card">
                <div class="row no-gutters">
                    <div class="col-md-4" style="background-color: #ffbe0b; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-bell icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Notice</span>
                            <p class="count">{{ $total_notice }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
