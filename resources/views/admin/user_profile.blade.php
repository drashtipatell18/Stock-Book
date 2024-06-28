@extends('layouts.main')
@section('content')
    <style>
        .custom-profile {
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;
        }

        .custom-profile-img {
            text-align: center;
        }

        .custom-profile-img img {
            width: 70%;
            height: 100%;
        }

        .custom-profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }

        .custom-profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .custom-profile-head h5 {
            color: #333;
        }

        .custom-profile-head h6 {
            color: #0062cc;
        }

        .custom-profile-edit-btn {
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }

        .custom-proile-rating {
            font-size: 12px;
            color: #818182;
            margin-top: 5%;
        }

        .custom-proile-rating span {
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }

        .custom-profile-head .nav-tabs {
            margin-bottom: 5%;
        }

        .custom-profile-head .nav-tabs .nav-link {
            font-weight: 600;
            border: none;
        }

        .custom-profile-head .nav-tabs .nav-link.active {
            border: none;
            border-bottom: 2px solid #0062cc;
        }

        .custom-profile-work {
            padding: 14%;
            margin-top: -15%;
        }

        .custom-profile-work p {
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }

        .custom-profile-work a {
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .custom-profile-work ul {
            list-style: none;
        }

        .custom-profile-tab label {
            font-weight: 600;
        }

        .custom-profile-tab p {
            font-weight: 600;
            color: #0062cc;
        }

        .modal-backdrop {
            position: static;
        }

        .profile {
            display: flex
        }

        .right {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
    </style>



    @php
        $userRole = '';
    @endphp
    @if (auth()->check())
        @php
            $userRole = strtolower(auth()->user()->role->role_name);
        @endphp
    @endif
    <div class="container custom-profile">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="post">

            <div class="profile">
                <div class="column col-md-3">
                    <div class="left">
                        <div class="">
                            <div class="custom-profile-img">
                                <img src="{{ asset('images/' . auth()->user()->image) }}" alt="User Image" width="100"
                                    height="50px" class="img-circle profile_img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column col-md-9">
                    <div class="right">
                        <div class="custom-profile-head">
                            @if (isset($users))
                                <h5>{{ $users->firstname }} {{ $users->lastname }}</h5>
                                <h6>
                                    <h5>{{ $users->position }}</h5>
                                </h6>

                                <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                            role="tab" aria-controls="home" aria-selected="true">About</a>
                                    </li>
                                </ul>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" id="editProfileButton">Edit Profile</button>
                        </div>
                    </div>
                    <div class="col-md-8 mt-0">
                        <div class="tab-content custom-profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $users->name }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $users->email }}</p>
                                    </div>
                                </div>
                                @if ($userRole == 'superadmin')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Role</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $users->role->role_name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <h4 class="text-center">users Not Found</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Your form for editing the profile goes here -->
                        <!-- For example: -->
                        @if (isset($users))
                            <form enctype="multipart/form-data" action="{{ route('update-profile', $users->id) }}"
                                id="frmUpdate" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $users->name }}">
                                </div>

                                {{-- <div class="form-group">
                                    @if (isset($image) && $users->image)
                                        <img id="oldImage" src="{{ asset('images/' . $users->image) }}"
                                            alt="Uploaded Document" width="100">
                                        <input type="hidden" class="form-control" name="oldimage"
                                            value="{{ $users->image }}">
                                    @endif
                                </div> --}}
                                <div class="form-group">
                                    <label for="image" class="control-label mb-1">Profile Pic</label>
                                    <input type="file" id="newimage" class="form-control" name="newimage">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ $users->email }}">
                                </div>
                                @if ($userRole != 'employee')
                                    <div class="form-group">
                                        <label for="role_id" class="control-label mb-1">Role</label>
                                        <select id="role_id" name="role_id"
                                            class="form-control @error('role_id') is-invalid @enderror">
                                            <option value="">Select</option>
                                            @foreach ($roles as $id => $name)
                                                <option value="{{ $id }}"
                                                    @if (old('role_id', isset($users->role_id) ? $users->role_id : '') == $id) selected @endif>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Update Changes</button>
                                </div>
                            </form>
                        @endif
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
            $('#editProfileButton').click(function() {
                $('#editProfileModal').modal('show');
            });

            setTimeout(function() {
                $(".alert-success").fadeOut(1000);
            }, 1000);
        });

        $("#frmUpdate").submit(function(e) {
            // e.preventDefault();
            // let fData = new FormData($("#frmUpdate")[0])
            // console.log(...fData);
        })
    </script>
@endpush
