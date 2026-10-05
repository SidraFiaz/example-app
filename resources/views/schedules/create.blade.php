<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-normal text-gray-800">
                Create Schedule
            </h2>

            <div class="flex items-center gap-2 text-sm mt-1">
                <a href="{{ route('dashboard') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Home
                </a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('schedules.index') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Time Table
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-500">Create Schedule</span>
            </div>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

                @if($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('schedules.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Class <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="class_id"
                                id="class_id"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Section
                            </label>
                            <select
                                name="section_id"
                                id="section_id"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Subject
                            </label>
                            <select
                                name="subject_id"
                                id="subject_id"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option
                                        value="{{ $subject->id }}"
                                        data-class="{{ $subject->class_id }}"
                                        {{ old('subject_id') == $subject->id ? 'selected' : '' }}
                                    >
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Weekdays <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="weekday"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Day</option>
                                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                    <option value="{{ $day }}" {{ old('weekday') === $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Time From
                            </label>
                            <input
                                type="time"
                                name="time_from"
                                value="{{ old('time_from') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Time To
                            </label>
                            <input
                                type="time"
                                name="time_to"
                                value="{{ old('time_to') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Teacher Name
                            </label>
                            <input
                                type="text"
                                name="teacher_name"
                                value="{{ old('teacher_name') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                    </div>

                    <div class="flex justify-center gap-4 mt-12">
                        <a href="{{ route('schedules.index') }}"
                           class="bg-[#111827] hover:bg-gray-800 text-white
                                  px-10 py-2.5 rounded-md text-sm font-medium">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="bg-[#111827] hover:bg-gray-800 text-white
                                   px-10 py-2.5 rounded-md text-sm font-medium"
                        >
                            Save
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const classSelect = document.getElementById('class_id');
            const sectionSelect = document.getElementById('section_id');
            const subjectSelect = document.getElementById('subject_id');
            const allSubjectOptions = Array.from(subjectSelect.querySelectorAll('option[data-class]'));

            function filterSubjects() {
                const classId = classSelect.value;
                const current = subjectSelect.value;

                subjectSelect.innerHTML = '<option value="">Select Subject</option>';

                if (!classId) {
                    return;
                }

                allSubjectOptions.forEach(function (option) {
                    if (String(option.dataset.class) === String(classId)) {
                        subjectSelect.appendChild(option.cloneNode(true));
                    }
                });

                if (current) {
                    subjectSelect.value = current;
                }
            }

            classSelect.addEventListener('change', function () {
                const classId = this.value;
                sectionSelect.innerHTML = '<option value="">Select Section</option>';

                if (classId) {
                    fetch("{{ url('/get-sections') }}/" + classId)
                        .then(response => response.json())
                        .then(sections => {
                            sections.forEach(function (section) {
                                const option = document.createElement('option');
                                option.value = section.id;
                                option.textContent = section.section_name;
                                sectionSelect.appendChild(option);
                            });
                        });
                }

                filterSubjects();
            });

            filterSubjects();
        });
    </script>

</x-app-layout>
