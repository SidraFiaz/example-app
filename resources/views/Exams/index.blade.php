<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-semibold text-xl text-gray-800">
                    Session Exams
                </h2>

                @if($session)
                    <p class="text-sm text-gray-500 mt-1">
                        Session: {{ $session->name }}
                    </p>
                @endif
            </div>

            <a href="{{ $session
                ? route('exams.create', ['session_id' => $session->id])
                : route('exams.create') }}"
               class="inline-flex items-center px-4 py-2 bg-black
                      border border-transparent rounded-md font-semibold
                      text-xs text-white uppercase tracking-widest
                      hover:bg-gray-800 transition">

                + Add Exam

            </a>

        </div>
    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-4 p-4 bg-green-100 border border-green-200
                            text-green-700 rounded-md">

                    {{ session('success') }}

                </div>

            @endif


            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    {{-- Session Information --}}
                    @if($session)

                        <div class="mb-6 p-4 bg-gray-50 border rounded-md">

                            <p class="text-sm text-gray-500">
                                Academic Session
                            </p>

                            <p class="text-lg font-semibold text-gray-800">
                                {{ $session->name }}
                            </p>

                        </div>

                    @endif


                    {{-- Search Exam --}}
                    <div class="mb-6">

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Search Exam
                        </label>

                        <input
                            type="text"
                            id="examSearch"
                            placeholder="Search exam..."
                            class="w-full border-gray-300 rounded-md shadow-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >

                    </div>


                    {{-- Exams Table --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               uppercase tracking-wider">
                                        Exam
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               uppercase tracking-wider">
                                        Total Marks
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               uppercase tracking-wider">
                                        Start Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               uppercase tracking-wider">
                                        End Date
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs
                                               font-medium text-gray-500
                                               uppercase tracking-wider">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody
                                id="examTableBody"
                                class="bg-white divide-y divide-gray-200"
                            >

                                @forelse($exams as $exam)

                                    <tr class="exam-row">

                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-sm font-medium
                                                   text-gray-900 exam-name">

                                            {{ $exam->exam_name }}

                                        </td>


                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-sm text-gray-700">

                                            {{ $exam->total_marks ?? '-' }}

                                        </td>


                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-sm text-gray-700">

                                            {{ $exam->start_date
                                                ? $exam->start_date->format('d-m-Y')
                                                : '-' }}

                                        </td>


                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-sm text-gray-700">

                                            {{ $exam->end_date
                                                ? $exam->end_date->format('d-m-Y')
                                                : '-' }}

                                        </td>


                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-right text-sm">

                                            <div class="action-btn-group justify-end">

                                                <x-action-edit :href="route('exams.edit', $exam->id)" />

                                                <form
                                                    action="{{ route('exams.destroy', $exam->id) }}"
                                                    method="POST"
                                                    data-delete-confirm="Are you sure you want to delete this exam?"
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

                                        <td colspan="5"
                                            class="px-6 py-8 text-center
                                                   text-sm text-gray-500">

                                            No exams found for this session.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Search Script --}}
    <script>

        document.getElementById('examSearch').addEventListener('keyup', function () {

            let searchValue = this.value.toLowerCase();

            let rows = document.querySelectorAll('.exam-row');

            rows.forEach(function (row) {

                let examName = row
                    .querySelector('.exam-name')
                    .textContent
                    .toLowerCase();

                if (examName.includes(searchValue)) {

                    row.style.display = '';

                } else {

                    row.style.display = 'none';

                }

            });

        });

    </script>

</x-app-layout>