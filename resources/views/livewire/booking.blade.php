<div>
    {{-- Header --}}
    <header class="bg-white/80 backdrop-blur sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-primary-700">{{ env('APP_NAME') }}</h1>
            <a href="#layanan" class="text-sm font-medium text-primary-600 hover:underline">Layanan</a>
        </div>
    </header>

    {{-- Hero --}}
    <section class="max-w-7xl mx-auto px-4 py-20 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div class="text-center md:text-left" data-aos="fade-right">
            <h2 class="text-4xl font-bold text-primary-700 mb-4">Selamat Datang di {{ env('APP_NAME') }}</h2>
            <p class="text-gray-600 text-lg mb-6">Nikmati perawatan terbaik dari terapis profesional kami</p>
            <!-- Trigger -->
            <button wire:click="showForm"
                class="inline-block px-6 py-3 text-white bg-primary-600 rounded-full hover:bg-primary-700 transition font-semibold shadow">
                <i class="fas fa-calendar-plus mr-2"></i> Booking Sekarang
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
    {{-- Modal --}}
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
        <div @click.outside="show = false"
            class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 space-y-4 relative">

            <button @click="show = false" wire:click="closeModal"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>

            <h3 class="text-xl font-bold text-primary-700 mb-2">
                <i class="fas fa-edit mr-2 text-pink-500"></i> Form Booking
            </h3>

            <div class="space-y-4">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Nama</label>
                        <input type="text" wire:model.live="nama"
                            class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">No. HP</label>
                        <input type="text" wire:model.live="no_hp"
                            class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Tanggal</label>
                            <input type="date" wire:model.live="tanggal"
                                class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Jam</label>
                            <input type="time" wire:model.live="jam"
                                class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" />
                        </div>
                    </div>

                    <!-- Layanan Section -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Pilih Layanan</label>
                        <div class="flex gap-2">
                            <select wire:model.live="layanan_id"
                                class="flex-1 px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                                <option value="">-- Pilih --</option>
                                @foreach ($layanans as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                                @endforeach
                            </select>
                            <button wire:click="addLayanan"
                                class="px-3 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Tabel Layanan Terpilih -->
                    @if (count($layanan_terpilih))
                    <div class="mt-4">
                        <h4 class="text-sm font-medium mb-2">Layanan Dipilih:</h4>
                        <table class="w-full text-sm text-left border rounded">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2">Layanan</th>
                                    <th class="px-3 py-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($layanan_terpilih as $index => $item)
                                <tr>
                                    <td class="px-3 py-2">{{ $item['nama'] }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <button wire:click="removeLayanan({{ $index }})"
                                            class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <button
                        class="w-full px-4 py-2 mt-4 bg-primary-600 text-white rounded-md hover:bg-primary-700 font-semibold">
                        Kirim Booking
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>