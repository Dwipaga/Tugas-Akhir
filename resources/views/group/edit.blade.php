@extends('layouts.auth')
@section('title', 'Edit Group')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('groups.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Back to List</span>
        </a>
    </div>
    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Group Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('groups.update', $group->group_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="group_name">Group Name</label>
                    <input type="text" class="form-control @error('group_name') is-invalid @enderror" id="group_name" name="group_name" value="{{ old('group_name', $group->group_name) }}" placeholder="Enter group name">
                    @error('group_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="group_desc">Description</label>
                    <textarea class="form-control @error('group_desc') is-invalid @enderror" id="group_desc" name="group_desc" placeholder="Enter description">{{ old('group_desc', $group->group_desc) }}</textarea>
                    @error('group_desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $group->status) == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                    @error('status')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('groups.index') }}" class="btn btn-secondary">
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