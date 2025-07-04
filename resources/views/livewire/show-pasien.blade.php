<div class="grid grid-cols-12 gap-6">
    <div class="p-6 bg-white col-span-12  rounded-lg bg-gradient-to-bl from-primary-50 to-primary-100 shadow">
        <h2 class="text-2xl font-semibold text-primary-700 flex items-center gap-3">
            <a href="/pasien"
                class="bg-primary-600 text-sm text-white w-7  h-7 duration-200 flex items-center justify-center rounded-full hover:bg-primary-700 transition">
                <i class="fa-solid fa-angle-left"></i>
            </a>
            Detail Pasien
        </h2>
        <table class="text-sm my-6 w-full border rounded">
            <tbody class="divide-y font-normal">
                <tr>
                    <th class="text-left  px-4 py-2  text-primary-700 ">Nama</th>
                    <td class="px-4 py-2 ">{{ $pasien->nama }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2  text-primary-700 ">No HP</th>
                    <td class="px-4 py-2 ">{{ $pasien->nohp }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2  text-primary-700 ">Tanggal Lahir</th>
                    <td class="px-4 py-2 ">{{ $pasien->tlahir->translatedFormat('l, d M Y') }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2  text-primary-700 ">Alamat</th>
                    <td class="px-4 py-2 ">{{ $pasien->alamat }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="p-6 bg-white col-span-12  rounded-lg bg-gradient-to-bl from-primary-50 to-primary-100 shadow">
        <h3 class="text-2xl font-semibold text-primary-700 flex items-center mb-4">Riwayat Transaksi</h3>
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6 md:col-span-4">
                <input type="date" id="filterTanggal" wire:model.live="filterTanggal"
                    class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
            </div>

            <div class="col-span-6 md:col-span-4">
                <select id="filterStatus" wire:model.live="filterStatus"
                    class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    <option value="">Semua Status</option>
                    <option value="0">Reservasi</option>
                    <option value="1">Dikonfirmasi</option>
                    <option value="2">Diproses</option>
                    <option value="3">Selesai</option>
                    <option value="4">Dibatalkan</option>
                </select>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="min-w-full text-sm border rounded">
                <thead class="">
                    <tr>
                        <th class="px-3 py-2 text-center text-gray-700 font-semibold border-b w-1/12">#</th>
                        <th class="px-3 py-2 text-center text-gray-700 font-semibold border-b">Tanggal</th>
                        <th class="px-3 py-2 text-center text-gray-700 font-semibold border-b">Status</th>
                        <th class="px-3 py-2 text-center text-gray-700 font-semibold border-b">Total</th>
                        <th class="px-3 py-2 text-right text-gray-700 font-semibold border-b"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasien->transaksis as $index => $trx)
                    <tr class="border-b hover:bg-primary-100 transition duration-200">
                        <td class="px-3 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $trx->waktu->translatedFormat('l, d F Y') }}</td>
                        <td class="px-3 py-2 text-center">
                            <span
                                class=" {{ $trx->status_warna }} text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">
                                {{ $trx->status_nama }}
                            </span>
                        </td>
                        <td class="px-3 py-2">
                            Rp{{ number_format($trx->listTransaksis->sum(fn($d) => $d->harga), 0, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 text-right">
                            <button wire:click="showModal({{ $trx->id }})"
                                class="text-white bg-info-700 hover:bg-info-800 font-medium rounded-md text-xs px-1 py-1">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>


                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($showingModalId)
    @php
    $selectedTrx = $pasien->transaksis->firstWhere('id', $showingModalId);
    @endphp

    <div class="fixed inset-0 z-50 bg-black/50 backdrop-blur-md flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class=" font-semibold text-gray-900">
                    Detail Transaksi - {{ $selectedTrx->waktu->translatedFormat('l, d F Y H:i') }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-900">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-4">
                <ul class="space-y-1 text-sm">
                    @foreach ($selectedTrx->listTransaksis as $detail)
                    <li class="flex justify-between">
                        <span>{{ $detail->nama }}</span>
                        <span>Rp{{ number_format($detail->harga, 0, ',', '.') }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>