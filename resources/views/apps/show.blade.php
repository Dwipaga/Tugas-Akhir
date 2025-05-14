@extends('layouts.auth')

@section('title', 'Detail Lamaran')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <!-- Data Pribadi -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pribadi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Nama Lengkap</th>
                            <td>{{ $application->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $application->email }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>{{ $application->phone }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $application->tanggal_lahir->format('d F Y') }} ({{ $application->tanggal_lahir->age }} tahun)</td>
                        </tr>
                        <tr>
                            <th>LinkedIn</th>
                            <td>
                                @if($application->linkedin)
                                    <a href="{{ $application->linkedin }}" target="_blank">{{ $application->linkedin }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Informasi Lamaran -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Lamaran</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Posisi</th>
                            <td>{{ $application->jobVacancy->nama_pekerjaan }}</td>
                        </tr>
                        <tr>
                            <th>Divisi</th>
                            <td>{{ $application->jobVacancy->divisi }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Pekerjaan</th>
                            <td>{{ ucfirst($application->jobVacancy->jenis_pekerjaan) }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Melamar</th>
                            <td>{{ $application->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge {{ $application->status_badge_class }}">
                                    {{ $application->status_text }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.applications.update-status', $application->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Status Lamaran</label>
                            <select name="status" class="form-control">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Files -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dokumen</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center">
                                <i class="fas fa-file-pdf fa-5x text-danger mb-3"></i>
                                <h5>CV</h5>
                                <a href="{{ route('admin.applications.download-cv', $application->id) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-download"></i> Download CV
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                @if($application->portfolio_file)
                                    <i class="fas fa-file-archive fa-5x text-info mb-3"></i>
                                    <h5>Portfolio</h5>
                                    <a href="{{ route('admin.applications.download-portfolio', $application->id)   }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download Portfolio
                                    </a>
                                @else
                                    <i class="fas fa-file-times fa-5x text-muted mb-3"></i>
                                    <h5>Portfolio</h5>
                                    <p class="text-muted">Tidak ada portfolio</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection