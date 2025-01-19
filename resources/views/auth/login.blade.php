<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title>Login</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <style>
        * {
            scroll-behavior: smooth;
        }
    </style>
    <main class="grid grid-cols-12 bg-[#F0F4FF] h-[100vh]">
        @include('components.failed-toast')
        @include('components.success-toast')

        <!-- Left Section with Background Image and Welcome Message -->
        <section class="relative lg:col-span-6 col-span-12">
            <img src="{{ asset('img/dalam.jpg') }}" class="h-screen w-full object-cover" alt="Background">
            <div class="absolute top-0 left-0 w-full h-full p-8 bg-gradient-to-t from-black via-transparent to-transparent">
                <h1 class="text-white text-center md:text-5xl text-3xl mt-32 font-bold">
                    Selamat Datang di E-Inventory
                    GBKP PANTAI BARAT
                </h1>
                <p class="text-white text-center md:text-2xl text-lg mt-4 font-medium mb-20">Sistem Inventaris GBKP PANTAI BARAT</p>
                <div class="flex justify-center lg:hidden">
                    <a href="#loginForm" class="bg-blue-700 hover:bg-blue-900 transition duration-300 text-white text-lg font-semibold px-12 py-3 rounded-lg shadow-lg">Login</a>
                </div>
            </div>
        </section>

        <!-- Right Section with Login Form -->
        <section id="loginForm" class="lg:col-span-6 col-span-12">
            <div class="flex flex-col justify-center items-center w-full h-[100vh] p-4">
                <div class="bg-white p-8 md:p-16 border shadow-xl rounded-xl w-full max-w-md space-y-8">
                    <div class="flex flex-col items-center space-y-4">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-24 h-24 rounded-full shadow-md">
                        <h1 class="md:text-4xl text-2xl text-gray-800 font-bold text-center">E-Inventory</h1>
                        <p class="text-gray-600 font-medium text-center">GBKP RUNGGUN PANTAI BARAT</p>
                    </div>
                    <form action="/login-process" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="username" class="block mb-2 text-sm font-semibold text-gray-700">Username</label>
                            <input type="text" id="username" name="username" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Masukkan Username" required />
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                            <input type="password" id="password" name="password" placeholder="********" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required />
                        </div>
                        <button type="submit" class="w-full py-3 bg-green-400 hover:bg-green-500 text-white font-semibold rounded-lg text-lg transition duration-300 focus:ring-4 focus:ring-green-200">Login</button>
                    </form>  
                </div>
            </div>
        </section>
    </main>
</body>
</html>