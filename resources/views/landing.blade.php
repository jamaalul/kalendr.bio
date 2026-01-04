<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kalendr — Booking made simple.</title>
    <style>
        /* Modern Grotesque Fonts */
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&family=Poppins:wght@500;600;700&display=swap');

        :root {
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        body {
            font-family: var(--font-body);
            background-color: #FFFFFF;
            color: #18181b;
            /* Zinc-900 */
        }

        h1,
        h2,
        h3,
        h4,
        .brand-font {
            font-family: var(--font-heading);
        }

        /* Subtle noise for texture */
        .bg-noise {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
        }

        /* Smooth reveal animation */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        /* Custom subtle scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #e4e4e7;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #d4d4d8;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        zinc: {
                            850: '#202023',
                            900: '#18181b',
                        }
                    },
                    boxShadow: {
                        'glow': '0 0 40px -10px rgba(0, 0, 0, 0.1)',
                        'inner-light': 'inset 0 1px 0 0 rgba(255, 255, 255, 0.1)',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-noise selection:bg-zinc-900 selection:text-white antialiased">

    <nav class="top-0 z-50 fixed px-6 pt-6 w-full">
        <div
            class="flex justify-between items-center bg-white/80 shadow-sm backdrop-blur-xl mx-auto p-3.5 border border-zinc-200/60 rounded-2xl max-w-5xl transition-all">
            <div class="pl-2.5 font-semibold text-lg tracking-tight brand-font">kalend<span
                    class="text-zinc-400">r.</span>
            </div>

            <div class="hidden md:flex items-center space-x-8 font-medium text-[14px] text-zinc-500">
                <a href="#cara-kerja" class="hover:text-zinc-900 transition-colors">Cara Kerja</a>
                <a href="#fitur" class="hover:text-zinc-900 transition-colors">Kenapa kami?</a>
                <a href="#harga" class="hover:text-zinc-900 transition-colors">Harga</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="/login"
                    class="font-medium text-[14px] text-zinc-500 hover:text-zinc-900 transition-colors">Masuk</a>
                <a href="/register"
                    class="group relative bg-zinc-900 hover:bg-zinc-800 shadow-lg shadow-zinc-200 hover:shadow-xl px-4 py-2 rounded-lg overflow-hidden font-medium text-[14px] text-white transition-all hover:-translate-y-0.5">
                    Daftar
                </a>
            </div>
        </div>
    </nav>

    <header class="relative mx-auto px-6 pt-40 md:pt-48 pb-20 max-w-5xl md:text-center">

        {{-- <div class="flex justify-center mb-8 animate-fade-up">
            <div
                class="group inline-flex items-center bg-zinc-50/50 hover:bg-white px-3 py-1 border border-zinc-200 hover:border-zinc-300 rounded-full font-medium text-[13px] text-zinc-600 transition-colors cursor-default">
                <span
                    class="flex bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)] mr-2 rounded-full w-1.5 h-1.5"></span>
                Sekarang tersedia untuk publik
            </div>
        </div> --}}

        <h1
            class="mx-auto mb-6 max-w-4xl font-semibold text-zinc-900 text-4xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl text-center leading-[1.05] tracking-tighter animate-fade-up delay-100">
            Terima booking,<br>
            <span class="text-zinc-400">Satu link beres.</span>
        </h1>

        <p
            class="mx-auto mb-10 max-w-2xl font-normal text-zinc-500 sm:text-md text-base md:text-lg text-center text-balance leading-relaxed animate-fade-up delay-200">
            Stop chat bolak-balik. Biar kalendr yang handle jadwalmu,<br class="hidden md:block"> kamu fokus ngerjain
            yang penting aja.
        </p>

        <div class="flex md:flex-row flex-col justify-center items-center gap-4 animate-fade-up delay-200">
            <a href="/dashboard"
                class="flex justify-center items-center bg-zinc-900 shadow-xl shadow-zinc-200 hover:shadow-2xl px-4 sm:px-6 py-2 sm:py-3 rounded-md w-full md:w-auto font-medium text-white sm:text-[15px] text-sm transition-all hover:-translate-y-1">
                Buat link gratis
            </a>
            <a href="#cara-kerja"
                class="flex justify-center items-center px-6 sm:px-8 py-3 sm:py-4 rounded-xl w-full md:w-auto font-medium text-zinc-500 sm:text-[15px] hover:text-zinc-900 text-sm transition-all">
                Cara kerjanya →
            </a>
        </div>

        <div class="hidden md:flex justify-center mt-24 px-4 animate-fade-up delay-200">
            <div class="bg-white shadow-2xl mx-auto md:border-2 md:rounded-lg w-full max-w-6xl overflow-hidden">
                <div class="flex md:flex-row flex-col">

                    <div
                        class="flex flex-col items-start p-8 border-gray-100 md:border-r-2 border-b-2 md:border-b-0 md:w-1/3">
                        <div class="mb-4 font-medium text-gray-500 text-sm">
                            John Doe
                        </div>

                        <h1 class="mb-4 font-bold text-gray-900 text-2xl leading-tight">
                            Product Demo
                        </h1>

                        <div class="space-y-3 mb-6 text-gray-500">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">45 menit</span>
                            </div>
                        </div>

                        {{-- <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $eventType->description }}
                        </div> --}}
                    </div>

                    <div class="relative p-8 md:w-2/3 min-h-[500px]">
                        <h2 class="mb-6 w-full font-bold text-xl text-start">Pilih Tanggal & Waktu</h2>

                        <div class="flex flex-col gap-8">
                            <div class="w-full">
                                <div class="flex justify-between items-center mb-6">
                                    <span class="font-medium text-lg">
                                        {{ now()->translatedFormat('F Y') }}
                                    </span>
                                    <div class="flex gap-2">
                                        <button class="hover:bg-gray-100 p-2 rounded-full text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <button class="hover:bg-gray-100 p-2 rounded-full text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="grid grid-cols-7 mb-2 font-semibold text-gray-400 text-xs text-center uppercase">
                                    <div>Min</div>
                                    <div>Sen</div>
                                    <div>Sel</div>
                                    <div>Rab</div>
                                    <div>Kam</div>
                                    <div>Jum</div>
                                    <div>Sab</div>
                                </div>

                                @php
                                    $now = now();
                                    $year = $now->year;
                                    $month = $now->month;
                                    $firstDay = \Carbon\Carbon::create($year, $month, 1);
                                    $lastDay = $firstDay->copy()->endOfMonth();
                                    $startWeekday = $firstDay->dayOfWeek; // 0=Sun, 1=Mon, ..., 6=Sat
                                    $calendarDays = [];
                                    // Add nulls for days before first day (adjust for Monday start)
                                    $adjustedStart = $startWeekday == 0 ? 6 : $startWeekday - 1; // Make Monday=0
                                    for ($i = 0; $i < $adjustedStart; $i++) {
                                        $calendarDays[] = ['dayOfMonth' => null, 'hasSlots' => false];
                                    }
                                    // Add days of the month
                                    for ($day = 1; $day <= $lastDay->day; $day++) {
                                        $currentDate = \Carbon\Carbon::create($year, $month, $day);
                                        $isPast = $currentDate->isBefore($now->toDateString());
                                        $hasSlots = !$isPast && rand(0, 2) > 0; // Random slots for future days
                                        $calendarDays[] = ['dayOfMonth' => $day, 'hasSlots' => $hasSlots];
                                    }
                                    // Set viewer timezone for demo
                                    $viewerTz = 'Asia/Jakarta';
                                @endphp
                                <div class="gap-1 grid grid-cols-7 text-center">
                                    {{-- This section would typically loop through your $calendarDays array --}}
                                    @foreach ($calendarDays as $day)
                                        <div>
                                            @if ($day['dayOfMonth'])
                                                <button
                                                    class="flex justify-center items-center mx-auto rounded-full w-10 h-10 font-medium text-sm transition-colors {{ $day['hasSlots'] ? 'bg-gray-100 font-bold text-gray-900 hover:border-black hover:border' : 'text-gray-400 cursor-default' }}"
                                                    {{ !$day['hasSlots'] ? 'disabled' : '' }}>
                                                    {{ $day['dayOfMonth'] }}
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-8 text-gray-500 text-xs uppercase tracking-wide">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                            </path>
                                        </svg>
                                        Waktu Indonesia Barat (WIB)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <hr class="border-zinc-100">

    <div class="bg-white py-10">
        <div class="mx-auto px-6 max-w-5xl text-center">
            <p class="mb-6 font-medium text-[13px] text-zinc-400 uppercase tracking-widest">Didesain untuk profesional
            </p>
            <div class="flex flex-wrap justify-center gap-2 md:gap-4">
                <span
                    class="bg-zinc-50 px-3 py-1.5 border border-zinc-100 rounded font-medium text-zinc-500 text-sm">Freelancer</span>
                <span
                    class="bg-zinc-50 px-3 py-1.5 border border-zinc-100 rounded font-medium text-zinc-500 text-sm">Consultant</span>
                <span
                    class="bg-zinc-50 px-3 py-1.5 border border-zinc-100 rounded font-medium text-zinc-500 text-sm">Teacher</span>
                <span
                    class="bg-zinc-50 px-3 py-1.5 border border-zinc-100 rounded font-medium text-zinc-500 text-sm">Coach</span>
            </div>
        </div>
    </div>

    <section id="cara-kerja" class="mx-auto px-6 py-32 max-w-5xl">
        <div class="items-center gap-12 grid md:grid-cols-2">
            <div>
                <h2 class="font-semibold text-zinc-900 text-3xl md:text-4xl tracking-tighter">Cara kerja super simpel.
                </h2>
                <div class="space-y-8 mt-8">
                    <div class="flex gap-5">
                        <div
                            class="flex flex-shrink-0 justify-center items-center bg-zinc-100 border border-zinc-200 rounded-full w-8 h-8 font-semibold text-zinc-900 text-sm">
                            1</div>
                        <div>
                            <h3 class="font-semibold text-zinc-900 text-lg">Atur Ketersediaan</h3>
                            <p class="mt-1 text-[15px] text-zinc-500 leading-relaxed">Pilih jam kerjamu. Sinkronkan
                                dengan Google Calendar supaya nggak bentrok.</p>
                        </div>
                    </div>
                    <div class="flex gap-5">
                        <div
                            class="flex flex-shrink-0 justify-center items-center bg-zinc-100 border border-zinc-200 rounded-full w-8 h-8 font-semibold text-zinc-900 text-sm">
                            2</div>
                        <div>
                            <h3 class="font-semibold text-zinc-900 text-lg">Bagikan Link</h3>
                            <p class="mt-1 text-[15px] text-zinc-500 leading-relaxed">Taruh `kalendr.bio/kamu` di
                                Instagram atau WA. Biar klien pilih sendiri.</p>
                        </div>
                    </div>
                    <div class="flex gap-5">
                        <div
                            class="flex flex-shrink-0 justify-center items-center bg-zinc-100 border border-zinc-200 rounded-full w-8 h-8 font-semibold text-zinc-900 text-sm">
                            3</div>
                        <div>
                            <h3 class="font-semibold text-zinc-900 text-lg">Otomatis Terjadwal</h3>
                            <p class="mt-1 text-[15px] text-zinc-500 leading-relaxed">Notifikasi masuk, link meeting
                                terbuat. Kamu tinggal datang.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="relative flex justify-center items-center bg-zinc-50 border border-zinc-100 rounded-2xl w-full h-[400px] overflow-hidden">
                <div
                    class="absolute inset-0 bg-[radial-gradient(#e4e4e7_1px,transparent_1px)] opacity-50 [background-size:16px_16px]">
                </div>

                <div class="z-10 relative space-y-4 text-center">
                    <div
                        class="inline-flex items-center gap-2 bg-white shadow-sm px-4 py-2 border border-zinc-100 rounded-full">
                        <div class="bg-green-500 rounded-full w-2 h-2"></div>
                        <span class="font-medium text-zinc-600 text-xs">Jadwal Terkonfirmasi</span>
                    </div>
                    <div class="bg-zinc-200 mx-auto w-px h-16"></div>
                    <div
                        class="inline-flex justify-center items-center bg-zinc-900 shadow-lg rounded-xl w-12 h-12 text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="bg-zinc-50/50 py-32 border-y border-zinc-100">
        <div class="mx-auto px-6 max-w-5xl">
            <div class="mx-auto mb-16 max-w-2xl md:text-center">
                <h2 class="font-semibold text-zinc-900 text-3xl md:text-4xl tracking-tighter">Semua yang kamu butuh.
                </h2>
                <p class="mt-4 text-zinc-500">Fitur esensial untuk mengatur jadwal tanpa sakit kepala.</p>
            </div>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                <div
                    class="group md:col-span-2 bg-white hover:shadow-lg hover:shadow-zinc-200/50 p-8 border border-zinc-200 hover:border-zinc-300 rounded-2xl transition-all">
                    <div
                        class="flex justify-center items-center bg-zinc-50 group-hover:bg-zinc-900 mb-4 border border-zinc-100 rounded-lg w-10 h-10 text-zinc-900 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900 text-xl">Sync Google Calendar</h3>
                    <p class="mt-2 text-[15px] text-zinc-500 leading-relaxed">Kalendr membaca jadwal Google kamu secara
                        real-time. Jika ada acara pribadi, slot booking otomatis tertutup. Anti bentrok.</p>
                </div>

                <div
                    class="group md:col-span-1 bg-white hover:shadow-lg hover:shadow-zinc-200/50 p-8 border border-zinc-200 hover:border-zinc-300 rounded-2xl transition-all">
                    <div
                        class="flex justify-center items-center bg-zinc-50 group-hover:bg-zinc-900 mb-4 border border-zinc-100 rounded-lg w-10 h-10 text-zinc-900 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900 text-xl">Auto Timezone</h3>
                    <p class="mt-2 text-[15px] text-zinc-500 leading-relaxed">Klien di Bali lihat jam Bali. Kamu di
                        Jakarta lihat jam Jakarta. Ajaib.</p>
                </div>

                <div
                    class="group md:col-span-1 bg-white hover:shadow-lg hover:shadow-zinc-200/50 p-8 border border-zinc-200 hover:border-zinc-300 rounded-2xl transition-all">
                    <div
                        class="flex justify-center items-center bg-zinc-50 group-hover:bg-zinc-900 mb-4 border border-zinc-100 rounded-lg w-10 h-10 text-zinc-900 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900 text-xl">Mobile First</h3>
                    <p class="mt-2 text-[15px] text-zinc-500 leading-relaxed">Tampilan booking sangat nyaman dibuka
                        lewat HP. Ringan dan cepat.</p>
                </div>

                <div
                    class="group md:col-span-2 bg-white hover:shadow-lg hover:shadow-zinc-200/50 p-8 border border-zinc-200 hover:border-zinc-300 rounded-2xl transition-all">
                    <div
                        class="flex justify-center items-center bg-zinc-50 group-hover:bg-zinc-900 mb-4 border border-zinc-100 rounded-lg w-10 h-10 text-zinc-900 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900 text-xl">Notifikasi WhatsApp & Email</h3>
                    <p class="mt-2 text-[15px] text-zinc-500 leading-relaxed">Setiap ada booking baru, kami kirim
                        notifikasi ke kamu dan klien. Reminder otomatis juga dikirim sebelum meeting dimulai.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="harga" class="mx-auto px-6 py-32 max-w-5xl text-center">
        <h2 class="font-semibold text-zinc-900 text-3xl md:text-5xl tracking-tighter">Mulai gratis aja dulu.</h2>
        <p class="mx-auto mt-6 max-w-xl text-zinc-500 text-lg">Kami ingin membantu kamu tumbuh. Gunakan fitur inti
            gratis selamanya.</p>

        <div class="flex justify-center mt-16">
            <div
                class="relative bg-white shadow-xl shadow-zinc-200/40 p-8 border border-zinc-200 rounded-3xl w-full max-w-sm text-left">
                <div
                    class="-top-4 left-1/2 absolute bg-zinc-900 shadow-sm px-4 py-1 border border-zinc-900 rounded-full font-medium text-white text-xs -translate-x-1/2">
                    Populer untuk Individu
                </div>

                <div class="flex justify-between items-baseline">
                    <h3 class="font-semibold text-zinc-900 text-lg">Starter</h3>
                    <div class="text-right">
                        <span class="font-semibold text-zinc-900 text-4xl tracking-tight">Rp0</span>
                    </div>
                </div>
                <p class="mt-2 text-zinc-500 text-sm">Selamanya. Tanpa kartu kredit.</p>

                <hr class="my-6 border-zinc-100">

                <ul class="space-y-4 mb-8 text-[15px] text-zinc-600">
                    <li class="flex items-center"><svg class="mr-3 w-5 h-5 text-zinc-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg> 1 Link personal</li>
                    <li class="flex items-center"><svg class="mr-3 w-5 h-5 text-zinc-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg> Unlimited booking</li>
                    <li class="flex items-center"><svg class="mr-3 w-5 h-5 text-zinc-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg> Sync Google Calendar</li>
                    <li class="flex items-center"><svg class="mr-3 w-5 h-5 text-zinc-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg> Notifikasi Email</li>
                </ul>

                <a href="/register"
                    class="block bg-zinc-900 hover:bg-zinc-800 shadow-lg shadow-zinc-300 hover:shadow-xl py-3.5 rounded-xl w-full font-medium text-white text-sm text-center transition-all hover:-translate-y-0.5">
                    Buat Akun Gratis
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-white pt-32 pb-20 border-zinc-200 border-t">
        <div class="mx-auto px-6 max-w-5xl text-center">
            <h2 class="mb-8 font-semibold text-zinc-900 text-4xl md:text-5xl tracking-tighter">
                Siap mengatur jadwal?
            </h2>

            <a href="/register"
                class="inline-flex items-center gap-2 bg-zinc-100 hover:bg-zinc-200 px-6 py-3 rounded-full font-medium text-zinc-900 text-sm transition-colors">
                Mulai sekarang
                <span aria-hidden="true">&rarr;</span>
            </a>

            <div
                class="flex md:flex-row flex-col justify-between items-center gap-6 mt-24 pt-8 border-zinc-100 border-t text-zinc-500 text-sm">
                <div class="font-semibold text-zinc-900 brand-font">kalendr.</div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-zinc-900 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-zinc-900 transition-colors">Terms</a>
                    <a href="#" class="hover:text-zinc-900 transition-colors">Twitter</a>
                </div>
                <div>&copy; 2024 Kalendr Bio.</div>
            </div>
        </div>
    </footer>

</body>

</html>
