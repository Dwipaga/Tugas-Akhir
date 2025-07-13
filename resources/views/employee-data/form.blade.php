@extends('layouts.auth')
@section('title', 'Form Data Karyawan')

@section('content')
<div class="container mt-4">
    <div class="card bg-success text-white mb-4">
        <div class="card-body">
            <i class="fas fa-bullhorn"></i>
            Selamat anda diterima menjadi keluarga di PT. Cubiconia Kanaya Pratama
            @if ($role)
            dengan role <strong>{{ $role->nama_pekerjaan }}</strong>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('errors'))
    <div class="alert alert-error">{{ session('errors') }}</div>
    @endif

    @if ($user != null)
    <div class="card bg-success text-white mb-4">
        <div class="card-body">
            Dokumen Tambahan Menunggu Disetujui, Mohon ditunggu....
            
        </div>
    </div>
    @else
    <form action="{{ route('employee-data.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Scan KTP</label>
            <input type="file" name="scan_ktp" class="form-control">
        </div>

        <div class="form-group">
            <label>Scan NPWP (Opsional)</label>
            <input type="file" name="scan_npwp" class="form-control">
        </div>

        <div class="form-group">
            <label>Nomor NPWP (15 digit) (Opsional)</label>
            <input type="text" name="npwp" class="form-control" maxlength="15" value="{{ old('npwp') }}">
        </div>

        <div class="form-group">
            <label>Nama Bank</label>
            <select name="nama_bank" id="nama_bank" class="form-control">
                <option value="">-- Pilih Bank --</option>
                <option value="BCA">BCA</option>
                <option value="Mandiri">Mandiri</option>
                <option value="BRI">BRI</option>
                <option value="BNI">BNI</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nomor Rekening</label>
            <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label>Upload Kontrak yang Sudah Ditandatangani</label>
            <input type="file" name="dokumen_kontrak" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Simpan</button>
    </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('nama_bank').addEventListener('change', function() {
        document.getElementById('nomor_rekening').disabled = !this.value;
    });
</script>
@endpush