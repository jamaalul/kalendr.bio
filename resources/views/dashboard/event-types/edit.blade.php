@extends('dashboard.layout')

@section('title', 'kalendr | Edit Agenda')

@section('content')
    <div class="flex flex-col gap-4 w-full lg:max-w-[80%]">
        <div class="bg-white p-6 border rounded-md">
            <h2 class="mb-4 font-medium text-xl">Edit Agenda</h2>
            <form method="POST" action="/event-types/{{ $eventType->id }}" class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block font-medium text-gray-700 text-sm">Nama Agenda</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', $eventType->name) }}"
                        class="block shadow-sm mt-1 px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-indigo-500 w-full"
                        required maxlength="255">
                    @error('name')
                        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="duration_minutes" class="block font-medium text-gray-700 text-sm">Durasi
                        (menit)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" min="5"
                        max="480"
                        value="{{ old('duration_minutes', $eventType->duration_minutes) }}"
                        class="block shadow-sm mt-1 px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-indigo-500 w-full"
                        required>
                    @error('duration_minutes')
                        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="timezone" class="block font-medium text-gray-700 text-sm">Zona Waktu</label>
                    <select name="timezone" id="timezone"
                        class="block shadow-sm mt-1 px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-indigo-500 w-full"
                        required>
                        @foreach ([
        'Asia/Jakarta' => 'Waktu Indonesia Barat (WIB)',
        'Asia/Makassar' => 'Waktu Indonesia Tengah (WITA)',
        'Asia/Jayapura' => 'Waktu Indonesia Timur (WIT)',
    ] as $tzId => $tzName)
                            <option value="{{ $tzId }}"
                                {{ old('timezone', $eventType->timezone) === $tzId ? 'selected' : '' }}>
                                {{ $tzName }}
                            </option>
                        @endforeach
                    </select>
                    @error('timezone')
                        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="is_active" class="flex items-center gap-2 cursor-pointer p-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $eventType->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                        <span class="font-medium text-gray-700 text-sm">Aktifkan Agenda</span>
                    </label>
                    <p class="mt-1 text-gray-500 text-sm">Agenda yang tidak aktif tidak akan dapat dibooking oleh orang lain.</p>
                    @error('is_active')
                        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                @include('dashboard.event-types._availability-fields')

                <div class="flex gap-2">
                    <button type="submit"
                        class="flex self-start gap-2 bg-black hover:bg-gray-800 px-3 py-2 rounded-md font-medium text-white text-base transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="/event-types"
                        class="flex self-start gap-2 bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md font-medium text-gray-700 text-base transition-all duration-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
