@extends('layouts.main')
@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Lamaran - {{ $jobVacancy->nama_pekerjaan }}</h4>
                </div>
                <div class="card-body">
                    <!-- Job Info Summary -->
                    <div class="alert alert-info mb-4">
                        <h5>Informasi Lowongan:</h5>
                        <p class="mb-1"><strong>Posisi:</strong> {{ $jobVacancy->nama_pekerjaan }}</p>
                        <p class="mb-1"><strong>Divisi:</strong> {{ $jobVacancy->divisi }}</p>
                        <p class="mb-1"><strong>Jenis:</strong> {{ ucfirst($jobVacancy->jenis_pekerjaan) }}</p>
                        <p class="mb-0"><strong>Batas Lamaran:</strong> {{ $jobVacancy->ditutup_pada->format('d F Y') }}</p>
                    </div>
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('application.store', $jobVacancy->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">Nama Depan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                       id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Nama Belakang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                       id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" 
                                       placeholder="08123456789" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                                       max="{{ date('Y-m-d') }}" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="linkedin">LinkedIn URL</label>
                                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" 
                                       id="linkedin" name="linkedin" value="{{ old('linkedin') }}" 
                                       placeholder="https://linkedin.com/in/username">
                                @error('linkedin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cv_file">Upload CV <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('cv_file') is-invalid @enderror" 
                                   id="cv_file" name="cv_file" accept=".pdf,.doc,.docx" required>
                            <label class="custom-file-label" for="cv_file">Choose file</label>
                            @error('cv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Format: PDF, DOC, DOCX. Max: 5MB</small>
                    </div>

                    <div class="form-group">
                        <label for="portfolio_file">Upload Portfolio (Optional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('portfolio_file') is-invalid @enderror" 
                                   id="portfolio_file" name="portfolio_file" accept=".pdf,.doc,.docx,.zip">
                            <label class="custom-file-label" for="portfolio_file">Choose file</label>
                            @error('portfolio_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Format: PDF, DOC, DOCX, ZIP. Max: 10MB</small>
                    </div>

                    <div class="form-group mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agreement" required>
                            <label class="form-check-label" for="agreement">
                                Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                            </label>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Kirim Lamaran
                        </button>
                        <a href="{{ route('lowongan.show', $jobVacancy->id) }}" class="btn btn-secondary btn-lg ml-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
// File input label update
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
</script>
@endpush