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
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Modal -->
    <div class="relative w-[92%] max-w-xl rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header bar with brand stripes -->
        <div class="grid grid-cols-3 h-2">
            <div class="bg-neutral-900"></div>
            <div class="bg-yellow-500"></div>
            <div class="bg-gradient-to-r from-fuchsia-700 via-pink-600 to-orange-500"></div>
        </div>

        <div class="bg-neutral-900 text-white p-6 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-bold mb-2">چندسؤال کوتاه تا انتخاب دقیق‌تر پکیج</h2>
            <p class="text-sm text-gray-300 mb-6 leading-7">
                لطفاً این اطلاعات را وارد کن تا پیشنهادها دقیق‌تر و متناسب با شرایطت ارائه شود. ذخیره‌سازی فقط برای
                بهبود تجربه‌ی تو در این سایت است.
            </p>

            <form wire:submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm">نام و نام خانوادگی</label>
                    <input type="text" wire:model.defer="name"
                           class="w-full rounded-xl bg-neutral-800 border border-neutral-700 focus:border-yellow-500 focus:ring-0 p-3"
                           placeholder="مثلاً: نگار محمدی">
                    @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm">تاریخ تولد</label>
                        <input type="text" wire:model.defer="dob"
                               class="w-full rounded-xl bg-neutral-800 border border-neutral-700 focus:border-yellow-500 focus:ring-0 p-3"
                               data-jdp>
                        @error('dob') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-sm">جنسیت</label>
                        <select wire:model.defer="gender"
                                class="w-full rounded-xl bg-neutral-800 border border-neutral-700 focus:border-yellow-500 focus:ring-0 p-3">
                            <option value="" disabled selected>انتخاب کن…</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->value }}">{{ $gender->label() }}</option>
                            @endforeach
                        </select>
                        @error('gender') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-sm">وضعیت رابطه</label>
                    <select wire:model.defer="relationship"
                            class="w-full rounded-xl bg-neutral-800 border border-neutral-700 focus:border-yellow-500 focus:ring-0 p-3">
                        <option value="" disabled selected>انتخاب کن…</option>
                        @foreach($relationships as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('relationship') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button type="button" class="px-4 py-2 text-sm text-gray-300 hover:text-white cursor-pointer"
                            wire:click="skip">
                        بعداً تکمیل می‌کنم
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl px-5 py-3 font-semibold bg-gradient-to-r from-yellow-500 to-orange-500 text-black hover:brightness-110 cursor-pointer">
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
