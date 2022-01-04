@extends('layouts.app')

@section('content')

<section id="login">
    <div class="container-fluid p-4">
        <h1>Log In</h1>
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 m-4">
                    <div class="row">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="error">
                            {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                        @if ($errors->has('password'))
                            <span class="error">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4 m-4">
                    <div class="row">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>

            
                </div>
            </div>
            <div class="row-sm-2 d-flex justify-content-center">
                <button type="submit button">
                Login
                    </button>
                    <a class="button button-outline" href="{{ route('register') }}">Register</a>
            </div>
        </form>
    </div>
</section>
@endsection
