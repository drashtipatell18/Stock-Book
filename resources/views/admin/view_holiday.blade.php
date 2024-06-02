@extends('layouts.main')
@section('content')
    <style>
        .statusbtn {
            color: white;
        }
    </style>
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Holiday List</div>
            {{-- @if (auth()->check())
                @php
                    $userRole = strtolower(auth()->user()->role);
                @endphp
            @endif --}}
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
                    <div id="alert-placeholder"></div>
                    {{-- @if ($userRole != 'employee') --}}
                        <div class="button-container text-right mb-2">
                            <a href="{{ route('create.holiday') }}"><button type="button"
                                    class="btn btn-primary btn-sm mt-1"><i class="bi bi-plus-lg"></i>  Add
                                    Holiday</button></a>
                        </div>
                    {{-- @endif --}}
                    {{-- <h3 class="text-right mt-4"></h3> --}}
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th>No</th>
                                <th class="">Name</th>
                                <th class="">Date</th>
                                <th class="">Day</th>
                                {{-- @if ($userRole != 'employee') --}}
                                    <th class=""><span class="nobr">Action</span></th>
                                {{-- @endif --}}
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($holidays as $index => $holiday)
                                @php
                                    $isPast = strtotime($holiday->date) < strtotime(date('Y-m-d'));
                                @endphp
                                <tr class="{{ $isPast ? 'past-date' : '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $holiday->name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($holiday->date)) }}
                                    <td>{{ $holiday->day }}</td>
                                    {{-- @if ($userRole != 'employee') --}}
                                        <td>
                                            <a href="{{ route('edit.holiday', $holiday->id) }}"
                                                class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></a>

                                            <a href="{{ route('destroy.holiday', $holiday->id) }}"
                                                class="btn btn-danger btn-sm"onclick="return confirm('Are you sure you want to delete this ?');"><i class="bi bi-trash3-fill"></i></a>
                                        </td>
                                    {{-- @endif --}}
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
            setTimeout(function() {
                $(".alert-danger").fadeOut(1000);
            }, 1000);
        });
    </script>
@endpush
