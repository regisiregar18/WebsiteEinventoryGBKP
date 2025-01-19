@extends('layouts.default')

@section('content')
    @include('components.success-toast')
    <div class="px-5 py-8 mb-8 bg-white rounded-lg md:w-1/2 xl:w-2/6 w-full shadow-lg">
        <div class="flex gap-3 items-center mb-5">
            <svg class="w-5 rounded-sm bg-black text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
            </svg>              
            <h1 class="ont-semibold">Data Barang</h1>
        </div>
        <form action="/barangs" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
            @csrf
            <div class="mb-5">
                <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="masukkan nama barang" required />
                @error('nama_barang')
                    <p class="text-red-700 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="kategori_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                <select id="kategori_barang" name="kategori_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option selected disabled>Pilih Kategori</option>
                  <option value="Alat Musik">Alat Musik</option>
                  <option value="Kendaraan">Kendaraan</option>
                  <option value="Properti">Properti</option>
                  <option value="Elektronik">Elektronik</option>
                </select>
                @error('kategori_barang')
                    <p class="text-red-700 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="status_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Barang</label>
                <select id="status_barang" name="status_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option selected disabled>Status</option>
                  <option value="0">Tidak Bisa Dipinjam</option>
                  <option value="1">Bisa Dipinjam</option>
                </select>
                @error('status_barang')
                    <p class="text-red-700 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="kondisi_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Barang</label>
                <select id="kondisi_barang" name="kondisi_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option selected disabled>Kondisi</option>
                  <option value="1">Bisa Dipakai</option>
                  <option value="0">Rusak</option>
                </select>
                @error('kondisi_barang')
                    <p class="text-red-700 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label for="jumlah_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Barang</label>
                <input type="text" id="jumlah_barang" name="jumlah_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="-" required />
                @error('jumlah_barang')
                    <p class="text-red-700 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="gambar">Gambar</label>
                <input name="gambar" accept="image/png, image/jpeg" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="gambar" type="file">
                @error('gambar')
                    <p class="text-red-700 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="text-white bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-sm text-sm w-full sm:w-auto px-5 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tambah Barang</button>
        </form>  
    </div>

    <livewire:table-data-barang />
@endsection