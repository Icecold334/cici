<div>
    {{-- Header --}}


    <div class="max-w-7xl mx-auto grid grid-cols-12 gap-6 p-20 ">
        <div class="md:col-span-7 col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 md:col-span-7">
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" wire:model.live="nama" placeholder="Masukkan nama lengkap"
                        class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" />
                </div>
                <div class="col-span-12 md:col-span-5">
                    <label class="block text-sm font-medium">No. HP</label>
                    <input type="text" wire:model.live="no_hp" placeholder="Masukkan nomor HP"
                        class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" />
                </div>
                <div class="col-span-12 md:col-span-4 ">
                    <label class="block text-sm font-medium">Tanggal Lahir</label>
                    <input type="date" wire:model.live="tlahir"
                        class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" />
                </div>
                <div class="col-span-12 md:col-span-8 ">
                    <label class="block text-sm font-medium">Waktu Reservasi</label>
                    <input type="datetime-local" wire:model.live="tanggal"
                        class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" />
                </div>
                <div class="col-span-12 ">
                    <label class="block text-sm font-medium">Alamat</label>
                    <textarea wire:model.live="alamat"
                        class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Masukkan alamat"></textarea>
                </div>

                <!-- Layanan Section -->
                <div class="col-span-12">
                    <label class="block text-sm font-medium ">Pilih Layanan</label>
                    <div class="flex gap-2">
                        <select wire:model.live="layanan_id" class="flex-1 px-4 py-2 border 
                                w-full  rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500
                                ">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach ($layanans as $layanan)
                            <option value="{{ $layanan->id }}" @disabled(in_array($layanan->id,
                                array_column($layanan_terpilih, 'id')))>
                                {{ $layanan->nama }}
                            </option>
                            @endforeach
                        </select>
                        <button wire:click="addLayanan" @disabled(!$layanan_id)
                            class="{{ !$layanan_id ? 'opacity-50 cursor-not-allowed':'hover:bg-primary-700' }} bg-primary-600 duration-200 text-white px-4 py-2 rounded  transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>



            </div>
        </div>
        <div class="md:col-span-5 col-span-12 max-h-[22rem] overflow-y-auto">
            <!-- Tabel Layanan Terpilih -->
            <div class="mt-4">
                <table class="w-full text-sm text-left border rounded ">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2">Layanan</th>
                            <th class="px-3 py-2 text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($layanan_terpilih as $index => $item)
                        <tr>
                            <td class="px-3 py-2">{{ $item['nama'] }}</td>
                            <td class="px-3 py-2 text-right">
                                <button wire:click="removeLayanan({{ $index }})"
                                    class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-3 py-2 text-center" colspan="3">Tidak ada layanan dipilih</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-span-12">
            <button @disabled($disableSimpan) wire:click="simpan"
                class="{{ $disableSimpan ? 'opacity-50 cursor-not-allowed':'hover:bg-primary-700' }} bg-primary-600 duration-200 text-white px-4 py-2 rounded  transition w-full">
                Kirim Booking
            </button>
        </div>
    </div>

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