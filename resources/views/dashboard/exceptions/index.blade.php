@extends('dashboard.layout')

@section('title', 'kalendr | Libur')

@section('content')

    <div class="flex flex-col gap-4 w-full lg:max-w-[80%]">
        <div class="flex justify-between items-center w-full">
            <h1 class="font-semibold text-xl md:text-2xl">Tanggal Libur</h1>
            <a href="{{ route('exceptions.create') }}"
                class="flex items-center gap-2 bg-black hover:bg-gray-800 shadow-sm px-4 py-2 rounded-lg font-medium text-white text-sm active:scale-95 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Libur
            </a>
        </div>

        <div class="flex flex-col gap-4 mt-4 pb-2 md:pb-4 w-full">
            @forelse ($exceptions as $exception)
                <div
                    class="group relative flex sm:flex-row flex-col justify-between sm:items-center gap-4 bg-white hover:shadow-sm p-4 border border-gray-200 hover:border-gray-300 rounded-xl transition-all duration-200">

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-gray-400 group-hover:text-gray-600 transition-colors">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex sm:flex-row flex-col sm:items-baseline gap-1 sm:gap-2">
                                @if ($exception->start_datetime->isSameDay($exception->end_datetime))
                                    <span class="font-medium text-[15px] text-gray-900 leading-none">
                                        {{ $exception->start_datetime->translatedFormat('l, d F Y') }}
                                    </span>
                                    <span class="font-normal text-gray-400 text-sm">
                                        {{ $exception->start_datetime->format('H:i') }} —
                                        {{ $exception->end_datetime->format('H:i') }}
                                    </span>
                                @else
                                    <div class="flex items-center gap-2 font-medium text-[15px] text-gray-900 leading-none">
                                        <span>{{ $exception->start_datetime->translatedFormat('d M Y, H:i') }}</span>
                                        <span class="font-light text-gray-300">→</span>
                                        <span>{{ $exception->end_datetime->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                @endif
                            </div>

                            @if ($exception->reason)
                                <div class="flex items-center gap-2">
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $exception->reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-1 sm:opacity-0 group-hover:opacity-100 ml-auto transition-opacity">
                        <a href="{{ route('exceptions.edit', $exception) }}"
                            class="inline-flex justify-center items-center hover:bg-gray-100 rounded-md w-8 h-8 text-gray-500 hover:text-gray-900 transition-colors"
                            title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                <path d="m15 5 4 4" />
                            </svg>
                        </a>

                        <form action="{{ route('exceptions.destroy', $exception) }}" method="POST"
                            onsubmit="return confirm('Hapus tanggal libur ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex justify-center items-center hover:bg-red-50 rounded-md w-8 h-8 text-gray-400 hover:text-red-600 transition-colors"
                                title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" y1="11" x2="10" y2="17" />
                                    <line x1="14" y1="11" x2="14" y2="17" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="flex flex-col justify-center items-center py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                        stroke="currentColor" class="mb-4 w-16 h-16 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada tanggal libur</p>
                    <p class="mt-1 text-gray-400 text-xs">Tambahkan tanggal untuk memblokir slot booking</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
