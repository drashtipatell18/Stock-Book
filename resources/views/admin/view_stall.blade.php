@extends('layouts.main')
@section('content')
<style>
    .img-fixed-height {
    height: 120px;
}

</style>
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Stall List</div>
            <div class="card-body">
                <div class="card-title">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('danger'))
                    <div class="alert alert-danger">
                        {{ session('dangerw') }}
                    </div>
                @endif
                    <div class="button-container text-right mb-2"> 
                        <a href="{{ route('stall.create') }}"><button type="button" class="btn btn-primary btn-sm mt-1"><i class="bi bi-plus-lg"></i> Add
                                Stall</button></a>
                    </div>
                    {{-- <h3 class="text-right mt-4"></h3> --}}
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th>No</th>
                                <th class="">Name</th>
                                <th class="">Location</th>
                                <th class="">Owner Name</th>
                                <th class=""><span class="nobr">Action</span></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($stalls as $index => $stall)
                                <tr class="">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $stall->name }}</td>
                                    <td>{{ $stall->location }}</td>
                                    <td>{{ $stall->owner_name }}</td>
                                    <td>
                                        <a href="{{ route('edit.stall', $stall->id) }}"
                                            class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></a>

                                        <a href="{{ route('destroy.stall', $stall->id) }}"
                                            class="btn btn-danger btn-sm"onclick="return confirm('Are you sure you want to delete this ?');"><i class="bi bi-trash3-fill"></i></a>
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

            setTimeout(function() {
                $(".alert-success").fadeOut(1000);
            }, 1000);
            setTimeout(function() {
                $(".alert-danger").fadeOut(1000);
            }, 1000);

        });
    </script>
@endpush
