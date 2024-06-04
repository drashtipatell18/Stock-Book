@extends('layouts.main')
@section('content')
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Scrap List</div>
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
                        <a href="{{ route('create.scrap') }}"><button type="button" class="btn btn-primary btn-sm mt-1">Add
                            Scrap</button></a>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th>No</th>
                                <th class="">Scrap Name</th>
                                <th class="">By Date</th>
                                <th class="">Price</th>
                                <th class="">To Date</th>
                                <th class=""><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scraps as $index => $scrap)
                                <tr class="">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $scrap->scrap_weight }}</td>
                                    <td>{{ date('d-m-Y', strtotime($scrap->by_date)) }}</td>
                                    <td>{{ $scrap->price }}</td>
                                    <td>{{ date('d-m-Y', strtotime($scrap->to_date)) }}</td>
                                    <td>
                                        <a href="{{ route('edit.scrap', $scrap->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        <a href="{{ route('destroy.scrap', $scrap->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
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
