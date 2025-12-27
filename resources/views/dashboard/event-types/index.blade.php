@extends('dashboard.layout')

@section('title', 'kalendr | Agenda')

@section('content')
    <div class="flex flex-col gap-4 bg-red w-full lg:max-w-[80%] h-96">
        <div class="flex justify-between items-center w-full">
            <div></div>
            <button
                class="flex gap-2 bg-black hover:bg-gray-800 px-3 py-2 rounded-md font-medium text-white text-base transition-all duration-200"
                onclick="window.location.href = '/event-types/create'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Agenda
            </button>
        </div>
        <div class="gap-2 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full">
            @foreach ($agendas as $agenda)
                <div class="flex flex-col justify-between bg-white hover:shadow-md p-5 border rounded-md h-48 hover:scale-[102%] transition-all duration-200 cursor-pointer"
                    onclick="window.location.href='/event-types/{{ $agenda['id'] }}/edit'">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                        </svg>
                        <h3 class="font-medium text-xl">{{ $agenda['name'] }}</h3>
                    </div>
                    <div class="flex flex-col gap-2 h-fit">
                        <div class="flex items-center gap-2">
                            <span
                                class="rounded-full size-2 {{ $agenda['is_active'] ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                            <p class="text-gray-400 text-sm">{{ $agenda['is_active'] ? 'Aktif' : 'Tidak Aktif' }}</p>
                        </div>
                        <p class="text-sm">Durasi: {{ $agenda['duration_minutes'] }} menit</p>
                        <p class="text-sm">Zona Waktu: {{ $agenda['timezone'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
