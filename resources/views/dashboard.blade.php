@extends('layouts.main')

@section('content')
<div class="col-md-12 col-sm-12 ">
    <div class="card">
        <div class="card-header">Work List</div>
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
                    <a href="">
                        <button type="button" class="btn btn-primary btn-sm mt-1" id="addWorkBtn">Add Work</button>
                    </a>
                </div>

                {{-- <h3 class="text-right mt-4"></h3> --}}
            </div>
            <div class="table-responsive mt-2">
                <table class="table table-striped jambo_table bulk_action" id="table">
                    <thead>
                        <tr class="">
                            <th>No</th>
                            <th class="">Employee Name</th>
                            <th class="">Date</th>
                            <th class="">Project Name</th>
                            <th class="">Description</th>
                            <th class=""><span class="nobr">Action</span></th>
                        </tr>
                    </thead>

                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection