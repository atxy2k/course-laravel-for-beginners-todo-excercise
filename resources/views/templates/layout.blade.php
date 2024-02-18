<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} {{ isset($title) ? "| $title" : '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @stack('css')
  </head>
  <body>
    <div class="full-container">

      @include('templates.partials.navbar')

      @foreach (Alert::getMessages() as $type => $messages)
          @foreach ($messages as $message)
              <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }}">{{ $message }}</div>
          @endforeach
      @endforeach

      @yield('content')
      
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    @stack('scripts')
  </body>
</html>