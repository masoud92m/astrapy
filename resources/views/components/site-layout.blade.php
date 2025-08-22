@props(['title' => 'آستروپینکی'])

    <!DOCTYPE html>
<html lang="fa" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.css') }}">
    @stack('styles')
</head>

<body class="space-bg text-white min-h-dvh flex flex-col vignette">
<div class="aurora"></div>

<!-- Header -->
<header class="w-full border-b border-white/10 backdrop-blur supports-[backdrop-filter]:bg-black/15 sticky top-0 z-40 glass">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="inline-block w-2 h-6 bg-white/10"></span>
            <span class="inline-block w-2 h-6 bg-yellow-500"></span>
            <span class="inline-block w-2 h-6 bg-gradient-to-b from-fuchsia-600 via-pink-500 to-amber-400"></span>
            <h1 class="font-bold text-lg tracking-tight">آستروپینکی</h1>
        </div>
        <nav class="hidden sm:flex items-center gap-6 text-sm text-gray-200">
            <a href="#packages" class="hover:text-white transition">پکیج‌ها</a>
            <a href="#contact" class="hover:text-white transition">تماس</a>
        </nav>
    </div>
</header>

<!-- Main content -->
<main class="flex-grow">
    {{ $slot }}
</main>

<!-- Footer -->
<footer id="contact" class="mt-auto border-t border-white/10 glass">
    <div class="max-w-6xl mx-auto px-4 py-8 text-sm text-gray-200/90">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© {{ date('Y') }} <a href="{{ route('home') }}" class="hover:underline">آستروپینکی</a></p>
            <div class="text-xs text-gray-200/80">ساخته‌شده با ❤️ و کمی غبار ستاره</div>
        </div>
    </div>
</footer>

@livewire('site.login.modal')

@livewireScripts
<script src="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.js') }}"></script>
@stack('scripts')
<script> jalaliDatepicker.startWatch(); </script>
</body>
</html>
