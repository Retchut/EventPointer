@extends('layouts.app')

@section('content')
<section id="login">
    <div class="container-fluid p-4">
        <h1>Register</h1>
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 m-4">
                    <div class="row">
                      <label for="name">Name</label>
                      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                      @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                      @endif
                    </div>

                    <div class="row">
                      <label for="email">E-Mail Address</label>
                      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                      @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                      @endif
                    </div>
                </div>

                <div class="col-sm-5 m-4">
                    <div class="row">
                      <label for="password">Password</label>
                      <input id="password" type="password" name="password" required>
                      @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                      @endif
                    </div>
                    <div class="row">
                      <label for="password-confirm">Confirm Password</label>
                      <input id="password-confirm" type="password" name="password_confirmation" required>
                    </div>
                </div>
                </div>

                <div class="row-sm-2 d-flex justify-content-center">
                  <button type="submit">
                    Register
                  </button>
                  <a class="button button-outline" href="{{ route('login') }}">Login</a>
                </div>
              </form>
</section>
@endsection
