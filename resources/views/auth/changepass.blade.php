@extends('layouts.app')

@section('content')
    <style>
        .login-content {
            margin-top: 43%;
        }
    </style>
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <h3 class="text-center">Change Password</h3>
                        <div class="login-form mt-4">
                            <form method="POST" action="{{ route('changePassword') }}" class="login">
                                @csrf
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input
                                        class="au-input au-input--full form-control @error('current_password') is-invalid @enderror"
                                        type="password" name="current_password" placeholder="Email">
                                    @error('current_password')
                                        <span class="invalid-feedback" style="color: red">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input
                                        class="au-input au-input--full form-control @error('new_password') is-invalid @enderror"
                                        type="password" name="new_password" placeholder="Password">
                                    @error('new_password')
                                        <span class="invalid-feedback" style="color: red">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input
                                        class="au-input au-input--full form-control @error('confirm_password') is-invalid @enderror"
                                        type="password" name="confirm_password" placeholder="Password">
                                    @error('confirm_password')
                                        <span class="invalid-feedback" style="color: red">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-5">
                                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Change Password</button>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
