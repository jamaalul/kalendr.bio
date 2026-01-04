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
        class="flex flex-col flex-1 items-center bg-[#eceef1] mx-2 md:mx-4 mb-2 md:mb-4 p-4 md:p-6 border rounded-lg overflow-y-scroll">
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-white shadow-sm mb-4 px-4 py-3 border border-gray-200 rounded-lg w-full lg:max-w-[80%]">
                <div class="bg-emerald-500 rounded-full w-1 h-5"></div>

                <div class="flex-1 font-medium text-[14px] text-gray-700">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="flex items-center gap-3 bg-white shadow-sm mb-4 px-4 py-3 border border-gray-200 rounded-lg w-full lg:max-w-[80%]">
                <div class="bg-red-500 rounded-full w-1 h-5"></div>

                <div class="flex-1 font-medium text-[14px] text-gray-700">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</body>

</html>
