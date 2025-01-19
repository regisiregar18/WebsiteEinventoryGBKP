<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Welcome | GBKP PANTAI BARAT</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <style>
        * {
            scroll-behavior: smooth;
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>

<nav class="bg-white shadow-md dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <!-- Logo Section -->
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo.png') }}" class="h-10 w-10" alt="Logo" />
                <div>
                    <h1 class="self-center text-2xl font-extrabold text-gray-800 dark:text-white">E-Inventory</h1>
                    <span class="self-center text-sm text-gray-500 dark:text-gray-400">GBKP RUNGGUN PANTAI BARAT</span>
                </div>
            </div>
        </a>
        
        <!-- Mobile Menu Button -->
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        
        <!-- Navigation Links -->
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="#beranda" class="block py-2 px-4 text-gray-900 hover:text-blue-700 rounded md:bg-transparent md:hover:bg-transparent hover:bg-gray-100 dark:text-white dark:hover:text-blue-500">Beranda</a>
                </li>
                <li>
                    <a href="#kategori" class="block py-2 px-4 text-gray-900 hover:text-blue-700 rounded md:bg-transparent md:hover:bg-transparent hover:bg-gray-100 dark:text-white dark:hover:text-blue-500">Kategori</a>
                </li>
                <li>
                    <a href="#form" class="block py-2 px-4 text-gray-900 hover:text-blue-700 rounded md:bg-transparent md:hover:bg-transparent hover:bg-gray-100 dark:text-white dark:hover:text-blue-500">Peminjaman</a>
                </li>
                <li>
                    <a href="#dana" class="block py-2 px-4 text-gray-900 hover:text-blue-700 rounded md:bg-transparent md:hover:bg-transparent hover:bg-gray-100 dark:text-white dark:hover:text-blue-500">Dana</a>
                </li>
                <li>
                    @auth
                        <a href="/dashboard" class="block py-2 px-4 text-gray-900 hover:text-blue-700 rounded md:bg-transparent md:hover:bg-transparent hover:bg-gray-100 dark:text-white dark:hover:text-blue-500">Dashboard</a>
                    @endauth
                    @guest
                        <a href="/login" class="block py-2 px-4 text-gray-900 hover:text-blue-700 rounded md:bg-transparent md:hover:bg-transparent hover:bg-gray-100 dark:text-white dark:hover:text-blue-500">Login</a>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="pb-8 bg-[#EDF3FD]">
    <!-- Hero Section -->
    <section id="beranda" class="relative flex flex-1 flex-col justify-center items-center min-h-screen">
        <div class="absolute top-0 left-0 w-full h-full bg-no-repeat bg-center bg-cover" style="background-image: url('{{ asset('img/depan.jpg') }}'); background-size: cover;"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-transparent"></div>
        <div class="relative z-50 mx-6 text-center">
            <h1 class="sm:text-4xl xl:text-6xl text-3xl text-white font-extrabold mb-8">Shalom! Mejuah-Juah !!</h1>
            <h1 class="sm:text-3xl xl:text-5xl text-2xl text-white font-bold mb-12 mt-8">
                Selamat Datang Di Sistem Inventaris <br> GBKP Runggun Pantai Barat
            </h1>
            <p class="text-white md:text-2xl xl:text-3xl font-semibold mb-6">
                Roma 12 : 1
            </p>
            <p class="text-white md:text-lg xl:text-xl leading-relaxed">
            Karena itu, saudara-saudara, demi kemurahan Allah aku menasihatkan kamu: persembahkanlah dirimu sebagai persembahan hidup yang kudus, yang berkenan kepada Allah; itu adalah ibadahmu yang sejati
            </p>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <!-- Image -->
                <div class="flex-shrink-0">
                    <img src="{{ asset('img/rumahpdt.jpg') }}" alt="About Image" class="w-full max-w-md rounded-lg shadow-lg">
                </div>

                <!-- Description -->
                <div class="lg:w-2/3">
                    <h2 class="text-3xl font-bold mb-4">Tentang E-Inventory</h2>
                    <p class="text-lg mb-4">
                        Sistem E-Inventory GBKP Runggun Pantai Barat adalah platform inovatif yang dirancang untuk mempermudah manajemen inventaris barang di gereja kami. Dengan fitur yang mudah digunakan, sistem ini memungkinkan pengguna untuk mengelola dan melacak barang inventaris dengan efisien.
                    </p>
                    <p class="text-lg">
                        Melalui E-Inventory, pengguna dapat menambah, mengedit, dan memonitor status barang dengan cepat. Sistem ini dirancang untuk memudahkan administrasi dan memastikan data inventaris selalu akurat dan up-to-date.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>


<section id="kategori" class="sm:px-8 px-4 mb-24">
    <h1 class="sm:text-3xl lg:text-4xl text-2xl text-center font-bold my-24">Barang Inventaris</h1>
    <h1 class="sm:text-3xl lg:text-4xl text-2xl font-bold mb-5 text-center">Alat Musik</h1>
    <div class="grid grid-cols-12 gap-6">
        @foreach ($alatMusik as $item)
            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3 col-span-12">
                <div class="bg-white shadow-lg border rounded-xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <img src="{{ asset('storage/barang/gambar/'. $item->gambar) }}" class="w-full h-48 object-cover" alt="">
                    <div class="p-4 space-y-2">
                        <h1 class="font-semibold text-xl">{{ $item->nama_barang }}</h1>
                        @if ($item->kondisi_barang != 0)
                            <p class="font-medium text-blue-500">Bisa Dipakai</p>
                        @else
                            <p class="font-medium text-red-500">Rusak</p>
                        @endif
                        <p class="font-semibold text-slate-500">{{ $item->kategori_barang }}</p>
                        <div class="mt-2">
                            @if ($item->status_barang != 0)
                                <p class="font-medium text-emerald-500">Bisa Dipinjam</p>
                            @else
                                <p class="font-medium text-red-500">Tidak Bisa Dipinjam</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
<section id="kendaraan" class="sm:px-8 px-4 mb-24">
    <h1 class="sm:text-3xl lg:text-4xl text-2xl font-bold mt-24 mb-5 text-center">Kendaraan</h1>
    <div class="grid grid-cols-12 gap-6">
        @foreach ($kendaraan as $item)
            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3 col-span-12">
                <div class="bg-white shadow-lg border rounded-xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <img src="{{ asset('storage/barang/gambar/'. $item->gambar) }}" class="w-full h-48 object-cover" alt="">
                    <div class="p-4 space-y-2">
                        <h1 class="font-semibold text-xl">{{ $item->nama_barang }}</h1>
                        @if ($item->kondisi_barang != 0)
                            <p class="font-medium text-blue-500">Bisa Dipakai</p>
                        @else
                            <p class="font-medium text-red-500">Rusak</p>
                        @endif
                        <p class="font-semibold text-slate-500">{{ $item->kategori_barang }}</p>
                        <div class="mt-2">
                            @if ($item->status_barang != 0)
                                <p class="font-medium text-emerald-500">Bisa Dipinjam</p>
                            @else
                                <p class="font-medium text-red-500">Tidak Bisa Dipinjam</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="properti" class="sm:px-8 px-4 mb-24">
    <h1 class="sm:text-3xl lg:text-4xl text-2xl font-bold mt-24 mb-5 text-center">Properti</h1>
    <div class="grid grid-cols-12 gap-6">
        @foreach ($properti as $item)
            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3 col-span-12">
                <div class="bg-white shadow-lg border rounded-xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <img src="{{ asset('storage/barang/gambar/'. $item->gambar) }}" class="w-full h-48 object-cover" alt="">
                    <div class="p-4 space-y-2">
                        <h1 class="font-semibold text-xl">{{ $item->nama_barang }}</h1>
                        @if ($item->kondisi_barang != 0)
                            <p class="font-medium text-blue-500">Bisa Dipakai</p>
                        @else
                            <p class="font-medium text-red-500">Rusak</p>
                        @endif
                        <p class="font-semibold text-slate-500">{{ $item->kategori_barang }}</p>
                        <div class="mt-2">
                            @if ($item->status_barang != 0)
                                <p class="font-medium text-emerald-500">Bisa Dipinjam</p>
                            @else
                                <p class="font-medium text-red-500">Tidak Bisa Dipinjam</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="elektronik" class="sm:px-8 px-4 mb-24">
    <h1 class="sm:text-3xl lg:text-4xl text-2xl font-bold mt-24 mb-5 text-center">Elektronik</h1>
    <div class="grid grid-cols-12 gap-6">
        @foreach ($elektronik as $item)
            <div class="sm:col-span-6 md:col-span-4 lg:col-span-3 col-span-12">
                <div class="bg-white shadow-lg border rounded-xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <img src="{{ asset('storage/barang/gambar/'. $item->gambar) }}" class="w-full h-48 object-cover" alt="{{ $item->nama_barang }}">
                    <div class="p-4 space-y-2">
                        <h1 class="font-semibold text-xl">{{ $item->nama_barang }}</h1>
                        @if ($item->kondisi_barang != 0)
                            <p class="font-medium text-blue-500">Bisa Dipakai</p>
                        @else
                            <p class="font-medium text-red-500">Rusak</p>
                        @endif
                        <p class="font-semibold text-slate-500">{{ $item->kategori_barang }}</p>
                        <div class="mt-2">
                            @if ($item->status_barang != 0)
                                <p class="font-medium text-emerald-500">Bisa Dipinjam</p>
                            @else
                                <p class="font-medium text-red-500">Tidak Bisa Dipinjam</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="form" class="sm:px-8 px-4 mb-24">
<h1 class="sm:text-3xl lg:text-4xl text-2xl font-bold mt-24 mb-5 text-center">Form Peminjaman Barang</h1>
@livewire('form-barang-pinjam', ['detail' => $detail ?? null])
<h1 class="sm:text-3xl lg:text-4xl text-2xl font-bold mt-24 mb-5 text-center">Tambahan Informasi Peminjaman</h1>
    <div class="text-center">
        <p class="text-lg mb-4">
            Atau anda bisa menghubungi kami melalui WhatsApp di nomor berikut:
        </p>
        <a href="https://wa.me/+6281264498310" 
           class="bg-green-500 text-white px-4 py-2 rounded-lg inline-block hover:bg-green-600 transition">
            Hubungi Admin via WhatsApp
        </a>
        <p class="text-lg mt-6">Anda juga dapat memindai barcode berikut untuk menghubungi admin:</p>
        <div class="flex justify-center mt-4">
            <img src="{{ asset('img/barcode.jpg') }}" alt="QR Code WhatsApp Admin" class="w-40 h-40">
        </div>
    </div>
    </section>

@if ($inventaris)
<section id="dana" class="sm:px-8 px-4 mb-24">
    <h1 class="text-center text-3xl sm:text-4xl lg:text-5xl font-bold my-12 text-gray-800">Pengadaan Barang Inventaris</h1>
    <div class="mx-auto lg:w-2/3">
        <div class="bg-white shadow-lg rounded-lg p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <div>
                        <p class="text-gray-600 font-semibold mb-2">Dana Yang Masuk</p>
                        <p class="border-2 border-gray-300 rounded-md px-4 py-2 text-lg font-semibold">@currency($inventaris->dana_masuk)</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-semibold mb-2">Target Dana</p>
                        <p class="border-2 border-gray-300 rounded-md px-4 py-2 text-lg font-semibold">@currency($inventaris->target_dana)</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-semibold mb-2">Sisa Dana yang Dibutuhkan</p>
                        @php
                            $sisa = $inventaris->target_dana - $inventaris->dana_masuk
                        @endphp
                        <p class="border-2 border-gray-300 rounded-md px-4 py-2 text-lg font-semibold
                            @if ($inventaris->dana_masuk >= $inventaris->target_dana)
                                text-green-600
                            @else
                                text-red-600
                            @endif
                        ">
                            @if ($inventaris->dana_masuk >= $inventaris->target_dana)
                                Dana Sudah Terkumpul
                            @else
                                @currency($sisa)
                            @endif
                        </p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold mb-3">Donasi Melalui</h2>
                        <div class="flex flex-wrap justify-around gap-4">
                        </div>
                    </div>
                    <!-- Tambahkan nomor dan logo BRI -->
                    <div class="flex items-center mt-4">
                        <img src="{{ asset('img/dana.png') }}" class="w-12 h-12 mr-2" alt="Dana"> <!-- Gambar Dana -->
                        <p class="text-lg font-semibold">081264498310</p> <!-- Nomor Dana -->
                        <img src="{{ asset('img/bri.png') }}" class="w-12 h-12 mx-4" alt="BRI"> <!-- Logo BRI -->
                        <p class="text-lg font-semibold">Rek: 376288200001</p> <!-- Nomor Rekening -->
                    </div>
                    <!-- Tambahkan informasi bukti pembayaran -->
                    <div class="flex items-center mt-4">
                        <p class="text-lg font-semibold mr-2">Bukti pembayaran kirim melalui:</p>
                        <img src="{{ asset('img/whatsapp.png') }}" class="w-12 h-12" alt="WhatsApp"> <!-- Gambar WhatsApp -->
                        <p class="text-lg font-semibold ml-2">081264498310</p> <!-- Nomor WhatsApp -->
                    </div>
                </div>
                <!-- Kolom Kanan -->
                <div class="flex flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">{{ $inventaris->nama_barang }}</h2>
                    <img src="{{ asset('storage/inventaris/gambar/'. $inventaris->gambar) }}" class="w-full max-w-xs h-auto object-cover rounded-lg shadow-md" alt="{{ $inventaris->nama_barang }}">
                </div>
            </div>
        </div>
    </div>
</section>


        @endif
        <footer class="bg-gray-900 text-white py-12 mt-10">
        <div class="container mx-auto px-6 lg:w-2/3">
        <!-- Border Footer -->
        <div class="border-t-4 border-gray-700 pt-10">
            <div class="grid md:grid-cols-3 grid-cols-1 gap-12">
                <!-- Section 1: Logo dan Deskripsi Singkat -->
                <div>
                    <img src="{{ asset('img/logo.png') }}" class="w-24 mb-6" alt="Logo">
                    <p class="text-sm text-gray-400">GBKP Runggun Pantai Barat adalah Gereja Batak Karo Protestan Runggun Pantai Barat Klasis Medan KP-Lalang yang melayani jemaat terletak di kota Medan tepatnya di Kelurahan Medan Cinta Damai</p>
                </div>
                
                <!-- Section 2: Kontak -->
                <div>
                    <h2 class="text-lg font-semibold mb-6">Kontak Kami</h2>
                    <ul class="text-sm space-y-2">
                        <li><a href="mailto:info@gbkprpb.org" class="hover:underline text-gray-300">gbkppbarat@gmail.com</a></li>
                        <li><a href="tel:+6282165093833" class="hover:underline text-gray-300">+62 821 6449 8310</a></li>
                        <li class="text-gray-400">Jl. Gereja, Cinta Damai, Kec. Medan Helvetia, Kota Medan, Sumatera Utara 20126</li>
                    </ul>

                    <!-- Google Maps Embed -->
                    <div class="mt-4">
                        <iframe class="w-full h-48" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1348.6481798028901!2d98.61139871317435!3d3.5981827412842637!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312ef45b7675d1%3A0x29afdb0ff3207c2b!2sGBKP%20Runggun%20Pantai%20Barat!5e0!3m2!1sid!2sid!4v1725701284222!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- Section 3: Media Sosial -->
                <div>
                    <h2 class="text-lg font-semibold mb-6">Ikuti Kami</h2>
                    <div class="flex space-x-6">
                        <a href="https://www.instagram.com/explore/locations/874466269/gbkp-pantai-barat-kp-lalang-medan/" target="_blank">
                            <img src="{{ asset('img/ig.png') }}" class="w-10" alt="Instagram">
                        </a>
                        <a href="https://wa.me/6282165093833" target="_blank">
                            <img src="{{ asset('img/whatsapp.png') }}" class="w-10" alt="WhatsApp">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div class="text-center text-gray-400 text-xs mt-8 border-t border-gray-700 pt-6">
            © 2024 GBKP Runggun Pantai Barat. created by: regisiregar.
        </div>
    </div>
</footer>
    </main>
</body>
</html>
