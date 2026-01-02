<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'kalendr | Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col bg-white w-screen max-w-screen min-h-screen overflow-x-hidden">
    @include('dashboard.navbar', ['state' => $state ?? 'agenda'])
    <div
        class="flex flex-col flex-1 items-center bg-gray-100 mx-2 md:mx-4 mb-2 md:mb-4 p-2 md:p-4 border rounded-lg overflow-y-scroll">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 px-4 py-3 rounded text-green-700 relative w-full lg:max-w-[80%]" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 px-4 py-3 rounded text-red-700 relative w-full lg:max-w-[80%]" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </div>
</body>

</html>
