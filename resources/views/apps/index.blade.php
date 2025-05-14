@extends('layouts.auth')
@section('title', 'Daftar Lamaran')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>
<!-- Filter Section -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.applications.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Lowongan</label>
                        <select name="job_vacancy_id" class="form-control">
                            <option value="">Semua Lowongan</option>
                            @foreach($jobVacancies as $job)
                                <option value="{{ $job->id }}" {{ request('job_vacancy_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->nama_pekerjaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cari</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Nama, email, telepon..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

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
        <h6 class="m-0 font-weight-bold text-primary">Daftar Lamaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Pelamar</th>
                        <th width="15%">Kontak</th>
                        <th width="20%">Posisi</th>
                        <th width="15%">Tanggal Melamar</th>
                        <th width="10%">Status</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $key => $application)
                    <tr>
                        <td>{{ $applications->firstItem() + $key }}</td>
                        <td>
                            <strong>{{ $application->full_name }}</strong><br>
                            <small>{{ $application->tanggal_lahir->format('d M Y') }}</small>
                        </td>
                        <td>
                            {{ $application->email }}<br>
                            {{ $application->phone }}
                        </td>
                        <td>
                            {{ $application->jobVacancy->nama_pekerjaan }}<br>
                            <small class="text-muted">{{ $application->jobVacancy->divisi }}</small>
                        </td>
                        <td>{{ $application->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <span class="badge {{ $application->status_badge_class }}">
                                {{ $application->status_text }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.show', $application->id) }}" 
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.applications.download-cv', $application->id) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-download"></i> CV
                            </a>
                            @if($application->portfolio_file)
                                <a href="{{ route('admin.applications.download-portfolio', $application->id) }}" 
                                   class="btn btn-secondary btn-sm">
                                    <i class="fas fa-download"></i> Portfolio
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data lamaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3">
            {{ $applications->links() }}
        </div>
    </div>
</div>
</div>
@endsection