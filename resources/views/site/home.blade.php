<!DOCTYPE html>
<html lang="fa" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فروش پکیج | صفحه اصلی</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.css') }}">
    @stack('styles')
</head>
<body class="bg-neutral-950 text-white min-h-dvh flex flex-col">
<header class="w-full border-b border-neutral-800/80 backdrop-blur supports-[backdrop-filter]:bg-neutral-950/70 sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="inline-block w-2 h-6 bg-neutral-900"></span>
            <span class="inline-block w-2 h-6 bg-yellow-500"></span>
            <span class="inline-block w-2 h-6 bg-gradient-to-b from-fuchsia-700 via-pink-600 to-orange-500"></span>
            <span class="font-bold text-lg">برند شما</span>
        </div>
        <nav class="hidden sm:flex items-center gap-6 text-sm text-gray-300">
            <a href="#packages" class="hover:text-white">پکیج‌ها</a>
            <a href="#faq" class="hover:text-white">سؤالات</a>
            <a href="#contact" class="hover:text-white">تماس</a>
        </nav>
    </div>
</header>

<section class="relative">
    <div class="max-w-6xl mx-auto px-4 py-10 sm:py-14 grid sm:grid-cols-2 gap-8 items-center">
        <div>
            <h1 class="text-2xl sm:text-4xl font-extrabold leading-relaxed">راه‌حل‌های ساده؛ نتیجه‌های واقعی</h1>
            <p class="text-gray-300 mt-3 leading-8">چهار پکیج جمع‌وجور و کارآمد که با در نظر گرفتن سبک زندگی تو طراحی شده‌اند. ساده، شفاف و قابل اعتماد.</p>
            <a href="#packages" class="inline-flex mt-6 rounded-2xl bg-gradient-to-r from-yellow-500 to-orange-500 text-black font-bold px-6 py-3 hover:brightness-110">مشاهده پکیج‌ها</a>
        </div>
        <div class="rounded-3xl overflow-hidden shadow-2xl ring-1 ring-white/10 h-56 sm:h-72">
            <div class="w-full h-full grid grid-cols-3">
                <div class="bg-neutral-900"></div>
                <div class="bg-yellow-500"></div>
                <div class="bg-gradient-to-br from-fuchsia-700 via-pink-600 to-orange-500"></div>
            </div>
        </div>
    </div>
</section>

<section id="packages" class="py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-xl sm:text-2xl font-bold mb-6">پکیج‌ها</h2>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $packages = [
                    ['title' => 'پکیج A', 'desc' => 'شروع سریع و اقتصادی.', 'tone' => 'neutral'],
                    ['title' => 'پکیج B', 'desc' => 'متعادل و پرفروش.', 'tone' => 'gold'],
                    ['title' => 'پکیج C', 'desc' => 'پیشرفته برای حرفه‌ای‌ها.', 'tone' => 'nebula'],
                    ['title' => 'پکیج D', 'desc' => 'کامل‌ترین انتخاب.', 'tone' => 'mix'],
                ];
            @endphp

            @foreach($packages as $p)
                <div class="rounded-2xl overflow-hidden border border-white/10 hover:border-white/20 transition group">
                    <div class="h-28 {{
                            $p['tone']==='gold'   ? 'bg-yellow-500' : (
                            $p['tone']==='nebula' ? 'bg-gradient-to-br from-fuchsia-700 via-pink-600 to-orange-500' : (
                            $p['tone']==='mix'    ? 'grid grid-cols-3' : 'bg-neutral-900')) }}">
                        @if($p['tone']==='mix')
                            <div class="h-full bg-neutral-900"></div>
                            <div class="h-full bg-yellow-500"></div>
                            <div class="h-full bg-gradient-to-br from-fuchsia-700 via-pink-600 to-orange-500"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $p['title'] }}</h3>
                        <p class="text-gray-300 text-sm mt-1 mb-4">{{ $p['desc'] }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-sm">شروع از <b class="text-white">—</b></span>
                            <a href="#" class="rounded-xl px-4 py-2 text-sm font-semibold bg-neutral-800 group-hover:bg-neutral-700">انتخاب</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<footer id="contact" class="mt-auto border-t border-neutral-800/80">
    <div class="max-w-6xl mx-auto px-4 py-8 text-sm text-gray-400">
        © {{ date('Y') }} برند شما
    </div>
</footer>
@livewire('site.login.modal')
@livewireScripts
<script type="text/javascript" src="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.js') }}"></script>
@stack('scripts')
<script>
    jalaliDatepicker.startWatch();
</script>
</body>
</html>
