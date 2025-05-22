@php

@endphp

@extends('layouts.app')

<style>
    .custom-card {
      border: 1px solid #e0e0e0;
      overflow: hidden;
      height: 100px;
    }

    .custom-card-profile {
      border: 1px solid #e0e0e0;
      overflow: hidden;
      height: 500px;
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
<style>
    .scrollable-list {
        display: block;
        max-height: 300px;
        overflow-y: auto;
        width: 100%;
    }

    .scrollable-list thead,
    .scrollable-list tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* .scrollable-list thead {
        width: calc( 100% - 1em );
    } */

    .scrollable-list tbody {
        display: block;
        overflow-y: auto;
        height: 100%;
        /* Control height based on content */
    }

    .scrollable-list th,
    .scrollable-list td {
        /* width: 100px; */
        /* padding: 8px; */
        text-align: center;
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
                    <div class="col-md-4" style="background-color: #d7263d; color: white; border-right: 1px solid #e0e0e0;">
                        <i class="fas fa-file-alt icon"></i>
                    </div>
                    <div class="col-md-8 p-2">
                        <div class="card-body">
                            <span class="title">Total Approved Requisition </span>
                            <p class="count">{{ $total_approved_requisition }}</p>
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
                            <span class="title">Total Rejected Requisition</span>
                            <p class="count">{{ $total_rejected_requisition }}</p>
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
    <div class="row p-4">
        <div class="col-lg-12">
            <div class="card custom-card-profile">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        @if($user && $user->image)
                            <img src="{{ asset('employee/' . $user->image) }}" alt="User Image" class="img-fluid" style="width: 60%; height: auto;">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>

                    <div class="col-md-2 p-2">
                        <div class="card-body">

                        </div>
                    </div>
                    <div class="col-md-5 p-2">
                        <div class="card-body">
                            <span class="title"><Strong>নাম&nbsp;: &nbsp; &nbsp;{{$user->name}}</Strong></span><br><br>
                            <span class="title"><Strong>মোবাইল&nbsp;: &nbsp; &nbsp;{{$user->mobile_no}}</Strong></span><br><br>
                            <span class="title"><Strong>ই-মেইল&nbsp;: &nbsp; &nbsp;{{$user->email}}</Strong></span><br><br>
                            <span class="title"><Strong>পদবি&nbsp;: &nbsp; &nbsp;{{$user->designation->name ??''}}</Strong></span><br><br>
                            <span class="title"><Strong>বিভাগ&nbsp;: &nbsp; &nbsp;{{$user->section->section_name ?? ''}}</Strong></span><br><br>
                            <span class="title"><Strong>অফিস আইডি&nbsp;: &nbsp; &nbsp;{{$user->office_id}}</Strong></span><br><br>
                            <span class="title"><Strong>জাতীয় পরিচয়&nbsp;: &nbsp; &nbsp;{{$user->nid}}</Strong></span><br><br>
                            <span class="title"><Strong>যোগদানের তারিখ&nbsp;: &nbsp; &nbsp;{{$user->joining_date}}</Strong></span><br><br>
                            <span class="title"><Strong>পি.আর.এল তারিখ&nbsp;: &nbsp; &nbsp;{{$user->prl_date}}</Strong></span><br><br>
                            <span class="title"><Strong>রক্তের গ্রুপ&nbsp;: &nbsp; &nbsp;{{$user->blood_group}}</Strong></span><br><br>
                            <span class="title"><Strong>ভূমিকা&nbsp;: &nbsp; &nbsp;{{$user->role}}</Strong></span><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const scrollableTable = document.querySelector('.scrollable-list');
        scrollableTable.style.maxHeight = '300px';
        window.addEventListener('resize', () => {
            const windowHeight = window.innerHeight;
            scrollableTable.style.maxHeight = (windowHeight - 200) + 'px';
        });
    });
</script>
