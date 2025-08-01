<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @routes
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white flex flex-col items-center justify-center min-h-screen site-quiz">
<div class="container flex-grow">

</div>
<footer class="bottom-5 text-gray-400 text-sm text-center w-full py-3">
    کلیه حقوق مادی و معنوی این سایت برای <a href="https://portalogy.com" class="text-red-500 font-bold">پورتالوژی</a> محفوظ
    است.<br>
</footer>

</body>
</html>
