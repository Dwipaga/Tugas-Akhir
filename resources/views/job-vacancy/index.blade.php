@extends('layouts.auth')
@section('title', 'Job Vacancy Management')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-end mb-4">
    <a href="{{ route('job-vacancy.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Add New Job Vacancy</span>
    </a>
</div>

<!-- Flash Message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Job Vacancy List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="jobVacancyTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Pekerjaan</th>
                        <th width="10%">Jenis</th>
                        <th width="15%">Divisi</th>
                        <th width="10%">Min. Pengalaman</th>
                        <th width="10%">Ditutup Pada</th>
                        <th width="10%">Status</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobVacancies as $key => $job)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $job->nama_pekerjaan }}</td>
                        <td>
                            <span class="badge badge-info">
                                {{ ucfirst($job->jenis_pekerjaan) }}
                            </span>
                        </td>
                        <td>{{ $job->divisi }}</td>
                        <td>{{ $job->min_pengalaman }} tahun</td>
                        <td>{{ $job->ditutup_pada->format('d M Y') }}</td>
                        <td>
                            @if($job->isExpired())
                                <span class="badge badge-warning">Expired</span>
                            @elseif($job->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('job-vacancy.show', $job->id) }}" 
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('job-vacancy.edit', $job->id) }}" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('job-vacancy.destroy', $job->id) }}" 
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this job vacancy?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#jobVacancyTable').DataTable({
            "dom": '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt<"bottom"ip><"clear">',
            "pageLength": 25,
            "order": [[ 5, "desc" ]],
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            },
        });
    });
</script>
@endpush
@push('styles')
<style>
/* Table styles */
.table-responsive {
    overflow-x: auto;
}
/* DataTables wrapper styling */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
display: inline-block;
margin-bottom: 10px;
}
.dataTables_wrapper .dataTables_length {
float: left;
}
.dataTables_wrapper .dataTables_filter {
float: right;
}
.dataTables_wrapper .dataTables_info {
float: left;
padding-top: 10px;
}
.dataTables_wrapper .dataTables_paginate {
float: right;
padding-top: 10px;
}
/* Card styling */
.card {
border: none;
border-radius: 8px;
box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}
/* Action buttons */
.btn-sm {
padding: 0.25rem 0.5rem;
font-size: 0.875rem;
margin: 0 2px;
}
/* Clear floats */
.dataTables_wrapper:after {
content: "";
display: table;
clear: both;
}
</style>
@endpush