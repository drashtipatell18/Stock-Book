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

    .circus .form-control {
        display: inline;
        height: 12px;
        width: 15px !important;
    }

    .radio-btn{
        display: flex;
    }

    .unmarried{
        margin-left: 15px;
    }

</style>
@section('content')
    <div class="col-md-6 col-sm-6 formdata">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">{{ isset($employees) ? 'Edit Employee' : 'Add Employee' }}</h3>
                </div>
                <hr>
                <form
                    action="{{ isset($employees) ? '/employee/update/' . $employees->id : '/employee/insert' }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="role_id" class="control-label mb-1">Select Role</label>
                        {{-- <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Select User</option>
                            @foreach ($users as $userId => $userName)
                            <option value="{{ $userId }}" {{ isset($employees) && $employees->user_id == $userId ? 'selected' : '' }}>
                                {{ $userName }}
                                </option>
                            @endforeach
                            @error('user_id')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </select> --}}
                        <select id="role_id" name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                            <option value="">Select Role</option>
                            @foreach ($roles as $roleId => $roleName)
                            <option value="{{ $roleId }}" {{ isset($user) && $user->role_id == $roleId ? 'selected' : '' }}>
                                {{ $roleName }}
                                </option>
                            @endforeach
                            @error('role_id')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="firstname" class="control-label mb-1">First Name</label>
                        <input id="firstname" name="firstname" type="text"
                            value="{{ old('firstname', $employees->firstname ?? '') }}"
                            class="form-control @error('firstname') is-invalid @enderror">
                        @error('firstname')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group has-success">
                        <label for="lastname" class="control-label mb-1">Last Name</label>
                        <input id="lastname" name="lastname"
                            type="text"value="{{ old('lastname', $employees->lastname ?? '') }}"
                            class="form-control @error('lastname') is-invalid @enderror">
                        @error('lastname')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                        @error('password')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="aadhar_number" class="form-label">Aadhar Number</label>
                        <input type="number" class="form-control" name="aadhar_number" id="aadhar_number">
                        @error('aadhar_number')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dob" class="control-label mb-1">DOB</label>
                        <input id="dob" name="dob" type="date" value="{{ old('dob', $employees->dob ?? '') }}"
                            class="form-control @error('dob') is-invalid @enderror">
                        @error('dob')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender" class="control-label mb-1">Gender</label>
                        <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="male"
                                {{ old('gender', $employees->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female"
                                {{ old('gender', $employees->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label mb-1">Email</label>
                        <input id="email" name="email" type="email"
                            value="{{ old('email', $employees->email ?? '') }}"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="5">{{ old('address', $employees->address ?? '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phoneno" class="control-label mb-1">Phone No</label>
                        <input id="phoneno" name="phoneno" type="number"
                            value="{{ old('phoneno', $employees->phoneno ?? '') }}"
                            class="form-control @error('phoneno') is-invalid @enderror">
                        @error('phoneno')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="joiningdate" class="control-label mb-1">Joining Date</label>
                        <input id="joiningdate" name="joiningdate" type="date"
                            value="{{ old('joiningdate', $employees->joiningdate ?? '') }}"
                            class="form-control @error('joiningdate') is-invalid @enderror">
                        @error('joiningdate')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="salary" class="control-label mb-1">Salary</label>
                        <input id="salary" name="salary" type="number"
                            value="{{ old('salary', $employees->salary ?? '') }}"
                            class="form-control @error('salary') is-invalid @enderror">
                        @error('salary')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
               
                    <div class="item form-group">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($employees))
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
            $("#user_id").change(function(){
                if($(this).val())
                {
                    $.ajax({
                        type: "GET",
                        method: "GET",
                        url: "/employee/getemail/" + $(this).val(),
                        success: function(response){
                            $("#email").val(response.email)
                        }
                    })
                }
            })
            $('#profilepicInput').change(function(e) {
                var fileName = e.target.files[0];
                if (fileName) {
                    $('#imageLabel').text('New Image'); // Change the label text

                    // Display the new image in the img tag
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#oldImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(fileName);
                }
            });
        });
    </script>
@endpush
