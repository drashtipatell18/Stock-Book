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
                    <h3 class="text-center title-2 mt-3 ">{{ isset($stock) ? 'Edit Stock' : 'Add Stock' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($stock) ? '/stock/update/' . $stock->id : '/stock/store' }}" method="POST">
                    @csrf

                    <div class="form-group mt-5">
                        <label for="name" class="control-label mb-1">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $stock->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label mb-1">Quantity</label>
                        <input id="quantity" name="quantity" type="number"
                            value="{{ old('quantity', $stock->quantity ?? '') }}"
                            class="form-control @error('quantity') is-invalid @enderror">
                        @error('quantity')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label mb-1">Price per Book</label>
                        <input id="price" name="price" type="number" value="{{ old('price', $stock->price ?? '') }}"
                            class="form-control @error('price') is-invalid @enderror">
                        @error('price')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="item form-group">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($stock))
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
