<div>


    {{-- Hero --}}
    <section class="max-w-7xl mx-auto px-4 py-20 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div class="text-center md:text-left" data-aos="fade-right">
            <h2 class="text-4xl font-bold text-primary-700 mb-4">Selamat Datang di {{ env('APP_NAME') }}</h2>
            <p class="text-gray-600 text-lg mb-6">Nikmati perawatan terbaik dari terapis profesional kami</p>
            <!-- Trigger -->
            <button wire:click="booking"
                class="inline-block px-6 py-3 text-white bg-primary-600 rounded-full hover:bg-primary-700 transition font-semibold shadow">
                <i class="fas fa-calendar-plus mr-2"></i> Reservasi Sekarang
            </button>
        </div>
        <div class="max-w-lg mx-auto" data-aos="fade-left">
            <img src="/assets/img/pic1.jpg" alt="Hero Image" class="rounded-xl shadow-lg object-cover w-full h-80">
        </div>
    </section>

    {{-- Layanan --}}
    <section id="layanan" class="max-w-7xl mx-auto px-4 py-20">
        <h3 class="text-3xl font-semibold text-gray-800 text-center mb-12" data-aos="fade-up">Layanan Kami</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($layanans as $layanan)
            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition" data-aos="fade-up">
                <h4 class="text-lg font-bold text-primary-700 mb-2">{{ $layanan->nama }}</h4>
                <p class="text-gray-600">{{ $layanan->deskripsi }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Galeri --}}
    <section id="galeri" class="max-w-7xl mx-auto px-4 py-20">
        <h3 class="text-3xl font-semibold text-gray-800 text-center mb-12" data-aos="fade-up">Galeri</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach (['pic1.jpg', 'pic2.jpg', 'pic3.jpg', 'pic4.jpg'] as $pic)
            <div class="overflow-hidden rounded-xl shadow" data-aos="zoom-in">
                <img src="/assets/img/{{ $pic }}" alt="Galeri"
                    class="w-full h-56 object-cover hover:scale-105 transition duration-500">
            </div>
            @endforeach
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white/70 backdrop-blur-sm py-6 mt-16 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-600">
            &copy; {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
          duration: 800,
          once: true,
          easing: 'ease-in-out'
        });
    </script>


</div>