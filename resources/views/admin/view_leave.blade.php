@extends('layouts.main')
@section('content')
    <style>
        .statusbtn {
            color: white;
        }
    </style>
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Leave List</div>
            @if (auth()->check())
                @php
                    $userRole = strtolower(auth()->user()->role->role_name);
                @endphp
            @endif
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
                        <a href="{{ route('create.leave') }}">
                            <button type="button" class="btn btn-primary btn-sm mt-1"><i class="bi bi-plus-lg"></i> Add Leave</button>
                        </a>
                    </div>
                    {{-- <h3 class="text-right mt-4"></h3> --}}
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th>No</th>
                                <th>Today Date</th>
                                <th class="">Employee Name</th>
                                <th class="">Reason</th>
                                <th class="">Leave From</th>
                                <th class="">Leave To</th>
                                <th class="">status</th>
                                @if ($userRole != 'employee')
                                    <th class=""><span class="nobr">Action</span></th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($leaves as $index => $leave)
                                <tr class="">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ date('d/m/y' , strtotime($leave->created_at))}}</td>
                                    <td>
                                        @if ($leave->employee)
                                            {{ $leave->employee->firstname }} {{ $leave->employee->lastname }}
                                        @endif
                                    </td>
                                    <td>{{ $leave->reason }}</td>
                                    <td>{{ date('d/m/Y', strtotime($leave->startdate)) }}
                                    <td>{{ date('d/m/Y', strtotime($leave->enddate)) }}
                                    <td>
                                        @if ($leave->status == '')
                                            <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                        @elseif($leave->status == 'approved')
                                            <button type="button" class="btn btn-success btn-sm">Approved</button>
                                        @elseif($leave->status == 'disapproved')
                                            <button type="button" class="btn btn-danger btn-sm">Disapprove</button>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if (is_null($leave->status))
                                            @if ($userRole != 'employee')
                                                <a href="#" class="btn btn-secondary btn-sm" id="updateButton"
                                                    data-id="{{ $leave->id }}"
                                                    onclick="return confirm('Are you sure you want to update the status?')">
                                                    <span class="statusbtn">Pending</span>
                                                </a>
                                            @else
                                                <a class="btn btn-secondary btn-sm"><span
                                                        class="statusbtn">Pending</span></a>
                                            @endif
                                        @elseif($leave->status == 1)
                                            <a class="btn btn-success btn-sm" id="approveButton"><span
                                                    class="statusbtn">Approved</span></a>
                                        @elseif($leave->status == 0)
                                            <a class="btn btn-danger btn-sm"><span class="statusbtn">Rejected</span></a>
                                        @endif
                                    </td> --}}
                                    @if ($userRole != 'Employee')
                                        <td>
                                            <a href="{{ route('edit.leave', $leave->id) }}"
                                                class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></a>

                                            <a href="{{ route('destroy.leave', $leave->id) }}"
                                                class="btn btn-danger btn-sm"onclick="return confirm('Are you sure you want to delete this ?');"><i class="bi bi-trash3-fill"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- @if ($userRole != 'employee')
                        <form action="{{ url('/update-status/' . $leave->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-secondary btn-sm">Approve</button>
                        </form>
                    @endif --}}

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
        $(document).on('click', '#updateButton', function(e) {
            // Prevent default action of the link
            e.preventDefault();

            // Check if the user confirmed the action
            if (!confirm('Are you sure you want to update the status?')) {
                return; // Exit function if user clicked cancel
            }

            var leaveId = $(this).data('id');
            $.ajax({
                url: '{{ route('update-status') }}',
                type: 'POST',
                data: {
                    id: leaveId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('.alert-danger').addClass('alert-success')
                            .text(response.message).show();

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('.alert-success').addClass('alert-danger')
                            .text(response.message).show();
                    }
                },
                error: function() {
                    $('.alert-success').addClass('alert-danger')
                        .text('An error occurred while updating. Please try again.')
                        .show();
                }
            });
            setTimeout(function() {
                $(".alert-success").fadeOut(1000);
            }, 1000);
            setTimeout(function() {
                $(".alert-danger").fadeOut(1000);
            }, 1000);
        });
    </script>
@endpush
