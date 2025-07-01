<div>
    <div class="grid grid-cols-1 md:grid-cols-2 justify-between mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-4xl font-semibold text-primary-700">Daftar Pasien</div>
                <button wire:click="openModal('create')" type="button"
                    class="text-primary-100  hover:text-primary-50 bg-primary-700  hover:bg-primary-800 transition duration-200 font-medium rounded-lg text-sm px-3 py-2">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="flex items-center gap-6 justify-self-end mt-4 md:mt-0">
            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex text-primary-600 items-center ps-3.5 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" wire:model.live="search" autofocus
                    class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-2.5"
                    placeholder="Cari Pasien">
            </div>

            <!-- Dropdown jumlah per halaman -->
            <select wire:model.live="paginate"
                class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-30 md:w-12 p-2.5">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-primary-500">
            <thead class="text-xs text-primary-700 uppercase bg-primary-200">
                <tr>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center hidden md:table-cell">Alamat</th>
                    <th class="px-6 py-3 text-center hidden md:table-cell">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-center hidden md:table-cell">No HP</th>
                    <th class="px-6 py-3 text-center"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pasiens as $item)
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td class="px-6 py-4 text-center">{{ $item->nama }}</td>
                    <td class="px-6 py-4 text-center hidden md:table-cell">{{ $item->alamat }}</td>
                    <td class="px-6 py-4 text-center hidden md:table-cell">{{ $item->tlahir->translatedFormat('d F Y')}}
                    </td>
                    <td class="px-6 py-4 text-center hidden md:table-cell">{{ $item->nohp }}</td>
                    <td class="px-6 py-4 text-right flex justify-center gap-2">
                        <button wire:click="showPasien({{ $item->id }})"
                            class="text-white bg-info-700  hover:bg-info-800 font-medium rounded-md text-xs px-1 py-1">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button wire:click="openModal('edit', {{ $item->id }})"
                            class="text-white bg-warning-500  hover:bg-warning-600 font-medium rounded-md text-xs px-1 py-1">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button onclick="confirmDelete({{ $item->id }})"
                            class="text-white bg-danger-700  hover:bg-danger-800 font-medium rounded-md text-xs px-1 py-1">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td colspan="5" class="text-center py-4">
                        {{ $search ? "Pasien '{$search}' tidak ditemukan." : "Belum ada data pasien." }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">
            {{ $pasiens->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div id="pasienModal"
        class="fixed {{ $modalOpen ? '' : 'hidden' }} top-0 left-0 right-0 z-50 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-modal h-full backdrop-blur-md bg-black/50">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-gradient-to-bl from-primary-50 to-primary-100 rounded-lg shadow">
                <div
                    class="flex bg-gradient-to-br from-primary-200 to-primary-300 items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-primary-900">
                        @if($modalMode === 'create') Tambah Pasien
                        @elseif($modalMode === 'edit') Edit Pasien
                        @else Detail Pasien @endif
                    </h3>
                    <button wire:click="closeModal" type="button"
                        class="text-primary-700  hover:bg-primary-600  hover:text-primary-100 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-primary-700">Nama</label>
                        <input wire:model.live="nama" @if($modalMode=='view' ) disabled @endif type="text"
                            class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Masukkan nama pasien">
                        @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700">Alamat</label>
                        <textarea wire:model.live="alamat" @if($modalMode=='view' ) disabled @endif
                            class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Masukkan alamat"></textarea>
                        @error('alamat') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700">Tanggal Lahir</label>
                        <input wire:model.live="tlahir" @if($modalMode=='view' ) disabled @endif type="date"
                            class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">
                        @error('tlahir') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700">No HP</label>
                        <input wire:model.live="nohp" @if($modalMode=='view' ) disabled @endif type="text"
                            class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Masukkan nomor HP">
                        @error('nohp') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button wire:click="closeModal" type="button"
                        class="text-primary-700 bg-white border border-primary-300 font-medium rounded-lg text-sm px-4 py-2  hover:bg-primary-600  hover:text-white">Tutup</button>

                    @if($modalMode !== 'view')
                    <button wire:click="save" type="button"
                        class="text-white bg-primary-600  hover:bg-primary-700 font-medium rounded-lg text-sm px-4 py-2">Simpan</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @pushOnce('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id)
                }
            });
        }
    </script>
    @endPushOnce
</div>