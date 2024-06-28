@extends('layouts.main')
@section('content')
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">SalesOrder List</div>
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
                        <a href="{{ route('create.salesorder') }}"><button type="button" class="btn btn-primary btn-sm mt-1"><i class="bi bi-plus-lg"></i> Add
                            SalesOrder</button></a>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th class="text-center">No</th>
                                <th class="text-center">Stall Name</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Book Name</th>
                                <th class="text-center">Sales Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesorders as $index => $salesorder)
                                <tr class="">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $salesorder->stall->name }}</td>
                                    <td class="text-center">{{ $salesorder->location }}</td>
                                    <td class="text-center">{{ $salesorder->book->name }}</td>
                                    <td class="text-center">{{ $salesorder->sales_price }}</td>
                                    <td class="text-center">{{ $salesorder->quantity }}</td>
                                    <td class="text-center">{{ $salesorder->total_price }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('edit.salesorder', $salesorder->id) }}" class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('destroy.salesorder', $salesorder->id) }}" class="btn btn-danger btn-sm"
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
