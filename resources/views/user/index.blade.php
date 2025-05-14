@extends('layouts.auth')

@section('title', 'User Management')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>

        <a href="{{ route('user.create') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add New User</span>
        </a>
    </div>
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="menuDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Username</th>
                            <th width="15%">Email</th>
                            <th width="15%">First Name</th>
                            <th width="15%">Last Name</th>
                            <th width="10%">Phone</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <a href="{{ route('user.edit', $user->user_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('user.destroy', $user->user_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('#menuDataTable').DataTable({
        "order": [
            [5, "asc"]
        ],
        "pageLength": 25
    });
</script>
@endpush
@push('styles')
<style>
    /* Table styles */
    .table-responsive {
        overflow-x: auto;
    }

    .avatar-placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #e9ecef;
        border-radius: 50%;
        font-weight: bold;
    }

    /* Card styling */
    .card {
        border: none;
        border-radius: 8px;
    }

    /* Action buttons */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endpush