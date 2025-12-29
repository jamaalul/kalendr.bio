<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cancel Booking - {{ $booking->eventType->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="flex justify-center items-center bg-gray-100 p-4 min-h-screen">

    <div class="bg-white p-4 md:p-8 border rounded-md w-full max-w-lg text-center">
        <div class="flex justify-center mb-6">
            <div class="flex justify-center items-center bg-red-200 mt-3 rounded-full w-16 h-16 text-red-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </div>
        </div>

        <h1 class="mb-2 font-bold text-gray-900 text-2xl">Batalkan Booking?</h1>
        <p class="mb-8 text-gray-600 text-sm">Apakah kamu yakin ingin membatalkan jadwal dengan
            <strong>{{ $booking->eventType->user->name }}</strong>?</p>

        <div class="bg-gray-50 mb-8 p-3 md:p-6 border border-gray-100 rounded-md text-left">
            <h3 class="mb-4 font-semibold text-gray-900 text-lg">{{ $booking->eventType->name }}</h3>

            <div class="space-y-4">
                <div class="flex items-start gap-3 text-gray-600">
                    <svg class="mt-0.5 w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <div>
                        <div class="font-medium text-gray-900">
                            {{ $booking->starts_at->setTimezone($booking->guest_timezone ?? 'UTC')->isoFormat('dddd, D MMMM YYYY') }}
                        </div>
                        <div class="text-sm">
                            {{ $booking->starts_at->setTimezone($booking->guest_timezone ?? 'UTC')->format('H:i') }} -
                            {{ $booking->ends_at->setTimezone($booking->guest_timezone ?? 'UTC')->format('H:i') }}
                            ({{ $booking->guest_timezone ?? 'WIB' }})
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST">
            @csrf
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 py-3 rounded-md w-full font-semibold text-white transition-colors">
                Ya, Batalkan Booking
            </button>
        </form>
    </div>

</body>

</html>
