<div>
    <div class="grid gap-4 mb-6">
        <div class="grid grid-cols-12 gap-4 items-start">
            <!-- Judul + Tambah -->
            <div class="col-span-12 md:col-span-4 flex items-center gap-4">
                <div class="text-4xl font-semibold text-primary-700">Daftar Transaksi</div>
                <button wire:click="addTransaksi"
                    class="text-primary-100 hover:text-primary-50 bg-primary-700 hover:bg-primary-800 transition duration-200 font-medium rounded-lg text-sm px-3 py-2">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>

            <!-- Filter Group -->
            <div class="col-span-12 md:col-span-8 flex flex-col md:flex-row md:justify-end gap-4">
                <!-- Search -->
                <div class="w-full md:w-1/3">
                    <input type="text" wire:model.live="search"
                        class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                        placeholder="Cari nama">
                </div>

                <!-- Status / Tanggal / Paginate Group -->
                <div class="flex justify-center md:justify-start gap-4 w-full md:w-auto">
                    <!-- Status -->
                    <div class="w-full md:w-1/2">
                        <select wire:model.live="filterStatus"
                            class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Semua Status</option>
                            <option value="0">Reservasi</option>
                            <option value="1">Dikonfirmasi</option>
                            <option value="2">Diproses</option>
                            <option value="3">Selesai</option>
                            <option value="4">Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="w-1/3">
                        <input type="date" wire:model.live="filterTanggal"
                            class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    </div>

                    <!-- Paginate -->
                    <div class="w-18 flex items-center gap-2">
                        <select wire:model.live="paginate"
                            class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>

                    </div>
                    <div class="w-18 flex items-center gap-2">

                        <!-- Tombol Export -->
                        <button wire:click="exportExcel"
                            class="text-success-100 hover:text-success-50 bg-success-700 hover:bg-success-800 transition duration-200 font-medium rounded-lg text-sm px-3 py-2"
                            title="Export ke Excel">
                            <i class="fa-solid fa-file-excel text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-primary-500">
            <thead class="text-xs text-primary-700 uppercase bg-primary-200">
                <tr>
                    {{-- <th class="px-4 py-3 text-center">Kode</th> --}}
                    <th class="px-4 py-3 text-center">Nama</th>
                    <th class="px-4 py-3 text-center hidden md:table-cell">Waktu</th>
                    {{-- <th class="px-4 py-3 text-center hidden md:table-cell">No HP</th> --}}
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $item)
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    {{-- <td class="px-4 py-3 text-center font-bold text-primary-800">{{ $item->kode_transaksi }}</td>
                    --}}
                    <td class="px-4 py-3 text-center">{{ $item->pasien->nama ?? $item->nama }}</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">
                        {{ $item->waktu->translatedFormat('d F Y H:i') }}
                    </td>
                    {{-- <td class="px-4 py-3 text-center hidden md:table-cell">{{ $item->nohp }}</td> --}}
                    <td class="px-4 py-3 text-center">
                        <span
                            class=" {{ $item->status_warna }} text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">
                            {{ $item->status_nama }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <button wire:click="showTransaksi({{ $item->id }})"
                            class="text-white bg-info-700 hover:bg-info-800 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        {{-- Tombol Aksi Status --}}
                        @if (in_array($item->status, [1, 2]) && $item->pasien_id)
                        <button
                            class="text-white bg-warning-500 hover:bg-warning-600 font-medium rounded-md text-xs px-2 py-1"
                            x-data @click="
                                    Swal.fire({
                                        title: '{{ $item->status === 2 ? 'Selesaikan Transaksi?' : 'Lanjutkan atau Batalkan?' }}',
                                        text: '{{ $item->status === 2 ? 'Status akan diselesaikan.' : 'Anda bisa memilih untuk melanjutkan atau membatalkan transaksi ini.' }}',
                                        icon: '{{ $item->status === 2 ? 'info' : 'question' }}',
                                        showCancelButton: true,
                                        showDenyButton: {{ $item->status < 2 ? 'true' : 'false' }},
                                        confirmButtonText: '{{ $item->status === 2 ? 'Selesaikan' : 'Lanjutkan' }}',
                                        denyButtonText: 'Batalkan',
                                        confirmButtonColor: '{{ $item->status === 2 ? '#16a34a' : '#2563eb' }}',
                                        denyButtonColor: '#dc2626',
                                        {{-- cancelButtonColor: '#d1d5db', --}}
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.lanjutStatus({{ $item->id }});
                                        } else if (result.isDenied) {
                                            $wire.batalkanTransaksi({{ $item->id }});
                                        }
                                    })
                                " type="button" title="Kelola Status"
                            class="text-gray-600 hover:text-gray-800 transition">
                            <i class="fa-solid fa-gear"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Tidak ada data transaksi ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $transaksis->links() }}
        </div>
    </div>


    @push('scripts')
    <script>
        window.addEventListener('toast', event => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: event.detail.icon || 'info',
                    title: event.detail.title || '',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            });
    </script>
    @endpush


</div>