@extends('layouts.auth')

@section('title', isset($user) ? 'Edit User' : 'Add User')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($user) ? 'Edit' : 'Add' }} User Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ isset($user) ? route('user.update', $user->user_id) : route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($user))
                {{-- Keep using POST method as defined in routes --}}
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <!-- Username Field -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" required>
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- First Name Field -->
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname', $user->firstname ?? '') }}" required>
                            @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Group</label>
                            <select class="form-control" id="group_id" name="group_id">
                                @if (Auth::user()->group_id == 1)
                                @if(isset($user) && $user->group_id)

                                <option value="1" {{ (old('group_id', $user->group_id) == 1) ? 'selected' : '' }}>Super Admin</option>
                                @else
                                <option value="1">Super Admin</option>
                                @endif
                                @endif
                                @foreach ($groups as $group)
                                @if ($group->group_id != 1)
                                @if(isset($user) && $user->group_id)

                                <option value="{{ $group->group_id }}" {{ (old('group_id', $user->group_id) == $group->group_id) ? 'selected' : '' }}>{{ $group->group_name }}</option>
                                @else
                                <option value="{{ $group->group_id }}" >{{ $group->group_name }}</option>
                                @endif
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <!-- Photo Field -->
                        <div class="form-group">
                            <label for="photo">Profile Photo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" accept=".jpg,.jpeg,.png">
                                <label class="custom-file-label" for="photo">Choose file</label>
                                @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if(isset($user) && $user->photo)
                            <div class="mt-2">
                                <img src="{{ Storage::url('user-photos/'.$user->photo) }}" width="100" class="img-thumbnail">
                                <p class="text-muted small mt-1">Current photo</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Last Name Field -->
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname', $user->lastname ?? '') }}" required>
                            @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password">{{ isset($user) ? 'New ' : '' }}Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-tie"></i> {{ isset($user) ? 'Update' : 'Create' }} User
                    </button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show file name when file selected
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("photo").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush

@push('styles')
<style>
    .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }

    .form-control {
        border-radius: 4px;
    }

    .custom-file-label::after {
        content: "Browse";
    }
</style>
@endpush