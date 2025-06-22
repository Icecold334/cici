<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cici | {{ $title }}</title>
  <script src="https://kit.fontawesome.com/5fd2369345.js" crossorigin="anonymous">
  </script>
  @stack('styles')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  {{-- @fluxAppearance --}}
</head>