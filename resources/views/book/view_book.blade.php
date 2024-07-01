@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Book List</div>
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
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="button-container text-right mb-2">
                        <a href="{{ route('create.book') }}">
                            <button type="button" class="btn btn-info btn-sm mt-1" id="addCategoryBtn"><i
                                    class="bi bi-plus-lg"></i> Add
                                Book</button>
                        </a>
                    </div>

                    {{-- <h3 class="text-right mt-4"></h3> --}}
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th class="text-center">No</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Book Name</th>
                                <th class="text-center">Category Name</th>
                                <th class="text-center">Price</th>
                           
                                <th class="text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $index => $book)
                                <tr class="">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center"><img src="{{ asset('images/' .$book->image)}}" class="img-fixed-height" width="100px"></td>
                                    <td class="text-center">{{ $book->name }}</td>
                                    <td class="text-center">{{ $book->category_name }}</td>
                                    <td class="text-center">{{ $book->price }}</td>
                                  
                                    <td class="text-center">
                                        <a href="{{ route('edit.book', $book->id) }}" class="btn btn-primary btn-sm"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('destroy.book', $book->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this ?');"><i
                                                class="bi bi-trash3-fill"></i></a>
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