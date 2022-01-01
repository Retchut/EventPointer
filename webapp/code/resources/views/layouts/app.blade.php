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
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
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
      <header>
        <h1><a href="{{ url('/home') }}">Event Pointer</a></h1>
        <a class="button" href="{{ url('/browse') }}">browse</a>
        <a class="button" href="{{ url('/member') }}">my page</a>
        <!-- if authenticated, shows logout button -->
        @if (Auth::check())
        <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
        @else
        <a class="button" href="{{ url('/login') }}"> Log in </a>
        @endif
      </header>
      <section id="content">
        @yield('content')
      </section>
      <footer>
        <a class="button" href="{{ url('/about') }}">about</a>
        <a class="button" href="{{ url('/contacts') }}">contacts</a>
        <a class="button" href="{{ url('/faq') }}">FAQ</a>
      </footer>
    </main>
  </body>
</html>
