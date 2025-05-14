@extends('layouts.auth')

@section('title', 'Job Vacancy Detail')

@section('content')

<div class="container-fluid"> <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Job Vacancy Detail</h1>
        <div> <a href="{{ route('job-vacancy.edit', $jobVacancy->id) }}" class="btn btn-warning btn-icon-split"> <span class="icon text-white-50"> <i class="fas fa-edit"></i> </span> <span class="text">Edit</span> </a> <a href="{{ route('job-vacancy.index') }}" class="btn btn-secondary btn-icon-split"> <span class="icon text-white-50"> <i class="fas fa-arrow-left"></i> </span> <span class="text">Back to List</span> </a> </div>
    </div>
    <!-- Detail Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $jobVacancy->nama_pekerjaan }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Jenis Pekerjaan</th>
                            <td>
                                <span class="badge badge-info">
                                    {{ ucfirst($jobVacancy->jenis_pekerjaan) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Divisi</th>
                            <td>{{ $jobVacancy->divisi }}</td>
                        </tr>
                        <tr>
                            <th>Min. Pengalaman</th>
                            <td>{{ $jobVacancy->min_pengalaman }} tahun</td>
                        </tr>
                        <tr>
                            <th>Contact Person</th>
                            <td>{{ $jobVacancy->contact_person }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Ditutup Pada</th>
                            <td>{{ $jobVacancy->ditutup_pada->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($jobVacancy->isExpired())
                                <span class="badge badge-warning">Expired</span>
                                @elseif($jobVacancy->is_active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $jobVacancy->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $jobVacancy->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <h5 class="font-weight-bold mb-3">Deskripsi Singkat</h5>
                    <p class="text-justify">{{ $jobVacancy->deskripsi }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <h5 class="font-weight-bold mb-3">Deskripsi Pekerjaan Detail</h5>
                    <div class="text-justify">{!! nl2br(e($jobVacancy->deskripsi_pekerjaan)) !!}</div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection
@push('styles')

<style>
    .table-borderless th,
    .table-borderless td {
        border: none;
        padding: 0.5rem 1rem;
    }

    .text-justify {
        text-align: justify;
    }
</style>
@endpush