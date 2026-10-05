<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Fee Process
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Main Box --}}
            <div class="bg-white rounded-lg shadow-sm p-6">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Search / Filter --}}
                <div class="flex flex-wrap items-center gap-4 mb-7">

                    {{-- Search --}}
                    <div>
                        <input
                            type="text"
                            id="search"
                            placeholder="Search name, code"
                            class="w-52 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-300 focus:border-gray-400">
                    </div>

                    {{-- Class --}}
                    <div>
                        <select
                            id="classFilter"
                            class="w-52 border border-gray-300 rounded-md px-4 py-2 bg-white">

                            <option value="">Select Class</option>

                            @foreach($fees->pluck('studentClass')->filter()->unique('id') as $class)
                                <option value="{{ $class->class_name }}">
                                    {{ $class->class_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Reset --}}
                    <button
                        type="button"
                        id="resetBtn"
                        class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800 transition">

                        Reset
                    </button>

                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="w-full border-separate border-spacing-y-3">

                        <thead>
                            <tr class="text-gray-600 text-left">

                                <th class="px-4 py-2 font-semibold">
                                    Student Code
                                </th>

                                <th class="px-4 py-2 font-semibold">
                                    Student
                                </th>

                                <th class="px-4 py-2 font-semibold">
                                    Class
                                </th>

                                <th class="px-4 py-2 font-semibold">
                                    Section
                                </th>

                                <th class="px-4 py-2 font-semibold">
                                    Fee Month
                                </th>

                                <th class="px-4 py-2 font-semibold text-center">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody id="feeTable">

                            @forelse($fees as $fee)

                                <tr
                                    class="fee-row bg-white shadow-sm hover:shadow-md transition"
                                    data-name="{{ strtolower($fee->student->name ?? '') }}"
                                    data-code="{{ $fee->student->id ?? '' }}"
                                    data-class="{{ strtolower($fee->studentClass->class_name ?? '') }}">

                                    <td class="px-4 py-4 border-y border-l border-gray-200 rounded-l-md">
                                        {{ $fee->student->id ?? '' }}
                                    </td>

                                    <td class="px-4 py-4 border-y border-gray-200">
                                        {{ $fee->student->name ?? '' }}
                                    </td>

                                    <td class="px-4 py-4 border-y border-gray-200">
                                        {{ $fee->studentClass->class_name ?? '' }}
                                    </td>

                                    <td class="px-4 py-4 border-y border-gray-200">
                                        {{ $fee->student->section->section_name ?? '' }}
                                    </td>

                                    <td class="px-4 py-4 border-y border-gray-200">
                                        {{ $fee->month }}-{{ $fee->year }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-4 border-y border-r border-gray-200 rounded-r-md">

                                        <div class="flex justify-center gap-2">

                                            {{-- View --}}
                                        <div class="action-btn-group">

                                            <a href="{{ route('fee-process.show', $fee->id) }}"
                                               class="action-btn bg-gray-700 hover:bg-gray-800 text-white">
                                                View
                                            </a>

                                            <form
                                                action="{{ route('fee-process.destroy', $fee->id) }}"
                                                method="POST"
                                                data-delete-confirm="Are you sure you want to delete this fee?">
                                                @csrf
                                                @method('DELETE')
                                                <x-action-delete />
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="6"
                                        class="text-center py-8 text-gray-500">

                                        No Fee Process Found

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- Search + Filter Script --}}
    <script>

        const search = document.getElementById('search');
        const classFilter = document.getElementById('classFilter');
        const resetBtn = document.getElementById('resetBtn');

        function filterRows() {

            const searchValue = search.value.toLowerCase();
            const classValue = classFilter.value.toLowerCase();

            document.querySelectorAll('.fee-row').forEach(row => {

                const name = row.dataset.name;
                const code = row.dataset.code;
                const className = row.dataset.class;

                const searchMatch =
                    name.includes(searchValue) ||
                    code.includes(searchValue);

                const classMatch =
                    classValue === '' ||
                    className === classValue;

                if (searchMatch && classMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }

            });

        }

        search.addEventListener('input', filterRows);

        classFilter.addEventListener('change', filterRows);

        resetBtn.addEventListener('click', function () {

            search.value = '';
            classFilter.value = '';

            filterRows();

        });

    </script>

</x-app-layout>