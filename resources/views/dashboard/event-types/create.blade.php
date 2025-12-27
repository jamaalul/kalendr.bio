@extends('dashboard.layout')

@section('title', 'kalendr | Buat Agenda')

@section('content')
    <div class="flex flex-col gap-6 mx-auto w-full md:w-[80%]">
        <!-- Main Form Card -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-gray-200 border-b">
                <h2 class="font-semibold text-gray-900 text-xl">Buat Agenda Baru</h2>
                <p class="mt-1 text-gray-600 text-sm">Isi detail agenda dan atur ketersediaan Anda.</p>
            </div>

            <form method="POST" action="/event-types" class="space-y-6 p-6">
                @csrf

                <!-- Basic Information Section -->
                <div class="space-y-4">
                    <h3 class="pb-2 border-gray-100 border-b font-medium text-gray-900 text-lg">Informasi Dasar</h3>

                    <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
                        <div>
                            <label for="name" class="block mb-1 font-medium text-gray-700 text-sm">
                                <svg class="inline mr-1 w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                Nama Agenda
                            </label>
                            <input type="text" name="name" id="name"
                                class="block shadow-sm px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full sm:text-sm"
                                required maxlength="255" placeholder="Masukkan nama agenda">
                        </div>

                        <div>
                            <label for="duration_minutes" class="block mb-1 font-medium text-gray-700 text-sm">
                                <svg class="inline mr-1 w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Durasi (menit)
                            </label>
                            <input type="number" name="duration_minutes" id="duration_minutes" min="5"
                                max="480"
                                class="block shadow-sm px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full sm:text-sm"
                                required placeholder="30">
                        </div>
                    </div>

                    <div>
                        <label for="timezone" class="block mb-1 font-medium text-gray-700 text-sm">
                            <svg class="inline mr-1 w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064">
                                </path>
                            </svg>
                            Zona Waktu
                        </label>
                        <input type="text" name="timezone" id="timezone" value="Asia/Jakarta"
                            class="block shadow-sm px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full sm:text-sm"
                            required placeholder="Asia/Jakarta">
                    </div>
                </div>

                <!-- Availability Section -->
                <div class="space-y-4">
                    <h3 class="pb-2 border-gray-100 border-b font-medium text-gray-900 text-lg">Ketersediaan</h3>
                    @php
                        $availabilitiesByDay = [];
                    @endphp
                    @include('dashboard.event-types._availability-fields')
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4 border-gray-200 border-t">
                    <button type="submit"
                        class="inline-flex items-center bg-black hover:bg-gray-800 px-4 py-2 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 font-medium text-white text-sm transition-colors duration-200">
                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.5v15m7.5-7.5h-15"></path>
                        </svg>
                        Buat Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
