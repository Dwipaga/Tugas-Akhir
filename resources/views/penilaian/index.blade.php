@extends('layouts.auth')

@section('title', 'Penilaian Karyawan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>

        <a href="{{ route('penilaian.create') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add New Pertanyaan</span>
        </a>
    </div>
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Penilaian List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="menuDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="60%">Penilaian</th>
                            <th width="15%">Role</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
    $('#menuDataTable').DataTable({
        "dom": '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt',
        "pageLength": 25,
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entry",
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
    margin-bottom: 3px;
}

.dataTables_wrapper .dataTables_length {
    float: left;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
}

/* Pagination styling */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5em 1em;
    margin-left: 2px;
    border-radius: 4px;
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
}

/* Clear floats */
.dataTables_wrapper:after {
    content: "";
    display: table;
    clear: both;
}
</style>
@endpush
