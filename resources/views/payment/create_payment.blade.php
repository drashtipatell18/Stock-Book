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
                    <h3 class="text-center title-2">{{ isset($payments) ? 'Edit Payment' : 'Add Payment' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($payments) ? '/payment/update/' . $payments->id : '/payment/insert' }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="employee_id" class="control-label mb-1">Employee:</label>
                        <select id="employee_id" name="employee_id" class="form-control">
                            <option value="">Select Employee</option>
                            @foreach ($employees as $id => $name)
                                <option value="{{ $id }}"
                                    {{ old('employee_id', $payments->employee_id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        {{-- @error('employee_id')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>

                    <div class="form-group">
                        <label for="accountno" class="control-label mb-1">Bank Account Number</label>
                        <input id="accountno" name="accountno" type="number"
                            value="{{ old('accountno', $payments->accountno ?? '') }}" class="form-control">
                        {{-- @error('accountno')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>

                    <div class="form-group has-success">
                        <label for="bankname" class="control-label mb-1">Bank Name</label>
                        <input id="bankname" name="bankname" type="text"
                            value="{{ old('bankname', $payments->bankname ?? '') }}" class="form-control ">
                        {{-- @error('bankname')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>

                    <div class="form-group has-success">
                        <label for="ifsccode" class="control-label mb-1">IFSC Code</label>
                        <input id="ifsccode" name="ifsccode"
                            type="text"value="{{ old('ifsccode', $payments->ifsccode ?? '') }}" class="form-control">
                        {{-- @error('ifsccode')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>
                    <div class="form-group">
                        <label for="type" class="control-label mb-1">Salary Type</label>
                        <select id="salary_type" name="salary_type" class="form-control">
                            <option value="">Select</option>
                            <option value="cash"
                                {{ old('salary_type', $payments->salary_type ?? '') == 'cash' ? 'selected' : '' }}>
                                Cash
                            </option>
                            <option value="online"
                                {{ old('salary_type', $payments->salary_type ?? '') == 'online' ? 'selected' : '' }}>
                                Online</option>
                        </select>
                    </div>

                    <div class="form-group has-success">
                        <label for="total_price" class="control-label mb-1">Total Salary</label>
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
                            <input id="total_price" name="total_price" placeholder="" type="text"
                                class="form-control miplusinput @error('total_price') is-invalid @enderror"
                                value="<?php echo isset($payments->total_price) ? $payments->total_price : ''; ?>">
                            @error('total_price')
                                <span class="invalid-feedback" style="color: red">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_date" class="control-label mb-1"> Payment Date</label>
                        <input id="payment_date" name="payment_date" type="date"
                            value="{{ old('payment_date', $payments->payment_date ?? '') }}"
                            class="form-control @error('payment_date') is-invalid @enderror">
                        @error('payment_date')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group has-success">
                        <label for="advance_payment" class="control-label mb-1">Advance Payment</label>
                        <input id="advance_payment" name="advance_payment" type="number"
                            value="{{ old('advance_payment', $payments->advance_payment ?? '') }}"
                            class="form-control @error('advance_payment') is-invalid @enderror">
                        @error('advance_payment')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="advance_payment_date" class="control-label mb-1">Advance Payment Date</label>
                        <input id="advance_payment_date" name="advance_payment_date" type="date"
                            value="{{ old('advance_payment_date', $payments->advance_payment_date ?? '') }}"
                            class="form-control @error('advance_payment_date') is-invalid @enderror">
                        @error('advance_payment_date')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="position" class="control-label mb-1">Status:</label>
                        <label
                            class="btn btn-success btn-sm mr-2 {{ old('status', isset($payments) ? $payments->status : '') == 'paid' ? 'active focus' : '' }}"
                            data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="status" value="paid" class="join-btn"
                                {{ old('status', isset($payments) ? $payments->status : '') == 'paid' ? 'checked' : '' }}>
                            Paid
                        </label>
                        <label
                            class="btn btn-warning btn-sm mr-2 {{ old('status', isset($payments) ? $payments->status : '') == 'pending' ? 'active focus' : '' }}"
                            data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="status" value="pending" class="join-btn"
                                {{ old('status', isset($payments) ? $payments->status : '') == 'pending' ? 'checked' : '' }}>
                            &nbsp; Pending &nbsp;
                        </label>

                        @error('status')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="item form-group">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($payments))
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
