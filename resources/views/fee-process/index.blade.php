<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Fee Process
                </h2>
            </div>

        </div>
    </x-slot>


    <div class="py-3 bg-gray-50 min-h-screen">

        <div class="max-w-full mx-auto px-2 sm:px-6 lg:px-6">

            {{-- Errors --}}
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Main Fee Process Box --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">

                <form action="{{ route('fee-process.store') }}" method="POST" id="fee-process-form">
                    @csrf

                    <div class="p-7">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-7 gap-y-4">

                           <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Session
    </label>

    <select
        name="session"
        class="w-full h-10 rounded-md border-gray-300 bg-white text-gray-600 focus:border-blue-500 focus:ring-blue-500"
        required
    >
        <option value="">Select Session</option>

        @for($year = date('Y') - 2; $year <= date('Y') + 2; $year++)
            @php
                $session = $year . '-' . ($year + 1);
            @endphp

            <option
                value="{{ $session }}"
                {{ old('session', date('Y') . '-' . (date('Y') + 1)) == $session ? 'selected' : '' }}
            >
                {{ $session }}
            </option>
        @endfor
    </select>
</div>
                            {{-- For Month --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    For Month
                                </label>

                                <select
                                    name="month"
                                    class="w-full h-10 rounded-md border-gray-300 bg-gray-100 text-gray-600 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">Select Month</option>

                                    @foreach([
                                        'January',
                                        'February',
                                        'March',
                                        'April',
                                        'May',
                                        'June',
                                        'July',
                                        'August',
                                        'September',
                                        'October',
                                        'November',
                                        'December'
                                    ] as $month)

                                        <option
                                            value="{{ $month }}"
                                            {{ old('month') == $month ? 'selected' : '' }}
                                        >
                                            {{ $month }}
                                        </option>

                                    @endforeach
                                </select>
                            </div>


                            {{-- Class --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Class <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="class_id"
                                    id="class_id"
                                    class="w-full h-10 rounded-md border-gray-300 bg-white text-gray-600 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">Select Class</option>

                                    @foreach($classes as $class)
                                        <option
                                            value="{{ $class->id }}"
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}
                                        >
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                           {{-- Section --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Section
        <span class="text-gray-400 font-normal">(optional)</span>
    </label>

    <select
        name="section_id"
        id="section_id"
        class="w-full h-10 rounded-md border-gray-300 bg-white text-gray-600 focus:border-blue-500 focus:ring-blue-500"
    >
        <option value="">Select Section</option>

        @foreach($sections as $section)
            <option
                value="{{ $section->id }}"
                data-class="{{ $section->class_id }}"
                {{ old('section_id') == $section->id ? 'selected' : '' }}
            >
                {{ $section->section_name }}
            </option>
        @endforeach
    </select>
</div>

                          {{-- Student --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Student
        <span class="text-gray-400 font-normal">(optional — leave empty for all students)</span>
    </label>

    <input
        type="text"
        id="student_search"
        placeholder="Search or Select Student"
        autocomplete="off"
        class="w-full h-10 rounded-md border-gray-300 bg-white text-gray-600 focus:border-blue-500 focus:ring-blue-500"
    >

    <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">

    <div
        id="student_dropdown"
        class="hidden mt-1 border border-gray-300 rounded-md bg-white max-h-48 overflow-y-auto shadow-sm"
    >
        @foreach($students as $student)
            <div
                class="student-option px-3 py-2 cursor-pointer hover:bg-gray-100"
                data-id="{{ $student->id }}"
                data-class="{{ $student->class_id }}"
                data-section="{{ $student->section_id }}"
            >
                {{ $student->name }}
            </div>
        @endforeach
    </div>
</div>


                            {{-- Issue Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Issue Date <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="issue_date"
                                    value="{{ old('issue_date', date('Y-m-d')) }}"
                                    class="w-full h-10 rounded-md border-gray-300 bg-white text-gray-600 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                >
                            </div>


                            {{-- Due Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Due Date <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="due_date"
                                    value="{{ old('due_date') }}"
                                    class="w-full h-10 rounded-md border-gray-300 bg-gray-100 text-gray-600 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                >
                            </div>

                        </div>


                        {{-- Process Button --}}
                        <div class="flex justify-center mt-4">
                           <button
    type="submit"
    class="bg-black hover:bg-gray-800 text-white px-9 py-2.5 rounded-md text-sm font-medium"
>
    Process
</button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- Student Filtering --}}
  <script>
document.addEventListener('DOMContentLoaded', function () {

    const classSelect = document.getElementById('class_id');
    const sectionSelect = document.getElementById('section_id');

    const studentSearch = document.getElementById('student_search');
    const studentHidden = document.getElementById('student_id');
    const studentDropdown = document.getElementById('student_dropdown');

    const studentOptions = document.querySelectorAll('.student-option');


    // =========================
    // FILTER SECTIONS
    // =========================

    function filterSections() {

        const classId = classSelect.value;

        Array.from(sectionSelect.options).forEach(function (option) {

            if (option.value === '') {
                option.hidden = false;
                return;
            }

            option.hidden = classId !== '' &&
                            option.dataset.class !== classId;
        });
    }


    // =========================
    // FILTER STUDENTS
    // =========================

    function filterStudents() {

        const searchText =
            studentSearch.value.toLowerCase().trim();

        const classId = classSelect.value;
        const sectionId = sectionSelect.value;


        studentOptions.forEach(function (option) {

            const name =
                option.textContent.toLowerCase().trim();

            const studentClass =
                option.dataset.class;

            const studentSection =
                option.dataset.section;


            const searchMatch =
                searchText === '' ||
                name.includes(searchText);

            const classMatch =
                classId === '' ||
                studentClass === classId;

            const sectionMatch =
                sectionId === '' ||
                studentSection === sectionId;


            if (
                searchMatch &&
                classMatch &&
                sectionMatch
            ) {

                option.classList.remove('hidden');

            } else {

                option.classList.add('hidden');

            }

        });
    }


    // =========================
    // CLASS CHANGE
    // =========================

    classSelect.addEventListener('change', function () {

        // Section filter
        filterSections();

        // Section reset
        sectionSelect.value = '';

        // Student reset
        studentSearch.value = '';
        studentHidden.value = '';

        // Student filter
        filterStudents();

    });


    // =========================
    // SECTION CHANGE
    // =========================

    sectionSelect.addEventListener('change', function () {

        studentSearch.value = '';
        studentHidden.value = '';

        filterStudents();

    });


    // =========================
    // STUDENT BOX CLICK
    // =========================

    studentSearch.addEventListener('focus', function () {

        filterStudents();

        studentDropdown.classList.remove('hidden');

    });


    // =========================
    // STUDENT SEARCH
    // =========================

    studentSearch.addEventListener('input', function () {

        studentHidden.value = '';

        filterStudents();

        studentDropdown.classList.remove('hidden');

    });


    // =========================
    // SELECT STUDENT
    // =========================

    studentOptions.forEach(function (option) {

        option.addEventListener('click', function () {

            const studentName =
                this.textContent.trim();

            const studentId =
                this.dataset.id;

            const studentClass =
                this.dataset.class;

            const studentSection =
                this.dataset.section;


            // Student select
            studentSearch.value = studentName;

            studentHidden.value = studentId;


            // Automatically select Class
            if (studentClass) {

                classSelect.value = studentClass;

            }


            // Show correct sections
            filterSections();


            // Automatically select Section
            if (studentSection) {

                sectionSelect.value = studentSection;

            }


            // Close dropdown
            studentDropdown.classList.add('hidden');

        });

    });


    // =========================
    // CLICK OUTSIDE
    // =========================

    document.addEventListener('click', function (event) {

        if (
            !studentSearch.contains(event.target) &&
            !studentDropdown.contains(event.target)
        ) {

            studentDropdown.classList.add('hidden');

        }

    });


    // =========================
    // PAGE LOAD
    // =========================

    filterSections();

    // IMPORTANT:
    // Students initially visible
    studentOptions.forEach(function (option) {

        option.classList.remove('hidden');

    });

    // If student search is empty on submit, process ALL matching class/section students
    const feeProcessForm = document.getElementById('fee-process-form');

    if (feeProcessForm) {
        feeProcessForm.addEventListener('submit', function () {
            if (!studentSearch.value.trim()) {
                studentHidden.value = '';
            }
        });
    }

});
</script>
</x-app-layout>