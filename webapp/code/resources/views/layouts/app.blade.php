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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <header class="container-fluid">
        <h1><a class="title" href="{{ url('/') }}">Event Pointer</a></h1>
        <div>
          <a class="button" href="{{ url('/browse') }}">Browse</a>
          <a class="button" href="{{ url('/member') }}">My Page</a>
          <!-- if authenticated, shows logout button -->
          @if (Auth::check())
          <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
          @else
          <a class="button" href="{{ url('/login') }}"> Log In </a>
          @endif
        </div>
      </header>
      <section id="content">
        @yield('content')
      </section>
      <footer class="container-fluid">
        <div><a class="text" href="{{ url('/about') }}">About</a></div>
        <div>
          <a class="text" href="{{ url('/contacts') }}">Contacts</a>
          <a class="text" href="{{ url('/faq') }}">FAQ</a>
        </div>
      </footer>
    </main>
  </body>
</html>
