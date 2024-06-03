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
                        <label for="stall_name" class="control-label mb-1">Stall Name*</label>
                        <select id="stall_name" name="stall_name"
                            class="form-control @error('stall_name') is-invalid @enderror">
                            <option value="">Select</option>
                            @foreach ($stalls as $stall)
                                <option value="{{ $stall }}" @if (old('stall_name', isset($salesorders->stall_name) ? $salesorders->stall_name : '') == $stall) selected @endif>
                                    {{ $stall }}</option>
                            @endforeach
                        </select>
                        @error('stall_name')
                            <span class="invalid-feedback" style="color: red">
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
                        <label for="book_name" class="control-label mb-1">Book Name</label>

                        <select id="book_name" name="book_name"
                            class="form-control @error('book_name') is-invalid @enderror">
                            <option value="">Select</option>
                            @foreach ($books as $book)
                                <option value="{{ $book }}" @if (old('book_name', isset($salesorders->book_name) ? $salesorders->book_name : '') == $book) selected @endif>
                                    {{ $book }}</option>
                            @endforeach
                        </select>
                        @error('book_name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="sales_price" class="control-label mb-1">Sales Price</label>
                        <input id="sales_price" name="sales_price" type="number"
                            value="{{ old('sales_price', $salesorders->sales_price ?? '') }}"
                            class="form-control @error('sales_price') is-invalid @enderror" oninput="calculateTotalPrice()">
                        @error('sales_price')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                        <input id="total_price" name="total_price" type="number"
                            value="{{ old('total_price', $salesorders->total_price ?? '') }}"
                            class="form-control @error('total_price') is-invalid @enderror" oninput="calculateTotalPrice()">
                        @error('total_price')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

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
