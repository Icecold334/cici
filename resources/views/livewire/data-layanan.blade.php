<div>
    <div class="grid grid-cols-1 md:grid-cols-2  justify-between mb-6">
        <div>
            <div class="text-4xl font-semibold text-primary-700">Daftar Layanan</div>
        </div>
        <div class="flex items-center gap-6 justify-self-end mt-4 md:mt-0">

            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex text-primary-600 items-center ps-3.5 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" id="input-group-1" wire:model.live="search"
                    class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-primary-700 dark:border-primary-600 dark:placeholder-primary-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari Layanan">
            </div>

            <!-- Dropdown jumlah per halaman -->
            <select id="countries"
                class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-30 md:w-12 p-2.5 dark:bg-primary-700 dark:border-primary-600 dark:placeholder-primary-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
            {{-- <select wire:model.live="paginate"
                class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-primary-700 dark:border-primary-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

            </select> --}}
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
                        <button type="button"
                            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4  font-medium rounded-md text-xs px-1 py-1  "><i
                                class="fa-solid fa-eye"></i></button>
                        <button type="button"
                            class="text-white bg-warning-700 hover:bg-warning-800 focus:ring-4  font-medium rounded-md text-xs px-1 py-1  "><i
                                class="fa-solid fa-eye"></i></button>
                    </td>
                </tr>
                @empty
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <th scope="row" colspan="4" class="px-6 py-4 text-xl font-medium  whitespace-nowrap text-center">
                        {{ $search ? "Layanan '{$search}' tidak terdaftar":"Tidak ada Layanan" }}
                    </th>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">
            {{ $layanans->links() }}
        </div>
    </div>
</div>