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
        <div class="row">
          <div class="col-sm-8">
            <h1><a class="title" href="/">Event Pointer</a></h1>
          </div>
          <div class="col d-flex align-items-center">
            <div class="col">
              <a class="button" href="/">Browse</a>
            </div>
            <div class="col">
              <a class="button" href="/">My Page</a>
            </div>
            <div class="col">
              <a class="button" href="/"> Log In </a>
            </div>
          </div>
        </div>
      </header>
      <footer class="container-fluid">
        <div class="row">
          <div class="col-sm-10">
            <a class="text" href="/">About</a>
          </div>
          <div class="col-sm-1">
            <a class="text" href="/">Contacts</a>
          </div>
          <div class="col-sm-1">
            <a class="text" href="/">FAQ</a>
          </div>
        </div>
      </footer>
    </main>
  </body>
</html>
