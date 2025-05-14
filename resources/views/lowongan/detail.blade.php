@extends('layouts.main')
@section('content')
<div class="container" style="margin-top: 100px;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ $jobVacancy->nama_pekerjaan }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Jenis Pekerjaan:</th>
                                <td>
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
                                </td>
                            </tr>
                            <tr>
                                <th>Divisi:</th>
                                <td>{{ $jobVacancy->divisi }}</td>
                            </tr>
                            <tr>
                                <th>Min. Pengalaman:</th>
                                <td>
                                    @if($jobVacancy->min_pengalaman > 0)
                                        {{ $jobVacancy->min_pengalaman }} tahun
                                    @else
                                        Fresh Graduate
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Contact Person:</th>
                                <td>{{ $jobVacancy->contact_person }}</td>
                            </tr>
                            <tr>
                                <th>Batas Pendaftaran:</th>
                                <td>
                                    @if($jobVacancy->ditutup_pada->isPast())
                                        <span class="text-danger font-weight-bold">Sudah ditutup</span>
                                    @else
                                        {{ $jobVacancy->ditutup_pada->format('d F Y') }}
                                        <small class="text-muted">({{ $jobVacancy->ditutup_pada->diffForHumans() }})</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Diposting:</th>
                                <td>{{ $jobVacancy->created_at->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="font-weight-bold">Deskripsi Singkat</h5>
                    <p class="text-justify">{{ $jobVacancy->deskripsi }}</p>
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="font-weight-bold">Deskripsi Pekerjaan Detail</h5>
                    <div class="text-justify">{!! nl2br(e($jobVacancy->deskripsi_pekerjaan)) !!}</div>
                </div>

                <div class="text-center mt-5">
                    @if(!$jobVacancy->ditutup_pada->isPast() && $jobVacancy->is_active)
                        <a href="{{ route('application.create', $jobVacancy->id) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Lamar Sekarang
                        </a>
                    @else
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-times-circle"></i> Lowongan Sudah Ditutup
                        </button>
                    @endif
                    
                    <a href="{{ route('lowongan.index') }}" class="btn btn-outline-secondary btn-lg ml-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection