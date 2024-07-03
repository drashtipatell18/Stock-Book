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
                    <h3 class="text-center title-2">{{ isset($scraps) ? 'Edit Scrap' : 'Add Scrap' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($scraps) ? '/scrap/update/' . $scraps->id : '/scrap/insert' }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="customer_name" class="control-label mb-1">Customer Name</label>
                        <div id="customer_name_wrapper">
                            {{-- @if(isset($scraps) && !empty($scraps->customer_name))
                                <input name="customer_name" id="customer_name_text" type="text" value="{{ $scraps->customer_name }}"
                                    class="form-control" disabled>
                            @else
                                <input id="customer_name_text" name="customer_name_text" type="text" placeholder="Enter customer name"
                                    class="form-control @error('customer_name') is-invalid @enderror">
                            @endif
                            <select id="customer_name_select" name="customer_name_select" class="form-control d-none">
                                <option value="">-- Select or enter new customer name --</option>
                                @foreach($customerNames as $customer)
                                    <option value="{{ $customer }}">{{ $customer }}</option>
                                @endforeach
                            </select> --}}
                            <input list="names" value="{{ old('name', $scraps->customer_name ?? '') }}" id="customer_name_text" name="customer_name_text" type="text" placeholder="Enter customer name"
                                    class="form-control @error('customer_name') is-invalid @enderror">
                            @if(isset($customerNames) && !empty($customerNames))
                                <datalist id="names">
                                    @foreach($customerNames as $name)
                                        <option value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                </datalist>
                            @endif
                        </div>
                        @error('customer_name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label mb-1">Scrap Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $scraps->name ?? '') }}"
                            class="form-control">
                        @error('name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="scrap_weight" class="control-label mb-1">Scrap weight</label>
                        <input id="scrap_weight" name="scrap_weight" type="number"
                            value="{{ old('scrap_weight', $scraps->scrap_weight ?? '') }}" class="form-control ">
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

                
                    <label for="sales_price" class="control-label mb-1">Sales Price</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <select class="form-control @error('price') is-invalid @enderror" name="symbol"
                                    autocomplete="off">
                                    <option value="₹">₹</option>
                                    <option value="$">$</option>
                                </select>
                            </span>
                        </div>
                        <input id="price" name="price" placeholder="" type="number"
                            class="form-control miplusinput @error('price') is-invalid @enderror"
                            value="<?php echo isset($stocks->price) ? $stocks->price : ''; ?>"  oninput="calculateTotalPrice()">
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
@push('scripts')
    <script>
        $(document).ready(function() {
            var customerName = "{{ isset($scraps) && !empty($scraps->customer_name) ? $scraps->customer_name : '' }}";
        var existingCustomers = {!! json_encode($customerNames) !!};

        // Show dropdown when input is focused or has text
        $('#customer_name_text').on('input', function() {
            var inputVal = $(this).val().trim();
            if (inputVal.length > 0) {
                var matchFound = false;
                existingCustomers.forEach(function(customer) {
                    if (customer.toLowerCase() === inputVal.toLowerCase()) {
                        matchFound = true;
                        return false; // Exit loop early
                    }
                });

                if (matchFound) {
                    $('#customer_name_select').removeClass('d-none');
                    $(this).prop('disabled', true); // Disable text input
                } else {
                    $('#customer_name_select').addClass('d-none');
                    $(this).prop('disabled', false); // Enable text input
                }
            } else {
                $('#customer_name_select').addClass('d-none');
                $(this).prop('disabled', false); // Enable text input
            }
        });

        // Show text input when dropdown is changed
        $('#customer_name_select').change(function() {
            var selectedVal = $(this).val().trim();
            if (selectedVal.length > 0) {
                $('#customer_name_text').prop('disabled', false);
                $('#customer_name_select').addClass('d-none');
            }
        });

        // Initialize based on existing customer name
        if (customerName) {
            $('#customer_name_select').removeClass('d-none');
            $('#customer_name_text').prop('disabled', true); // Disable text input
        }
        });
    </script>
@endpush
