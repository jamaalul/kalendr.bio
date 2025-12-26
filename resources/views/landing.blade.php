<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kalendr — Terima booking lebih gampang lewat satu link.</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&family=Poppins:wght@500;600;700&display=swap');

        h1,
        h2,
        h3 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">

    <nav class="top-0 z-10 sticky flex justify-between items-center bg-white mx-auto px-6 py-6 rounded-b-lg max-w-5xl">
        <div class="font-semibold text-xl tracking-tight brand-font">kalend<span class="text-gray-400">r.</span></div>
        <div
            class="hidden left-1/2 absolute md:flex space-x-10 font-medium text-[15px] text-gray-500 -translate-x-1/2 transform">
            <a href="#cara-kerja" class="hover:text-black transition">Cara Kerja</a>
            <a href="#fitur" class="hover:text-black transition">Kenapa kami?</a>
            <a href="#harga" class="hover:text-black transition">Harga</a>
        </div>
        @auth
            <a href="/dashboard"
                class="hover:bg-gray-50 px-5 py-2.5 border border-gray-200 rounded font-semibold text-sm transition">Dashboard</a>
        @else
            <div class="flex gap-1">
                <a href="/login"
                    class="hover:bg-gray-50 px-5 py-2.5 border border-gray-200 rounded font-semibold text-sm transition">Masuk</a>
                <a href="/register"
                    class="hover:bg-gray-50 px-5 py-2.5 border border-gray-200 rounded font-semibold text-sm transition">Daftar</a>
            </div>
        @endauth
    </nav>

    <header class="mx-auto px-6 pt-12 pb-20 max-w-5xl md:text-left text-center">
        <h1 class="mb-6 font-semibold text-5xl md:text-7xl leading-[1.1] tracking-tight">
            Terima booking gampang <br class="hidden md:block">lewat satu link.
        </h1>
        <p class="mb-10 max-w-2xl text-gray-500 text-lg md:text-xl leading-relaxed">
            Nggak perlu lagi capek balesin chat cuma buat cocokin jadwal. Kasih satu link, biar klien kamu yang pilih
            sendiri waktunya.
        </p>
        <div class="flex md:flex-row flex-col items-center md:space-x-6 space-y-4 md:space-y-0">
            <a href="/dashboard"
                class="bg-black hover:bg-gray-800 px-8 py-4 rounded w-full md:w-auto font-medium text-white text-center transition">
                Buat link jadwal
            </a>
            <a href="#cara-kerja" class="font-medium text-gray-500 hover:text-black transition">
                Gimana cara kerjanya?
            </a>
        </div>
    </header>

    <hr class="border-gray-100">

    <section class="mx-auto px-6 py-24 max-w-5xl">
        <div class="items-start gap-16 grid md:grid-cols-2">
            <h2 class="font-semibold text-3xl leading-snug tracking-tight">Capek atur jadwal manual?</h2>
            <div class="space-y-8 text-gray-600">
                <div class="p-4 border-gray-100 border-l-2">
                    <p><strong class="font-semibold text-black italic">"Bisa jam 2?" "Waduh, jam segitu ada
                            kelas."</strong> Chat bolak-balik kayak gini cuma buang waktu kamu.</p>
                </div>
                <div class="p-4 border-gray-100 border-l-2">
                    <p>Sering lupa catat jadwal yang masuk dari WhatsApp sampai akhirnya <strong
                            class="font-semibold text-black">jadwal bentrok</strong>.</p>
                </div>
                <div class="p-4 border-gray-100 border-l-2">
                    <p>Repot kalau harus kirim list jam kosong setiap kali ada yang nanya.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="bg-gray-50 px-6 py-24 border-gray-100 border-y">
        <div class="mx-auto max-w-5xl">
            <h2 class="mb-16 font-bold text-3xl text-center">Bikin hidup lebih simpel.</h2>
            <div class="gap-12 grid md:grid-cols-3">
                <div class="bg-white p-8 border border-gray-200 rounded">
                    <div
                        class="flex justify-center items-center bg-black mb-6 rounded-full w-10 h-10 font-bold text-white">
                        1</div>
                    <h3 class="mb-3 font-bold text-xl">Atur jadwal kamu</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pilih hari dan jam kapan kamu siap terima klien
                        atau konsultasi.</p>
                </div>
                <div class="bg-white p-8 border border-gray-200 rounded">
                    <div
                        class="flex justify-center items-center bg-black mb-6 rounded-full w-10 h-10 font-bold text-white">
                        2</div>
                    <h3 class="mb-3 font-bold text-xl">Sebar linknya</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pasang link kalendr.bio kamu di bio Instagram atau
                        kirim langsung lewat chat.</p>
                </div>
                <div class="bg-white p-8 border border-gray-200 rounded">
                    <div
                        class="flex justify-center items-center bg-black mb-6 rounded-full w-10 h-10 font-bold text-white">
                        3</div>
                    <h3 class="mb-3 font-bold text-xl">Beres</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Booking otomatis masuk ke kalender kamu. Nggak
                        perlu konfirmasi manual lagi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="mx-auto px-6 py-24 max-w-5xl">
        <div class="gap-20 grid md:grid-cols-2">
            <div>
                <h2 class="mb-8 font-bold text-4xl leading-tight">Nggak ada lagi alasan buat ribet.</h2>
                <p class="mb-8 text-gray-500">Kalendr dibikin supaya kamu bisa fokus sama kerjaan, bukan urusan
                    administrasi.</p>
                <div class="gap-4 grid grid-cols-2">
                    <div class="bg-gray-50 p-4 rounded-lg font-semibold text-sm">Tutor</div>
                    <div class="bg-gray-50 p-4 rounded-lg font-semibold text-sm">Freelancer</div>
                    <div class="bg-gray-50 p-4 rounded-lg font-semibold text-sm">Coach</div>
                    <div class="bg-gray-50 p-4 rounded-lg font-semibold text-sm">Konsultan</div>
                </div>
            </div>
            <div class="space-y-10">
                <div class="flex items-start">
                    <div class="mt-1 mr-4">✓</div>
                    <div>
                        <h4 class="mb-1 font-bold">Cek jadwal di HP kapan aja</h4>
                        <p class="text-gray-500 text-sm">Semuanya sinkron ke Google Calendar. Jadi, kamu nggak bakal
                            kelewatan jadwal.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="mt-1 mr-4">✓</div>
                    <div>
                        <h4 class="mb-1 font-bold">WhatsApp-Friendly banget</h4>
                        <p class="text-gray-500 text-sm">Klien kamu nggak perlu download app. Tinggal klik link, pilih
                            jam, kelar.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="mt-1 mr-4">✓</div>
                    <div>
                        <h4 class="mb-1 font-bold">Auto-paham timezone</h4>
                        <p class="text-gray-500 text-sm">Klien dari luar kota atau luar negeri? Tenang, jamnya bakal
                            otomatis nyesuain.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="harga" class="bg-black px-6 py-24 text-white">
        <div class="mx-auto max-w-md text-center">
            <h2 class="mb-4 font-bold text-3xl">Mulai gratis aja dulu.</h2>
            <p class="mb-10 text-gray-400">Gunakan semua fitur inti tanpa bayar sepeser pun.</p>
            <div class="bg-[#111] p-8 border border-neutral-800 rounded-2xl text-left">
                <div class="mb-6">
                    <span class="font-bold text-4xl">Gratis</span>
                    <span class="ml-2 text-gray-500 text-sm">selamanya</span>
                </div>
                <ul class="space-y-4 mb-10 text-[15px] text-gray-300">
                    <li class="flex items-center"><span class="mr-3 text-white">✓</span> 1 Link personal</li>
                    <li class="flex items-center"><span class="mr-3 text-white">✓</span> Sinkron Google Calendar
                    </li>
                    <li class="flex items-center"><span class="mr-3 text-white">✓</span> Booking tanpa batas</li>
                    <li class="flex items-center"><span class="mr-3 text-white">✓</span> Notifikasi email</li>
                </ul>
                <a href="#"
                    class="block bg-white hover:bg-gray-200 py-4 rounded w-full font-bold text-black text-center transition">Buat
                    Sekarang</a>
            </div>
        </div>
    </section>

    <footer class="mx-auto px-6 py-24 max-w-5xl text-center">
        <h2 class="mb-8 font-bold text-4xl md:text-5xl tracking-tight">Yuk, bikin jadwalmu lebih rapi.</h2>
        <a href="#"
            class="inline-block bg-black hover:opacity-90 shadow-lg px-10 py-5 rounded font-bold text-white text-lg transition">
            Mulai gratis di kalendr
        </a>
        <div class="mt-20 font-bold text-[12px] text-gray-300 uppercase tracking-widest brand-font">
            kalendr.bio — Teman atur jadwalmu.
        </div>
    </footer>

</body>

</html>
