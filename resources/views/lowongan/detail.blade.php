@extends('layouts.main')

@section('content')
<div class="container" style="margin-top: 100px; margin-bottom: 100px">  <!-- Menambahkan margin top 30px -->
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-12 mb-4">
            <div class="card h-100 shadow-lg" style="border: none">
                <div class="card-header text-black">
                    <h5 class="mb-0" style="font-weight: bold;">Job Vacancy : Frontend Developer</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="header">
                        <span style="font-weight: bold;">Detail</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="maincontent">
                        <span style="font-weight: bold;">Kualifikasi</span>
                        <li>Pendidikan Terakhir : Minimal S1 Sistem Informasi</li>
                        <li>Pengalaman : Memiliki pengalaman minimal 1 tahun di bidang Frontend Developer</li>
                    </div><br>
                    <div class="content">
                        <span style="font-weight: bold;">Benefit</span>
                        <li>Insentif bulanan</li>
                        <li>Uang makan</li>
                        <li>Uang Transportasi</li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
