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
                <h3>{{ count($messages) }}</h3>
                <p>Messages</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ count($notifications) }}</h3>
                <p>Notifications</p>
            </div>
            <div class="icon">
                <i class="fas fa-bell"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
@endsection