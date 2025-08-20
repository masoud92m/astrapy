{{-- resources/views/site/package.blade.php --}}
<x-site-layout :title="'آستراپی | ' . $package->name">
    @php
        $hasSpecial = !empty($package->special_price) && $package->special_price < $package->price;
        $off = $hasSpecial && $package->price > 0
               ? max(1, floor((1 - ($package->special_price / $package->price)) * 100))
               : 0;
        $save = $hasSpecial ? ($package->price - $package->special_price) : 0;
    @endphp

        <!-- Breadcrumb -->
    <section class="border-b border-white/10 glass">
        <div class="max-w-6xl mx-auto px-4 py-4 text-sm text-gray-200/90 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:underline">خانه</a>
            <span class="opacity-60">/</span>
            <a href="{{ route('home') }}#packages" class="hover:underline">پکیج‌ها</a>
            <span class="opacity-60">/</span>
            <span class="text-gray-50 font-semibold">{{ $package->name }}</span>
        </div>
    </section>

    <!-- Header -->
    <section class="relative">
        <div class="max-w-6xl mx-auto px-4 py-8 sm:py-12 grid lg:grid-cols-2 gap-8 items-start">
            <!-- Media -->
            <div class="rounded-3xl overflow-hidden ring-1 ring-white/10 glass">
                <div class="relative">
                    @if($package->image_path)
                        <img src="{{ asset($package->image_path) }}" alt="{{ $package->name }}" class="w-full h-[320px] sm:h-[420px] object-cover">
                    @else
                        <div class="w-full h-[320px] sm:h-[420px] bg-white/10"></div>
                    @endif

                    @if($hasSpecial)
                        <!-- گوشه‌نوار تخفیف -->
                        <div class="absolute top-3 left-3">
                            <div class="relative">
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold
                                                 bg-gradient-to-r from-emerald-400 to-teal-500 text-black shadow-md">
                                        {{ $off }}٪ تخفیف ویژه
                                    </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary -->
            <div class="glass rounded-3xl p-6 sm:p-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold leading-relaxed">{{ $package->name }}</h1>

                @if(!empty($package->desc))
                    <p class="text-gray-100/90 mt-3 leading-8">
                        {{ $package->desc }}
                    </p>
                @endif

                <!-- Price -->
                <div class="mt-6">
                    <div class="rounded-2xl p-4 ring-1 ring-white/10 bg-white/[0.06] relative overflow-hidden">
                        @if($hasSpecial)
                            <!-- نوار گرادیانی باریک تزئینی -->
                            <span class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-yellow-400 via-pink-500 to-violet-500"></span>

                            <div class="flex items-end justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl font-extrabold text-amber-300 drop-shadow">
                                            {{ number_format($package->special_price) }}
                                        </span>
                                        <span class="text-xs text-gray-300/80">تومان</span>
                                    </div>
                                    <div class="text-xs text-gray-300/80">
                                        <del>{{ number_format($package->price) }}</del>
                                        <span class="ms-1 opacity-90">قبل از تخفیف</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-extrabold text-white">
                                    {{ number_format($package->price) }}
                                </span>
                                <span class="text-xs text-gray-300/80">تومان</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Badges -->
                <div class="mt-4 flex flex-wrap gap-2 text-xs">
                    <span class="rounded-full px-3 py-1 bg-white/10">آپدیت رایگان</span>
                    <span class="rounded-full px-3 py-1 bg-white/10">پشتیبانی ۷/۲۴</span>
                    <span class="rounded-full px-3 py-1 bg-white/10">ضمانت بازگشت وجه</span>
                </div>

                <!-- CTA -->
                <div class="mt-6">
                    <a href="#order" class="inline-flex rounded-2xl bg-gradient-to-r from-yellow-500 via-pink-500 to-violet-500 text-black font-extrabold px-6 py-3 hover:brightness-110 btn-neon">
                        شروع فرایند خرید
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Details (full width) -->
    <section class="py-6 sm:py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="glass rounded-3xl p-6 sm:p-8">
                <h2 class="text-xl sm:text-2xl font-bold mb-4">درباره پکیج</h2>
                <div class="prose prose-invert max-w-none leading-8">
                    {{-- اینجا محتوای مفصل «درباره پکیج» را قرار دهید (سرفصل‌ها، مخاطب هدف، نتایج، پیش‌نیازها و …) --}}
                </div>
            </div>
        </div>
    </section>

    <!-- Order Form (empty placeholder) -->
    <section id="order" class="py-8 sm:py-12 border-t border-white/10 glass">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="text-xl sm:text-2xl font-bold mb-4">ثبت سفارش</h2>
            <div class="rounded-2xl p-4 sm:p-6 bg-white/5 ring-1 ring-white/10">
                {{-- ⛳ اینجا فرم شما قرار می‌گیرد. --}}
                {{-- {!! $yourFormHtml !!} یا @livewire(...) --}}
            </div>
        </div>
    </section>
</x-site-layout>
