<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Selamat Datang di {{ env('APP_NAME') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://kit.fontawesome.com/5fd2369345.js" crossorigin="anonymous">

  </script>
  <!-- AOS Animation -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-primary-100 to-primary-200 min-h-screen font-sans text-gray-800">
  <livewire:booking :layanans="$layanans" />
</body>

</html>