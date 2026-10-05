<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Edit Parent Meeting
                </h2>
                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Home</a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('parent-meetings.index') }}" class="text-blue-600 hover:text-blue-800">Parent Meeting</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">Edit</span>
                </div>
            </div>

            <a href="{{ route('parent-meetings.index') }}"
               class="bg-black hover:bg-gray-800 text-white px-7 py-2.5 rounded-md text-sm font-medium">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-3 bg-gray-100 min-h-screen">
        <div class="max-w-full mx-auto px-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

                @if($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('parent-meetings.update', $parentMeeting->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Select Student <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="student_id"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ old('student_id', $parentMeeting->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                        @if($student->studentClass)
                                            ({{ $student->studentClass->class_name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Meeting Date
                            </label>
                            <input
                                type="date"
                                name="meeting_date"
                                value="{{ old('meeting_date', optional($parentMeeting->meeting_date)->format('Y-m-d')) }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Purpose
                            </label>
                            <input
                                type="text"
                                name="purpose"
                                value="{{ old('purpose', $parentMeeting->purpose) }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Meeting Attend
                            </label>
                            <select
                                name="meeting_attend"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                                @foreach(['Pending', 'Yes', 'No'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('meeting_attend', $parentMeeting->meeting_attend) === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-10">
                        <a href="{{ route('parent-meetings.index') }}"
                           class="bg-black hover:bg-gray-800 text-white px-6 py-2.5 rounded-md text-sm font-medium">
                            Close
                        </a>
                        <button
                            type="submit"
                            class="bg-black hover:bg-gray-800 text-white px-6 py-2.5 rounded-md text-sm font-medium"
                        >
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
