<div
    x-data="{ open: false }"
    x-init="
        @if($show)
            setTimeout(() => { open = true }, 1000);
        @endif
        $wire.on('close-modal', () => { open = false });
    "
    x-show="open"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center"
>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div class="relative w-[92%] max-w-lg rounded-3xl overflow-hidden shadow-2xl glass animate-in fade-in-0 zoom-in-95">
        <!-- Header bar -->
        <div class="h-2 bg-gradient-to-r from-yellow-400 via-pink-500 to-violet-500"></div>

        <!-- Content -->
        <div class="p-6 sm:p-8 text-white">
            <h2 class="text-xl sm:text-2xl font-bold mb-2 flex items-center gap-2">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-2.21 1.79-4 4-4s4 1.79 4 4v2a4 4 0 11-8 0v-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 11V9a6 6 0 1112 0v2"/>
                </svg>
                چند سؤال کوتاه تا انتخاب دقیق‌تر پکیج
            </h2>
            <p class="text-sm text-gray-200/90 mb-6 leading-7">
                لطفاً این اطلاعات را وارد کن تا پیشنهادها دقیق‌تر و متناسب با شرایطت ارائه شود.
                داده‌ها فقط برای بهبود تجربه‌ی تو ذخیره می‌شوند.
            </p>

            <form wire:submit.prevent="submit" class="space-y-5">
                <!-- Name -->
                <div>
                    <label class="block mb-1 text-sm font-medium">نام و نام خانوادگی</label>
                    <input type="text" wire:model.defer="name"
                           class="w-full rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 p-3">
                    @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- DOB + Gender -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium">تاریخ تولد</label>
                        <input type="text" wire:model.defer="dob" data-jdp
                               class="w-full rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 p-3">
                        @error('dob') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">جنسیت</label>
                        <select wire:model.defer="gender"
                                class="w-full rounded-xl bg-white/20 border border-white/30 text-white
                                       focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-fuchsia-500 p-3">
                            <option value="" disabled selected>انتخاب کن…</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->value }}">{{ $gender->label() }}</option>
                            @endforeach
                        </select>
                        @error('gender') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Relationship -->
                <div>
                    <label class="block mb-1 text-sm font-medium">وضعیت رابطه</label>
                    <select wire:model.defer="relationship"
                            class="w-full rounded-xl bg-white/20 border border-white/30 text-white
                                   focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 p-3">
                        <option value="" disabled selected>انتخاب کن…</option>
                        @foreach($relationships as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('relationship') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between pt-4">
                    <button type="button"
                            class="px-4 py-2 text-sm text-gray-300 hover:text-white transition cursor-pointer"
                            wire:click="skip">
                        بعداً تکمیل می‌کنم
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl px-5 py-3 font-semibold
                                   bg-gradient-to-r from-yellow-400 via-pink-500 to-violet-500 text-black hover:brightness-110 shadow-lg btn-neon cursor-pointer">
                        ادامه
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 5l7 7-7 7M5 5h8v2H5v10h8v2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
