<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $eventType->name }} - {{ $eventType->user->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex justify-center md:items-center bg-gray-100 md:p-4 min-h-screen">

    <div class="bg-white mx-auto md:border-2 md:rounded-lg w-full max-w-6xl overflow-hidden" x-data="bookingCalendar(@js($displaySlots))">

        <div class="flex md:flex-row flex-col">

            <div class="p-8 border-gray-100 md:border-r-2 border-b-2 md:border-b-0 transition-all duration-300 ease-in-out"
                :class="selectedDate ? 'md:w-[20%]' : 'md:w-1/3'">

                <div class="mb-4 font-medium text-gray-500 text-sm">
                    {{ $eventType->user->name }}
                </div>

                <h1 class="mb-4 font-bold text-gray-900 text-2xl leading-tight">
                    {{ $eventType->name }}
                </h1>

                <div class="space-y-3 mb-6 text-gray-500">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ $eventType->duration_minutes }} menit</span>
                    </div>
                </div>

                @if ($eventType->description)
                    <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $eventType->description }}
                    </div>
                @endif
            </div>

            <div class="relative p-8 min-h-[500px] transition-all duration-300 ease-in-out"
                :class="selectedDate ? 'md:w-[80%]' : 'md:w-2/3'">

                <h2 class="mb-6 font-bold text-xl">Pilih Tanggal & Waktu</h2>

                <div class="flex md:flex-row flex-col gap-8">

                    <div class="flex-1" :class="{ 'md:max-w-md': selectedDate, 'w-full': !selectedDate }">

                        <div class="flex justify-between items-center mb-6">
                            <span class="font-medium text-lg" x-text="currentMonthName + ' ' + currentYear"></span>
                            <div class="flex gap-2">
                                <button @click="prevMonth" class="hover:bg-gray-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button @click="nextMonth" class="hover:bg-gray-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 mb-2 font-semibold text-gray-400 text-xs text-center uppercase">
                            <div>Min</div>
                            <div>Sen</div>
                            <div>Sel</div>
                            <div>Rab</div>
                            <div>Kam</div>
                            <div>Jum</div>
                            <div>Sab</div>
                        </div>

                        <div class="gap-1 grid grid-cols-7 text-center">
                            <template x-for="day in calendarDays" :key="day.dateString">
                                <div>
                                    <button x-show="day.dayOfMonth" @click="selectDate(day)" :disabled="!day.hasSlots"
                                        class="flex justify-center items-center mx-auto rounded-full w-10 h-10 font-medium text-sm transition-colors"
                                        :class="{
                                            'bg-black text-white': isSelected(day),
                                            'bg-gray-100 font-bold hover:border hover:border-black cursor-pointer text-gray-900': day
                                                .hasSlots && !isSelected(day),
                                            'text-gray-400 cursor-default': !day.hasSlots && day.dayOfMonth,
                                        }">
                                        <span x-text="day.dayOfMonth"></span>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="mt-8 text-gray-500 text-sm">
                            <label for="timezone" class="block mb-1 text-xs uppercase tracking-wide">Zona Waktu</label>
                            <select id="timezone" x-model="currentTz" @change="changeTimezone"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5">
                                @foreach ($timezones as $tzId => $tzName)
                                    <option value="{{ $tzId }}">{{ $tzName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="md:w-48" x-show="selectedDate" x-cloak>
                        <div class="mb-4 font-medium text-gray-900" x-text="formatDateHuman(selectedDate)"></div>

                        <div
                            class="space-y-2 md:space-y-3 bg-gray-100 p-2 border rounded-md max-h-[400px] overflow-y-auto">
                            <template x-for="slot in availableSlotsInSelectedDate" :key="slot.starts_at_viewer">
                                <button @click="selectedSlot = slot.starts_at_viewer"
                                    class="py-3 border rounded w-full font-semibold transition-colors duration-200"
                                    :class="{
                                        'bg-black text-white border-black': selectedSlot === slot.starts_at_viewer,
                                        'bg-white text-gray-900 border-gray-200 hover:border-black': selectedSlot !==
                                            slot.starts_at_viewer
                                    }">
                                    <span x-text="formatTime(slot.starts_at_viewer)"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Booking Form (Right Side / Overlay) -->
                    <div class="md:w-[300px]" x-show="selectedSlot" x-transition x-cloak>
                        <div class="mb-6">
                            <button @click="selectedSlot = null"
                                class="flex items-center gap-2 mb-4 text-gray-500 hover:text-gray-900 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Batal
                            </button>
                            <h3 class="mb-1 font-bold text-gray-900 text-xl">Konfirmasi Reservasi</h3>
                            <div class="mb-6 text-gray-600">
                                <span x-text="formatDateHuman(selectedDate)"></span><br>
                                <span class="font-medium text-gray-900"
                                    x-text="formatTime(selectedSlot) + ' - ' + formatTime(getEndTime(selectedSlot))"></span>
                            </div>

                            <form action="/{{ $eventType->user->username }}/{{ $eventType->slug }}/book" method="POST"
                                class="space-y-4">
                                @csrf
                                <input type="hidden" name="starts_at_utc" :value="getSlotUtc(selectedSlot)">
                                <input type="hidden" name="guest_timezone" value="{{ $viewerTz }}">

                                <div>
                                    <label class="block mb-1 font-medium text-gray-700 text-sm">Name</label>
                                    <input type="text" name="guest_name" required
                                        class="shadow-sm border-gray-300 focus:border-black rounded-md focus:ring-black w-full">
                                </div>

                                <div>
                                    <label class="block mb-1 font-medium text-gray-700 text-sm">Email</label>
                                    <input type="email" name="guest_email" required
                                        class="shadow-sm border-gray-300 focus:border-black rounded-md focus:ring-black w-full">
                                </div>

                                <button type="submit"
                                    class="bg-black hover:bg-gray-800 py-3 rounded-lg w-full font-medium text-white transition-colors">
                                    Konfirmasi
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function bookingCalendar(slots) {
            return {
                today: new Date(),
                currentDate: new Date(),
                selectedDate: null,
                selectedSlot: null, // Track the selected time
                currentTz: '{{ $viewerTz }}',
                slots: slots,

                changeTimezone() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('timezone', this.currentTz);
                    window.location.href = url.toString();
                },

                init() {
                    this.slotsByDate = this.slots.reduce((acc, slot) => {
                        const date = slot.starts_at_viewer.split('T')[0];
                        acc[date] = acc[date] || [];
                        acc[date].push(slot);
                        return acc;
                    }, {});
                },

                get currentMonthName() {
                    return this.currentDate.toLocaleString('id-ID', {
                        month: 'long'
                    });
                },

                get currentYear() {
                    return this.currentDate.getFullYear();
                },

                get calendarDays() {
                    const year = this.currentDate.getFullYear();
                    const month = this.currentDate.getMonth();
                    const firstDay = new Date(year, month, 1);
                    const lastDay = new Date(year, month + 1, 0);

                    let days = [];
                    for (let i = 0; i < firstDay.getDay(); i++) {
                        days.push({
                            dayOfMonth: null,
                            dateString: `empty-${i}`
                        });
                    }

                    for (let i = 1; i <= lastDay.getDate(); i++) {
                        const date = new Date(year, month, i);
                        const ymd = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                        days.push({
                            dayOfMonth: i,
                            dateString: ymd,
                            hasSlots: !!this.slotsByDate[ymd]
                        });
                    }
                    return days;
                },

                get availableSlotsInSelectedDate() {
                    return this.slotsByDate[this.selectedDate] || [];
                },

                prevMonth() {
                    this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
                },

                nextMonth() {
                    this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
                },

                selectDate(day) {
                    if (day.hasSlots) {
                        this.selectedDate = day.dateString;
                        this.selectedSlot = null; // Reset time selection when date changes
                    }
                },

                isSelected(day) {
                    return this.selectedDate === day.dateString;
                },

                formatDateHuman(dateString) {
                    // dateString is typically YYYY-MM-DD from the calendar loop
                    // But wait, the calendar days are generated from local server time or what?
                    // The calendar generation logic in JS `days` loop uses `new Date(year, month, i)`. 
                    // This creates dates in browser local time.
                    // However, `selectedDate` is a string "YYYY-MM-DD".
                    // When we display it, we just want to format YYYY-MM-DD into "Monday, 29 December".
                    // We can just append a time and use the TZ.
                    return new Date(dateString + 'T00:00:00').toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        // timeZone: this.currentTz // Not strictly necessary for just date if we parse correctly, but safer
                    });
                },

                formatTime(iso) {
                    return new Date(iso).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        timeZone: this.currentTz
                    });
                },

                getEndTime(startIso) {
                    // This is just for display purposes, precise calculation is on backend
                    const d = new Date(startIso);
                    d.setMinutes(d.getMinutes() + {{ $eventType->duration_minutes }});
                    return d.toISOString();
                },

                getSlotUtc(startIso) {
                    // find the slot object to get the UTC value
                    const slot = this.slots.find(s => s.starts_at_viewer === startIso);
                    return slot ? slot.starts_at_utc : '';
                }
            }
        }
    </script>

</body>

</html>
