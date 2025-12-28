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

            <div class="p-8 border-gray-100 md:border-r-2 border-b-2 md:border-b-0 md:w-1/3">

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

            <div class="relative p-8 md:w-2/3 min-h-[500px]">

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
                            Zona Waktu: <span class="font-medium text-gray-700">{{ $viewerTz }}</span>
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
                slots: slots,

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
                    return new Date(dateString).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long'
                    });
                },

                formatTime(iso) {
                    return new Date(iso).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
        }
    </script>

</body>

</html>
