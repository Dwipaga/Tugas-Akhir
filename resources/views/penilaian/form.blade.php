@extends('layouts.auth')
@section('title', isset($penilaian) ? 'Edit Penilaian' : 'Create New Penilaian')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary btn-icon-split">
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
                {{ isset($penilaian) ? 'Edit Penilaian Form' : 'Create Penilaian Form' }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ isset($penilaian) ? route('penilaian.update', $penilaian->id) : route('penilaian.store') }}" method="POST">
                @csrf
                @if(isset($penilaian))
                @method('PUT')
                @endif

                <div class="form-group">
                    <label for="penilaian">Penilaian</label>
                    <input type="text" class="form-control @error('penilaian') is-invalid @enderror" id="penilaian" name="penilaian" value="{{ old('penilaian', $penilaian->penilaian ?? '') }}" placeholder="Enter penilaian">
                    @error('penilaian')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Asesi</label>
                    <select class="form-control @error('asesi_id') is-invalid @enderror" id="asesi_id" name="asesi_id">
                        <option value="">-- Select Asesi --</option>
                        @foreach ($groups as $group)
                        @if(isset($penilaian))
                        <option value="{{ $group->group_id }}" {{ (old('asesi_id', $penilaian->asesi_id) == $group->group_id) ? 'selected' : '' }}>
                            {{ $group->group_name }}
                        </option>
                        @else
                        <option value="{{ $group->group_id }}" {{ old('asesi_id') == $group->group_id ? 'selected' : '' }}>
                            {{ $group->group_name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    @error('asesi_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Asesor</label>
                    <select class="form-control @error('asesor_id') is-invalid @enderror" id="asesor_id" name="asesor_id">
                        <option value="">-- Select Asesor --</option>
                        @foreach ($groups as $group)
                        @if(isset($penilaian))
                        <option value="{{ $group->group_id }}" {{ (old('asesor_id', $penilaian->asesor_id) == $group->group_id) ? 'selected' : '' }}>
                            {{ $group->group_name }}
                        </option>
                        @else
                        <option value="{{ $group->group_id }}" {{ old('asesor_id') == $group->group_id ? 'selected' : '' }}>
                            {{ $group->group_name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    @error('asesor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bobot">Bobot</label>
                    <input type="number" class="form-control @error('bobot') is-invalid @enderror" id="bobot" name="bobot" value="{{ old('bobot', $penilaian->bobot ?? '') }}" placeholder="Enter bobot" step="0.01" min="0" max="100">
                    @error('bobot')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{isset($penilaian->is_active) && $penilaian->is_active == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Is Active</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ isset($penilaian) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
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
    // Add any additional JavaScript if needed
</script>
@endpush