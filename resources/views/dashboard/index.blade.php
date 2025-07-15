@extends('layouts.auth')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-6" style="margin-left: 10px;">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $users }}</h3>
                <p>Jumlah Karyawan</p>
            </div>
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
            <a href="/user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $jobs }}</h3>
                <p> <i>Applicant's</i> Menunggu </i>Review</i></p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="/apps?status=pending" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
@endsection