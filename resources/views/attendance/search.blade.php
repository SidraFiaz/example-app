
<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>
                <h2 class="font-semibold text-2xl text-gray-800">
                    Search Student Attendance
                </h2>

                <p class="text-blue-600">
                    Home / Search Student Attendance
                </p>
            </div>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form method="GET" action="{{ route('attendance.search') }}">

                    {{-- Session + Month + Class --}}

                    <div class="grid grid-cols-3 gap-6 mb-5">

                        {{-- Session --}}

                        <div>

                            <label class="block mb-2 text-gray-700">
                                Session
                            </label>

                            <input
                                type="text"
                                readonly
                                value="{{ $session ? $session->name : '' }}"
                                class="w-full border rounded p-3 bg-gray-100"
                            >

                        </div>


                        {{-- For Month --}}

                        <div>

                            <label class="block mb-2 text-gray-700">
                                For Month
                            </label>

                            <input
                                type="text"
                                readonly
                                value="{{ date('F-Y') }}"
                                class="w-full border rounded p-3 bg-gray-100"
                            >

                        </div>


                        {{-- Class --}}

                        <div>

                            <label class="block mb-2 text-gray-700">
                                Class
                            </label>

                            <select
                                id="search_class_id"
                                name="class_id"
                                class="w-full border rounded p-3"
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

                    </div>


                    {{-- Section --}}

                    <div class="grid grid-cols-3 gap-6 mb-6">

                        <div>

                            <label class="block mb-2 text-gray-700">
                                Section
                            </label>

                            <select
                                id="search_section_id"
                                name="section_id"
                                class="w-full border rounded p-3"
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

                    </div>


                    {{-- Search Button --}}

                    <div class="flex justify-center">

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700"
                        >
                            Search
                        </button>

                    </div>

                </form>


                {{-- No Records --}}

                @if(request()->filled('class_id') && request()->filled('section_id') && $students->isEmpty())

                    <div class="text-center text-red-500 text-2xl mt-8">
                        No Records found
                    </div>

                @endif


                {{-- Students --}}

                @if($students->count())

                    <div class="mt-8 border rounded">

                        <div class="p-5 border-b">

                            <h2 class="text-xl font-bold">
                                Students
                            </h2>

                        </div>


                        <table class="w-full border-collapse">

                            <thead>

                                <tr class="bg-gray-100">

                                    <th class="border p-3">
                                        ID
                                    </th>

                                    <th class="border p-3">
                                        Student Name
                                    </th>

                                    <th class="border p-3">
                                        Attendance Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($students as $student)

                                    <tr>

                                        <td class="border p-3">
                                            {{ $student->id }}
                                        </td>

                                        <td class="border p-3">
                                            {{ $student->name }}
                                        </td>

                                        <td class="border p-3">

                                            @php
                                                $attendance = \App\Models\Attendance::where(
                                                    'student_id',
                                                    $student->id
                                                )
                                                ->whereDate(
                                                    'attendance_date',
                                                    now()
                                                )
                                                ->first();
                                            @endphp

                                            {{ $attendance->status ?? '-' }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- Dynamic Section Script --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const classDropdown =
                document.getElementById('search_class_id');

            const sectionDropdown =
                document.getElementById('search_section_id');


            classDropdown.addEventListener('change', function () {

                const classId = this.value;

                sectionDropdown.innerHTML =
                    '<option value="">Select Section</option>';


                if (!classId) {
                    return;
                }


                fetch('{{ url('/get-sections') }}/' + classId)

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

        });

    </script>


</x-app-layout>

