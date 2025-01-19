<div class="bg-white px-5 py-10 rounded shadow-lg">
    <div class="flex mb-5 justify-end">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative lg:w-2/5 w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" wire:model.live='cariBarang' id="default-search"
                class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Cari nama barang atau kode barang" />
        </div>
    </div>
    
    <div>
    <div class="flex justify-end mb-5">
    <a href="/printDataBarang" target="_blank" class="flex items-center gap-2 px-2 py-1 bg-white border-2 border-[#FFA500] rounded-lg shadow-sm text-[#000000] text-xs font-semibold">
        <svg class="w-5 text-[#000000]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
            <path d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z"/>
        </svg>
        Cetak Laporan Data Barang
    </a>
</div>

<div>
    <!-- Form Filter -->
    <div class="flex mb-5 justify-end space-x-4">
        <select wire:model="bulan" class="border border-gray-300 rounded-lg p-2 bg-white text-gray-700">
            <option value="">Pilih Bulan</option>
            @foreach (range(1, 12) as $bln)
                <option value="{{ $bln }}">{{ date('F', mktime(0, 0, 0, $bln, 1)) }}</option>
            @endforeach
        </select>

        <select wire:model="tahun" class="border border-gray-300 rounded-lg p-2 bg-white text-gray-700">
            <option value="">Pilih Tahun</option>
            @foreach (range(date('Y'), date('Y') - 10) as $thn)
                <option value="{{ $thn }}">{{ $thn }}</option>
            @endforeach
        </select>

        <!-- Tombol Filter -->
        <button wire:click="filter" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
            Filter
        </button>
    </div>

<div class="relative overflow-x-auto">
    <h1 class="text-xl font-bold">Data Barang</h1>
    <p class="font-semibold mb-5">Kelola Data Barang</p>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">NO</th>
                <th scope="col" class="px-6 py-3">Kode Barang</th>
                <th scope="col" class="px-6 py-3">
                    <a href="?sort=nama_barang&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}">
                        Nama Barang
                        @if (request('sort') == 'nama_barang')
                            @if (request('direction') == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </a>
                </th>
                <th scope="col" class="px-6 py-3">Gambar</th>
                <th scope="col" class="px-6 py-3">Kategori</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Kondisi</th>
                <th scope="col" class="px-6 py-3">Jumlah</th>
                <th scope="col" class="px-6 py-3">Tanggal Input</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @if ($data->count() < 1)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" colspan="10" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Data tidak ada!
                    </th>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $no++ }}</th>
                        <td class="px-6 py-4">{{ $item->kode_barang }}</td>
                        <td class="px-6 py-4">{{ $item->nama_barang }}</td>
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/barang/gambar/' . $item->gambar) }}" class="w-24 h-auto" alt="">
                        </td>
                        <td class="px-6 py-4">{{ $item->kategori_barang }}</td>
                        <td class="px-6 py-4">
                            @if ($item->status_barang == 0)
                                <span class="text-red-500 font-semibold">Tidak Bisa Dipinjam</span>
                            @else
                                <span class="text-green-600 font-semibold">Bisa Dipinjam</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->kondisi_barang == 1)
                                <span class="text-green-600 font-semibold">Bisa Dipakai</span>
                            @else
                                <span class="text-red-500 font-semibold">Rusak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $item->jumlah_barang }}</td>
                        <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-2 py-2">
                            <div class="flex flex-col justify-center items-center gap-2">
                                <button wire:click='select({{ $item->id }})' data-modal-target="edit-barang" data-modal-toggle="edit-barang" class="flex justify-center items-center gap-1 bg-white border-2 border-blue-500 rounded-md py-1 px-5 text-blue-500">
                                <svg class="w-5 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2l14-14 2 2-14 14H3Zm5-11L15 3l2 2-7 7" />
                                </svg>
                                    Ubah
                                </button>
                                <button wire:click='select({{ $item->id }})' data-modal-target="hapus-barang" data-modal-toggle="hapus-barang" class="flex justify-center items-center gap-1 bg-white border-2 border-red-500 rounded-md py-1 px-5 text-red-500">
                                    <svg class="w-5 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<div class="mt-6">
    {{ $data->links() }}
