<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'پنل مدیریت')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.css') }}">
    <style>
        .transition-width {
            transition: width 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            width: 0 !important;
            overflow: hidden;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans">
<div class="flex">
    <div id="sidebar" class="bg-gray-800 text-white w-64 transition-width flex flex-col">
        <div class="p-4 text-lg font-bold">@lang('Admin Panel')</div>
        <ul>
            @foreach($menu as $item)
                <li class="">
                    <a href="{!! $item['route'] !!}"
                       class="block p-3 hover:bg-gray-600 cursor-pointer {{ $item['highlight'] ? 'bg-gray-700' : '' }}"
                    >{{ $item['title'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="flex-1 flex flex-col min-h-screen">
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <button onclick="toggleSidebar()" class="bg-gray-800 hover:bg-gray-600 text-white px-4 py-2 rounded cursor-pointer">☰</button>
            <div>
                <a href="{{ route('admin.logout') }}" class="bg-blue-600 text-white px-4 py-1 rounded cursor-pointer">خروج</a>
            </div>
        </div>

        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.js') }}"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('sidebar-collapsed');
    }
</script>
<script>
    jalaliDatepicker.startWatch({
        minDate: "attr",
        maxDate: "attr",
        time: false,
    });

</script>
@stack('scripts')
</body>
</html>
