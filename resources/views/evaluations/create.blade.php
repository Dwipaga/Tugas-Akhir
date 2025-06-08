@extends('layouts.auth')
@section('title', 'Create Evaluation')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('evaluations.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Back to List</span>
        </a>
    </div>
    <!-- Flash Message -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Evaluation Form for {{ $asesi->firstname }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('evaluations.store', $asesi->user_id) }}" method="POST">
                @csrf

                @foreach ($penilaians as $penilaian)
                    <div class="form-group">
                        <label for="score_{{ $penilaian->id }}">{{ $penilaian->penilaian }} (Weight: {{ $penilaian->bobot }})</label>
                        <input type="number" 
                               class="form-control @error('scores.' . $penilaian->id) is-invalid @enderror" 
                               id="score_{{ $penilaian->id }}" 
                               name="scores[{{ $penilaian->id }}]" 
                               value="{{ old('scores.' . $penilaian->id) }}"
                               min="1" 
                               max="100" 
                               placeholder="Enter score (1-100)"
                               required>
                        @error('scores.' . $penilaian->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Submit Evaluation
                    </button>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">
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