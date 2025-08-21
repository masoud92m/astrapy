<div class="mt-3 min-h-[calc(100vh-200px)]" x-data="{submitting : false}">
    <form>
        <div class="mb-3 sm:w-1/2">
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

            @foreach($questions as $question)
                <div class="mb-3 sm:w-1/2">
                    <label class="block mb-1 text-sm">
                        {{ $question->content }}
                        @if($question->is_required)
                            <span class="text-red-500">*</span>
                        @endif
                    </label>

                    @switch($question->type)
                        @case('text')
                            <input type="text"
                                   wire:model.defer="answers.{{ $question->id }}"
                                   class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2"
                                   placeholder="">
                            @break

                        @case('date')
                            <input type="text"
                                   wire:model.defer="answers.{{ $question->id }}"
                                   data-jdp
                                   class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2">
                            @break

                        @case('select')
                            <select wire:model.defer="answers.{{ $question->id }}"
                                    class="w-full rounded-sm border border-gray-700 focus:border-gray-500 focus:ring-0 p-2">
                                <option value="" disabled selected>انتخاب کن…</option>
                                @foreach($question->options as $option)
                                    <option value="{{ $option->value }}">{{ $option->value }}</option>
                                @endforeach
                            </select>
                            @break
                    @endswitch

                    @error("answers.{$question->id}")
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach


            <div class="flex items-center justify-between pt-2 sm:w-1/2">
                <div class="flex items-center">
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
                    <div x-show="submitting" class="mr-2 mt-1">
                        <span class="loader"></span>
                    </div>
                </div>
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
