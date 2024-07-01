@extends('layouts.main')
@section('content')
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Payment List</div>
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
                    <div class="button-container text-right mb-2">
                        <a href="{{ route('create.payment') }}"><button type="button" class="btn btn-info btn-sm mt-1"><i class="bi bi-plus-lg"></i> Add
                                Payment</button></a>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th>No</th>
                                <th class="">Employee Name</th>
                                <th class="">Salary Type</th>
                                <th class="">Total Price</th>
                                <th class="">Date</th>
                                <th class="">Status</th>
                                <th class=""><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $index => $payment)
                                <tr class="">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($payment->employee)
                                        <a href="{{ route('employee') }}">
                                            {{ $payment->employee->firstname }} {{ $payment->employee->lastname }}
                                        </a>
                                        @else
                                        {{ 'No employee found' }}
                                        @endif
                                    </td>
                                    <td>{{ $payment->salary_type }}</td>
                                    <td>{{ $payment->total_price }}</td>
                                    <td>{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                                    <td>
                                        @if ($payment->status == 'pending')
                                            <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                        @elseif($payment->status == 'paid')
                                            <button type="button" class="btn btn-success btn-sm">Paid</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.payment', $payment->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('destroy.payment', $payment->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this?');"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
