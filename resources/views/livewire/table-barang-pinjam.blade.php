<div class="bg-white p-5 rounded-lg mt-8">
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="font-semibold text-xl">Data Peminjaman Barang</h1>
            <p class="mb-5 font-medium text-sm">Kelola Data</p>
        </div>
        <div>
            <a href="/printBarangPinjam" target="_blank"
                class="flex items-center gap-2 px-2 py-1 bg-white md:border-4 border-2 border-[#FFA500] rounded-lg shadow-sm text-[#000000] md:text-base text-xs md:text-start text-center font-semibold">
                <svg class="md:w-6 w-5 text-[#000000]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z"
                        clip-rule="evenodd" />
                    <path d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z" />
                </svg>
                Cetak Laporan Peminjaman
            </a>
        </div>
    </div>

    <div class="flex justify-end w-full mb-5">
        <label for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative md:w-1/2 xl:w-1/4 w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" wire:model.live='cariPeminjaman' id="default-search"
                class="block w-full px-4 py-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Cari peminjam atau nama barang" />
        </div>
    </div>
    <div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Barang yang Dipinjam</th>
                <th scope="col" class="px-6 py-3">Nama Peminjam</th>
                <th scope="col" class="px-6 py-3">No Whatsapp</th>
                <th scope="col" class="px-6 py-3">Jaminan</th>
                <th scope="col" class="px-6 py-3">Bukti Peminjam</th>
                <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                <th scope="col" class="px-6 py-3">Tanggal Selesai</th>
                <th scope="col" class="px-6 py-3">Jumlah</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
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
                <tr wire:key='{{ $item->id }}' class="bg-white text-black border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $no++ }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->kode_barang }} - {{ $item->nama_barang }}
                    </td>
                    <td class="px-6 py-4">
                        {{ Str::limit($item->nama_peminjam, 20) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->no_wa }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->jaminan_peminjam }}
                    </td>
                    <td class="px-6 py-4">
                    <img src="{{ asset('storage/bukti/gambar/' . $item->bukti_peminjam) }}" alt="Bukti Peminjam" />
                    </td>
                    <td class="px-6 py-4">
                        @if ($item->tgl_peminjaman)
                            @php
                                $datePeminjaman = date_create($item->tgl_peminjaman);
                            @endphp
                            {{ date_format($datePeminjaman, 'd M Y') }}
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if ($item->tgl_selesai)
                            @php
                                $dateSelesai = date_create($item->tgl_selesai);
                            @endphp
                            {{ date_format($dateSelesai, 'd M Y') }}
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->jumlah_pinjam }}
                    </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 items-center">
                                <button wire:click='select({{ $item->id }})' data-modal-target="kembalikan-modal"
                                    data-modal-toggle="kembalikan-modal"
                                    class="flex items-center gap-1 bg-green-400 px-3 py-2 text-white rounded-md font-medium">
                                    <svg class="w-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                    </svg>
                                    Kembalikan
                                </button>
                                <a href="edit-barang-pinjam/{{ $item->id }}"
                                    class="flex items-center gap-1 bg-white border-2 border-blue-500 px-3 py-2 text-blue-500 rounded-md font-medium">
                                    <svg class="w-5 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2l14-14 2 2-14 14H3Zm5-11L15 3l2 2-7 7" />
                                    </svg>
                                    Ubah
                                </a>
                                <button wire:click='select({{ $item->id }})' data-modal-target="hapus-modal"
                                    data-modal-toggle="hapus-modal"
                                    class="flex items-center gap-1 bg-white border-2 border-red-500 px-3 py-2 text-red-500 rounded-md font-medium">
                                    <svg class="w-5 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $data->links() }}
    </div>
    <div wire:ignore.self id="kembalikan-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="kembalikan-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin kembalikan barang
                        ini?</h3>
                    <button wire:click='confirmKembalikan' data-modal-hide="kembalikan-modal" type="button"
                        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Ya, saya yakin
                    </button>
                    <button data-modal-hide="kembalikan-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tidak,
                        kembali</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="hapus-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="hapus-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin hapus data
                        ini?</h3>
                    <button wire:click='confirmHapus' data-modal-hide="hapus-modal" type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Ya, saya yakin
                    </button>
                    <button data-modal-hide="hapus-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tidak,
                        kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>
