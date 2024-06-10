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
                    <h3 class="text-center title-2">{{ isset($scraps) ? 'Edit Scrap' : 'Add Scrap' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($scraps) ? '/scrap/update/' . $scraps->id : '/scrap/insert' }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label for="name" class="control-label mb-1">Name</label>
                        <input id="name" name="name" type="text"
                            value="{{ old('name', $scraps->name ?? '') }}"
                            class="form-control">
                        @error('name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="scrap_weight" class="control-label mb-1">Scrap weight</label>
                        <input id="scrap_weight" name="scrap_weight"
                            type="number" value="{{ old('scrap_weight', $scraps->scrap_weight ?? '') }}"
                            class="form-control ">
                        @error('scrap_weight')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="by_date" class="control-label mb-1">By Date</label>
                        <input id="by_date" name="by_date" type="date"
                            value="{{ old('by_date', $scraps->by_date ?? '') }}"
                            class="form-control @error('by_date') is-invalid @enderror">
                        @error('by_date')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="price" class="control-label mb-1">Price</label>
                        <input id="price" name="price"
                            type="number" value="{{ old('price', $scraps->price ?? '') }}"
                            class="form-control ">
                        @error('price')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="to_date" class="control-label mb-1">To Date</label>
                        <input id="to_date" name="to_date" type="date"
                            value="{{ old('to_date', $scraps->to_date ?? '') }}"
                            class="form-control @error('to_date') is-invalid @enderror">
                        @error('to_date')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                   
                    <div class="item form-group">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($scraps))
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
