@extends('layouts.main')
<style>
    .button-container {
        display: flex;
        justify-content: flex-end;
    }

    .card-header {
        display: none;
    }

    .formdata {
        margin-left: 23% !important;
    }
    .oldimage{
        display: none;
    }
</style>
@section('content')
    <div class="col-md-6 col-sm-6 formdata">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">{{ isset($users) ? 'Edit User' : 'Add User' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($users) ? '/user/update/' . $users->id : '/user/insert' }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label mb-1">Name*</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $users->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label mb-1">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $users->email ?? '') }}"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if(!isset($users))
                        <div class="form-group">
                            <label for="password" class="control-label mb-1">password</label>
                            <input id="password" name="password" type="password"
                                value="{{ old('password', $users->password ?? '') }}"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="invalid-feedback" style="color: red">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="role" class="control-label mb-1">Role</label>
                        <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                            <option value="">Select</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @if (old('role', isset($users->role) ? $users->role : '') == $role) selected @endif>
                                    {{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image" id="imageLabel" class="control-label mb-1 oldimage">Old Image</label>
                        @if (isset($users) && $users->image)
                            <img id="oldImage" src="{{ asset('images/' . $users->image) }}"
                                alt="Uploaded Document" width="100">
                            <input type="hidden" class="form-control" name="oldimage"
                                value="{{ $users->image }}">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label mb-1">Image</label>
                        <input type="file" id="profilepicInput" class="form-control" name="image">
                        @error('image')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="item form-group">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($users))
                                Update
                            @else
                                Save
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#profilepicInput').change(function(e) {
                var fileName = e.target.files[0];
                if (fileName) {
                    $('#imageLabel').text('New Image'); // Change the label text

                    // Display the new image in the img tag
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#oldImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(fileName);
                }
            });
        });
    </script>
@endpush
