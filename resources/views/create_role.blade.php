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

    .timelabel {
        color: red;
    }

    .circus .form-control {
        display: inline;
        height: 12px;
        width: 15px !important;
    }

    #imageLabel {
        display: none;
    }
</style>
@section('content')
    <div class="col-md-6 col-sm-6 formdata">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2 mt-3 ">{{ isset($role) ? 'Edit Role' : 'Add Role' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($role) ? '/role/update/' . $role->id : '/role/store' }}" method="POST">
                    @csrf

                    <div class="form-group mt-5">
                        <label for="role_name" class="control-label mb-1"> Role Name</label>
                        <input id="role_name" name="role_name" type="text"
                            value="{{ old('role_name', $role->role_name ?? '') }}"
                            class="form-control @error('role_name') is-invalid @enderror">
                        @error('role_name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="item form-group mt-5">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($role))
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
