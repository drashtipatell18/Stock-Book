@extends('layouts.main')
<style>
    .button-container {
        display: flex;
        justify-content: flex-end;
    }

    .card-header {
        display: none;
    }

    .formdata {
        margin-left: 23% !important;
    }

    .timelabel {
        color: red;
    }

    .circus .form-control {
        display: inline;
        height: 12px;
        width: 15px !important;
    }

    .leaveheader {
        text-align: end;
        color: red;
    }
</style>
@section('content')
    <div class="col-md-6 col-sm-6 formdata">
        <div class="card">
            <div class="card-header"></div>
            @php
                $userRole = '';
            @endphp
            @if (auth()->check())
                @php
                    $userRole = strtolower(auth()->user()->role);
                @endphp
            @endif
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">{{ isset($leaves) ? 'Edit Leave' : 'Add Leave' }}</h3>
                </div>
                <div class="leaveheader">Balance Leave: {{ $balanceLeave }}</div>
                <hr>
                <form action="{{ isset($leaves) ? '/leave/update/' . $leaves->id : '/leave/insert' }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="employee_id"
                        value="{{ isset($leaves->employee) ? $leaves->employee->id : $employee_id }}">
                    <input type="hidden" name="user_id"
                        value="{{ isset($leaves->employee) ? $leaves->employee->user_id : $user_id }}">
                    <div class="form-group">
                        <label for="reason" class="control-label mb-1">Reason*</label>
                        <textarea id="reason" name="reason" class="form-control @error('reason') is-invalid @enderror" rows="4"
                            cols="50">{{ old('reason', $leaves->reason ?? '') }}</textarea>

                        @error('reason')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label mb-1">Date Range</label>
                        <input id="startdate" name="startdate" type="date"
                            value="{{ old('startdate', $leaves->startdate ?? '') }}"
                            class="form-control @error('startdate') is-invalid @enderror">
                        @error('startdate')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        To
                        <input id="enddate" name="enddate" type="date"
                            value="{{ old('enddate', $leaves->enddate ?? '') }}"
                            class="form-control @error('enddate') is-invalid @enderror">
                        @error('enddate')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group circus">
                        <label for="leave_type" class="control-label mb-3">leave Type</label>
                        <div>
                            <input type="radio" id="sickleave" name="leave_type" value="sickleave"
                                {{ old('leave_type') == 'sickleave' || (isset($leaves) && $leaves->leave_type == 'sickleave') ? 'checked' : '' }}
                                class="form-control @error('leave_type') is-invalid @enderror">
                            <label for="sickleave">Sick Leave</label>
                        </div>
                        <div>
                            <input type="radio" id="causalleave" name="leave_type" value="causalleave"
                                {{ old('leave_type') == 'causalleave' || (isset($leaves) && $leaves->leave_type == 'causalleave') ? 'checked' : '' }}
                                class="form-control @error('leave_type') is-invalid @enderror">
                            <label for="causalleave">Causal Leave</label>
                        </div>
                        <div>
                            <input type="radio" id="emergencyleave" name="leave_type" value="emergencyleave"
                                {{ old('leave_type') == 'emergencyleave' || (isset($leaves) && $leaves->leave_type == 'emergencyleave') ? 'checked' : '' }}
                                class="form-control @error('leave_type') is-invalid @enderror">
                            <label for="emergencyleave">Emergency Leave</label>
                        </div>
                        @error('leave_type')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="time_from" class="control-label mb-1">Time From</label>
                        <input id="time_from" name="time_from" type="time"
                            value="{{ old('time_from', $leaves->time_from ?? '') }}"
                            class="form-control @error('time_from') is-invalid @enderror">
                        @error('time_from')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for="time_for" class="control-label mb-1">Time To</label>
                            <input id="time_to" name="time_to" type="time"
                                value="{{ old('time_to', $leaves->time_to ?? '') }}"
                                class="form-control @error('time_to') is-invalid @enderror">
                            @error('time_to')
                                <span class="invalid-feedback" style="color: red">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="totalhours" class="control-label mb-1">Total Hours*</label>
                            <input type="text" id="totalhours" name="totalhours"
                                class="form-control @error('totalhours') is-invalid @enderror"
                                value="{{ old('totalhours', $leaves->totalhours ?? '') }}" readonly>
                            @error('totalhours')
                                <span class="invalid-feedback" style="color: red">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
 
                        @if ($userRole != 'employee')
                            <div class="form-group">
                                <label for="workingon" class="control-label mb-1">Status*</label>
                                <div class="col-md-6 col-sm-6">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label
                                            class="btn btn-warning btn-sm mr-2 {{ old('status', isset($leaves) ? $leaves->status : '') == 'pending' ? 'active focus' : '' }}"
                                            data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="pending" class="join-btn"
                                                {{ old('status', isset($leaves) ? $leaves->status : '') == 'pending' ? 'checked' : '' }}>
                                            &nbsp; Pending &nbsp;
                                        </label>
                                        <label
                                            class="btn btn-success btn-sm mr-2 {{ old('status', isset($leaves) ? $leaves->status : '') == 'approved' ? 'active focus' : '' }}"
                                            data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="approved" class="join-btn"
                                                {{ old('status', isset($leaves) ? $leaves->status : '') == 'approved' ? 'checked' : '' }}>
                                            Approved
                                        </label>
                                        <label
                                            class="btn btn-danger btn-sm {{ old('status', isset($leaves) ? $leaves->status : '') == 'disapproved' ? 'active focus' : '' }}"
                                            data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="disapproved" class="join-btn"
                                                {{ old('status', isset($leaves) ? $leaves->status : '') == 'disapproved' ? 'checked' : '' }}>
                                            Disapproved
                                        </label>
                                    </div>

                                    @error('status')
                                        <span class="invalid-feedback" style="color: red">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        {{-- <div class="form-group">
                            <label for="requestto" class="control-label mb-1">RequestTo*</label>
                            <select id="requestto" name="requestto"
                                class="form-control @error('requestto') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="hrmanger"
                                    {{ old('requestto') == 'hrmanger' || (isset($leaves) && $leaves->requestto == 'hrmanger') ? 'selected' : '' }}>
                                    HR Manager</option>
                                <option value="teamleader"
                                    {{ old('requestto') == 'teamleader' || (isset($leaves) && $leaves->requestto == 'teamleader') ? 'selected' : '' }}>
                                    Team Leader</option>
                                <option value="projectmanger"
                                    {{ old('requestto') == 'projectmanger' || (isset($leaves) && $leaves->requestto == 'projectmanger') ? 'selected' : '' }}>
                                    Project Manager</option>
                            </select>
                            @error('requestto')
                                <span class="invalid-feedback" style="color: red">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                        <div class="item form-group">
                            <button type="submit" class="btn btn-lg btn-info btn-block">
                                @if (isset($users))
                                    Update
                                @else
                                    Save
                                @endif
                            </button>
                        </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            function calculateTotalHours() {
                var timeFrom = $('#time_from').val();
                var timeTo = $('#time_to').val();
                var startDate = $('#startdate').val();
                var endDate = $('#enddate').val();

                if (timeFrom && timeTo && startDate && endDate) {
                    var startDateObj = new Date(startDate);
                    var endDateObj = new Date(endDate);

                    // Calculate total days between start and end dates (inclusive)
                    var totalDays = Math.floor((endDateObj - startDateObj) / (1000 * 60 * 60 * 24)) + 1;

                    // Calculate hours from time_from to time_to
                    var startDateTime = new Date('1970-01-01T' + timeFrom + 'Z');
                    var endDateTime = new Date('1970-01-01T' + timeTo + 'Z');

                    // Calculate difference in hours
                    var diffMs = endDateTime - startDateTime;
                    var diffHrs = diffMs / (1000 * 60 * 60);

                    // Adjust for overnight times
                    if (diffHrs < 0) {
                        diffHrs += 24; // Assuming a 24-hour day format
                    }

                    // Calculate total hours based on total days and hours per day
                    var hoursPerDay = 9; // Assuming 9 hours per day
                    var totalHours = (totalDays - 1) * hoursPerDay + diffHrs;

                    $('#totalhours').val(totalHours.toFixed(2)); // Display total hours with two decimal places
                } else {
                    $('#totalhours').val('');
                }
            }

            $('#time_from, #time_to, #startdate, #enddate').on('change', calculateTotalHours);
        });
    </script>
@endpush
