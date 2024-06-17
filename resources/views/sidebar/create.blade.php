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
</style>
@section('content')
    <div class="col-md-6 col-sm-6 formdata">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">{{ isset($sidebar) ? 'Edit Sidebar Menu' : 'Add Sidebar Menu' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($sidebar) ? '/sidebar/update/' . $sidebar->id : route('sidebar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="class" class="control-label mb-1">Class</label>
                        <input id="class" name="class" type="text" value="{{ old('class', $sidebar->name ?? '') }}" class="form-control @error('class') is-invalid @enderror">
                        @error('class')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="display_name" class="control-label mb-1">Display Name</label>
                        <input id="display_name" name="display_name" type="text" value="{{ old('display_name', $sidebar->display_name ?? '') }}" class="form-control @error('display_name') is-invalid @enderror">
                        @error('display_name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="route" class="control-label mb-1">Route</label>
                        <input id="route" name="route" type="text" value="{{ old('route', $sidebar->route ?? '') }}" class="form-control @error('route') is-invalid @enderror">
                        @error('route')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="item form-group">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($sidebar))
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