@extends('layouts.main')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="row">
        @forelse($jobVacancies as $jobVacancy)
        <!-- Job Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-lg" style="border: none">
                <div class="card-header text-black">
                    <h5 class="mb-0" style="font-weight: bold;">{{ $jobVacancy->nama_pekerjaan }}</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        <i class="fas fa-building mr-2"></i>{{ $jobVacancy->divisi }}<br>
                    </p>
                    <div class="mb-3">
                        @switch($jobVacancy->jenis_pekerjaan)
                            @case('fulltime')
                                <span class="badge badge-success">Full-time</span>
                                @break
                            @case('kontrak')
                                <span class="badge badge-warning">Kontrak</span>
                                @break
                            @case('internship')
                                <span class="badge badge-info">Internship</span>
                                @break
                        @endswitch
                    @if($jobVacancy->min_pengalaman > 0)
                        <span class="badge badge-secondary">Min. {{ $jobVacancy->min_pengalaman }} Tahun</span>
                    @else
                        <span class="badge badge-secondary">Fresh Graduate</span>
                    @endif
                </div>
                <p class="text-muted small">
                    {{ \Illuminate\Support\Str::limit($jobVacancy->deskripsi, 100) }}
                </p>
                <div class="mt-auto">
                    <a href="{{ route('lowongan.show', $jobVacancy->id) }}" style="color: blue;">Lihat Detail</a>
                </div>
            </div>
            <div class="card-footer text-muted small">
                @if($jobVacancy->ditutup_pada->isPast())
                    <span class="text-danger">Sudah ditutup</span>
                @else
                    Ditutup pada: {{ $jobVacancy->ditutup_pada->format('d F Y') }}
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Belum ada lowongan kerja yang tersedia saat ini.
        </div>
    </div>
    @endforelse
</div>
</div>
@endsection