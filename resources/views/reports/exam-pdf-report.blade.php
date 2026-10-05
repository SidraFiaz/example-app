<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Exam PDF Reports
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                {{-- Page Header --}}
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Exam PDF Report
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Select the required information to generate the examination result PDF.
                    </p>
                </div>

                {{-- Form --}}
                <form method="GET" action="#" class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Session --}}
                        <div>
                            <label for="session_id"
                                   class="block text-sm font-medium text-gray-700 mb-2">
                                Session
                            </label>

                            <select id="session_id"
        name="session_id"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">

    <option value="">Select Session</option>

    @foreach($sessions as $session)
        <option value="{{ $session->id }}"
            {{ old('session_id', $selectedSessionId ?? '') == $session->id ? 'selected' : '' }}>
            {{ $session->name }}
        </option>
    @endforeach

</select>
                        </div>

                       {{-- Class --}}
<div>
    <label for="class_id"
           class="block text-sm font-medium text-gray-700 mb-2">
        Class
    </label>

    <select id="class_id"
            name="class_id"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">

        <option value="">
            Select Class
        </option>

        @foreach($classes as $class)
            <option value="{{ $class->id }}"
                {{ old('class_id', $selectedClassId ?? '') == $class->id ? 'selected' : '' }}>
                {{ $class->class_name }}
            </option>
        @endforeach

    </select>
</div>

                      {{-- Section --}}
<div>
    <label for="section_id"
           class="block text-sm font-medium text-gray-700 mb-2">
        Section
    </label>

    <select id="section_id"
            name="section_id"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">

        <option value="">
            Select Section
        </option>

    </select>
</div>

                        {{-- Examination --}}
                        <div>
                            <label for="exam_id"
                                   class="block text-sm font-medium text-gray-700 mb-2">
                                Examination
                            </label>

                            <select id="exam_id"
                                    name="exam_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">

                                <option value="">
                                    Select Examination
                                </option>

                                {{-- Exams will be connected in the next step --}}
                            </select>
                        </div>

                        {{-- Student --}}
                        <div class="md:col-span-2">
                            <label for="student_id"
                                   class="block text-sm font-medium text-gray-700 mb-2">
                                Student
                            </label>

                            <select id="student_id"
                                    name="student_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">

                                <option value="">
                                    All Students
                                </option>

                                {{-- Students will be connected in the next step --}}
                            </select>

                            <p class="text-xs text-gray-500 mt-1">
                                Leave as “All Students” to generate the report for all students
                                in the selected class and section.
                            </p>
                        </div>

                    </div>

                    {{-- Generate Button --}}
                    <div class="mt-8 flex justify-end">

                        <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">

                            Generate PDF

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

        classSelect.addEventListener('change', function () {

            const classId = this.value;

            // Reset section dropdown
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (!classId) {
                return;
            }

            fetch(`/exam-pdf-report/sections/${classId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load sections.');
                    }

                    return response.json();
                })
                .then(sections => {

                    sections.forEach(section => {

                        const option = document.createElement('option');

                        option.value = section.id;
                        option.textContent = section.section_name;

                        sectionSelect.appendChild(option);
                    });

                })
                .catch(error => {
                    console.error('Error loading sections:', error);
                });
        });

    });
</script>

</x-app-layout>