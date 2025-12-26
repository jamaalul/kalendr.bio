<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>kalendr | Daftar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex bg-gray-200 p-0 md:p-1 w-screen h-screen">
    <div
        class="right-0 md:right-1 md:absolute flex flex-col justify-center items-center bg-white shadow-lg p-12 md:rounded-md w-full md:w-[35rem] h-screen md:h-[calc(100vh-8px)]">
        <h1 class="mb-6 font-semibold text-black text-5xl tracking-tight">kalend<span class="text-gray-400">r.</span>
        </h1>
        <p class="mb-8 font-medium text-gray-600 text-xl">Daftar</p>
        <form method="POST" action="{{ route('register') }}" class="flex flex-col justify-center items-center w-full">
            @csrf

            <!-- Name -->
            <div class="w-full md:w-[80%]">
                <label for="name" class="font-medium text-gray-700 text-sm">Nama</label>
                <input id="name" class="block bg-gray-200 mt-1 border-0 rounded-full w-full" type="text"
                    name="name" :value="old('name')" required autofocus autocomplete="name" />
                <error :messages="$errors->get('name')" class="mt-2 text-red-600 text-xs" />
            </div>

            <!-- Email Address -->
            <div class="mt-4 w-full md:w-[80%]">
                <label for="email" class="font-medium text-gray-700 text-sm">Email</label>
                <input id="email" class="block bg-gray-200 mt-1 border-0 rounded-full w-full" type="email"
                    name="email" :value="old('email')" required autocomplete="username" />
                <error :messages="$errors->get('email')" class="mt-2 text-red-600 text-xs" />
            </div>

            <!-- Password -->
            <div class="mt-4 w-full md:w-[80%]">
                <label for="password" class="font-medium text-gray-700 text-sm">Password</label>
                <input id="password" class="block bg-gray-200 mt-1 border-0 rounded-full w-full" type="password"
                    name="password" required autocomplete="new-password" />

                <error :messages="$errors->get('password')" class="mt-2 text-red-600 text-xs" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 w-full md:w-[80%]">
                <label for="password_confirmation" class="font-medium text-gray-700 text-sm">Konfirmasi Password</label>
                <input id="password_confirmation" class="block bg-gray-200 mt-1 border-0 rounded-full w-full"
                    type="password" name="password_confirmation" required autocomplete="new-password" />

                <error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-xs" />
            </div>

            <div class="flex justify-end items-center mt-4 w-full md:w-[80%]">
                <a class="rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-gray-600 hover:text-gray-900 text-sm underline"
                    href="{{ route('login') }}">
                    Sudah punya akun?
                </a>

                <button
                    class="bg-black hover:bg-gray-800 ms-3 px-5 py-2 rounded-md font-medium text-white text-sm transition-all duration-100">
                    Daftar
                </button>
            </div>
        </form>
        <div class="flex items-center my-4 w-full">
            <span class="flex-1 border-gray-300 border-t"></span>

            <p class="mx-4 text-gray-500 text-sm whitespace-nowrap">
                atau daftar dengan
            </p>

            <span class="flex-1 border-gray-300 border-t"></span>
        </div>
        <button
            class="flex justify-center items-center gap-4 hover:shadow-md mt-2 p-2 border border-gray-400 rounded-full w-[80%] hover:scale-[102%] transition-all duration-200 cursor-pointer">
            <span
                title="Original: Google Vector:  Designism, Liquinoid, and YeBoy371, Public domain, via Wikimedia Commons"
                href="https://commons.wikimedia.org/wiki/File:Google_Favicon_2025.svg"><img width="18"
                    alt="Google logo"
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Google_Favicon_2025.svg/512px-Google_Favicon_2025.svg.png?20251015042304">
            </span>
            <span class="font-medium text-black text-base">
                Google
            </span>
        </button>
    </div>
</body>

</html>
