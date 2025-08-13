<x-admin-layout>
    @section('title', implode(' ', [
    __('Edit'),
    $item->mobile
    ]))
    <div class="bg-white p-6 rounded shadow-lg">
        <h2 class="text-xl font-bold mb-4">@yield('title')</h2>
        <form action="{{ route('admin.users.update', $item->id) }}" method="post" enctype="multipart/form-data">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block font-bold" for="mobile">موبایل / نام کاربری</label>
                        <input type="text" id="mobile" class="w-1xl p-2 border rounded" name="mobile"
                               value="{{ old('mobile', $item->mobile) }}">
                        @error('mobile')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold" for="name">نام</label>
                        <input type="text" id="name" class="w-1xl p-2 border rounded" name="name"
                               value="{{ old('name', $item->name) }}">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold" for="age">سن</label>
                        <input type="number" id="age" class="w-1xl p-2 border rounded" name="age"
                               value="{{ old('age', $item->age) }}">
                        @error('age')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold" for="password">پسورد (اختیاری)</label>
                        <input type="text" id="password" class="w-1xl p-2 border rounded" name="password">
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold" for="password_confirmation">تکرار پسورد</label>
                        <input type="text" id="password_confirmation" class="w-1xl p-2 border rounded" name="password_confirmation">
                        @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold" for="subscription_started_at">شروع اشتراک</label>
                        <input type="text" id="subscription_started_at" class="w-1xl p-2 border rounded"
                               name="subscription_started_at"
                               value="{{ old('subscription_started_at', $item->subscription_started_at) }}" data-jdp>
                        @error('subscription_started_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold" for="subscription_expires_at">پایان اشتراک</label>
                        <input type="text" id="subscription_expires_at" class="w-1xl p-2 border rounded"
                               name="subscription_expires_at"
                               value="{{ old('subscription_expires_at', $item->subscription_expires_at) }}" data-jdp>
                        @error('subscription_expires_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">ذخیره</button>
                </div>
                <div>
                    <div class="mb-4">
                        <p class="block font-bold mb-2">دسترسی</p>
                        <label class="flex items-center mb-1 cursor-pointer">
                            <input type="checkbox" class="ml-1" name="is_admin" value="1"
                                {{ old('is_admin', $item->is_admin ?? false) ? 'checked' : '' }}>
                            <span>ادمین</span>
                        </label>
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <p class="block font-bold mb-2">پادکست ها</p>
                        @php
                            $userPodcastIds = $item->podcasts->pluck('id')->toArray();
                        @endphp
                        @foreach(\App\Models\Podcast::get() as $podcast)
                            <label class="flex items-center mb-1 cursor-pointer">
                                <input type="checkbox" class="ml-1" name="podcasts[]" value="{{ $podcast->id }}"
                                    {{ in_array($podcast->id, old('podcasts', $userPodcastIds)) ? 'checked' : '' }}>
                                <span>{{ $podcast->title }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.css') }}">
        <script type="text/javascript" src="{{ asset('assets/jalalidatepicker/jalalidatepicker.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            jalaliDatepicker.startWatch();
        </script>
    @endpush
</x-admin-layout>
