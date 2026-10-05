<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Time Table
                </h2>

                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:text-blue-800">
                        Home
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">Schedule List</span>
                </div>
            </div>

            <a href="{{ route('schedules.create') }}"
               class="bg-[#111827] hover:bg-gray-800 text-white
                      px-7 py-2.5 rounded-md text-sm font-medium">
                Add Schedule
            </a>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">

                @if(session('success'))
                    <div class="mb-5 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-7">
                    <label class="block text-sm font-medium text-gray-800 mb-2">
                        Search Items
                    </label>
                    <input
                        type="text"
                        id="searchItems"
                        class="w-full h-11 rounded-md border border-gray-300
                               focus:border-black focus:ring-black
                               text-sm text-gray-700"
                    >
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="text-left text-gray-700 border-b border-gray-200">
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Class</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Schedule</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($schedules as $schedule)
                                <tr class="border-b border-gray-100 schedule-row">
                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $schedule->studentClass->class_name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <a href="{{ route('schedules.show', $schedule->id) }}"
                                           class="text-blue-600 hover:text-blue-800 hover:underline text-sm">
                                            View Schedule
                                        </a>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="action-btn-group">
                                            <x-action-edit :href="route('schedules.edit', $schedule->id)" />

                                            <form
                                                action="{{ route('schedules.destroy', $schedule->id) }}"
                                                method="POST"
                                                data-delete-confirm="Are you sure you want to delete this schedule?"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <x-action-delete />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-10 text-center text-gray-500">
                                        No data available in table
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchItems');
            const rows = document.querySelectorAll('.schedule-row');

            searchInput.addEventListener('keyup', function () {
                const search = this.value.toLowerCase().trim();
                rows.forEach(function (row) {
                    row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
                });
            });
        });
    </script>

</x-app-layout>
