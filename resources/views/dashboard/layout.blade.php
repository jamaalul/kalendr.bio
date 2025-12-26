<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>kalendr | Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col bg-white w-screen min-h-screen">
    @include('dashboard.navbar', ['state' => $state])
    <div class="flex-1 bg-gray-100 mx-4 mb-4 border rounded-lg"></div>
</body>

</html>
