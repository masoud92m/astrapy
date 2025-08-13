<x-admin-layout>
    @section('title', 'دریافت تحلیل')
    <form action="{{ route('admin.users.index') }}" id="filter-form"></form>
    <div class="bg-white p-5 rounded shadow-lg">
        <div class="flex items-center w-full">
            <h2 class="text-xl font-bold mb">@yield('title')</h2>
            <div class="ms-auto"></div>
        </div>
        @livewire('admin.package.get-analysis')
    </div>
</x-admin-layout>
