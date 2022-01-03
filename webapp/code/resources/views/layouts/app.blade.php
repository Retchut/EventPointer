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
    <!-- <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
    <header>
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-8">
              <h1><a class="title" href="{{ url('/') }}">Event Pointer</a></h1>
            </div>
            <div class="col d-flex align-items-center">
              <div class="col">
                <a class="button" href="{{ url('/browse') }}">Browse</a>
              </div>
              @if (Auth::check())
              <div class="col">
                <a class="button" href="{{ url('/user/{user_id}') }}">My Page</a>
              </div>
              <div class="col">
                <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
              </div>
              @else
              <div class="col">
                <a class="button" href="{{ url('/login') }}"> Log In </a>
              </div>
              @endif

            </div>
          </div>
        </div>
      </header>


      <section id="content">
        @yield('content')
      </section>

      <footer>
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-1">
              <a class="text" href="{{ url('/about') }}">About</a>
            </div>
            <div class="col-sm-10">
              <a class="text" href="{{ url('/faq') }}">FAQ</a>
            </div>
            <div class="col-sm-1 float-end">
              <a class="text" href="{{ url('/contacts') }}">Contacts</a>
            </div>
          </div>
        </div>
      </footer>
    </main>
  </body>
</html>
