@extends('layouts.auth')

@section('title', isset($menu) ? 'Edit Menu' : 'Create Menu')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Back to List</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($menu) ? route('menus.update', $menu->menu_id) : route('menus.store') }}" class="user">
                @csrf
                @if(isset($menu))
                @method('PUT')
                <input type="hidden" name="menu_id" value="{{ $menu->menu_id }}">
                @endif

                <div class="form-group">
                    <label for="menu_name">Menu Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('menu_name') is-invalid @enderror" id="menu_name" name="menu_name" value="{{ old('menu_name', $menu->menu_name ?? '') }}" required>
                    @error('menu_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="menu_description">Menu Description</label>
                    <input type="text" class="form-control @error('menu_description') is-invalid @enderror" id="menu_description" name="menu_description" value="{{ old('menu_description', $menu->menu_description ?? '') }}">
                    @error('menu_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_url">Menu URL</label>
                            <input type="text" class="form-control @error('menu_url') is-invalid @enderror" id="menu_url" name="menu_url" value="{{ old('menu_url', $menu->menu_url ?? '') }}">
                            @error('menu_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_icon">Menu Icon (FontAwesome)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i id="icon-preview" class="{{ old('menu_icon', $menu->menu_icon ?? 'fas fa-icons') }}"></i></span>
                                </div>
                                <input type="text" class="form-control @error('menu_icon') is-invalid @enderror" id="menu_icon" name="menu_icon" value="{{ old('menu_icon', $menu->menu_icon ?? '') }}" placeholder="fas fa-home">
                                @error('menu_icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_parent">Parent Menu</label>
                            <select class="form-control @error('menu_parent') is-invalid @enderror" id="menu_parent" name="menu_parent">
                                <option value="0">Root (No Parent)</option>
                                @foreach($parents as $parent)
                                <option value="{{ $parent->menu_id }}" {{ old('menu_parent', $menu->menu_parent ?? 0) == $parent->menu_id ? 'selected' : '' }}>
                                    {{ $parent->menu_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('menu_parent')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_type">Menu Type <span class="text-danger">*</span></label>
                            <select class="form-control @error('menu_type') is-invalid @enderror" id="menu_type" name="menu_type">
                                <option value="side-menu" {{ old('menu_type', $menu->menu_type ?? 'side-menu') == 'side-menu' ? 'selected' : '' }}>
                                    Side Menu
                                </option>
                                <option value="top-menu" {{ old('menu_type', $menu->menu_type ?? '') == 'top-menu' ? 'selected' : '' }}>
                                    Top Menu
                                </option>
                            </select>
                            @error('menu_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label></label>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ isset($menu) && $menu->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">
                                            Is Active?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>User Group Access</label>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                @foreach($groups as $group)
                                <div class="col-md-4 mb-2">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="group-{{ $group->group_id }}" name="group_user[]" value="{{ $group->group_id }}" {{ in_array($group->group_id, $menu_role) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="group-{{ $group->group_id }}">
                                            {{ $group->group_name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-between">
                    <div>
                        @if(isset($menu))
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmModal">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($menu) ? 'Update' : 'Save' }} Menu
                        </button>
                    </div>
                    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@if(isset($menu))
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the menu "{{ $menu->menu_name }}"?<br>
                This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form action="{{ route('menus.destroy', $menu->menu_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Icon preview
        $('#menu_icon').on('input', function() {
            $('#icon-preview').attr('class', $(this).val() || 'fas fa-icons');
        });

        // Type change handler
        $('#menu_type').change(function() {
            var menuType = $(this).val();
            var menuId = $('input[name="menu_id"]').val() || '0';

            // AJAX to get parent menus based on selected type
            $.ajax({
                url: '{{ route("menus.parents") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: menuType,
                    menu_id: menuId
                },
                success: function(data) {
                    var $parentSelect = $('#menu_parent');
                    $parentSelect.empty();
                    $parentSelect.append($('<option></option>').val('0').text('Root (No Parent)'));

                    $.each(data, function(id, name) {
                        $parentSelect.append($('<option></option>').val(id).text(name));
                    });
                },
                error: function(xhr) {
                    console.error('Error loading parent menus');
                }
            });
        });
    });
</script>
@endpush