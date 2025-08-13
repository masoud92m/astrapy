<div class="mt-3" x-data="{submitting : false}">
    <form>
        <div>
            <label class="block mb-1 text-sm">پکیج</label>
            <select wire:model.change="package_id"
                    class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2">
                <option value="" disabled selected>انتخاب کن…</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                @endforeach
            </select>
            @error('package_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
        </div>
        @if($package_id)
            <div>
                <label class="block mb-1 text-sm">نام و نام خانوادگی</label>
                <input type="text" wire:model.defer="name"
                       class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2"
                       placeholder="مثلاً: نگار محمدی">
                @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm">تاریخ تولد</label>
                    <input type="text" wire:model.defer="dob"
                           class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2"
                           data-jdp>
                    @error('dob') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm">جنسیت</label>
                    <select wire:model.defer="gender"
                            class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2">
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
                        class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2">
                    <option value="" disabled selected>انتخاب کن…</option>
                    @foreach($relationships as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>
                @error('relationship') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
            </div>

            @foreach($questions as $question)
                <div>
                    <label class="block mb-1 text-sm">{{ $question->content }}</label>
                    <input type="text" wire:model.defer="answers.{{ $question->id }}"
                           class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2"
                           placeholder="">
                    @error('answers.' . $question->id) <span
                        class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>
            @endforeach

            <div class="flex items-center justify-between pt-2">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer rounded-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        x-on:click="
                            if (submitting) return;
                            submitting = true;
                            $wire.submit()
                            .finally(() => {
                                submitting = false;
                            });
                        "
                        :disabled="submitting"
                >
                    دریافت تحلیل
                </button>
                <button
                    type="button"
                    :disabled="submitting"
                    wire:click="new"
                    class="bg-red-600 text-white px-4 py-2 rounded cursor-pointer rounded-sm disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    تحلیل جدید
                </button>
            </div>
        @endif
    </form>
    <div class="py-4">
        @if($response)
            <div class="mt-2">
                <h2 class="text-sm font-bold mb-2">پاسخ:</h2>
                {!! nl2br($response) !!}
            </div>
        @endif
    </div>
</div>
