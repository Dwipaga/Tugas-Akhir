@extends('layouts.auth')
@section('title', isset($jobVacancy) ? 'Edit Job Vacancy' : 'Create New Job Vacancy')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('job-vacancy.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Back to List</span>
        </a>
    </div>
    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ isset($jobVacancy) ? 'Edit Job Vacancy Form' : 'Create Job Vacancy Form' }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ isset($jobVacancy) ? route('job-vacancy.update', $jobVacancy->id) : route('job-vacancy.store') }}"
                method="POST">
                @csrf
                @if(isset($jobVacancy))
                @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pekerjaan">Nama Pekerjaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_pekerjaan') is-invalid @enderror"
                                id="nama_pekerjaan" name="nama_pekerjaan"
                                value="{{ old('nama_pekerjaan', $jobVacancy->nama_pekerjaan ?? '') }}"
                                placeholder="Masukkan nama pekerjaan">
                            @error('nama_pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_pekerjaan">Jenis Pekerjaan <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis_pekerjaan') is-invalid @enderror"
                                id="jenis_pekerjaan" name="jenis_pekerjaan">
                                <option value="">-- Pilih Jenis Pekerjaan --</option>
                                <option value="kontrak" {{ old('jenis_pekerjaan', $jobVacancy->jenis_pekerjaan ?? '') == 'kontrak' ? 'selected' : '' }}>
                                    Kontrak
                                </option>
                                <option value="internship" {{ old('jenis_pekerjaan', $jobVacancy->jenis_pekerjaan ?? '') == 'internship' ? 'selected' : '' }}>
                                    Internship
                                </option>
                                <option value="fulltime" {{ old('jenis_pekerjaan', $jobVacancy->jenis_pekerjaan ?? '') == 'fulltime' ? 'selected' : '' }}>
                                    Full Time
                                </option>
                            </select>
                            @error('jenis_pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="divisi">Divisi <span class="text-danger">*</span></label>
                                <select name="divisi" class="form-control">
                                    <option value="" {{ old('divisi', $jobVacancy->divisi ?? '') == null ? 'selected' : '' }}>--Select Divisi--</option>
                                    <option value="PROGRAMMER" {{ old('divisi', $jobVacancy->divisi ?? '') == 'Programer' ? 'selected' : '' }}>Programer</option>
                                    <option value="BSS" {{ old('divisi', $jobVacancy->divisi ?? '') == 'BSS' ? 'selected' : '' }}>BSS</option>
                                    <option value="CONSULTANT" {{ old('divisi', $jobVacancy->divisi ?? '') == 'Consultant' ? 'selected' : '' }}>Consultant</option>
                                </select>
                            </div>
                            @error('divisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="min_pengalaman">Minimal Pengalaman (tahun) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('min_pengalaman') is-invalid @enderror"
                                id="min_pengalaman" name="min_pengalaman"
                                value="{{ old('min_pengalaman', $jobVacancy->min_pengalaman ?? 0) }}"
                                min="0" placeholder="0">
                            @error('min_pengalaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ditutup_pada">Ditutup Pada <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('ditutup_pada') is-invalid @enderror"
                                id="ditutup_pada" name="ditutup_pada"
                                value="{{ old('ditutup_pada', $jobVacancy->ditutup_pada ?? '') }}"
                                min="{{ date('Y-m-d') }}">
                            @error('ditutup_pada')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_person">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                id="contact_person" name="contact_person"
                                value="{{ old('contact_person', $jobVacancy->contact_person ?? '') }}"
                                placeholder="Masukkan contact person">
                            @error('contact_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Singkat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                        id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Masukkan deskripsi singkat">{{ old('deskripsi', $jobVacancy->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi_pekerjaan">Deskripsi Pekerjaan Detail <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_pekerjaan') is-invalid @enderror"
                        id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="6"
                        placeholder="Masukkan deskripsi pekerjaan detail">{{ old('deskripsi_pekerjaan', $jobVacancy->deskripsi_pekerjaan ?? '') }}</textarea>
                    @error('deskripsi_pekerjaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_active"
                            name="is_active" value="1"
                            {{ old('is_active', $jobVacancy->is_active ?? true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Is Active</label>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ isset($jobVacancy) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('job-vacancy.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Set minimum date for ditutup_pada to today's date for new entries
    @if(!isset($jobVacancy))
    document.getElementById('ditutup_pada').min = new Date().toISOString().split('T')[0];
    @endif
</script>
@endpush