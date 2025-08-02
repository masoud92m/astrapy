<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأیید شماره موبایل</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-800 flex flex-col items-center justify-center min-h-screen login">
<div class="container flex-grow">
    <div class="bg-gray-700 p-6 rounded-lg shadow-lg w-96 max-w-[90%] text-center mt-[30pt] mx-auto">
    <form action="" id="mobile-form">
            <h2 class="text-white text-xl font-bold ">ورود / ثبت نام</h2>

            <div class="text-right mb-2">
                <label class="text-gray-300 text-sm block mb-1">شماره همراه</label>
                <input type="text" id="mobile" value="" name="mobile"
                       class="w-full px-3 py-2 rounded bg-gray-900 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-center ltr">
            </div>

            <p class="text-red-500 text-sm mt-2 hidden error-message"></p>
            <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-lg font-bold cursor-pointer mt-4"
                    type="submit">ارسال کد تایید
            </button>
        </form>

        <form action="" id="verify-form" class="hidden mt-4">
            <h2 class="text-white text-xl font-bold mb-4">تایید شماره موبایل</h2>

            <div class="text-right mb-3">
                <label class="text-gray-300 text-sm block mb-1" for="verify-mobile">شماره همراه</label>
                <input type="text" value="" disabled name="mobile" id="verify-mobile"
                       class="w-full px-3 py-2 rounded bg-gray-900 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-center ltr">
            </div>

            <div class="text-right mb-3 name-box">
                <label class="text-gray-300 text-sm block mb-1" for="name">نام و نام خانوادگی</label>
                <input type="text" value="" id="name"
                       class="w-full px-3 py-2 rounded bg-gray-900 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-center">
            </div>

            <div class="text-right mb-3 age-box">
                <label class="text-gray-300 text-sm block mb-1" for="age">سن</label>
                <input type="text" value="" id="age"
                       autocomplete="off"
                       class="w-full px-3 py-2 rounded bg-gray-900 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-center">
            </div>

            <div class="text-right mb-3">
                <label class="text-gray-300 text-sm block mb-1" for="otp">کد تایید</label>
                <input type="text" placeholder="" id="otp" name="otp"
                       autocomplete="off"
                       class="w-full px-3 py-2 rounded bg-gray-900 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-center">
            </div>

            <div class="flex items-center justify-between mb-4">
            <span class="bg-gray-500 text-white px-3 py-1 rounded flex items-center opacity-50 cursor-not-allowed"
                  id="resend-otp">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h6" />
                </svg>
                ارسال مجدد
            </span>
                <span class="text-red-500 text-lg font-bold" id="timer"></span>
            </div>

            <p class="text-red-500 text-sm mt-2 hidden error-message"></p>

            <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-lg font-bold cursor-pointer">
                ورود
            </button>
            <span class="block text-blue-400 mt-3 cursor-pointer" id="edit-mobile">ویرایش شماره همراه</span>
        </form>
    </div>

</div>
<footer class="bottom-5 text-gray-400 text-sm text-center w-full py-3">
    کلیه حقوق مادی و معنوی این سایت برای <a href="https://portalogy.com" class="text-red-500 font-bold">پورتالوژی</a> محفوظ
    است.<br>
</footer>
</body>
</html>
