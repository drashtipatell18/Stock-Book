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

    .oldimage {
        display: none;
    }
    .miplus {
        position: absolute;
        width: 60px;
    }

    .miplusinput {
        padding-left: 70px;
    }
</style>
@section('content')
    <div class="col-md-6 col-sm-6 formdata">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">{{ isset($salesorders) ? 'Edit Sales Order' : 'Add Sales Order' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($salesorders) ? '/salesorder/update/' . $salesorders->id : '/salesorder/insert' }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="stall_id">Store Name</label>
                        <select id="stall_id" name="stall_id" class="form-control @error('stall_id') is-invalid @enderror">
                            <option value="">Select</option>
                            @foreach ($stalls as $id => $name)
                                <option value="{{ $id }}" @if (old('stall_id') == $id) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('stall_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="location" class="control-label mb-1">Location</label>
                        <input id="location" name="location" type="text"
                            value="{{ old('location', $salesorders->location ?? '') }}"
                            class="form-control @error('location') is-invalid @enderror">
                        @error('location')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="book_id">Book Name</label>
                        <select id="book_id" name="book_id" class="form-control @error('book_id') is-invalid @enderror">
                            <option value="">Select</option>
                            @foreach ($books as $id => $name)
                                <option value="{{ $id }}" @if (old('book_id') == $id) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="sales_price" class="control-label mb-1">Sales Price</label>
                        <div class="form-group has-success">
                            <span class="miplus">
                                <select class="form-control @error('sales_price') is-invalid @enderror" name="symbol"
                                    autocomplete="off">
                                    <option value="$">$</option>
                                    <option value="₹">₹</option>
                                </select>
                            </span>
                            <input id="sales_price" name="sales_price" placeholder="" type="number"
                                class="form-control miplusinput @error('sales_price') is-invalid @enderror"
                                value="<?php echo isset($stocks->sales_price) ? $payments->sales_price : ''; ?>"  oninput="calculateTotalPrice()">
                            @error('sales_price')
                                <span class="invalid-feedback" style="color: red">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group has-success">
                        <label for="quantity" class="control-label mb-1">Quantity</label>
                        <input id="quantity" name="quantity" type="number"
                            value="{{ old('quantity', $salesorders->quantity ?? '') }}"
                            class="form-control @error('quantity') is-invalid @enderror" oninput="calculateTotalPrice()">
                        @error('quantity')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="total_price" class="control-label mb-1">Total Price</label>
                        <div class="form-group has-success">
                            <span class="miplus">
                                <select class="form-control @error('total_price') is-invalid @enderror" name="symbol"
                                    autocomplete="off">
                                    <option value="$">$</option>
                                    <option value="₹">₹</option>
                                </select>
                            </span>
                            <input id="total_price" name="total_price" placeholder="" type="text"
                                class="form-control miplusinput @error('total_price') is-invalid @enderror"
                                value="<?php echo isset($stocks->total_price) ? $payments->total_price : ''; ?>"  oninput="calculateTotalPrice()">
                            @error('total_price')
                                <span class="invalid-feedback" style="color: red">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if (isset($customError))
                        <span class="text-danger" style="font-size: small">{{ $customError }}</span>
                    @endif

                    <div class="item form-group">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($salesorders))
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
        function calculateTotalPrice() {
            const salesPrice = document.getElementById('sales_price').value;
            const quantity = document.getElementById('quantity').value;
            const totalPrice = salesPrice * quantity;
            document.getElementById('total_price').value = totalPrice;
        }
    </script>
@endpush
