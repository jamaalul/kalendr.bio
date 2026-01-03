@extends('dashboard.layout')

@section('title', 'kalendr | Edit Libur')

@section('content')

    <div class="flex flex-col gap-4 w-full lg:max-w-[80%]">
        <div class="flex items-center gap-4 w-full">
            <a href="{{ route('exceptions.index') }}" class="hover:bg-gray-100 p-2 rounded-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
            <h1 class="font-semibold text-xl md:text-2xl">Edit Tanggal Libur</h1>
        </div>

        <form action="{{ route('exceptions.update', $exception) }}" method="POST"
            class="flex flex-col gap-6 mt-4 bg-white border border-gray-200 rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="start_date" class="font-medium text-gray-700 text-sm">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date"
                        value="{{ old('start_date', $exception->start_datetime->format('Y-m-d')) }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent @error('start_date') border-red-500 @enderror"
                        required>
                    @error('start_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="start_time" class="font-medium text-gray-700 text-sm">Waktu Mulai</label>
                    <input type="time" name="start_time" id="start_time"
                        value="{{ old('start_time', $exception->start_datetime->format('H:i')) }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent @error('start_time') border-red-500 @enderror"
                        required>
                    @error('start_time')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="end_date" class="font-medium text-gray-700 text-sm">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date"
                        value="{{ old('end_date', $exception->end_datetime->format('Y-m-d')) }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent @error('end_date') border-red-500 @enderror"
                        required>
                    @error('end_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="end_time" class="font-medium text-gray-700 text-sm">Waktu Selesai</label>
                    <input type="time" name="end_time" id="end_time"
                        value="{{ old('end_time', $exception->end_datetime->format('H:i')) }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent @error('end_time') border-red-500 @enderror"
                        required>
                    @error('end_time')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="reason" class="font-medium text-gray-700 text-sm">Alasan (opsional)</label>
                <input type="text" name="reason" id="reason" value="{{ old('reason', $exception->reason) }}"
                    placeholder="Contoh: Tahun Baru, Cuti, Sakit"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent @error('reason') border-red-500 @enderror">
                @error('reason')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('exceptions.index') }}"
                    class="px-5 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="bg-black hover:bg-gray-800 shadow-sm px-5 py-2 rounded-lg font-medium text-white text-sm active:scale-95 transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
