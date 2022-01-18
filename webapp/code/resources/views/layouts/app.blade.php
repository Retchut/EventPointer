<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}">
</script>
  </head>
  <body>
    <main>
    <header>
        <nav class="navbar navbar-expand-lg bg-primary navbar-dark nav-justified">
          <div class="container-fluid">
            <a class="ms-4 navbar-brand" href="{{ url('/') }}">Event Pointer</a>

            <div class="justify-content-end" id="navbarColor01">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/browse') }}">Browse</a>
                </li>
                @if (Auth::check())
                <li class="nav-item">
                  <a class="nav-link" style="width: 85px;" href="{{ url('/user/'.@Auth::user()->id) }}">My Page</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/logout') }}">Logout</a> <span>{{ Auth::user()->name }}</span>
                </li>
                @else
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/login') }}">Log In</a>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </nav>
      </header>


      <section class="m-3" id="content">
        @yield('content')
      </section>

      <footer>
        <div class="container-fluid mt-4">
          <div class="row">
            <div class="col-sm-auto">
              <a class="btn btn-link" href="{{ url('/about') }}">About</a>
            </div>
            <div class="col-sm">
              <a class="btn btn-link" href="{{ url('/faq') }}">FAQ</a>
            </div>
            <div class="col-sm-auto">
              <a class="btn btn-link" href="{{ url('/contacts') }}">Contacts</a>
            </div>
          </div>
        </div>
      </footer>
    </main>
  </body>
</html>
