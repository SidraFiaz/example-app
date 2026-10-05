<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Under 5 Student Polio Report
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Header --}}
                <div class="p-6 flex items-center justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Under 5 Student Polio Report
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Class: {{ $class->class_name }}
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="window.print()"
                        class="inline-flex items-center px-4 py-2
                               bg-gray-800 border border-transparent
                               rounded-md font-semibold text-xs
                               text-white uppercase tracking-widest
                               hover:bg-gray-700"
                    >
                        Print Report
                    </button>

                </div>


                {{-- Table --}}
                <div class="p-6 overflow-x-auto">

                    <table class="w-full border border-gray-400 border-collapse">

                        <thead>

                            <tr class="bg-gray-200">

                                <th class="border border-gray-400 px-4 py-2">
                                    Sr#
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Student Name
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Father Name
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Family No
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Section
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Father Contact
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($admissions as $admission)

                                <tr>

                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->student_name }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->father_name }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->family_no ?? 'N/A' }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->section->section_name ?? 'N/A' }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->father_contact ?? 'N/A' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="border border-gray-400 px-4 py-8
                                               text-center text-gray-500"
                                    >
                                        No students found for this class.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>