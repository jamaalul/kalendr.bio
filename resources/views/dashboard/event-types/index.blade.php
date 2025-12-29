@extends('dashboard.layout')

@section('title', 'kalendr | Agenda')

@section('content')

    <div class="flex flex-col gap-4 bg-red w-full lg:max-w-[80%] h-96">
        <div class="flex justify-between items-center w-full">
            <h1 class="font-semibold text-md md:text-xl">Daftar Agenda</h1>
            <button
                class="flex justify-center items-center gap-2 bg-black hover:bg-gray-800 px-3 py-2 rounded-md font-medium text-white text-sm md:text-base transition-all duration-200"
                onclick="window.location.href = '/event-types/create'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 md:size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Agenda
            </button>
        </div>
        <div class="gap-2 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full">
            @foreach ($agendas as $agenda)
                <div class="flex flex-col justify-between gap-4 bg-white hover:shadow-md p-5 border rounded-md lg:h-48 hover:scale-[102%] transition-all duration-200 cursor-pointer"
                    onclick="window.location.href='/event-types/{{ $agenda['id'] }}/edit'">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 md:size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                        </svg>
                        <h3 class="font-medium text-lg lg:text-xl">{{ $agenda->name }}</h3>
                    </div>
                    <div class="flex flex-col gap-2 h-fit">
                        <div class="flex items-center gap-2">
                            <span
                                class="rounded-full size-2 {{ $agenda->is_active ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                            <p class="text-gray-400 text-xs md:text-sm lg:text-base">
                                {{ $agenda->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
                        </div>
                        <p class="text-xs md:text-sm lg:text-base">Durasi: {{ $agenda->duration_minutes }} menit</p>
                        <p class="text-xs md:text-sm lg:text-base">Zona Waktu: {{ $agenda->timezone }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex flex-col gap-4 mt-4 pb-2 md:pb-4 w-full">
            <h1 class="font-semibold text-md md:text-xl">Janji Baru</h1>
            @foreach ($bookings as $booking)
                <div
                    class="flex justify-between items-center bg-white hover:shadow-sm p-6 border border-gray-200 rounded-md w-full transition-shadow duration-300">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span
                                class="font-medium text-gray-400 text-sm tracking-wide">{{ $booking->eventType->name }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-lg tracking-tight">{{ $booking->guest_name }}</h3>
                        <p class="font-medium text-gray-500 text-sm italic">{{ $booking->guest_email }}</p>

                        <div class="flex items-center gap-2 mt-2 pt-2 border-t text-gray-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>
                                <span class="font-medium text-black">
                                    {{ \Carbon\Carbon::parse($booking->starts_at)->setTimezone(Auth::user()->timezone)->translatedFormat('d M Y') }}
                                </span>
                                |
                                {{ \Carbon\Carbon::parse($booking->starts_at)->setTimezone(Auth::user()->timezone)->format('H:i') }}
                                —
                                {{ \Carbon\Carbon::parse($booking->ends_at)->setTimezone(Auth::user()->timezone)->format('H:i') }}
                                @php
                                    $tzMap = [
                                        'Asia/Jakarta' => 'WIB',
                                        'Asia/Makassar' => 'WITA',
                                        'Asia/Jayapura' => 'WIT',
                                    ];
                                @endphp
                                <span
                                    class="ml-1 text-gray-400">({{ $tzMap[Auth::user()->timezone] ?? Auth::user()->timezone }})</span>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 h-full">
                        <form action="{{ route('booking.accept') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $booking->id }}">
                            <button type="submit"
                                class="bg-black hover:bg-gray-800 shadow-sm px-5 py-2 rounded-lg font-medium text-white text-sm active:scale-95 transition-all">
                                Terima
                            </button>
                        </form>
                        <form action="{{ route('booking.reject') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $booking->id }}">
                            <button type="submit"
                                class="hover:bg-red-100 px-5 py-2 rounded-lg w-full font-medium text-red-500 text-sm active:scale-95 transition-all">
                                Tolak
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
