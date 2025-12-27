{{-- Availability Fields Partial --}}
@php
    $days = [0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'];
@endphp

<div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    @foreach ($days as $dayNumber => $dayName)
        @php
            $existingSlots = $availabilitiesByDay[$dayNumber] ?? [];
            $isEnabled = count($existingSlots) > 0;

            // Default slot for UI purposes if empty
            $displaySlots = $isEnabled ? $existingSlots : [(object) ['start_time' => '09:00', 'end_time' => '17:00']];
        @endphp

        <div class="bg-gray-50 p-4 border border-gray-200 hover:border-gray-300 rounded-md transition-colors">

            {{-- Header: Checkbox & Day Name --}}
            <div class="flex justify-between items-center mb-3">
                <label for="day_{{ $dayNumber }}_enabled" class="group flex items-center gap-2 w-full cursor-pointer">
                    <input type="checkbox" id="day_{{ $dayNumber }}_enabled"
                        class="border-gray-300 rounded focus:ring-black w-4 h-4 text-black transition duration-150 ease-in-out cursor-pointer day-toggle"
                        data-day="{{ $dayNumber }}" {{ $isEnabled ? 'checked' : '' }}>
                    <span class="font-medium text-gray-700 group-hover:text-black text-sm transition-colors">
                        {{ $dayName }}
                    </span>
                </label>
            </div>

            {{-- Time Slots Container --}}
            <div id="slots_{{ $dayNumber }}" class="{{ !$isEnabled ? 'hidden' : 'block' }}">
                @foreach ($displaySlots as $index => $slot)
                    <div class="flex items-center gap-2">
                        {{-- Start Time --}}
                        <div class="flex-1">
                            <label class="block mb-1 text-gray-500 text-xs">Mulai</label>
                            <input type="text"
                                name="availability[{{ $dayNumber }}][{{ $index }}][start_time]"
                                value="{{ $slot->start_time ?? '09:00' }}"
                                class="time-picker block bg-white shadow-sm px-2 py-1.5 border border-gray-300 focus:border-black rounded-md focus:ring-black w-full text-sm"
                                data-day="{{ $dayNumber }}"
                                placeholder="HH:MM"
                                {{ $isEnabled ? 'required' : 'disabled' }}>
                        </div>

                        {{-- Separator --}}
                        <div class="pt-5 text-gray-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>

                        {{-- End Time --}}
                        <div class="flex-1">
                            <label class="block mb-1 text-gray-500 text-xs">Selesai</label>
                            <input type="text"
                                name="availability[{{ $dayNumber }}][{{ $index }}][end_time]"
                                value="{{ $slot->end_time ?? '17:00' }}"
                                class="time-picker block bg-white shadow-sm px-2 py-1.5 border border-gray-300 focus:border-black rounded-md focus:ring-black w-full text-sm"
                                data-day="{{ $dayNumber }}"
                                placeholder="HH:MM"
                                {{ $isEnabled ? 'required' : 'disabled' }}>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Off State Text --}}
            {{-- <div id="placeholder_{{ $dayNumber }}" class="{{ $isEnabled ? 'hidden' : 'block' }}">
                <p class="pt-1 text-gray-400 text-xs italic">Tidak aktif</p>
            </div> --}}
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store flatpickr instances
        const flatpickrInstances = {};

        // Initialize flatpickr for all time picker inputs
        document.querySelectorAll('.time-picker').forEach(input => {
            const instance = flatpickr(input, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 15,
                defaultHour: input.value ? parseInt(input.value.split(':')[0]) : 9,
                defaultMinute: input.value ? parseInt(input.value.split(':')[1]) : 0,
                clickOpens: !input.disabled,
                allowInput: true
            });

            // Store instance reference
            flatpickrInstances[input.name] = instance;
        });

        // Handle day toggle
        const toggles = document.querySelectorAll('.day-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const day = this.dataset.day;
                const slotContainer = document.getElementById(`slots_${day}`);
                const placeholder = document.getElementById(`placeholder_${day}`);
                const inputs = slotContainer.querySelectorAll('input');

                if (this.checked) {
                    slotContainer.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                    inputs.forEach(input => {
                        input.disabled = false;
                        input.required = true;
                        // Re-enable flatpickr
                        const instance = flatpickrInstances[input.name];
                        if (instance) {
                            instance.set('clickOpens', true);
                        }
                    });
                } else {
                    slotContainer.classList.add('hidden');
                    if (placeholder) placeholder.classList.remove('hidden');
                    inputs.forEach(input => {
                        input.disabled = true;
                        input.required = false;
                        // Disable flatpickr
                        const instance = flatpickrInstances[input.name];
                        if (instance) {
                            instance.set('clickOpens', false);
                        }
                    });
                }
            });
        });
    });
</script>
