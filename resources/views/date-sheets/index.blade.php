<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Date Sheet
                </h2>

                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:text-blue-800">
                        Home
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">Date Sheet</span>
                </div>
            </div>

            <a href="{{ route('date-sheets.create') }}"
               class="bg-[#111827] hover:bg-gray-800 text-white
                      px-7 py-2.5 rounded-md text-sm font-medium">
                Create DateSheet
            </a>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                @if(session('success'))
                    <div class="mb-5 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="text-left text-gray-700 border-b border-gray-200">
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Exam</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Class</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Session</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($dateSheets as $dateSheet)
                                <tr class="border-b border-gray-100">
                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $dateSheet->exam->exam_name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $dateSheet->studentClass->class_name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $dateSheet->session->name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <x-action-edit :href="route('date-sheets.edit', $dateSheet->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-gray-500">
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

</x-app-layout>
