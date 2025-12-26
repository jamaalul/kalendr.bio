<nav class="sticky flex flex-col gap-4 px-4 md:px-10 pt-8 w-full">
    <div class="flex justify-between items-center w-full">
        <h3 class="font-semibold text-black text-xl md:text-2xl tracking-tight">kalend<span
                class="text-gray-400">r.</span></h3>
        <div
            class="flex items-center gap-1 hover:bg-gray-200 px-3 py-2 rounded-full transition-all duration-200 cursor-pointer">
            <p class="font-medium text-black text-sm md:text-base">{{ Auth::user()->name }}</p>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4 md:size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </div>
    </div>
    <div class="flex items-center gap-3 md:gap-4 w-full overflow-x-auto">
        <div class="py-4 h-full whitespace-nowrap" id="agenda">
            <a href="" class="font-medium text-gray-500 text-sm md:text-base no-underline">Agenda</a>
        </div>
        <div class="py-4 h-full whitespace-nowrap" id="kalender">
            <a href="" class="font-medium text-gray-500 text-sm md:text-base no-underline">Kalender</a>
        </div>
        <div class="py-4 h-full whitespace-nowrap" id="mendatang">
            <a href="" class="font-medium text-gray-500 text-sm md:text-base no-underline">Mendatang</a>
        </div>
    </div>

    <script>
        document.getElementById('{{ $state }}').classList.add('border-b-[3px]', 'border-black')
        document.getElementById('{{ $state }}').firstElementChild.style.color = 'black';
    </script>
</nav>
