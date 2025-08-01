<x-admin-layout>
    @section('title', __('Users'))
    <form action="{{ route('users.index') }}" id="filter-form"></form>
    <div class="bg-white p-6 rounded shadow-lg">
        <div class="flex items-center w-full">
            <h2 class="text-xl font-bold mb-4">@yield('title')</h2>
            <div class="ms-auto">
                <a href="{{ route('users.create') }}"
                   class="bg-blue-600 text-white px-4 py-1 rounded">@lang('Create')</a>
            </div>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 p-2">#</th>
                <th class="border border-gray-300 p-2">نام</th>
                <th class="border border-gray-300 p-2">موبایل / نام کاربری</th>
                <th class="border border-gray-300 p-2">دسترسی به ادمین</th>
                <th class="border border-gray-300 p-2"></th>
            </tr>
            <tr class="">
                <th class="border border-gray-300 p-2">
                    <input type="text" class="w-1xl p-1 border rounded" name="id" value="{{ request('id') }}"
                           form="filter-form">
                </th>
                <th class="border border-gray-300 p-2">
                    <input type="text" class="w-1xl p-1 border rounded" name="name" value="{{ request('name') }}"
                           form="filter-form">
                </th>
                <th class="border border-gray-300 p-2">
                    <input type="text" class="w-1xl p-1 border rounded" name="mobile" value="{{ request('mobile') }}"
                           form="filter-form">
                </th>
                <th></th>
                <th class="border border-gray-300 p-2">
                    <button class="bg-green-600 text-white px-4 py-1 rounded cursor-pointer" form="filter-form">فیلتر
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td class="border border-gray-300 p-2">{{ $item->id }}</td>
                    <td class="border border-gray-300 p-2">{{ $item->name }}</td>
                    <td class="border border-gray-300 p-2">{{ $item->mobile }}</td>
                    <td class="border border-gray-300 p-2">{{ $item->is_admin ? 'بله' : 'خیر' }}</td>
                    <td class="border border-gray-300 p-2">
                        <a href="{{ route('users.edit', $item->id) }}"
                           class="bg-blue-600 text-white px-4 py-1 rounded">@lang('Edit')</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $items->appends(request()->except('page'))->links() }}
        </div>
    </div>
</x-admin-layout>
