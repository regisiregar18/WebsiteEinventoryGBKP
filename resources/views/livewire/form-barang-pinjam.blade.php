<div>
    <form @if ($in_detail) wire:submit.prevent='update' @else wire:submit.prevent='store' @endif
        enctype="multipart/form-data" class="bg-white py-5 sm:px-8 px-5 rounded-lg"> <!-- Tambahkan enctype di sini -->
        
        <div class="mb-5">
            <label for="nama_peminjam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                Peminjam</label>
            <input type="text" id="nama_peminjam" wire:model='nama_peminjam'
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="isi nama peminjam" required />
        </div>

        <div class="mb-5">
            <label for="no_wa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Whatsapp</label>
            <input type="text" id="no_wa" wire:model='no_wa'
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="isi nomer whatsapp" required />
        </div>

        <div class="mb-5 relative">
            <label for="barang_pinjaman" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barang
                yang Dipinjam</label>
            <input type="text" autocomplete="off" wire:focus='suggestToggle' wire:model.live='barang_pinjaman'
                id="barang_pinjaman"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="barang yang dipinjam" required />
            <ul
                class="@if (strlen($barang_pinjaman) < 3 || !$showSuggest) hidden @else absolute top-full h-56 overflow-y-scroll overflow-x-hidden w-full space-y-3 bg-white border-2 py-3 rounded-md shadow @endif">
                @if (count($data) < 1)
                    <li class="text-center font-semibold px-4 py-1">Pencarian Tidak Ada!</li>
                @endif
                @foreach ($data as $item)
                    <li class="hover:bg-slate-300 px-4 py-1 cursor-pointer" wire:click='select({{ $item->id }})'>
                        {{ $item->nama_barang }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Tanggal Mulai Peminjaman -->
        <div class="mb-5">
            <label for="tgl_peminjaman" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai Peminjaman</label>
            <input type="date" id="tgl_peminjaman" wire:model='tgl_peminjaman'
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>

        <!-- Tanggal Selesai Peminjaman -->
        <div class="mb-5">
            <label for="tgl_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai Peminjaman</label>
            <input type="date" id="tgl_selesai" wire:model='tgl_selesai'
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>

        <div class="mb-5">
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jaminan Peminjam</label>
    <div class="flex items-center mb-4">
        <input id="KTP" type="radio" value="KTP" wire:model="jaminan_peminjam"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="KTP" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">KTP</label>
    </div>
    <div class="flex items-center">
        <input id="SIM" type="radio" value="SIM" wire:model="jaminan_peminjam"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="SIM" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">SIM</label>
    </div>
</div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="bukti_peminjam">Upload Foto KTP/SIM</label>
            <input wire:model="bukti_peminjam" accept="image/png, image/jpeg"
                class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="bukti_peminjam" type="file">
            @error('bukti_peminjam') 
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
        class="flex items-center gap-1 text-white bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm w-full sm:w-auto px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h14m-7 7V5" />
            </svg>
            @if ($in_detail)
                Update Peminjam
            @else
                Tambah Peminjam
            @endif
        </button>
    </form>
</div>
