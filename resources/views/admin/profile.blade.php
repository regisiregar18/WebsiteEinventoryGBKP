<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile | {{ $data->first_name }} {{ $data->last_name }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <main class="flex flex-1 flex-col justify-center items-center bg-gradient-to-br from-blue-200 to-blue-500 py-12 min-h-screen">
        <!-- Container -->
        <section class="bg-white p-8 rounded-2xl shadow-2xl w-5/6 lg:w-1/2">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8 border-b-2 pb-4 border-gray-200">
                <h1 class="text-2xl text-gray-700 font-extrabold">Detail User</h1>
                <a href="/dashboard" class="flex items-center gap-2 font-bold hover:text-blue-600 transition text-blue-800">
                    <svg class="w-6 h-6 text-blue-800 hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
                    Kembali                 
                </a>
            </div>

            <!-- Profile Picture -->
            <div class="w-36 h-36 flex justify-center items-center bg-blue-100 rounded-full mx-auto shadow-lg mb-5 overflow-hidden">
                <img src="https://via.placeholder.com/150" alt="Profile Picture" class="w-full h-full object-cover">
            </div>

            <!-- User Information -->
            <div class="grid grid-cols-12 gap-6 text-gray-600">
                <!-- First Name -->
                <div class="col-span-12 md:col-span-6">
                    <p class="text-gray-700 font-semibold mb-1">First Name</p>
                    <p class="bg-gray-100 px-4 py-2 rounded-md shadow-sm">{{ $data->first_name }}</p>
                </div>
                <!-- Last Name -->
                <div class="col-span-12 md:col-span-6">
                    <p class="text-gray-700 font-semibold mb-1">Last Name</p>
                    <p class="bg-gray-100 px-4 py-2 rounded-md shadow-sm">{{ $data->last_name }}</p>
                </div>
                <!-- Phone -->
                <div class="col-span-12 md:col-span-6">
                    <p class="text-gray-700 font-semibold mb-1">Phone Number</p>
                    <p class="bg-gray-100 px-4 py-2 rounded-md shadow-sm">0{{ $data->phone }}</p>
                </div>
                <!-- Email -->
                <div class="col-span-12 md:col-span-6">
                    <p class="text-gray-700 font-semibold mb-1">Email</p>
                    <p class="bg-gray-100 px-4 py-2 rounded-md shadow-sm">{{ $data->email }}</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
