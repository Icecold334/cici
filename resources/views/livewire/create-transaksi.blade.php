<div class="grid grid-cols-12 gap-6 ">
    <div class="p-6 bg-gradient-to-br from-primary-50 to-primary-100 col-span-12 xl:col-span-8 rounded-2xl shadow-lg ">
        <h2 class="text-2xl font-bold text-primary-700 flex items-center gap-3">
            <a href="/transaksi"
                class="bg-primary-600 text-sm text-white w-7  h-7 duration-200 flex items-center justify-center rounded-full hover:bg-primary-700 transition">
                <i class="fa-solid fa-angle-left"></i>
            </a>
            Tambah Transaksi
        </h2>


        <form wire:submit.prevent="simpan" class="space-y-6">
            {{-- Select atau Form Pasien --}}
            <div x-data="{ open: false, search: '' }" class="mb-4">
                <div class="flex items-center justify-between">
                    <label class="block text-sm text-gray-700">Pasien</label>
                    <button type="button" wire:click="toggleFormPasien"
                        class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 bg-primary-50 px-3 py-2 rounded-md hover:bg-primary-100 transition">

                        @if ($formTambahPasien)
                        <i class="fas fa-times text-primary-600"></i>
                        Batal Tambah Pasien Baru
                        @else
                        <i class="fas fa-user-plus text-primary-600"></i>
                        Tambah Pasien Baru
                        @endif
                    </button>
                </div>

                {{-- Jika formTambahPasien == false, tampilkan dropdown --}}
                @if (!$formTambahPasien)
                <div class="flex items-start gap-3 mt-1">
                    {{-- Dropdown Select Pasien --}}
                    <div class="relative w-full" x-data="{ open: false, search: '' }">
                        <div @click.outside="open = false" class="relative">
                            <button type="button"
                                class="w-full border border-gray-300 rounded-md p-2 flex justify-between items-center bg-white"
                                @click="open = !open" :class="{ 'bg-gray-100': open }">
                                <span>
                                    {{ $pasien_id ? App\Models\Pasien::find($pasien_id)?->nama ?? 'Pilih Pasien' :
                                    'Pilih
                                    Pasien' }}
                                </span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition
                                class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow">
                                <input type="text" x-model="search" placeholder="Cari nama..."
                                    class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none text-sm" />
                                <ul class="max-h-48 overflow-y-auto text-sm">
                                    @foreach ($pasiens as $pasien)
                                    <template
                                        x-if="{{ json_encode(Str::lower($pasien->nama)) }}.includes(search.toLowerCase())">
                                        <li class="px-3 py-2 hover:bg-primary-100 cursor-pointer"
                                            @click="$wire.set('pasien_id', {{ $pasien->id }}); open = false;">
                                            {{ $pasien->nama }} ({{ $pasien->nohp }})
                                        </li>
                                    </template>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Jika formTambahPasien == true, tampilkan form --}}
                @if ($formTambahPasien)
                <div class="mt-4 space-y-3 text-sm">
                    <div>
                        <label class="block text-sm text-gray-700">Nama</label>
                        <input type="text" wire:model.live="nama" class="w-full border-gray-300 rounded-md p-2 mt-1" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700">Alamat</label>
                        <input type="text" wire:model.live="alamat"
                            class="w-full border-gray-300 rounded-md p-2 mt-1" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700">Tanggal Lahir</label>
                        <input type="date" wire:model.live="tlahir"
                            class="w-full border-gray-300 rounded-md p-2 mt-1" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700">No. HP</label>
                        <input type="text" wire:model.live="nohp" class="w-full border-gray-300 rounded-md p-2 mt-1" />
                    </div>
                </div>
                @endif
            </div>

            {{-- Waktu --}}
            <div>
                <label class="block text-sm text-gray-700">Waktu Transaksi</label>
                <input type="datetime-local" wire:model="waktu" class="w-full border-gray-300 rounded" />
                @error('waktu') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tambah Layanan --}}
            <div>
                <label class="block text-sm text-gray-700">Tambah Layanan</label>
                <div class="flex gap-2 mt-1" x-data="{ openLayanan: false, searchLayanan: '' }">
                    <div class="relative w-full">
                        <div @click.outside="openLayanan = false" class="relative">
                            <button type="button"
                                class="w-full border border-gray-300 rounded-md p-2 flex justify-between items-center bg-white"
                                @click="openLayanan = !openLayanan" :class="{ 'bg-gray-100': openLayanan }">
                                <span>
                                    {{ $layanan_id ? App\Models\Layanan::find($layanan_id)?->nama ?? 'Pilih Layanan' :
                                    'Pilih Layanan'
                                    }}
                                </span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="openLayanan" x-transition
                                class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow">
                                <input type="text" x-model="searchLayanan" placeholder="Cari layanan..."
                                    class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none text-sm" />
                                <ul class="max-h-48 overflow-y-auto text-sm">
                                    @foreach ($layanans as $layanan)
                                    <template
                                        x-if="{{ json_encode(Str::lower($layanan->nama)) }}.includes(searchLayanan.toLowerCase())">
                                        <li class="px-3 py-2 hover:bg-primary-100 cursor-pointer"
                                            @click="$wire.set('layanan_id', {{ $layanan->id }}); openLayanan = false;">
                                            {{ $layanan->nama }} - Rp{{ number_format($layanan->harga, 0, ',', '.') }}
                                        </li>
                                    </template>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button type="button" wire:click="addLayanan" @disabled(!$layanan_id)
                        class="{{ !$layanan_id ? 'opacity-50 cursor-not-allowed':'hover:bg-primary-700' }} bg-primary-600 duration-200 text-white px-4 py-2 rounded  transition">
                        Tambah
                    </button>
                </div>
            </div>



            {{-- Submit --}}
            <div>
                <button type="submit" @disabled(!count($list) || !$pasien_id) class="{{ !count($list) || !$pasien_id ?'cursor-not-allowed opacity-50':'hover:bg-primary-700'}}  duration-200 w-full py-3 bg-primary-600 text-white font-semibold rounded-xl 
                    transition">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
    <div
        class="p-6 bg-gradient-to-br from-primary-50 to-primary-100 col-span-12 xl:col-span-4 rounded-2xl shadow-lg space-y-4">
        <h3 class="text-xl font-bold text-primary-700">Daftar Layanan</h3>

        <div class="relative overflow-x-auto  sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-700 border rounded-lg">
                <thead class="text-xs text-primary-50 uppercase bg-primary-600">
                    <tr>
                        <th scope="col" class="px-4 py-3">#</th>
                        <th scope="col" class="px-4 py-3">Layanan</th>
                        <th scope="col" class="px-4 py-3">Harga</th>
                        <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $index => $item)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $item['nama'] }}</td>
                        <td class="px-4 py-3">Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="removeLayanan({{ $index }})"
                                class="text-red-600 hover:text-red-700 hover:underline text-sm transition">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 px-4 py-6">Belum ada layanan dipilih.</td>
                    </tr>
                    @endforelse
                </tbody>

                @if (count($list) > 0)
                <tfoot class="bg-gray-50 font-semibold">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-right">Total</td>
                        <td colspan="2" class="px-4 py-3 text-left text-primary-700">
                            Rp{{ number_format(collect($list)->sum('harga'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>