</div>
    {{-- Modal Hapus --}}
    <div wire:ignore.self id="hapus-barang" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="hapus-barang">
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
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin akan hapus data
                        ini?</h3>
                    <form action="/barangs/{{ $id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-modal-hide="hapus-barang" type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Ya, saya yakin
                        </button>
                        <button data-modal-hide="hapus-barang" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tidak,
                            kembali</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div wire:ignore.self id="edit-barang" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit {{ $namaBarang }}
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="edit-barang">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="/barangs/{{ $id }}" method="POST" enctype="multipart/form-data"
                        class="max-w-sm mx-auto">
                        @method('PUT')
                        @csrf
                        <div class="mb-5">
                            <label for="nama_barang"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Barang</label>
                            <input type="text" value="{{ $namaBarang }}" id="nama_barang" name="nama_barang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Gitar Yamaha Racing" required />
                        </div>
                        <div class="mb-5">
                            <label for="kategori_barang"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                            <select id="kategori_barang" name="kategori_barang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @switch($kategoriBarang)
                                    @case('Alat Musik')
                                        <option disabled>Pilih Kategori</option>
                                        <option selected value="Alat Musik">Alat Musik</option>
                                        <option value="Kendaraan">Kendaraan</option>
                                        <option value="Properti">Properti</option>
                                        <option value="Elektronik">Elektronik</option>
                                    @break

                                    @case('Kendaraan')
                                        <option disabled>Pilih Kategori</option>
                                        <option value="Alat Musik">Alat Musik</option>
                                        <option selected value="Kendaraan">Kendaraan</option>
                                        <option value="Properti">Properti</option>
                                        <option value="Elektronik">Elektronik</option>
                                    @break

                                    @case('Properti')
                                        <option disabled>Pilih Kategori</option>
                                        <option value="Alat Musik">Alat Musik</option>
                                        <option value="Kendaraan">Kendaraan</option>
                                        <option selected value="Properti">Properti</option>
                                        <option value="Elektronik">Elektronik</option>
                                    @break

                                    @case('Elektronik')
                                        <option disabled>Pilih Kategori</option>
                                        <option value="Alat Musik">Alat Musik</option>
                                        <option value="Kendaraan">Kendaraan</option>
                                        <option value="Properti">Properti</option>
                                        <option selected value="Elektronik">Elektronik</option>
                                    @break

                                    @default
                                        <option selected disabled>Pilih Kategori</option>
                                        <option value="Alat Musik">Alat Musik</option>
                                        <option value="Kendaraan">Kendaraan</option>
                                        <option value="Properti">Properti</option>
                                        <option value="Elektronik">Elektronik</option>
                                @endswitch
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="status_barang"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                                Barang</label>
                            <select id="status_barang" name="status_barang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if ($statusBarang == 0)
                                    <option disabled>Status</option>
                                    <option selected value="0">Tidak Bisa Dipinjam</option>
                                    <option value="1">Bisa Dipinjam</option>
                                @else
                                    <option disabled>Status</option>
                                    <option value="0">Tidak Bisa Dipinjam</option>
                                    <option selected value="1">Bisa Dipinjam</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="kondisi_barang"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi
                                Barang</label>
                            <select id="kondisi_barang" name="kondisi_barang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if ($kondisiBarang == 1)
                                    <option disabled>Kondisi</option>
                                    <option selected value="1">Bisa Dipakai</option>
                                    <option value="0">Rusak</option>
                                @else
                                    <option disabled>Kondisi</option>
                                    <option value="1">Bisa Dipakai</option>
                                    <option selected value="0">Rusak</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="jumlah_barang"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                Barang</label>
                            <input type="text" value="{{ $jumlahBarang }}" id="jumlah_barang" name="jumlah_barang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0" required />
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="gambar">Gambar</label>
                            <input name="gambar" accept="image/png, image/jpeg"
                                class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="gambar" type="file">
                        </div>
                        <button type="submit"
                            class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-sm text-sm w-full px-5 py-2 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-700">Update
                            Barang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
