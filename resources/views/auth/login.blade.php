@extends('layouts.app')

@section('content')
<style>
    .login-content{
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
                    <div class="login-form">
                        <form method="POST" action="{{ route('login') }}" class="login">
                            @csrf
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                            </div>
                            <div class="login-checkbox">
                                <label>

                                </label>
                                <label>
                                    <a href="{{ route('forget.password') }}">Forgotten Password?</a>
                                </label>
                            </div>
                            <div class="mt-3">
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>

                            </div>
                          
                        </form>
                        <div class="register-link">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
