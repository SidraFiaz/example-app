<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>
                <h2 class="font-semibold text-2xl text-gray-800">
                    Student Attendance Report
                </h2>

                <p class="text-gray-500 mt-1">
                    Home / Student Attendance Report
                </p>
            </div>

            <div class="flex gap-3">

                <button
                    type="button"
                    class="bg-black text-white px-5 py-3 rounded-md hover:bg-gray-800"
                >
                    Attendance Report
                </button>

                <button
                    type="button"
                    class="bg-black text-white px-5 py-3 rounded-md hover:bg-gray-800"
                >
                    Search Attendance Record
                </button>

            </div>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-lg shadow-sm p-6">


                {{-- FILTER SECTION --}}

                <form
                    method="GET"
                    action="{{ route('attendance.report') }}"
                >

                    <div class="grid grid-cols-3 gap-6">


                        {{-- CLASS --}}

                        <div>

                            <label class="block font-medium text-gray-700 mb-2">
                                Class
                            </label>

                            <select
                                id="report_class_id"
                                name="class_id"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                            >

                                <option value="">
                                    Select Class
                                </option>

                                @foreach($classes as $class)

                                    <option
                                        value="{{ $class->id }}"
                                        {{ request('class_id') == $class->id ? 'selected' : '' }}
                                    >
                                        {{ $class->class_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- SECTION --}}

                        <div>

                            <label class="block font-medium text-gray-700 mb-2">
                                Section
                            </label>

                            <select
                                id="report_section_id"
                                name="section_id"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                            >

                                <option value="">
                                    Select Section
                                </option>

                                @foreach($sections as $section)

                                    <option
                                        value="{{ $section->id }}"
                                        {{ request('section_id') == $section->id ? 'selected' : '' }}
                                    >
                                        {{ $section->section_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- STUDENT --}}

                        <div>

                            <label class="block font-medium text-gray-700 mb-2">
                                Student
                            </label>

                            <select
                                id="report_student_id"
                                name="student_id"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                            >

                                <option value="">
                                    Select Student
                                </option>

                              @foreach($students->where('id', request('student_id')) as $student)

                                    <option
                                        value="{{ $student->id }}"
                                        {{ request('student_id') == $student->id ? 'selected' : '' }}
                                    >
                                        {{ $student->id }} - {{ $student->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- SECOND ROW --}}

                    <div class="grid grid-cols-3 gap-6 mt-5">


                        {{-- MONTH --}}

                        <div>

                            <label class="block font-medium text-gray-700 mb-2">
                                Select Month
                            </label>

                            <select
                                name="month"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                            >

                                <option value="">
                                    Select Month
                                </option>

                                @for($month = 1; $month <= 12; $month++)

                                    <option
                                        value="{{ $month }}"
                                        {{ request('month') == $month ? 'selected' : '' }}
                                    >
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>

                                @endfor

                            </select>

                        </div>


                        {{-- YEAR --}}

                        <div>

                            <label class="block font-medium text-gray-700 mb-2">
                                Year
                            </label>

                            <select
                                name="year"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                            >

                                <option value="{{ date('Y') }}">
                                    {{ date('Y') }}
                                </option>

                                <option value="{{ date('Y') - 1 }}">
                                    {{ date('Y') - 1 }}
                                </option>

                            </select>

                        </div>


                        {{-- SHOW BUTTON --}}

                        <div class="flex items-end">

                            <button
                                type="submit"
                                class="bg-black text-white px-6 py-2.5 rounded-md hover:bg-gray-800"
                            >
                                Show
                            </button>

                        </div>

                    </div>

                </form>


                {{-- REPORT TABLE --}}

                @if(request('class_id') && request('section_id'))

                    <div class="mt-8">

                        <div class="flex justify-between items-center mb-4">

                            <h2 class="text-xl font-semibold text-gray-800">
                                Attendance Report
                            </h2>

                        </div>


                        <div class="overflow-x-auto">

                            <table class="w-full border border-gray-300 border-collapse">

                                <thead>

                                    <tr class="bg-gray-100">

                                        <th class="border border-gray-300 px-4 py-3">
                                            ID
                                        </th>

                                        <th class="border border-gray-300 px-4 py-3">
                                            Student Name
                                        </th>

                                        <th class="border border-gray-300 px-4 py-3">
                                            Present
                                        </th>

                                        <th class="border border-gray-300 px-4 py-3">
                                            Absent
                                        </th>

                                        <th class="border border-gray-300 px-4 py-3">
                                            Leave
                                        </th>

                                        <th class="border border-gray-300 px-4 py-3">
                                            Half Day
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($students as $student)

                                        <tr>

                                            <td class="border border-gray-300 px-4 py-3 text-center">
                                                {{ $student->id }}
                                            </td>

                                            <td class="border border-gray-300 px-4 py-3">
                                                {{ $student->name }}
                                            </td>

                                            <td class="border border-gray-300 px-4 py-3 text-center">
                                                -
                                            </td>

                                            <td class="border border-gray-300 px-4 py-3 text-center">
                                                -
                                            </td>

                                            <td class="border border-gray-300 px-4 py-3 text-center">
                                                -
                                            </td>

                                            <td class="border border-gray-300 px-4 py-3 text-center">
                                                -
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="6"
                                                class="border border-gray-300 px-4 py-8 text-center text-gray-500"
                                            >
                                                No students found.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                @endif


            </div>

        </div>

    </div>


    {{-- DYNAMIC CLASS → SECTION → STUDENT --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const classDropdown =
                document.getElementById('report_class_id');

            const sectionDropdown =
                document.getElementById('report_section_id');

            const studentDropdown =
                document.getElementById('report_student_id');


            classDropdown.addEventListener('change', function () {

                const classId = this.value;

                sectionDropdown.innerHTML =
                    '<option value="">Select Section</option>';

                studentDropdown.innerHTML =
                    '<option value="">Select Student</option>';


                if (!classId) {
                    return;
                }


                fetch('/attendance/report/sections/' + classId)

                    .then(response => response.json())

                    .then(data => {

                        data.forEach(function (section) {

                            const option =
                                document.createElement('option');

                            option.value = section.id;

                            option.textContent =
                                section.section_name;

                            sectionDropdown.appendChild(option);

                        });

                    })

                    .catch(error => {

                        console.error(error);

                    });

            });


            sectionDropdown.addEventListener('change', function () {

                const sectionId = this.value;

                studentDropdown.innerHTML =
                    '<option value="">Select Student</option>';


                if (!sectionId) {
                    return;
                }


                fetch('/attendance/report/students/' + sectionId)

                    .then(response => response.json())

                    .then(data => {

                        data.forEach(function (student) {

                            const option =
                                document.createElement('option');

                            option.value = student.id;

                            option.textContent =
                                student.id + ' - ' + student.name;

                            studentDropdown.appendChild(option);

                        });

                    })

                    .catch(error => {

                        console.error(error);

                    });

            });

        });

    </script>

</x-app-layout>