@extends('layouts.main')
@section('content')
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Permission List</div>
            <div class="card-body">
                <div class="card-title">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('danger'))
                        <div class="alert alert-danger">
                            {{ session('danger') }}
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="form-group col-md-3">
                            <label for="role_id" class="control-label mb-1">Role</label>
                            <select id="role_id" name="role_id" class="form-control">
                                <option value="">Select</option>
                                @foreach ($roles as $id => $name)
                                    <option value="{{ $id }}" @if (old('role_id', isset($permissions->role_id) ? $permissions->role_id : '') == $id) selected @endif>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <a href="{{ route('create.permission') }}" class="btn btn-primary btn-sm mt-4 ml-3">
                            <i class="bi bi-plus-lg"></i> Add Permission
                        </a>
                    </div>
                    
                </div>
                <form action="{{ route('update.permissions') }}" method="POST">
                    @csrf
                    <div class="table-responsive mt-2">
                        <table class="table table-striped jambo_table bulk_action" id="table">
                            <thead>
                                <tr class="">
                                    <th>No</th>
                                    <th>Status</th>
                                    <th class="">Name</th>
                                    <th class="">Slug</th>
                                    <th class=""><span class="nobr">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $index => $permission)
                                    <tr class="">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <label class="au-checkbox">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $currentPermissions) ? 'checked' : '' }}>
                                                <span class="au-checkmark"></span>
                                            </label>
                                        </td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->slug }}</td>
                                        <td>
                                            <a href="{{ route('edit.permission', $permission->id) }}" class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            <a href="{{ route('destroy.permission', $permission->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?');"><i class="bi bi-trash3-fill"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="item form-group">
                            <button type="submit" class="btn btn-info">
                                Update
                            </button>
                        </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
            setTimeout(function() {
                $(".alert-success").fadeOut(1000);
            }, 1000);
        });
    </script>
@endpush
