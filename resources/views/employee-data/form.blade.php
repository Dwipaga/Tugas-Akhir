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
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($contract)
    <div class="card bg-info text-white mb-4">
        <div class="card-body">
            <i class="fas fa-info-circle"></i>
            Kontrak Anda telah digenerate. Anda dapat melihat atau mengunduh kontrak di bawah ini. Silakan unggah kontrak yang telah ditandatangani.
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-file-contract"></i> Kelola Kontrak
            </h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Status Kontrak:</strong> {{ ucfirst($contract->status) }}
            </div>
            <div class="mb-3">
                <a href="{{ route('employee-data.view-contract', ['userId' => $user->user_id]) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Lihat Kontrak
                </a>
                <a href="{{ route('employee-data.download-contract', ['userId' => $user->user_id]) }}" class="btn btn-success ml-2">
                    <i class="fas fa-download"></i> Unduh Kontrak
                </a>
            </div>
            @if(!$user->dokumen_kontrak)
            <form action="{{ route('employee-data.upload-signed-contract') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="signed_contract">
                        <i class="fas fa-file-upload"></i> Unggah Kontrak yang Ditandatangani *
                    </label>
                    <input type="file" name="signed_contract" id="signed_contract" class="form-control" accept=".pdf" required>
                    <small class="form-text text-muted">Format: PDF (Max: 2MB)</small>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Unggah Kontrak
                </button>
            </form>
            @else
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Kontrak yang ditandatangani telah diunggah. 
                <a href="{{ Storage::url($user->dokumen_kontrak) }}" target="_blank">Lihat Kontrak</a>
                . Menunggu persetujuan HR....
            </div>
            @endif
        </div>
    </div>
    @endif

    @if(!$user->scan_ktp)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-user-plus"></i> Lengkapi Data Diri Tambahan
            </h5>
        </div>
        <div class="card-body">
            <p class="text-muted">
                Silakan lengkapi data tambahan dibawah ini. Setelah data tersimpan, sistem akan secara otomatis memgenerate kontrak berdasarkan template yang telah disediakan.
            </p>
            
            <form action="{{ route('employee-data.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="scan_ktp">
                                <i class="fas fa-id-card"></i> Scan KTP *
                            </label>
                            <input type="file" name="scan_ktp" id="scan_ktp" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                            <small class="form-text text-muted">Format: JPG, PNG, PDF (Max: 2MB)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="scan_npwp">
                                <i class="fas fa-file-invoice"></i> Scan NPWP (Opsional)
                            </label>
                            <input type="file" name="scan_npwp" id="scan_npwp" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="form-text text-muted">Format: JPG, PNG, PDF (Max: 2MB)</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="npwp">
                                <i class="fas fa-hashtag"></i> Nomor NPWP (15 digit) (Opsional)
                            </label>
                            <input type="text" name="npwp" id="npwp" class="form-control" maxlength="15" value="{{ old('npwp') }}" placeholder="Contoh: 123456789012345">
                            <small class="form-text text-muted">Masukkan 15 digit nomor NPWP tanpa tanda baca</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_bank">
                                <i class="fas fa-university"></i> Nama Bank *
                            </label>
                            <select name="nama_bank" id="nama_bank" class="form-control" required>
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA" {{ old('nama_bank') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                <option value="Mandiri" {{ old('nama_bank') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="BRI" {{ old('nama_bank') == 'BRI' ? 'selected' : '' }}>BRI</option>
                                <option value="BNI" {{ old('nama_bank') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                <option value="CIMB Niaga" {{ old('nama_bank') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                <option value="Danamon" {{ old('nama_bank') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                                <option value="Permata" {{ old('nama_bank') == 'Permata' ? 'selected' : '' }}>Permata</option>
                                <option value="BTN" {{ old('nama_bank') == 'BTN' ? 'selected' : '' }}>BTN</option>
                                <option value="BSI" {{ old('nama_bank') == 'BSI' ? 'selected' : '' }}>BSI</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomor_rekening">
                                <i class="fas fa-credit-card"></i> Nomor Rekening *
                            </label>
                            <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" disabled required value="{{ old('nomor_rekening') }}" placeholder="Masukkan nomor rekening">
                            <small class="form-text text-muted">Pilih bank terlebih dahulu</small>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i>
                    <strong>Informasi:</strong> 
                    Setelah data ini tersimpan, sistem akan secara otomatis memgenerate kontrak kerja berdasarkan template yang telah disediakan dengan mengisi data Anda.
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data & Generate Kontrak
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('nama_bank').addEventListener('change', function() {
        const nomorRekeningInput = document.getElementById('nomor_rekening');
        nomorRekeningInput.disabled = !this.value;
        
        if (this.value) {
            nomorRekeningInput.focus();
        } else {
            nomorRekeningInput.value = '';
        }
    });

    document.getElementById('npwp').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 15) {
            value = value.substring(0, 15);
        }
        e.target.value = value;
    });

    document.getElementById('nomor_rekening').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
</script>
@endpush