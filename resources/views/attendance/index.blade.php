<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>
                <h2 class="font-semibold text-2xl text-gray-800">
                    Student Daily Attendance
                </h2>

                <p class="text-blue-600">
                    Home / Student Daily Attendance
                </p>
            </div>

            <div class="flex gap-3">

               <a
    href="{{ route('attendance.report') }}"
    class="bg-black text-white px-5 py-3 rounded-md hover:bg-gray-800"
>
    Attendance Report
</a>

                <a
    href="{{ route('attendance.search') }}"
    class="bg-black text-white px-5 py-3 rounded"
>
    Search Attendance Record
</a>

            </div>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- Main Card --}}
            <div class="bg-white p-6 rounded-lg shadow">


                {{-- Success Message --}}
                @if(session('success'))

                    <div class="mb-5 p-4 bg-green-100 border border-green-300 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>

                @endif


                {{-- Filter Form --}}
                <form
                    method="GET"
                    action="{{ route('attendance.index') }}"
                    id="attendanceFilterForm"
                >

                    {{-- First Row --}}
                    <div class="grid grid-cols-3 gap-6 mb-5">


                        {{-- Session --}}
                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Session
                            </label>

                            <input
                                type="text"
                                readonly
                                value="{{ $session ? $session->name : '' }}"
                                class="w-full border-gray-300 rounded-md p-3 bg-gray-100"
                            >

                        </div>


                        {{-- For Month --}}
                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                For Month
                            </label>

                            <input
                                type="text"
                                readonly
                                value="{{ date('F-Y') }}"
                                class="w-full border-gray-300 rounded-md p-3 bg-gray-100"
                            >

                        </div>


                        {{-- Date --}}
                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Date
                            </label>

                            <input
                                type="date"
                                id="attendance_date"
                                value="{{ request('date', date('Y-m-d')) }}"
                                class="w-full border-gray-300 rounded-md p-3 bg-gray-100"
                            >

                        </div>

                    </div>


                    {{-- Second Row --}}
                    <div class="grid grid-cols-2 gap-6 mb-6">


                        {{-- Class --}}
                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Class
                            </label>

                            <select
                                id="class_id"
                                name="class_id"
                                class="w-full border-gray-300 rounded-md p-3"
                            >

                                <option value="">
                                    Select Class
                                </option>

                                @foreach($classes as $class)

                                    <option
                                        value="{{ $class->id }}"
                                        {{ (string) $selectedClass === (string) $class->id ? 'selected' : '' }}
                                    >
                                        {{ $class->class_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Section --}}
                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Section
                            </label>

                            <select
                                id="section_id"
                                name="section_id"
                                class="w-full border-gray-300 rounded-md p-3"
                                {{ !$selectedClass ? 'disabled' : '' }}
                            >

                                <option value="">
                                    Select Section
                                </option>

                                @foreach($sections as $section)

                                    <option
                                        value="{{ $section->id }}"
                                        {{ (string) $selectedSection === (string) $section->id ? 'selected' : '' }}
                                    >
                                        {{ $section->section_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </form>


                {{-- Attendance Form --}}
                @if($students->count())


                    <form
                        method="POST"
                        action="{{ route('attendance.store') }}"
                    >

                        @csrf


                        {{-- Hidden Values --}}
                        <input
                            type="hidden"
                            name="session_id"
                            value="{{ $session->id ?? '' }}"
                        >

                        <input
                            type="hidden"
                            name="class_id"
                            value="{{ $selectedClass }}"
                        >

                        <input
                            type="hidden"
                            name="section_id"
                            value="{{ $selectedSection }}"
                        >

                        <input
                            type="hidden"
                            name="date"
                            id="save_date"
                            value="{{ request('date', date('Y-m-d')) }}"
                        >


                        {{-- Students Box --}}
                        <div class="border border-gray-300 rounded-lg overflow-hidden">


                            {{-- Students Header --}}
                            <div class="flex justify-between items-center p-5">

                                <h2 class="text-xl font-bold text-gray-800">
                                    Students
                                </h2>


                                <button
                                    type="submit"
                                    class="bg-black text-white px-5 py-2 rounded-md hover:bg-gray-800"
                                >
                                    Save Attendance
                                </button>

                            </div>


                            {{-- Table --}}
                            <div class="overflow-x-auto">

                                <table class="w-full border-collapse">


                                    <thead>

                                        <tr>

                                            <th class="border border-gray-300 p-3 text-left">
                                                ID
                                            </th>

                                            <th class="border border-gray-300 p-3 text-left">
                                                Student Name
                                            </th>

                                            <th class="border border-gray-300 p-3 text-left">
                                                Attendance Status
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach($students as $student)

                                            <tr>


                                                {{-- ID --}}
                                                <td class="border border-gray-300 p-3">
                                                    {{ $student->id }}
                                                </td>


                                                {{-- Student Name --}}
                                                <td class="border border-gray-300 p-3">
                                                    {{ $student->name }}
                                                </td>


                                                {{-- Attendance --}}
                                                <td class="border border-gray-300 p-3">

                                                    <select
                                                        name="attendance[{{ $student->id }}]"
                                                        class="w-full border-gray-300 rounded-md p-2"
                                                    >

                                                        <option value="Present">
                                                            Present
                                                        </option>

                                                        <option value="Absent">
                                                            Absent
                                                        </option>

                                                        <option value="Half Day">
                                                            Half Day
                                                        </option>

                                                        <option value="Leave">
                                                            Leave
                                                        </option>

                                                        <option value="P/Late">
                                                            P/Late
                                                        </option>

                                                    </select>

                                                </td>


                                            </tr>

                                        @endforeach

                                    </tbody>


                                </table>

                            </div>

                        </div>


                    </form>


                @elseif($selectedClass && $selectedSection)

                    <div class="border border-gray-300 rounded-lg p-6 text-center text-gray-500">

                        No students found in this section.

                    </div>

                @endif


            </div>

        </div>

    </div>


    {{-- JavaScript --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const classDropdown = document.getElementById('class_id');
            const sectionDropdown = document.getElementById('section_id');
            const dateInput = document.getElementById('attendance_date');
            const saveDate = document.getElementById('save_date');


            /*
            |--------------------------------------------------------------------------
            | Date
            |--------------------------------------------------------------------------
            */

            if (dateInput && saveDate) {

                dateInput.addEventListener('change', function () {

                    saveDate.value = this.value;

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Class Change
            |--------------------------------------------------------------------------
            */

            classDropdown.addEventListener('change', function () {

                const classId = this.value;


                sectionDropdown.innerHTML =
                    '<option value="">Loading Sections...</option>';

                sectionDropdown.disabled = true;


                if (!classId) {

                    sectionDropdown.innerHTML =
                        '<option value="">Select Section</option>';

                    return;

                }


                fetch('{{ url('/get-sections') }}/' + classId)

                    .then(response => {

                        if (!response.ok) {
                            throw new Error('Failed to load sections');
                        }

                        return response.json();

                    })

                    .then(data => {

                        sectionDropdown.innerHTML =
                            '<option value="">Select Section</option>';


                        data.forEach(function (section) {

                            const option =
                                document.createElement('option');

                            option.value = section.id;

                            option.textContent =
                                section.section_name;

                            sectionDropdown.appendChild(option);

                        });


                        sectionDropdown.disabled = false;

                    })

                    .catch(error => {

                        console.error(error);

                        sectionDropdown.innerHTML =
                            '<option value="">Unable to load sections</option>';

                    });

            });


            /*
            |--------------------------------------------------------------------------
            | Section Change
            |--------------------------------------------------------------------------
            */

            sectionDropdown.addEventListener('change', function () {

                const classId = classDropdown.value;

                const sectionId = this.value;


                if (!classId || !sectionId) {
                    return;
                }


                /*
                | Reload page with selected class + section
                | Controller will then load students.
                */

                const url =
                    '{{ route('attendance.index') }}' +
                    '?class_id=' + encodeURIComponent(classId) +
                    '&section_id=' + encodeURIComponent(sectionId);


                window.location.href = url;

            });

        });

    </script>


</x-app-layout>