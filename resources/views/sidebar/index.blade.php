@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Sidebar Menus</div>
            <div class="card-body">
                <div class="card-title">
                    {{-- <div class="button-container text-right mb-2">
                        <a href="{{ route('sidebar.create') }}">
                            <button type="button" class="btn btn-primary btn-sm mt-1" id="addCategoryBtn"><i
                                    class="bi bi-plus-lg"></i> Add New Menu</button>
                        </a>
                    </div> --}}
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th class="text-center">No</th>
                                <th class="text-center">Class</th>
                                <th class="text-center">Display Name</th>
                                <th class="text-center">Route</th>
                                <th class="text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($siderbars as $sidebar)
                                <tr>
                                    <td class="text-center">{{ $index++ }}</td>
                                    <td class="text-center"><i class="{{ $sidebar->name }}"></i></td>
                                    <td class="text-center">{{ $sidebar->display_name }}</td>
                                    <td class="text-center">{{ $sidebar->route }}</td>
                                    <td class="text-center"><a href="/sidebar/edit/{{ $sidebar->id }}">
                                            <button class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                        <a href="/sidebar/delete/{{ $sidebar->id }}">
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </a>

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
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endpush
