@extends('dashboard.layout')

@section('title', 'kalendr | Dashboard')

@section('content')
    <div class="flex flex-col lg:flex-row gap-8 w-full max-w-[95%]">
        
        {{-- Left Column: Calendar --}}
        <div class="flex flex-col gap-6 w-full lg:w-2/3">
            <div class="flex justify-between items-center">
                <h1 class="font-semibold text-gray-900 text-xl md:text-2xl">Kalender Saya</h1>
            </div>

            <div class="bg-white shadow-sm p-6 border rounded-xl w-full text-black" 
                 x-data="calendar()" 
                 x-init="initCalendar()">
                 
                {{-- Calendar Header --}}
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <span x-text="monthNames[month]" class="font-bold text-gray-800 text-lg"></span>
                        <span x-text="year" class="ml-1 font-normal text-gray-600 text-lg"></span>
                    </div>
                    <div class="flex items-center gap-2 border-gray-200 border rounded-lg px-1 py-1">
                        <button 
                            type="button"
                            class="hover:bg-gray-100 p-1 rounded-md text-gray-600 transition-colors cursor-pointer leading-none inline-flex items-center justify-center p-1.5" 
                            @click="month--; if(month < 0) { month = 11; year--; } getNoOfDays()">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>  
                        </button>
                        <button 
                            type="button"
                            class="hover:bg-gray-100 p-1 rounded-md text-gray-600 transition-colors cursor-pointer leading-none inline-flex items-center justify-center p-1.5" 
                            @click="month++; if(month > 11) { month = 0; year++; } getNoOfDays()">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Weekdays --}}
                <div class="grid grid-cols-7 mb-2 text-center">
                    <template x-for="(day, index) in days" :key="index">
                        <div class="py-2">
                            <span x-text="day" class="font-medium text-gray-500 text-xs uppercase tracking-wide"></span>
                        </div>
                    </template>
                </div>

                {{-- Days --}}
                <div class="grid grid-cols-7 gap-1">
                    {{-- Empty slots for previous month --}}
                    <template x-for="blank in blankdays">
                        <div class="p-2 md:h-24 h-16 text-center border border-transparent"></div>
                    </template>

                    {{-- Days of current month --}}
                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                        <div class="relative bg-white hover:bg-gray-50 p-1 md:p-2 border border-gray-100 rounded-lg md:h-28 h-20 transition-colors group">
                            {{-- Date Number --}}
                            <span x-text="date" 
                                  class="flex justify-center items-center rounded-full w-6 h-6 font-medium text-sm"
                                  :class="isToday(date) ? 'bg-black text-white' : 'text-gray-700'"></span>

                            {{-- Events Dots/List --}}
                            <div class="flex flex-col gap-1 mt-1 overflow-y-auto max-h-[calc(100%-1.5rem)] no-scrollbar">
                                <template x-for="event in getEvents(date)">
                                    <div class="px-1.5 py-0.5 rounded text-[10px] md:text-xs truncate cursor-pointer"
                                         :class="getEventColor(event.status)"
                                         @click.stop="showEventDetails(event)">
                                        <span x-text="formatTime(event.starts_at)" class="font-semibold opacity-75"></span>
                                        <span x-text="event.guest_name"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            {{-- Selected Event Modal (Simple implementation) --}}
            <div x-show="selectedEvent" 
                 class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50 backdrop-blur-sm"
                 x-transition.opacity
                 style="display: none;">
                 
                <div class="bg-white shadow-xl p-6 rounded-xl w-full max-w-md" @click.away="selectedEvent = null">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-bold text-xl" x-text="selectedEvent?.guest_name"></h3>
                        <button @click="selectedEvent = null" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="flex justify-center items-center bg-gray-100 rounded-full w-8 h-8 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Event Type</p>
                                <p class="font-medium text-sm" x-text="selectedEvent?.event_name"></p>
                            </div>
                         </div>

                        <div class="flex items-center gap-3">
                            <div class="flex justify-center items-center bg-gray-100 rounded-full w-8 h-8 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Waktu</p>
                                <p class="font-medium text-sm">
                                    <span x-text="formatDate(selectedEvent?.starts_at)"></span>, 
                                    <span x-text="formatTime(selectedEvent?.starts_at) + ' - ' + formatTime(selectedEvent?.ends_at)"></span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex justify-center items-center bg-gray-100 rounded-full w-8 h-8 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                             <div>
                                <p class="text-gray-500 text-xs">Email</p>
                                <p class="font-medium text-sm" x-text="selectedEvent?.guest_email"></p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium text-xs" :class="getEventColor(selectedEvent?.status)">
                            <span x-text="selectedEvent?.status"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Action Items --}}
        <div class="flex flex-col gap-8 w-full lg:w-1/3">
            
            {{-- Unaccepted Bookings --}}
            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-gray-900 text-lg">Perlu Persetujuan</h2>
                    @if($unacceptedBookings->count() > 0)
                        <span class="bg-red-500 px-2 py-0.5 rounded-full font-bold text-white text-xs">{{ $unacceptedBookings->count() }}</span>
                    @endif
                </div>
                
                <div class="flex flex-col gap-3">
                    @forelse($unacceptedBookings as $booking)
                        <div class="flex flex-col gap-3 bg-white hover:shadow-md p-4 border border-gray-200 rounded-xl transition-all duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $booking->guest_name }}</h3>
                                    <p class="text-gray-500 text-xs">{{ $booking->eventType->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900 text-xs">
                                        {{ \Carbon\Carbon::parse($booking->starts_at)->setTimezone($booking->eventType->timezone)->format('d M') }}
                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        {{ \Carbon\Carbon::parse($booking->starts_at)->setTimezone($booking->eventType->timezone)->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 mt-1">
                                <form action="{{ route('booking.accept') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $booking->id }}">
                                    <button type="submit" class="flex justify-center items-center bg-black hover:bg-gray-800 py-1.5 rounded-lg w-full font-medium text-white text-xs transition-colors">
                                        Terima
                                    </button>
                                </form>
                                <form action="{{ route('booking.reject') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $booking->id }}">
                                    <button type="submit" class="flex justify-center items-center hover:bg-red-50 py-1.5 border border-red-200 hover:border-red-300 rounded-lg w-full font-medium text-red-600 text-xs transition-colors">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-gray-400 text-sm italic">
                            Tidak ada janji yang menunggu persetujuan.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Cancellation Proposals --}}
            <div class="flex flex-col gap-4">
                 <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-gray-900 text-lg">Permintaan Pembatalan</h2>
                     @if($cancellationProposals->count() > 0)
                        <span class="bg-orange-500 px-2 py-0.5 rounded-full font-bold text-white text-xs">{{ $cancellationProposals->count() }}</span>
                    @endif
                </div>

                <div class="flex flex-col gap-3">
                    @forelse($cancellationProposals as $booking)
                        <div class="flex flex-col gap-3 bg-red-50 hover:shadow-md p-4 border border-red-100 rounded-xl transition-all duration-200">
                             <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $booking->guest_name }}</h3>
                                    <p class="text-gray-500 text-xs">Ingin membatalkan: {{ $booking->eventType->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900 text-xs">
                                        {{ \Carbon\Carbon::parse($booking->starts_at)->setTimezone($booking->eventType->timezone)->format('d M') }}
                                    </p>
                                     <p class="text-gray-500 text-xs">
                                        {{ \Carbon\Carbon::parse($booking->starts_at)->setTimezone($booking->eventType->timezone)->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                             <div class="grid grid-cols-2 gap-2 mt-1">
                                <form action="{{ route('booking.accept') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $booking->id }}">
                                    <button type="submit" class="flex justify-center items-center bg-red-600 hover:bg-red-700 py-1.5 rounded-lg w-full font-medium text-white text-xs transition-colors">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('booking.reject') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $booking->id }}">
                                    <button type="submit" class="flex justify-center items-center hover:bg-white py-1.5 border border-gray-300 rounded-lg w-full font-medium text-gray-700 text-xs transition-colors">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                         <div class="py-8 text-center text-gray-400 text-sm italic">
                            Tidak ada permintaan pembatalan.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- Script for Calendar Logic --}}
    <script>
        function calendar() {
            return {
                month: '',
                year: '',
                no_of_days: [],
                blankdays: [],
                days: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'], // Indonesian days
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                @php
                    $eventsData = $bookings->map(function($booking) {
                        return [
                            'id' => $booking->id,
                            'guest_name' => $booking->guest_name,
                            'guest_email' => $booking->guest_email,
                            'event_name' => $booking->eventType->name,
                            'starts_at' => \Carbon\Carbon::parse($booking->starts_at)->setTimezone($booking->eventType->timezone)->toIso8601String(),
                            'ends_at' => \Carbon\Carbon::parse($booking->ends_at)->setTimezone($booking->eventType->timezone)->toIso8601String(),
                            'date' => \Carbon\Carbon::parse($booking->starts_at)->setTimezone($booking->eventType->timezone)->format('Y-m-d'),
                            'status' => $booking->status
                        ];
                    });
                @endphp
                events: @json($eventsData),
                selectedEvent: null,

                initCalendar() {
                    let today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.getNoOfDays();
                },

                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);
                    return today.toDateString() === d.toDateString();
                },

                getEvents(date) {
                    let dateString = new Date(this.year, this.month, date).toLocaleDateString('en-CA'); // YYYY-MM-DD
                    return this.events.filter(e => e.date.startsWith(dateString));
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                    let dayOfWeek = new Date(this.year, this.month).getDay();

                    let blankdaysArray = [];
                    for (var i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                },
                
                getEventColor(status) {
                    if (status === 'accepted') return 'bg-green-100 text-green-800 border-green-200';
                    if (status === 'completed') return 'bg-gray-100 text-gray-800 border-gray-200';
                    return 'bg-blue-100 text-blue-800 border-blue-200';
                },
                
                formatTime(isoString) {
                    if(!isoString) return '';
                    const date = new Date(isoString);
                    return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                },

                formatDate(isoString) {
                    if(!isoString) return '';
                    const date = new Date(isoString);
                    return date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                },
                
                showEventDetails(event) {
                    this.selectedEvent = event;
                }
            }
        }
    </script>
@endsection
