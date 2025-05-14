@extends('layouts.auth')
@section('title', 'Penilaian Karyawan')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-end mb-4">
        <a href="{{ route('penilaian.create') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add New Penilaian</span>
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
            <h6 class="m-0 font-weight-bold text-primary">Penilaian List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="menuDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Penilaian</th>
                            <th width="15%">Asesi</th>
                            <th width="15%">Asesor</th>
                            <th width="10%">Bobot</th>
                            <th width="10%">Is Active</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penilaians as $key => $penilaian)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $penilaian->penilaian }}</td>
                            <td>{{ $penilaian->asesi->group_name ?? 'N/A' }}</td>
                            <td>{{ $penilaian->asesor->group_name ?? 'N/A' }}</td>
                            <td>{{ $penilaian->bobot }}</td>
                            <td>
                                <span class="badge badge-{{ $penilaian->is_active ? 'success' : 'danger' }}">
                                    {{ $penilaian->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('penilaian.destroy', $penilaian->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">
                                        <i class="fas fa-trash"></i> Delete
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