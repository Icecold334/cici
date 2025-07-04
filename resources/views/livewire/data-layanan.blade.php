<div>
    <div class="grid grid-cols-1 md:grid-cols-2  justify-between mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-4xl font-semibold text-primary-700">Daftar Layanan</div>

                <button wire:click="openModal('create')" type="button"
                    class="text-primary-100 hover:text-primary-50 bg-primary-700 hover:bg-primary-800 transition duration-200 font-medium rounded-lg text-sm px-3 py-2">
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
                <input type="text" id="input-group-1" wire:model.live="search" autofocus
                    class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-2.5 dark:bg-primary-700 dark:border-primary-600 dark:placeholder-primary-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Cari Layanan">
            </div>


            <!-- Dropdown jumlah per halaman -->
            <select wire:model.live="paginate"
                class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-30 md:w-12 p-2.5 dark:bg-primary-700 dark:border-primary-600 dark:placeholder-primary-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>

        </div>
    </div>

    {{-- table --}}
    <div class="relative overflow-x-auto  sm:rounded-lg">
        <table class="w-full text-sm text-left  text-primary-500 dark:text-primary-400">
            <thead class="text-xs text-primary-700 uppercase bg-primary-200 dark:bg-primary-700 dark:text-primary-400">
                <tr>
                    <th scope="col" class="text-center px-6 py-3">
                        Nama Layanan
                    </th>
                    {{-- <th scope="col" class="text-center px-6 py-3 w-1/3">
                        Deskripsi
                    </th> --}}
                    <th scope="col" class="text-center px-6 py-3 hidden md:table-cell">
                        Harga
                    </th>
                    <th scope="col" class="text-center px-6 py-3 w-1/6">

                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($layanans as $item)
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                        {{ $item->nama }}
                    </th>
                    {{-- <td class="px-6 py-4">
                        {{ $item->deskripsi }}
                    </td> --}}
                    <td class="px-6 py-4 text-right font-semibold hidden md:table-cell">
                        {{ $item->rupiah }}
                    </td>
                    <td class="px-6 py-4 text-center flex gap-2 justify-center">
                        <button wire:click="openModal('view', {{ $item->id }})"
                            class="text-white bg-primary-700 hover:bg-primary-800 font-medium rounded-md text-xs px-1 py-1">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <button wire:click="openModal('edit', {{ $item->id }})"
                            class="text-white bg-warning-700 hover:bg-warning-800 font-medium rounded-md text-xs px-1 py-1">
                            <i class="fa-solid fa-pencil"></i>
                        </button>

                        <button type="button" onclick="confirmDelete({{ $item->id }})"
                            class="text-white bg-danger-700 hover:bg-danger-800 font-medium rounded-md text-xs px-1 py-1">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td colspan="5" class="text-center py-4">
                        {{ $search ? "Layanan '{$search}' tidak terdaftar":"Tidak ada Layanan" }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">
            {{ $layanans->links() }}
        </div>
    </div>


    <!-- Modal -->
    <div id="layananModal" tabindex="-1" aria-hidden="true"
        class="fixed {{ $modalOpen ? : 'hidden' }} top-0 left-0 right-0 z-50 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-modal h-full backdrop-blur-md bg-black/50">
        {{-- style="{{ $modalOpen ? '' : 'display: none;' }}"> --}}
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-gradient-to-bl from-primary-50 to-primary-100 rounded-lg shadow">
                <div
                    class="flex bg-gradient-to-br from-primary-200 to-primary-300 items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-primary-900 dark:text-white">
                        @if($modalMode === 'create') Tambah Layanan
                        @elseif($modalMode === 'edit') Edit Layanan
                        @else Detail Layanan @endif
                    </h3>
                    <button type="button" wire:click="closeModal"
                        class="text-primary-700 transition duration-200 bg-transparent hover:bg-primary-600 hover:text-primary-100 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-primary-700 dark:text-primary-300">Nama
                            Layanan</label>
                        <input type="text" wire:model.live="nama" @if($modalMode=='view' ) disabled @endif
                            placeholder="Masukkan nama layanan"
                            class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">
                        @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-primary-700 dark:text-primary-300">Deskripsi</label>
                        <textarea wire:model.live="deskripsi" @if($modalMode=='view' ) disabled @endif
                            placeholder="Masukkan deskripsi layanan"
                            class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"></textarea>
                        @error('deskripsi') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 dark:text-primary-300">Harga</label>
                        <input type="number" wire:model.live="harga" @if($modalMode=='view' ) disabled @endif
                            placeholder="Masukkan harga layanan"
                            class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">
                        @error('harga') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button wire:click="closeModal" type="button"
                        class="text-primary-700 transition duration-200 bg-white border border-primary-300 font-medium rounded-lg text-sm px-4 py-2 hover:bg-primary-600 hover:text-primary-200">Tutup</button>

                    @if($modalMode !== 'view')
                    <button wire:click="save" type="button"
                        class="text-white bg-primary-600 hover:bg-primary-700 transition duration-200 font-medium rounded-lg text-sm px-4 py-2">Simpan</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @pushOnce('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin hapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Livewire.dispatch('deleteConfirmed', { id: id });
                    @this.call('delete',id)
                }
            });
        }


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
    @endPushOnce
</div>