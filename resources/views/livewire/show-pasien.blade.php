<div class="grid grid-cols-12 gap-6">
    <div class="p-6 bg-white col-span-8 rounded-lg bg-gradient-to-bl from-primary-50 to-primary-100 shadow">
        <h2 class="text-2xl font-bold text-primary-700 flex items-center gap-3">
            <a href="/pasien"
                class="bg-primary-600 text-sm text-white w-7  h-7 duration-200 flex items-center justify-center rounded-full hover:bg-primary-700 transition">
                <i class="fa-solid fa-angle-left"></i>
            </a>
            Detail Pasien
        </h2>
        <table class="text-sm my-6 w-full border rounded">
            <tbody class="divide-y">
                <tr>
                    <th class="w-40 px-4 py-2  text-gray-700">Nama</th>
                    <td class="px-4 py-2">{{ $pasien->nama }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2  text-gray-700">No HP</th>
                    <td class="px-4 py-2">{{ $pasien->nohp }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2  text-gray-700">Tanggal Lahir</th>
                    <td class="px-4 py-2">{{ $pasien->tlahir->translatedFormat('l, d M Y') }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2  text-gray-700">Alamat</th>
                    <td class="px-4 py-2">{{ $pasien->alamat }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="p-6 bg-white col-span-4 rounded-lg bg-gradient-to-bl from-primary-50 to-primary-100 shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Transaksi</h3>
        <div class="overflow-auto">
            <table class="min-w-full text-sm border rounded">
                <thead class="">
                    <tr>
                        <th class="px-3 py-2 text-left text-gray-700 font-semibold border-b">#</th>
                        <th class="px-3 py-2 text-left text-gray-700 font-semibold border-b">Tanggal</th>
                        <th class="px-3 py-2 text-left text-gray-700 font-semibold border-b">Status</th>
                        <th class="px-3 py-2 text-left text-gray-700 font-semibold border-b">Total</th>
                        <th class="px-3 py-2 text-right text-gray-700 font-semibold border-b"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasien->transaksis as $index => $trx)
                    <tr class="border-b hover:bg-primary-100 transition duration-200">
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $trx->waktu->translatedFormat('l, d M Y') }}</td>
                        <td class="px-3 py-2">
                            <span class="text-white text-xs px-3 py-1 rounded-full {{ $trx->status_warna }}">
                                {{ $trx->status_nama }}
                            </span>
                        </td>
                        <td class="px-3 py-2">
                            Rp{{ number_format($trx->listTransaksis->sum(fn($d) => $d->layanan->harga), 0, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 text-right">
                            <button type="button" data-modal-target="modalDetail{{ $trx->id }}"
                                data-modal-toggle="modalDetail{{ $trx->id }}"
                                class="text-white bg-info-700 hover:bg-info-800 font-medium rounded-md text-xs px-1 py-1">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Modal Detail Layanan --}}
                    <div id="modalDetail{{ $trx->id }}" tabindex="-1" aria-hidden="true"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow">
                                <div class="flex items-start justify-between p-4 border-b rounded-t">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Detail Layanan - {{ $trx->waktu->translatedFormat('l, d F Y H:i') }}
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:text-gray-900"
                                        data-modal-hide="modalDetail{{ $trx->id }}">
                                        <i class="fa-solid fa-xmark text-xl"></i>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <ul class="space-y-1 text-sm">
                                        @foreach ($trx->listTransaksis as $detail)
                                        <li class="flex justify-between">
                                            <span>{{ $detail->layanan->nama }}</span>
                                            <span>Rp{{ number_format($detail->layanan->harga, 0, ',', '.') }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>