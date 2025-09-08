<div class="mt-3" x-data="{submitting : false}">
    <form>
        @foreach($questions as $question)
            <div class="mb-5">
                <label class="block mb-1 text-sm font-medium text-gray-200">
                    {{ $question->content }}
                    @if($question->is_required)
                        <span class="text-red-400">*</span>
                    @endif
                </label>

                @switch($question->type)
                    @case('text')
                        <input type="text"
                               wire:model.defer="answers.{{ $question->id }}"
                               class="w-full rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300
                                      focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 p-3">
                        @break

                    @case('date')
                        <input type="text"
                               wire:model.defer="answers.{{ $question->id }}"
                               data-jdp
                               data-jdp-max-date="today"
                               class="w-full rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300
                                      focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 p-3">
                        @break

                    @case('select')
                        <select wire:model.defer="answers.{{ $question->id }}"
                                class="w-full rounded-xl bg-white/20 border border-white/30 text-white
                                       focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 p-3">
                            <option value="" selected>انتخاب کن…</option>
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

        <!-- دکمه و لودر -->
        <div class="flex items-center justify-between pt-2 sm:w-1/2">
            <div class="flex items-center">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl px-5 py-3 font-semibold
                               bg-gradient-to-r from-yellow-400 via-pink-500 to-violet-500 text-black
                               hover:brightness-110 shadow-lg btn-neon disabled:opacity-50 disabled:cursor-not-allowed"
                        x-on:click="
                            if (submitting) return;
                            submitting = true;
                            $wire.submit()
                            .finally(() => { submitting = false });
                        "
                        :disabled="submitting"
                >
                    دریافت تحلیل
                </button>
                <div x-show="submitting" class="mr-3 mt-1">
                    <span class="loader"></span>
                </div>
            </div>
        </div>
    </form>

    <!-- پاسخ -->
    <div class="py-6">
        @if($response)
            <div class="glass rounded-2xl p-4 mt-2">
                <h2 class="text-sm font-bold mb-2">پاسخ:</h2>
                {!! nl2br($response) !!}
            </div>
        @endif
    </div>
</div>
