<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'kalendr | Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col bg-white w-screen min-h-screen">
    @include('dashboard.navbar', ['state' => $state ?? 'agenda'])
    <div class="flex flex-col flex-1 items-center bg-gray-100 mx-2 md:mx-4 mb-2 md:mb-4 p-2 md:p-4 border rounded-lg">
        @yield('content')
    </div>
</body>

</html>
