<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-layouts.app.head :title="$title" />

<body class="bg-gray-50">

  <!-- Sidebar -->
  <x-layouts.app.side />

  <!-- Navbar -->
  <x-layouts.app.nav />

  <!-- Main Content -->
  <main class="pt-20 px-4 lg:ml-64 bg-gradient-to-br from-pink-50 to-primary-100 min-h-screen">
    {{ $slot }}
  </main>



  {{-- <script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  @stack('scripts')
</body>

</html>