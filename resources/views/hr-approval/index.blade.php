@extends('layouts.auth')

@section('title', 'HR Approval')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Approval Data Karyawan</h1>
    </div>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Karyawan Menunggu Approval</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="menuDataTable" style="width: 100%;" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NPWP</th>
                            <th>Nama Bank</th>
                            <th>No. Rekening</th>
                            <th>Scan KTP</th>
                            <th>Scan NPWP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->npwp ?? '-' }}</td>
                            <td>{{ $user->nama_bank ?? '-' }}</td>
                            <td>{{ $user->nomor_rekening ?? '-' }}</td>
                            <td>
                                @if($user->scan_ktp)
                                    <a href="{{ asset('storage/dokumen-files/' . $user->scan_ktp) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-id-card"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->scan_npwp)
                                    <a href="{{ asset('storage/dokumen-files/' . $user->scan_npwp) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('hr-approval.edit', $user->user_id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-check-circle"></i> Approve
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @if ($users->isEmpty())
                        <tr><td colspan="9" class="text-center text-muted">Tidak ada data</td></tr>
                        @endif
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
            "order": [
                [0, "asc"]
            ],
            "pageLength": 25,
            "autoWidth": false
        });
    });
</script>
@endpush

@push('styles')
<style>
    .table-responsive {
        overflow-x: auto;
    }

    .card {
        border: none;
        border-radius: 8px;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endpush
