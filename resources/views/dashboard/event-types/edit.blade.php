@extends('dashboard.layout')

@section('title', 'kalendr | Edit Agenda')

@section('content')
    <div class="flex flex-col gap-4 w-full lg:max-w-[80%]">
        <div class="flex items-center gap-4 w-full">
            <a href="/event-types" class="hover:bg-gray-100 p-2 rounded-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
            <h1 class="font-semibold text-xl md:text-2xl">Edit Agenda</h1>
        </div>

        <form method="POST" action="/event-types/{{ $eventType->id }}"
            class="flex flex-col gap-6 bg-white mt-4 p-6 border border-gray-200 rounded-lg">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block font-medium text-gray-700 text-sm">Nama Agenda</label>
                <input type="text" name="name" id="name" value="{{ old('name', $eventType->name) }}"
                    class="px-4 py-2 border border-gray-300 focus:border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-black w-full"
                    required maxlength="255">
                @error('name')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="duration_minutes" class="block font-medium text-gray-700 text-sm">Durasi
                    (menit)</label>
                <input type="number" name="duration_minutes" id="duration_minutes" min="5" max="480"
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
            <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
                <div>
                    <label for="minimum_notice_minutes" class="block font-medium text-gray-700 text-sm">Waktu Pemberitahuan
                        Minimum (menit)</label>
                    <input type="number" name="minimum_notice_minutes" id="minimum_notice_minutes" min="0"
                        value="{{ old('minimum_notice_minutes', $eventType->minimum_notice_minutes) }}"
                        class="block shadow-sm mt-1 px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-indigo-500 w-full"
                        placeholder="Misal: 240 (4 jam)">
                    @error('minimum_notice_minutes')
                        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="before_slot_padding_minutes" class="block font-medium text-gray-700 text-sm">Gap Sebelum
                        (menit)</label>
                    <input type="number" name="before_slot_padding_minutes" id="before_slot_padding_minutes" min="0"
                        value="{{ old('before_slot_padding_minutes', $eventType->before_slot_padding_minutes) }}"
                        class="block shadow-sm mt-1 px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-indigo-500 w-full"
                        placeholder="Misal: 15">
                    @error('before_slot_padding_minutes')
                        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="after_slot_padding_minutes" class="block font-medium text-gray-700 text-sm">Gap Sesudah
                        (menit)</label>
                    <input type="number" name="after_slot_padding_minutes" id="after_slot_padding_minutes" min="0"
                        value="{{ old('after_slot_padding_minutes', $eventType->after_slot_padding_minutes) }}"
                        class="block shadow-sm mt-1 px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-indigo-500 w-full"
                        placeholder="Misal: 15">
                    @error('after_slot_padding_minutes')
                        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="is_active" class="flex items-center gap-2 p-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active', $eventType->is_active) ? 'checked' : '' }}
                        class="border-gray-300 rounded focus:ring-black w-4 h-4 text-black">
                    <span class="font-medium text-gray-700 text-sm">Aktifkan Agenda</span>
                </label>
                <p class="mt-1 text-gray-500 text-sm">Agenda yang tidak aktif tidak akan dapat dibooking oleh orang
                    lain.</p>
                @error('is_active')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            @include('dashboard.event-types._availability-fields')

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="/event-types"
                    class="hover:bg-gray-100 px-5 py-2 rounded-lg font-medium text-gray-600 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="bg-black hover:bg-gray-800 shadow-sm px-5 py-2 rounded-lg font-medium text-white text-sm active:scale-95 transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
    </div>
@endsection
