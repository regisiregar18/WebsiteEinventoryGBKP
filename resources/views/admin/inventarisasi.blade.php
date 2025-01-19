@extends('layouts.default')

@section('content')
    @include('components.success-toast')
    <div class="h-screen">
        <form @if ($data != null) action="/inventarisasis/{{ $data->id }}" @else action="/inventarisasis" @endif method="POST" enctype="multipart/form-data" class="bg-white sm:px-8 px-4 py-5 rounded max-w-lg mx-auto">
            @if ($data != null)
                @method('PUT')
            @endif
            @csrf
            <div class="flex gap-3 items-center mb-5">
                <svg class="w-5 rounded-sm bg-black text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                </svg>              
                <h1 class="font-semibold">Pengadaan Barang Inventaris</h1>
            </div>
            <div class="mb-5">
                <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang</label>
                <input type="text" id="nama_barang" @if ($data != null) value="{{ $data->nama_barang }}" @endif name="nama_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Gitar Yamaha Racing" required />
            </div>
            <div class="mb-5">
                <label for="target_dana" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Target Dana</label>
                <input type="number" id="target_dana" min="0" @if ($data != null) value="{{ $data->target_dana }}" @endif name="target_dana" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="5000000" required />
            </div>
            <div class="mb-5">
                <label for="dana_masuk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dana Masuk</label>
                <input type="number" id="dana_masuk" min="0" @if ($data != null) value="{{ $data->dana_masuk }}" @endif name="dana_masuk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="5000000" required />
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Masukkan Gambar</label>
                @if ($data != null)
                    <img src="{{ asset('storage/inventaris/gambar/'.$data->gambar) }}" class="block sm:mx-0 mx-auto max-w-44 mb-3" alt="">
                @endif
                <input name="gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" @if ($data == null) required @endif>
            </div>
            <div class="flex justify-center items-center gap-2">
                @if ($data != null)
                    @if ($data->dana_masuk >= $data->target_dana)
                        <button type="button" data-modal-target="hapus-inventaris" data-modal-toggle="hapus-inventaris" class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-sm w-full px-5 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Reset</button>
                        <div class="text-white bg-slate-500 border-2 border-white font-medium rounded-md text-sm w-full px-5 py-2 text-center">Dana Tercapai</div>    
                    @else
                        <button type="submit" class="text-gray-800 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm w-full px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 dark:text-gray-200">Apply</button>
                        <div class="text-slate-400 bg-white border-2 border-slate-400 font-medium rounded-md text-sm w-full px-5 py-2 text-center">Dana Tercapai</div>
                    @endif
                @else
                    <button type="submit" class="text-gray-800 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm w-full px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 dark:text-gray-200">Apply</button>
                    <div class="text-slate-400 bg-white border-2 border-slate-400 font-medium rounded-md text-sm w-full px-5 py-2 text-center">Dana Tercapai</div>    
                @endif
            </div>
        </form>  
    </div>
    @if ($data != null)
        <div id="hapus-inventaris" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="hapus-inventaris">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin akan mereset inventaris ini?</h3>
                        <form action="/inventarisasis/{{ $data->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" data-modal-hide="hapus-inventaris" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Ya, saya yakin
                            </button>
                            <button data-modal-hide="hapus-inventaris" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tidak, kembali</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection