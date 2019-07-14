@extends('layouts.frontapp')

@section('content')
<div class="container" style="margin-top: 8%;">

    <div class="card card-container">
        <h2 id="loginTitle">Login</h2>

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                    <p><strong>{{ $errors->first('name') }}</strong></p>
                </span><br>
        @endif

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                    <p><strong>{{ $errors->first('password') }}</strong></p>
                </span><br>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Username</label>
            <input id="email" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                   value="{{ old('name') }}" required autocomplete="name" autofocus>



            <label id="passwordLabel" for="passwordLogin">Password</label>
            <input id="passwordLogin" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                   name="password" required autocomplete="current-password">



            <div id="rememberMe" class="checkbox">
                <label>
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                </label>
                <a href="#" style="float: right;">
                    Forgot your password?
                </a>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Login</button>
        </form>
        <p class="text-center">Don't have an account yet? Create one <a href="{{ route('password.request') }}">here</a>.
        </p>
    </div>
</div>
@endsection
