<div class="grid grid-cols-12 gap-6">
    <div class="p-6 bg-gradient-to-bl from-primary-50 to-primary-100 col-span-12 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-primary-700 flex items-center mb-4 gap-3">
            <a href="/transaksi"
                class="bg-primary-600 text-sm text-white w-7  h-7 duration-200 flex items-center justify-center rounded-full hover:bg-primary-700 transition">
                <i class="fa-solid fa-angle-left"></i>
            </a>
            Detail Transaksi
        </h2>

        {{-- Info Pasien + Status --}}
        <div class="mt-4 text-sm overflow-x-auto">
            <table class="w-full text-left text-sm border rounded-lg">
                <tbody class="divide-y">
                    <tr>
                        <th class="text-left px-4 py-2  text-primary-700   w-60">Nama</th>
                        <td class="px-4 py-2 ">{{ $transaksi->pasien->nama ?? $transaksi->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-left px-4 py-2  text-primary-700  ">No. HP</th>
                        <td class="px-4 py-2 ">{{ $transaksi->pasien->nohp ?? $transaksi->nohp }}</td>
                    </tr>
                    <tr>
                        <th class="text-left px-4 py-2  text-primary-700  ">Alamat</th>
                        <td class="px-4 py-2 ">{{ $transaksi->pasien->alamat ?? $transaksi->alamat }}</td>
                    </tr>
                    <tr>
                        <th class="text-left px-4 py-2  text-primary-700  ">Waktu Transaksi</th>
                        <td class="px-4 py-2 ">{{ $transaksi->waktu->translatedFormat('l, d F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th class="text-left px-4 py-2  text-primary-700  ">Status</th>
                        <td class="px-4 py-2 ">
                            <span
                                class=" {{ $transaksi->status_warna }} text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">
                                {{ $transaksi->status_nama }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @php
        $status = $transaksi->status;
        @endphp

        @if (in_array($status, [0, 1, 2]))
        <div class="mt-6 flex gap-3">
            @if ($status === 0)
            {{-- Tombol Konfirmasi --}}
            <button x-data @click="
                Swal.fire({
                    title: 'Konfirmasi Booking?',
                    text: 'Apakah ini pasien baru atau lama?',
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Pasien Baru',
                    denyButtonText: 'Pasien Lama',
                    confirmButtonColor: '#2563eb',
                    denyButtonColor: '#22c55e',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.konfirmasiBooking('baru');
                    } else if (result.isDenied) {
                        $wire.bukaPemilihanPasien();
                    }
                })" type="button"
                class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-check me-2"></i>Konfirmasi
            </button>

            {{-- Tombol Batalkan --}}
            <button x-data @click="Swal.fire({
                title: 'Batalkan Transaksi?',
                text: 'Transaksi ini akan dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.batalkanTransaksi({{ $transaksi->id }});
                }
            })" type="button"
                class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                <i class="fa-solid fa-xmark me-2"></i>Batalkan
            </button>
            @elseif ($status === 1)
            {{-- Tombol Lanjut --}}
            <button x-data @click="Swal.fire({
                title: 'Lanjutkan Proses?',
                text: 'Status akan dilanjutkan ke tahap berikutnya.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Ya, Lanjutkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.lanjutStatus({{ $transaksi->id }});
                }
            })" type="button"
                class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-forward me-2"></i>Lanjutkan
            </button>

            {{-- Tombol Batalkan --}}
            <button x-data @click="Swal.fire({
                title: 'Batalkan Transaksi?',
                text: 'Transaksi ini akan dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.batalkanTransaksi({{ $transaksi->id }});
                }
            })" type="button"
                class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                <i class="fa-solid fa-xmark me-2"></i>Batalkan
            </button>
            @elseif ($status === 2)
            {{-- Tombol Selesaikan --}}
            <button x-data @click="Swal.fire({
                title: 'Selesaikan Transaksi?',
                text: 'Pastikan layanan telah diberikan.',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                confirmButtonText: 'Ya, Selesaikan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.selesaikanTransaksi({{ $transaksi->id }});
                }
            })" type="button"
                class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                <i class="fa-solid fa-check me-2"></i>Selesaikan
            </button>
            @endif
        </div>
        @endif
    </div>

    {{-- Tabel Layanan --}}
    <div class="p-6 bg-gradient-to-bl from-primary-50 to-primary-100 col-span-12 rounded-2xl shadow">
        <h3 class="text-2xl font-semibold text-primary-700 flex items-center mb-4">Daftar Layanan</h3>
        <div class="overflow-auto">
            <table class="min-w-full text-sm border rounded">
                <thead class="">
                    <tr>
                        <th class="px-3 py-2 text-left text-gray-700 font-semibold border-b">#</th>
                        <th class="px-3 py-2 text-left text-gray-700 font-semibold border-b">Nama Layanan</th>
                        <th class="px-3 py-2 text-left text-gray-700 font-semibold border-b">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->listTransaksis as $index => $detail)
                    <tr class="border-b hover:bg-primary-100 transition duration-200">
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $detail->layanan->nama }}</td>
                        <td class="px-3 py-2">Rp{{ number_format($detail->layanan->harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class=" font-semibold">
                        <td colspan="2" class="px-3 py-2">Total</td>
                        <td class="px-3 py-2 text-primary-700">
                            Rp{{ number_format($transaksi->listTransaksis->sum(fn($d) => $d->layanan->harga), 0, ',',
                            '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @if ($showPasienPicker)
    <div x-data class="fixed inset-0 z-50 backdrop-blur-md bg-black/50 flex items-center justify-center">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Pilih Pasien Lama</h2>

            {{-- Input pencarian --}}
            <div class="mb-3">
                <input wire:model.live="searchPasien" type="text" placeholder="Cari nama, no HP, atau alamat..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-primary-500 text-sm">
            </div>

            {{-- Tabel hasil --}}
            <div class="max-h-80 overflow-y-auto border rounded">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">No. HP</th>
                            <th class="px-4 py-2">Alamat</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filteredPasien as $pasien)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-2">{{ $pasien->nama }}</td>
                            <td class="px-4 py-2">{{ $pasien->nohp }}</td>
                            <td class="px-4 py-2">{{ $pasien->alamat }}</td>
                            <td class="px-4 py-2">
                                <button wire:click="setSelectedPasien({{ $pasien->id }})"
                                    class="text-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">Pasien tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                <button wire:click="$set('showPasienPicker', false)"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Batal
                </button>
            </div>
        </div>
    </div>
    @endif
    @if ($showKonfirmasiPasienLama)
    <div x-data class="fixed inset-0 z-50 backdrop-blur-md bg-black/50 flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6">
            <h2 class=" font-semibold text-gray-800 mb-4">Konfirmasi Pasien Lama</h2>
            <p class="text-sm text-gray-600 mb-6">Yakin ingin menghubungkan transaksi ini ke pasien terpilih?</p>

            <div class="flex justify-end gap-3">
                <button wire:click="$set('showKonfirmasiPasienLama', false)"
                    class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    Batal
                </button>
                <button wire:click="konfirmasiPasienLamaFinal"
                    class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Ya, Konfirmasi
                </button>
            </div>
        </div>
    </div>
    @endif

</div>