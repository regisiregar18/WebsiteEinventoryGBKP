<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title>Setting Profile</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <main class="bg-[#F3F4F6] flex flex-1 justify-center items-center w-full h-screen p-4">
        @include('components.success-toast')
        @include('components.failed-toast')
        
        <section class="bg-white py-8 px-8 rounded-2xl shadow-lg md:w-2/3 w-full space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-700">Setting Profile</h1>
                <a href="/dashboard" class="flex items-center gap-1 font-semibold text-blue-500 hover:text-blue-700">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali                 
                </a>
            </div>
            <!-- Form -->
            <form action="/users/{{ $data->id }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf
                <!-- Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" id="first_name" value="{{ $data->first_name }}" name="first_name" class="input-field" required />
                        @error('first_name')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" id="last_name" value="{{ $data->last_name }}" name="last_name" class="input-field" required />
                        @error('last_name')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" value="{{ $data->email }}" name="email" class="input-field" placeholder="name@email.com" required />
                    @error('email')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" value="{{ $data->username }}" name="username" class="input-field" placeholder="Julian123" required />
                    @error('username')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" id="phone" value="{{ $data->phone }}" name="phone" class="input-field" placeholder="08123456789" required />
                </div>
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" class="input-field pr-10" minlength="6" placeholder="Min length 6" required />
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-blue-500">
                            👁️
                        </button>
                    </div>
                </div>
                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="input-field" minlength="6" placeholder="Min length 6" required />
                </div>
                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300 ease-in-out">
                        Update Profile
                    </button>
                </div>
            </form>
        </section>
    </main>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
    <style>
        .input-field {
            @apply w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700;
        }
    </style>
</body>
</html>
