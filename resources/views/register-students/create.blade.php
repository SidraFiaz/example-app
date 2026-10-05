<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-normal text-gray-800">
                Register Students 9th,10th
            </h2>

            <div class="flex items-center gap-2 text-sm mt-1">
                <a href="{{ route('dashboard') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Home
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-500">Register Students</span>
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

                <form method="POST" action="{{ route('register-students.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Class --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Class <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="class_id"
                                id="class_id"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
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

                        {{-- Students --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Students
                            </label>
                            <select
                                name="student_id"
                                id="student_id"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option
                                        value="{{ $student->id }}"
                                        data-class="{{ $student->class_id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}
                                    >
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Admission # (1) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Admission #
                            </label>
                            <input
                                type="text"
                                name="admission_no"
                                value="{{ old('admission_no') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                        </div>

                        {{-- Admission # (2) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Admission #
                            </label>
                            <input
                                type="text"
                                name="admission_no_2"
                                value="{{ old('admission_no_2') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                        </div>

                        {{-- Form # --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Form #
                            </label>
                            <input
                                type="text"
                                name="form_no"
                                value="{{ old('form_no') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                        </div>

                        {{-- Registration # --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Registration #
                            </label>
                            <input
                                type="text"
                                name="registration_no"
                                value="{{ old('registration_no') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                        </div>

                        {{-- Roll # --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Roll #
                            </label>
                            <input
                                type="text"
                                name="roll_no"
                                value="{{ old('roll_no') }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                        </div>

                        {{-- Obtain Marks --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Obtain Marks
                            </label>
                            <input
                                type="number"
                                name="obtain_marks"
                                value="{{ old('obtain_marks') }}"
                                min="0"
                                step="0.01"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                        </div>

                        {{-- Admission Date --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Admission Date
                            </label>
                            <input
                                type="date"
                                name="admission_date"
                                value="{{ old('admission_date', date('Y-m-d')) }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                        </div>

                    </div>

                    <div class="flex justify-center gap-4 mt-12">

                        <a href="{{ route('register-students.index') }}"
                           class="bg-black hover:bg-gray-800 text-white
                                  px-10 py-2.5 rounded-md text-sm font-medium">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="bg-black hover:bg-gray-800 text-white
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
            const studentSelect = document.getElementById('student_id');
            const selectedStudent = @json(old('student_id'));

            function loadStudents(classId, selectedId) {
                studentSelect.innerHTML = '<option value="">Select Student</option>';

                if (!classId) {
                    return;
                }

                fetch("{{ url('/register-students/students') }}/" + classId)
                    .then(response => response.json())
                    .then(students => {
                        students.forEach(function (student) {
                            const option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = student.name;
                            if (String(selectedId) === String(student.id)) {
                                option.selected = true;
                            }
                            studentSelect.appendChild(option);
                        });
                    })
                    .catch(function () {
                        // keep empty dropdown on failure
                    });
            }

            classSelect.addEventListener('change', function () {
                loadStudents(this.value, null);
            });

            if (classSelect.value) {
                loadStudents(classSelect.value, selectedStudent);
            }
        });
    </script>

</x-app-layout>
