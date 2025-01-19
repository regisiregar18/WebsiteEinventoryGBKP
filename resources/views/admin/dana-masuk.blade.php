@extends('layouts.default')

@section('content')
    @include('components.success-toast')

    <div class="flex space-x-6">
        <!-- Bagian Kiri: Tombol Cetak Laporan dan Form Donasi -->
        <div class="flex-none w-1/3">
            <!-- Tombol Cetak Laporan -->
            <div class="mb-6 w-full">
                <a href="/printDanaMasuk" target="_blank" class="flex items-center justify-center gap-2 px-3 py-2 bg-orange-600 text-white rounded-md shadow hover:bg-orange-700 transition duration-300 ease-in-out font-medium text-xs md:text-sm max-w-sm w-full">
                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                        <path d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z"/>
                    </svg>
                    Cetak Laporan Dana
                </a>
            </div>

            <!-- Form Donasi -->
            <div class="px-6 py-8 bg-white rounded-lg shadow-lg">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6">Donasi Jemaat</h1>
                <form action="/donasis" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Nama -->
                    <div class="relative">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full px-3 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Isi nama" required />
                        @error('nama')
                            <p class="text-red-600 text-sm font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div class="relative">
                        <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required />
                        @error('tanggal')
                            <p class="text-red-600 text-sm font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Persembahan -->
                    <div class="relative">
                        <label for="jumlah_donasi" class="block mb-2 text-sm font-medium text-gray-700">Jumlah Persembahan</label>
                        <input type="number" id="jumlah_donasi" min="0" name="jumlah_donasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full px-3 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="-" required />
                        @error('jumlah_donasi')
                            <p class="text-red-600 text-sm font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-400 text-white font-medium rounded-md px-5 py-2 hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 ease-in-out">Tambahkan Donasi</button>
                </form>
            </div>
        </div>

        <!-- Bagian Kanan: Tabel Donasi -->
        <div class="flex-none w-2/3 relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-200 rounded-lg">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Jumlah Dana</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($donasiJemaat->count() < 1)
                        <tr class="bg-white">
                            <td colspan="3" class="px-6 py-4 text-center text-gray-700">Data tidak ada!</td>
                        </tr>
                    @endif
                    @foreach ($donasiJemaat as $item)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-6 h-6 text-blue-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $item->nama }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $date = date_create($item->tanggal)
                                @endphp
                                {{ date_format($date,"d M Y") }}
                            </td>
                            <td class="px-6 py-4">
                                @currency($item->jumlah_donasi)
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
