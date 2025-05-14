@extends('layouts.main')

@section('content')
<div class="container" style="margin-top: 100px;">  <!-- Menambahkan margin top 30px -->
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header text-black">
                    <h5 class="mb-0" style="font-weight: bold;">Frontend Developer</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- <p class="card-text">
                        <i class="fas fa-map-marker-alt mr-2"></i>Jakarta Selatan<br>
                    </p> -->
                    <div class="mb-3">
                        <span class="badge badge-success">Full-time</span>
                        <span class="badge badge-info">Min. 2 Tahun</span>
                    </div>
                    <!-- <p class="text-muted small">
                        <i class="fas fa-info-circle mr-1"></i> Pengalaman Nuxt.js & API development
                    </p> -->
                    <div class="mt-auto">
                        <a href="/lowongan/detail/1" style="color: blue;">Lihat Detail</a>
                    </div>
                </div>
                <div class="card-footer text-muted small">
                    Ditutup pada: 30 Juni 2023
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header text-black d-flex justify-content-between">
                    <h5 class="mb-0" style="font-weight: bold;">Backend Developer</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- <p class="card-text">
                        <i class="fas fa-map-marker-alt mr-2"></i>Bandung (Hybrid)
                    </p> -->
                    <div class="mb-3">
                        <span class="badge badge-primary">Kontrak</span>
                        <span class="badge badge-secondary">Min. 3 Tahun</span>
                    </div>
                    <!-- <p class="text-muted small">
                        <i class="fas fa-info-circle mr-1"></i> Pengalaman Laravel & API development
                    </p> -->
                    <div class="mt-auto">
                        <a href="/lowongan/detail/1" style="color: blue;">Lihat Detail</a>
                    </div>
                </div>
                <div class="card-footer text-muted small">
                    Ditutup pada: 30 Juni 2023
                </div>
            </div>
        </div>
    </div>
</div>
@endsection