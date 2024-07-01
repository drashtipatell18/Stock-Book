@extends('layouts.main')

@section('content')
<style>
    .modal-backdrop {
        position: relative !important;
    }
</style>
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Category List</div>
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

                    <div class="button-container text-right mb-2">
                        <a href="{{ route('category.create') }}">
                            <button type="button" class="btn btn-info btn-sm mt-1" id="addCategoryBtn"><i class="bi bi-plus-lg"></i> Add
                                Category</button>
                        </a>
                    </div>

                    {{-- <h3 class="text-right mt-4"></h3> --}}
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th class="text-center">No</th>
                                <th class="text-center">Category Name</th>
                                <th class="text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorys as $index => $category)
                                <tr class="">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $category->category_name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('edit.category', $category->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('destroy.category', $category->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this ?');"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="bookDeleteConfirmation" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Associated Books</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Do you also want to delete the books associated with "{{ $category->name }}" category?</p>
                                <ul>
                                    @foreach ($books as $book)
                                        <li>{{ $book }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="{{ route('category.delete-books', $category->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Yes, Delete Books</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
            $('#bookDeleteConfirmation').modal('show');
        });
    </script>
@endpush
