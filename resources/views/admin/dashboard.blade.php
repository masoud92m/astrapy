<x-admin-layout>
    @section('title', __('Dashboard'))
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">خلاصه وضعیت</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('admin.users.index') }}"
               class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">تعداد کاربران</div>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ \App\Models\User::count() }}</div>
                </div>
                <div class="text-blue-500 text-3xl">👤</div>
            </a>

{{--            <a href="{{ route('instructors.index') }}"--}}
{{--               class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 flex items-center justify-between hover:shadow-md transition">--}}
{{--                <div>--}}
{{--                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">مربیان فعال</div>--}}
{{--                    <div--}}
{{--                        class="text-2xl font-bold text-gray-800 dark:text-white">{{ \App\Models\Instructor::count() }}</div>--}}
{{--                </div>--}}
{{--                <div class="text-green-500 text-3xl">🏋️</div>--}}
{{--            </a>--}}

{{--            <a href="{{ route('podcasts.index') }}"--}}
{{--               class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 flex items-center justify-between hover:shadow-md transition">--}}
{{--                <div>--}}
{{--                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">پادکست‌ها</div>--}}
{{--                    <div--}}
{{--                        class="text-2xl font-bold text-gray-800 dark:text-white">{{ \App\Models\Podcast::count() }}</div>--}}
{{--                </div>--}}
{{--                <div class="text-purple-500 text-3xl">🎧</div>--}}
{{--            </a>--}}

{{--            <a href="{{ route('respondents.index') }}"--}}
{{--               class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 flex items-center justify-between hover:shadow-md transition">--}}
{{--                <div>--}}
{{--                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">پاسخنامه های پر شده</div>--}}
{{--                    <div--}}
{{--                        class="text-2xl font-bold text-gray-800 dark:text-white">{{ \App\Models\Respondent::count() }}</div>--}}
{{--                </div>--}}
{{--                <div class="text-pink-500 text-3xl">📝</div>--}}
{{--            </a>--}}

{{--            <a href=""--}}
{{--               class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 flex items-center justify-between hover:shadow-md transition">--}}
{{--                <div>--}}
{{--                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">وبینار های ثبت نام شده</div>--}}
{{--                    <div--}}
{{--                        class="text-2xl font-bold text-gray-800 dark:text-white">{{ \App\Models\WebinarLead::count() }}</div>--}}
{{--                </div>--}}
{{--                <div class="text-pink-500 text-3xl">🖥️🎥</div>--}}
{{--            </a>--}}
        </div>
    </div>

{{--    <div class="p6 bg-red">--}}
{{--        <div class="max-w mx-auto mt-10 p-4 bg-white rounded-2xl shadow-lg">--}}
{{--            <canvas id="myChart" width="500" height="100"></canvas>--}}
{{--        </div>--}}
{{--    </div>--}}

    @push('scripts')
        <script src="{{ asset('assets/chart.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('myChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['{!! implode("','", $respondents['label']) !!}'],
                        datasets: [{
                            label: 'ثبت پاسخنامه',
                            data: [{!! implode(",", $respondents['data']) !!}],
                            // backgroundColor: ['#60a5fa', '#34d399', '#fbbf24'],
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
