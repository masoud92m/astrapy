<x-site-layout title="آستروپینکی | صفحه اصلی">

    <!-- Hero Section -->
    <section class="relative">
        <div class="max-w-6xl mx-auto px-4 py-10 sm:py-14 grid sm:grid-cols-2 gap-8 items-center">
            <div class="glass rounded-3xl p-6 sm:p-8">
                <div class="text-2xl sm:text-4xl font-extrabold leading-relaxed">
                    <div>راه‌حل‌های ساده؛</div>
                    <div class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-pink-400 to-violet-400 flex justify-center">
                        نتیجه‌های واقعی
                    </div>
                </div>
                <p class="text-gray-100/90 mt-3 leading-8">
                    چهار پکیج جمع‌وجور و کارآمد که با در نظر گرفتن سبک زندگی تو طراحی شده‌اند. شفاف، عملی و قابل اعتماد.
                </p>
                <a href="#packages"
                   class="inline-flex mt-6 rounded-2xl bg-gradient-to-r from-yellow-500 via-pink-500 to-violet-500 text-black font-extrabold px-6 py-3 hover:brightness-110 btn-neon">
                    مشاهده پکیج‌ها
                </a>
                <p class="text-xs text-gray-200/80 mt-3">پشتیبانی ۷/۲۴، ضمانت بازگشت وجه، آپدیت رایگان</p>
            </div>

            <div class="rounded-3xl overflow-hidden ring-1 ring-white/10 h-56 sm:h-72 glass">
                <div class="relative w-full h-full">
                    <div class="absolute inset-0 grid grid-cols-3">
                        <div class="bg-white/10"></div>
                        <div class="bg-yellow-500/25"></div>
                        <div class="bg-gradient-to-br from-fuchsia-700/30 via-pink-600/30 to-orange-500/30"></div>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="rounded-full w-40 h-40 sm:w-56 sm:h-56 bg-gradient-to-tr from-yellow-300 via-pink-400 to-violet-500 opacity-40 blur-2xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-10 sm:py-14">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-end justify-between mb-6">
                <h2 class="text-xl sm:text-2xl font-bold">پکیج‌ها</h2>
                <span class="text-xs text-gray-100/80">انتخاب هوشمند با ضمانت رضایت</span>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($packages as $package)
                    @php
                        $hasSpecial = !empty($package->special_price) && $package->special_price < $package->price;
                        $off = $hasSpecial && $package->price > 0
                               ? max(1, floor((1 - ($package->special_price / $package->price)) * 100))
                               : 0;
                    @endphp

                    <a href="{{ route('package', $package->slug) }}" class="rounded-2xl overflow-hidden glass hover:border-white/30 transition group">
                        <div class="h-40 relative overflow-hidden">
                            @if($package->image_path)
                                <img class="w-full h-full object-cover opacity-95 group-hover:opacity-100 transition"
                                     src="{{ asset($package->image_path) }}" alt="{{ $package->name }}">
                            @else
                                <div class="w-full h-full bg-white/10"></div>
                            @endif

                            @if($hasSpecial)
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold
                                                 bg-gradient-to-r from-emerald-400 to-teal-500 text-black shadow-md">
                                        {{ $off }}٪ تخفیف ویژه
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-1 min-h-[3.5rem] flex">
                                {{ $package->name }}
                            </h3>
                            @if(!empty($package['desc']))
                                <p class="text-gray-200 text-sm mb-4 leading-6 line-clamp-3">{{ $package['desc'] }}</p>
                            @endif

                            <div class="flex items-end justify-between">
                                <div>
                                    @if($hasSpecial)
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-2xl font-extrabold text-amber-300 drop-shadow">
                                                {{ number_format($package->special_price) }}
                                            </span>
                                            <span class="text-xs text-gray-300/80">تومان</span>
                                        </div>
                                        <div class="text-xs text-gray-300/80 mt-1">
                                            <del>{{ number_format($package->price) }}</del>
                                            <span class="ms-1">قبل از تخفیف</span>
                                        </div>
                                    @else
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-2xl font-extrabold text-white">
                                                {{ number_format($package->price) }}
                                            </span>
                                            <span class="text-xs text-gray-300/80">تومان</span>
                                        </div>
                                    @endif
                                </div>

                                <span class="rounded-xl px-4 py-2 text-sm font-semibold bg-white/15 hover:bg-white/25 transition">
                                    مشاهده
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

</x-site-layout>
