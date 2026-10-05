<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    View Schedule
                </h2>
                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Home</a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('schedules.index') }}" class="text-blue-600 hover:text-blue-800">Time Table</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">
                        {{ $schedule->studentClass->class_name ?? 'Schedule' }}
                    </span>
                </div>
            </div>

            <a href="{{ route('schedules.index') }}"
               class="bg-[#111827] hover:bg-gray-800 text-white px-7 py-2.5 rounded-md text-sm font-medium">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-3 bg-gray-100 min-h-screen">
        <div class="max-w-full mx-auto px-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="text-left text-gray-700 border-b border-gray-200">
                                <th class="px-5 py-3 font-semibold">Weekday</th>
                                <th class="px-5 py-3 font-semibold">Subject</th>
                                <th class="px-5 py-3 font-semibold">Section</th>
                                <th class="px-5 py-3 font-semibold">Time From</th>
                                <th class="px-5 py-3 font-semibold">Time To</th>
                                <th class="px-5 py-3 font-semibold">Teacher</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classSchedules as $item)
                                <tr class="border-b border-gray-100">
                                    <td class="px-5 py-4 text-gray-700">{{ $item->weekday }}</td>
                                    <td class="px-5 py-4 text-gray-700">{{ $item->subject->subject_name ?? '-' }}</td>
                                    <td class="px-5 py-4 text-gray-700">{{ $item->section->section_name ?? '-' }}</td>
                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $item->time_from ? \Illuminate\Support\Str::substr($item->time_from, 0, 5) : '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $item->time_to ? \Illuminate\Support\Str::substr($item->time_to, 0, 5) : '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">{{ $item->teacher_name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                        No schedule found for this class.
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
