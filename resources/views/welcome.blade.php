<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selamat Datang di Klinik Kecantikan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-primary-50 to-primary-100 min-h-screen font-sans text-gray-800">

  {{-- Header --}}
  <header class="bg-white/80 backdrop-blur sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-primary-700">Klinik Cantik</h1>
      <a href="#booking" class="text-sm font-medium text-primary-600 hover:underline">Booking</a>
    </div>
  </header>

  {{-- Hero --}}
  <section class="text-center py-20 px-6">
    <h2 class="text-4xl font-bold text-primary-700 mb-4">Selamat Datang</h2>
    <p class="text-gray-600 mb-8 text-lg">Rasakan perawatan terbaik dari terapis berpengalaman</p>
    <a href="#booking"
      class="px-6 py-3 text-white bg-primary-600 rounded-full hover:bg-primary-700 transition font-semibold shadow">
      Booking Sekarang
    </a>
  </section>

  {{-- Layanan --}}
  <section id="layanan" class="max-w-6xl mx-auto px-4 py-16">
    <h3 class="text-2xl font-semibold text-gray-800 text-center mb-8">Layanan Kami</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      @foreach ($layanans as $layanan)
      <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
        <h4 class="text-lg font-bold text-primary-700 mb-2">{{ $layanan->nama }}</h4>
        <p class="text-gray-600 mb-3">Harga: Rp{{ number_format($layanan->harga, 0, ',', '.') }}</p>
      </div>
      @endforeach
    </div>
  </section>

  {{-- Booking Form --}}
  <section id="booking" class="bg-white rounded-t-3xl shadow-inner py-16 px-4 mt-16">
    <div class="max-w-xl mx-auto">
      <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Form Booking Pasien</h3>

      <form action="#" method="POST" class="space-y-5">
        @csrf

        <div>
          <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" required
            class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
        </div>

        <div>
          <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
          <input type="text" name="no_hp" id="no_hp" required
            class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
        </div>

        <div>
          <label for="layanan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Layanan</label>
          <select name="layanan_id" id="layanan_id" required
            class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
            <option value="">-- Pilih --</option>
            @foreach ($layanans as $layanan)
            <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" required
              class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
          </div>

          <div>
            <label for="jam" class="block text-sm font-medium text-gray-700 mb-1">Jam</label>
            <input type="time" name="jam" id="jam" required
              class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
          </div>
        </div>

        <button type="submit"
          class="w-full mt-6 px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition font-semibold">
          Kirim Booking
        </button>
      </form>
    </div>
  </section>

  {{-- Footer --}}
  <footer class="bg-white/70 backdrop-blur-sm py-6 mt-16 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-600">
      &copy; {{ now()->year }} Klinik Cantik. All rights reserved.
    </div>
  </footer>

</body>

</html>