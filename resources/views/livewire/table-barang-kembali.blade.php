<div class="bg-white p-5 rounded-lg">
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="font-semibold text-xl">Data Pengembalian Barang</h1>
            <p class="font-medium text-sm">Kelola Data Barang</p>
        </div>
        <div>
            <a href="/printBarangKembali" target="_blank" class="flex items-center gap-2 px-2 py-1 bg-white md:border-4 border-2 border-[#FFA500] rounded-lg shadow-sm text-[#000000] md:text-base text-xs md:text-start text-center font-semibold">
                <svg class="md:w-6 w-5 text-[#000000]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                    <path d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z"/>
                </svg>
                Cetak Laporan Pengembalian
            </a>
        </div>
    </div>
    <div class="flex justify-end w-full mb-5">   
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative md:w-1/2 xl:w-1/4 w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" wire:model.live='cariPeminjaman' id="default-search" class="block w-full px-4 py-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari nama barang" />
        </div>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kode Barang
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Barang
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Sub Kategori
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Pengembalian
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @if ($data->count() < 1)
                <tr class="bg-white text-black border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="9" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Data Tidak Ada!
                    </td>
                </tr>
            @endif
                @foreach ($data as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $no++ }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->kode_barang }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->nama_barang }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->kategori_barang }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $date = date_create($item->tgl_kembali)
                            @endphp
                            {{ date_format($date,"d M Y") }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $data->links() }}
    </div>
</div>
