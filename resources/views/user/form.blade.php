@extends('layouts.auth')

@section('title', $user ? 'Edit User' : 'Add User')

@section('content')
@if(isset($labels) && count($labels) > 0)

<div class="card shadow mb-4 mt-5">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Grafik Evaluasi - 6 Bulan Terakhir</h6>
    </div>
    <div class="card-body">
        <canvas id="evaluasiChart" height="100"></canvas>
    </div>
</div>
@endif
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ $user ? 'Edit' : 'Add' }} User</h6>
        </div>
        <div class="card-body">
            <form action="{{ $user ? route('user.update', $user->user_id) : route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($user) @method('POST') @endif

                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" class="form-control" value="{{ old('firstname', $user->firstname ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $user->lastname ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="npwp">NPWP</label>
                            <input type="number" name="npwp" class="form-control" value="{{ old('npwp', $user->npwp ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="number" name="nik" class="form-control" value="{{ old('nik', $user->nik ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $user->tempat_lahir ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $user->tanggal_lahir ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="photo">Foto</label>
                            <input type="file" name="photo" class="form-control-file">
                            @if (isset($user) && $user->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/user-photos/' . $user->photo) }}" alt="Foto Profil" width="120">
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $user->tanggal_masuk ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_akhir_kontrak">Tanggal Akhir Kontrak</label>
                            <input type="date" name="tanggal_akhir_kontrak" class="form-control" value="{{ old('tanggal_akhir_kontrak', $user->tanggal_akhir_kontrak ?? '') }}">
                        </div>



                        <div class="form-group">
                            <label for="jenis_kontrak">Jenis Kontrak</label>
                            <select name="jenis_kontrak" class="form-control">
                                <option value="" disabled {{ old('jenis_kontrak', $user->jenis_kontrak ?? '') == null ? 'selected' : '' }}>--Select Jenis Kontrak--</option>
                                <option value="PKWT" {{ old('jenis_kontrak', $user->jenis_kontrak ?? '') == 'PKWT' ? 'selected' : '' }}>PKWT</option>
                                <option value="PKWTT" {{ old('jenis_kontrak', $user->jenis_kontrak ?? '') == 'PKWTT' ? 'selected' : '' }}>PKWTT</option>
                                <option value="INTERNSHIP" {{ old('jenis_kontrak', $user->jenis_kontrak ?? '') == 'INTERNSHIP' ? 'selected' : '' }}>Internship</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="divisi">Divisi</label>
                            <select name="divisi" class="form-control">
                                <option value="" {{ old('divisi', $user->divisi ?? '') == null ? 'selected' : '' }}>--Select Divisi--</option>
                                <option value="PROGRAMMER" {{ old('divisi', $user->divisi ?? '') == 'Programer' ? 'selected' : '' }}>Programer</option>
                                <option value="LEADER" {{ old('divisi', $user->divisi ?? '') == 'Programer' ? 'selected' : '' }}>Leader</option>
                                <option value="BSS" {{ old('divisi', $user->divisi ?? '') == 'BSS' ? 'selected' : '' }}>BSS</option>
                                <option value="HRD" {{ old('divisi', $user->divisi ?? '') == 'HRD' ? 'selected' : '' }}>HRD</option>
                                <option value="CONSULTANT" {{ old('divisi', $user->divisi ?? '') == 'Consultant' ? 'selected' : '' }}>Consultant</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <label for="dokumen_kontrak">Dokumen Kontrak</label>
                            <input type="file" name="dokumen_kontrak" class="form-control-file">
                            @if (isset($user) && $user->dokumen_kontrak)
                            <div class="mt-2">
                                <a href="{{ asset('storage/dokumen-files/' . $user->dokumen_kontrak) }}" target="_blank">Lihat Dokumen</a>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">Password {{ $user ? '(Kosongkan jika tidak diubah)' : '' }}</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="group_id">Group</label>
                            <select name="group_id" class="form-control">
                                @foreach ($groups as $group)
                                @if ($group->group_id != 1)
                                <option value="{{ $group->group_id }}" {{ old('group_id', $user->group_id ?? '') == $group->group_id ? 'selected' : '' }}>
                                    {{ $group->group_name }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ $user ? 'Update' : 'Create' }} User
                    </button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('evaluasiChart').getContext('2d');
    const evaluasiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: {!! json_encode($datasets) !!}
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Total Akhir'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>
@endpush
