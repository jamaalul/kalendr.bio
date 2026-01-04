@extends('dashboard.layout')

@section('title', 'kalendr | Agenda')

@section('content')

    <div class="flex flex-col gap-4 bg-red w-full lg:max-w-[80%] h-96">
        <div class="flex justify-between w-full">
            <h1 class="font-semibold text-xl md:text-2xl">Daftar Agenda</h1>
            <button
                class="flex justify-center items-center gap-2 bg-black hover:bg-gray-800 px-3 py-2 rounded-md font-medium text-white text-sm md:text-base transition-all duration-200"
                onclick="window.location.href = '{{ route('event-types.create') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 md:size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Agenda
            </button>
        </div>
        <div class="gap-2 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full">
            @foreach ($agendas as $agenda)
                <div class="group relative bg-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-5 border rounded-md transition-all duration-300 ease-out cursor-pointer"
                    onclick="window.location.href='/event-types/{{ $agenda['id'] }}/edit'">

                    <div class="flex justify-between items-start mb-6">
                        <div
                            class="bg-slate-50 group-hover:bg-black p-2.5 rounded-xl group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                            </svg>
                        </div>

                        <div
                            class="flex items-center gap-1.5 px-3 py-1 rounded-full border {{ $agenda->is_active ? 'border-emerald-100 bg-emerald-50/50' : 'border-slate-100 bg-slate-50' }}">
                            <span
                                class="size-1.5 rounded-full {{ $agenda->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                            <span
                                class="text-[11px] font-bold uppercase tracking-wider {{ $agenda->is_active ? 'text-emerald-700' : 'text-slate-500' }}">
                                {{ $agenda->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <h3
                            class="font-semibold text-slate-900 group-hover:text-black text-xl tracking-tight transition-colors">
                            {{ $agenda->name }}
                        </h3>
                        <div class="flex items-center gap-3 text-slate-500 text-sm">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="size-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span>{{ $agenda->duration_minutes }}m</span>
                            </div>
                            <span class="text-slate-300">|</span>
                            @php
                                $tzMap = [
                                    'Asia/Jakarta' => 'WIB',
                                    'Asia/Makassar' => 'WITA',
                                    'Asia/Jayapura' => 'WIT',
                                ];
                            @endphp
                            <span>{{ $tzMap[$agenda->timezone] ?? $agenda->timezone }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6 pt-4 border-slate-50 border-t">
                        <span class="font-medium text-slate-400 group-hover:text-slate-600 text-xs transition-colors">Edit
                            Agenda</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor"
                            class="opacity-0 group-hover:opacity-100 size-4 text-slate-300 transition-all -translate-x-2 group-hover:translate-x-0 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($agendas->isEmpty())
            <div class="flex flex-col justify-center items-center py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor" class="mb-4 w-16 h-16 text-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                </svg>
                <p class="text-gray-500 text-sm">Belum ada agenda</p>
                <p class="mt-1 text-gray-400 text-xs">Buat agenda pertama Anda untuk mulai menerima booking</p>
            </div>
        @endif
        <div class="flex flex-col gap-4 mt-4 pb-2 md:pb-4 w-full">
            <h2 class="font-semibold text-lg">Janji Diterima</h2>
            @foreach ($bookings as $booking)
                <div
                    class="flex justify-between items-center bg-white hover:shadow-sm p-4 border border-gray-200 rounded-md w-full transition-shadow duration-300">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span
                                class="font-medium text-gray-400 text-sm tracking-wide">{{ $booking->eventType->name }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-base tracking-tight">{{ $booking->guest_name }}</h3>
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
                </div>
            @endforeach
        </div>
    </div>
@endsection
