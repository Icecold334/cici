<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Selamat Datang di {{ env('APP_NAME') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://kit.fontawesome.com/5fd2369345.js" crossorigin="anonymous"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- AOS Animation -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-primary-100 to-primary-200 min-h-screen font-sans text-gray-800">
  <header class="bg-white/80 backdrop-blur sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <a href="/" class="text-xl font-bold text-primary-700">{{ env('APP_NAME') }}</a>
      <a href="/booking" class="text-sm font-medium text-primary-600 hover:underline">Reservasi</a>
    </div>
  </header>
  <livewire:booking :layanans="$layanans" />
</body>
<script>
  window.addEventListener('booked', function (event) {
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: event.detail,
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  });
</script>

</html>