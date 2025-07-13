@extends('layouts.auth')

@section('title', 'Form Approval HR')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-bullhorn"></i> Data Karyawan - Approval HR</h6>
        </div>
        <div class="card-body">
            <div class="mb-3"><strong>Nama:</strong> {{ $user->firstname }} {{ $user->lastname }}</div>
            <div class="mb-3"><strong>Email:</strong> {{ $user->email }}</div>
            <div class="mb-3"><strong>NPWP:</strong> {{ $user->npwp }}</div>
            <div class="mb-3"><strong>Nama Bank:</strong> {{ $user->nama_bank }}</div>
            <div class="mb-3"><strong>Nomor Rekening:</strong> {{ $user->nomor_rekening }}</div>

            <div class="mb-3"><strong>Scan KTP:</strong><br>
                @if ($user->scan_ktp)
                    <a href="{{ asset('storage/dokumen-files/' . $user->scan_ktp) }}" target="_blank">Lihat Scan KTP</a>
                @else
                    <span class="text-danger">Belum diunggah</span>
                @endif
            </div>

            <div class="mb-3"><strong>Scan NPWP:</strong><br>
                @if ($user->scan_npwp)
                    <a href="{{ asset('storage/dokumen-files/' . $user->scan_npwp) }}" target="_blank">Lihat Scan NPWP</a>
                @else
                    <span class="text-muted">Tidak tersedia</span>
                @endif
            </div>

            <form action="{{ route('hr-approval.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="dokumen_kontrak">Upload Dokumen Kontrak (TTD HR)</label>
                    <input type="file" name="dokumen_kontrak" class="form-control-file">
                    @if ($user->dokumen_kontrak)
                    <div class="mt-2">
                        <a href="{{ asset('storage/dokumen-files/' . $user->dokumen_kontrak) }}" target="_blank">Lihat Dokumen Kontrak</a>
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="group_id">Group</label>
                    <select name="group_id" class="form-control">
                        @foreach ($groups as $group)
                            <option value="{{ $group->group_id }}" {{ $user->group_id == $group->group_id ? 'selected' : '' }}>
                                {{ $group->group_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-3">
                    <i class="fas fa-check"></i> Approve Sekarang
                </button>
                <a href="{{ route('hr-approval.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
