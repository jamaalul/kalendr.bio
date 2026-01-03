@extends('dashboard.layout')

@section('title', 'kalendr | Libur')

@section('content')

    <div class="flex flex-col gap-4 w-full lg:max-w-[80%]">
        <div class="flex justify-between items-center w-full">
            <h1 class="font-semibold text-xl md:text-2xl">Tanggal Libur</h1>
            <a href="{{ route('exceptions.create') }}"
                class="flex items-center gap-2 bg-black hover:bg-gray-800 shadow-sm px-4 py-2 rounded-lg font-medium text-white text-sm active:scale-95 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Libur
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-md p-4 text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col gap-4 mt-4 pb-2 md:pb-4 w-full">
            @forelse ($exceptions as $exception)
                <div
                    class="flex justify-between items-center bg-white hover:shadow-sm p-4 border border-gray-200 rounded-md w-full transition-shadow duration-300">
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <div class="flex flex-col">
                                @if ($exception->start_datetime->isSameDay($exception->end_datetime))
                                    <span class="font-semibold text-gray-900 text-base">
                                        {{ $exception->start_datetime->translatedFormat('l, d F Y') }}
                                    </span>
                                    <span class="text-gray-500 text-sm">
                                        {{ $exception->start_datetime->format('H:i') }} — {{ $exception->end_datetime->format('H:i') }}
                                    </span>
                                @else
                                    <span class="font-semibold text-gray-900 text-base">
                                        {{ $exception->start_datetime->translatedFormat('d M Y') }}, {{ $exception->start_datetime->format('H:i') }}
                                        —
                                        {{ $exception->end_datetime->translatedFormat('d M Y') }}, {{ $exception->end_datetime->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if ($exception->reason)
                            <p class="font-medium text-gray-500 text-sm italic pl-8">{{ $exception->reason }}</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('exceptions.edit', $exception) }}"
                            class="hover:bg-gray-100 p-2 rounded-lg transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <form action="{{ route('exceptions.destroy', $exception) }}" method="POST"
                            onsubmit="return confirm('Hapus tanggal libur ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:bg-red-100 p-2 rounded-lg transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                        stroke="currentColor" class="w-16 h-16 text-gray-300 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada tanggal libur</p>
                    <p class="text-gray-400 text-xs mt-1">Tambahkan tanggal untuk memblokir slot booking</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
