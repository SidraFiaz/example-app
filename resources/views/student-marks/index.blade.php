<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Student Marks
            </h2>
            <div class="text-sm mt-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-500">View and Edit Student Marks</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 sm:p-8">

                @if(session('success'))
                    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 p-4 rounded-md text-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="GET" action="{{ route('student-marks.index') }}" id="view-marks-filter-form">
                    <input type="hidden" name="view_data" value="1">

                    <style>
                        .student-marks-view-form {
                            display: flex;
                            flex-direction: column;
                            gap: 24px;
                        }
                        .student-marks-view-form .form-row {
                            display: grid;
                            column-gap: 24px;
                            row-gap: 24px;
                        }
                        .student-marks-view-form .form-row-3 {
                            grid-template-columns: repeat(1, minmax(0, 1fr));
                        }
                        .student-marks-view-form .form-row-2 {
                            grid-template-columns: repeat(1, minmax(0, 1fr));
                        }
                        @media (min-width: 768px) {
                            .student-marks-view-form .form-row-3 {
                                grid-template-columns: repeat(3, minmax(0, 1fr));
                            }
                            .student-marks-view-form .form-row-2 {
                                grid-template-columns: repeat(2, minmax(0, 1fr));
                            }
                        }
                        .student-marks-view-form .form-group {
                            margin: 0;
                            padding: 0;
                        }
                        .student-marks-view-form .form-group label {
                            display: block;
                            margin-bottom: 8px;
                        }
                        .student-marks-view-form-actions {
                            margin-top: 15px;
                        }
                    </style>

                    <div class="student-marks-view-form">

                        {{-- ROW 1: Current Date | Session | Exams * --}}
                        <div class="form-row form-row-3">
                            <div class="form-group">
                                <label for="current_date" class="text-sm font-medium text-gray-800">
                                    Current Date
                                </label>
                                <input
                                    type="date"
                                    name="current_date"
                                    id="current_date"
                                    value="{{ old('current_date', request('current_date', $currentDate)) }}"
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-50 focus:border-black focus:ring-black text-sm"
                                >
                            </div>

                            <div class="form-group">
                                <label for="session_id" class="text-sm font-medium text-gray-800">
                                    Session
                                </label>
                                <select
                                    name="session_id"
                                    id="session_id"
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                                >
                                    <option value="">Select Session</option>
                                    @foreach($sessions as $session)
                                        <option
                                            value="{{ $session->id }}"
                                            @selected((string) old('session_id', request('session_id', $activeSession->id ?? '')) === (string) $session->id)
                                        >
                                            {{ $session->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exam_id" class="text-sm font-medium text-gray-800">
                                    Exams <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="exam_id"
                                    id="exam_id"
                                    required
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                                >
                                    <option value="">Select Exam</option>
                                    @foreach($exams as $exam)
                                        <option value="{{ $exam->id }}" @selected((string) old('exam_id', request('exam_id')) === (string) $exam->id)>
                                            {{ $exam->exam_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- ROW 2: Class * | Section * --}}
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label for="class_id" class="text-sm font-medium text-gray-800">
                                    Class <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="class_id"
                                    id="class_id"
                                    required
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                                >
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" @selected((string) old('class_id', request('class_id')) === (string) $class->id)>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="section_id" class="text-sm font-medium text-gray-800">
                                    Section <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="section_id"
                                    id="section_id"
                                    required
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                                >
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                        </div>

                        {{-- ROW 3: Subject * | Student --}}
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label for="subject_id" class="text-sm font-medium text-gray-800">
                                    Subject <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="subject_id"
                                    id="subject_id"
                                    required
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                                >
                                    <option value="">Select Subject</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="student_id" class="text-sm font-medium text-gray-800">
                                    Student
                                </label>
                                <select
                                    name="student_id"
                                    id="student_id"
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                                >
                                    <option value="">Select Student Id</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8 flex justify-center student-marks-view-form-actions">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-10 py-2.5 rounded-md shadow-sm transition text-sm"
                        >
                            View Data
                        </button>
                    </div>
                </form>

                @if($showResults)
                    <div class="mt-8 border-t border-gray-200 pt-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Students</h3>
                            <button
                                type="submit"
                                form="marks-sheet-form"
                                id="save-marks-sheet-btn"
                                class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-md shadow-sm transition text-sm"
                            >
                                Save Marks Sheet
                            </button>
                        </div>

                        <div id="sheet-client-error" class="mb-4 hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"></div>

                        <form
                            method="POST"
                            action="{{ route('student-marks.sheet.store') }}"
                            id="marks-sheet-form"
                        >
                            @csrf
                            <input type="hidden" name="return_to" value="index">
                            <input type="hidden" name="exam_id" value="{{ request('exam_id') }}">
                            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                            <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                            <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                            <input type="hidden" name="session_id" value="{{ request('session_id') }}">
                            <input type="hidden" name="date" value="{{ request('current_date', $currentDate) }}">
                            <input type="hidden" name="total_marks" value="{{ $sheetTotalMarks ?? '' }}">
                            <input type="hidden" name="filter_student_id" value="{{ request('student_id') }}">

                            <div class="overflow-x-auto rounded-lg border border-gray-200">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50">
                                        <tr class="border-b border-gray-200">
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700 w-20">ID</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Student Name</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Subject</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700 w-36">Total Marks</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700 w-44">Obtained Marks</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700 w-28">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sheetStudents as $index => $student)
                                            @php
                                                $totalValue = $student['total_marks'] === null
                                                    ? ''
                                                    : number_format((float) $student['total_marks'], 2, '.', '');
                                                $obtainedValue = $student['obtained_marks'] === null
                                                    ? ''
                                                    : (float) $student['obtained_marks'];
                                            @endphp
                                            <tr class="border-b border-gray-100 hover:bg-gray-50/80">
                                                <td class="px-4 py-3 text-gray-700">{{ $student['id'] }}</td>
                                                <td class="px-4 py-3 text-gray-900 font-medium">{{ $student['name'] }}</td>
                                                <td class="px-4 py-3 text-gray-700">{{ $student['subject_name'] }}</td>
                                                <td class="px-4 py-3 text-gray-700 tabular-nums">
                                                    <input type="hidden" name="marks[{{ $index }}][student_id]" value="{{ $student['id'] }}">
                                                    @if($totalValue !== '')
                                                        <input type="hidden" name="marks[{{ $index }}][total_marks]" value="{{ $totalValue }}">
                                                    @endif
                                                    {{ $totalValue !== '' ? $totalValue : '—' }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input
                                                        type="number"
                                                        min="0"
                                                        step="0.01"
                                                        name="marks[{{ $index }}][obtained_marks]"
                                                        value="{{ $obtainedValue }}"
                                                        data-total="{{ $totalValue }}"
                                                        class="obtained-input w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                                        placeholder="Enter marks"
                                                    >
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if(!empty($student['mark_id']))
                                                        <button
                                                            type="submit"
                                                            form="delete-mark-{{ $student['mark_id'] }}"
                                                            class="action-btn action-btn-delete"
                                                            onclick="return confirm('Delete this marks record?');"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </button>
                                                    @else
                                                        <span class="text-gray-400 text-xs">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                                    No students found for the selected Class and Section.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        @foreach($sheetStudents as $student)
                            @if(!empty($student['mark_id']))
                                <form
                                    id="delete-mark-{{ $student['mark_id'] }}"
                                    method="POST"
                                    action="{{ route('student-marks.destroy', $student['mark_id']) }}"
                                    class="hidden"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="return_sheet" value="1">
                                    <input type="hidden" name="current_date" value="{{ request('current_date', $currentDate) }}">
                                    <input type="hidden" name="session_id" value="{{ request('session_id') }}">
                                    <input type="hidden" name="exam_id" value="{{ request('exam_id') }}">
                                    <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                                    <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                                    <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                                    <input type="hidden" name="student_id" value="{{ request('student_id') }}">
                                </form>
                            @endif
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const classSelect = document.getElementById('class_id');
            const sectionSelect = document.getElementById('section_id');
            const subjectSelect = document.getElementById('subject_id');
            const studentSelect = document.getElementById('student_id');
            const sheetForm = document.getElementById('marks-sheet-form');
            const sheetError = document.getElementById('sheet-client-error');

            const oldSectionId = @json(old('section_id', request('section_id')));
            const oldSubjectId = @json(old('subject_id', request('subject_id')));
            const oldStudentId = @json(old('student_id', request('student_id')));

            function resetSelect(selectEl, placeholder) {
                selectEl.innerHTML = '<option value="">' + placeholder + '</option>';
            }

            function loadSections(classId, selectedId) {
                resetSelect(sectionSelect, 'Select Section');

                if (!classId) {
                    return Promise.resolve();
                }

                return fetch("{{ url('/get-sections') }}/" + classId)
                    .then(function (response) { return response.json(); })
                    .then(function (sections) {
                        sections.forEach(function (section) {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.section_name;
                            if (selectedId && String(selectedId) === String(section.id)) {
                                option.selected = true;
                            }
                            sectionSelect.appendChild(option);
                        });
                    })
                    .catch(function (error) {
                        console.error('Section Error:', error);
                    });
            }

            function loadSubjects(classId, selectedId) {
                resetSelect(subjectSelect, 'Select Subject');

                if (!classId) {
                    return Promise.resolve();
                }

                return fetch("{{ url('/student-marks/subjects') }}/" + classId)
                    .then(function (response) { return response.json(); })
                    .then(function (subjects) {
                        subjects.forEach(function (subject) {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.subject_name;
                            if (selectedId && String(selectedId) === String(subject.id)) {
                                option.selected = true;
                            }
                            subjectSelect.appendChild(option);
                        });
                    })
                    .catch(function (error) {
                        console.error('Subject Error:', error);
                    });
            }

            function loadStudents(classId, sectionId, selectedId) {
                resetSelect(studentSelect, 'Select Student Id');

                if (!classId) {
                    return Promise.resolve();
                }

                let url = "{{ url('/get-students') }}/" + classId;
                if (sectionId) {
                    url += '?section_id=' + encodeURIComponent(sectionId);
                }

                return fetch(url)
                    .then(function (response) { return response.json(); })
                    .then(function (students) {
                        students.forEach(function (student) {
                            const option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = student.name + ' (ID: ' + student.id + ')';
                            if (selectedId && String(selectedId) === String(student.id)) {
                                option.selected = true;
                            }
                            studentSelect.appendChild(option);
                        });
                    })
                    .catch(function (error) {
                        console.error('Student Error:', error);
                    });
            }

            classSelect.addEventListener('change', function () {
                const classId = this.value;
                Promise.all([
                    loadSections(classId),
                    loadSubjects(classId),
                    loadStudents(classId, '')
                ]);
            });

            sectionSelect.addEventListener('change', function () {
                loadStudents(classSelect.value, this.value);
                loadSubjects(classSelect.value, subjectSelect.value);
            });

            if (classSelect.value) {
                Promise.all([
                    loadSections(classSelect.value, oldSectionId),
                    loadSubjects(classSelect.value, oldSubjectId)
                ]).then(function () {
                    loadStudents(classSelect.value, sectionSelect.value || oldSectionId, oldStudentId);
                });
            }

            if (sheetForm) {
                sheetForm.addEventListener('submit', function (event) {
                    if (sheetError) {
                        sheetError.classList.add('hidden');
                        sheetError.textContent = '';
                    }

                    const inputs = sheetForm.querySelectorAll('.obtained-input');
                    let hasValue = false;
                    let invalid = false;

                    inputs.forEach(function (input) {
                        if (input.value === '' || input.value === null) {
                            return;
                        }

                        hasValue = true;
                        const obtained = Number(input.value);
                        const total = Number(input.getAttribute('data-total'));

                        if (Number.isNaN(obtained) || obtained < 0) {
                            invalid = true;
                        }

                        if (!Number.isNaN(total) && total > 0 && obtained > total) {
                            invalid = true;
                        }
                    });

                    if (!hasValue) {
                        event.preventDefault();
                        if (sheetError) {
                            sheetError.textContent = 'Please enter Obtained Marks for at least one student before saving.';
                            sheetError.classList.remove('hidden');
                        }
                        return;
                    }

                    if (invalid) {
                        event.preventDefault();
                        if (sheetError) {
                            sheetError.textContent = 'Obtained Marks must be numeric, not negative, and cannot be greater than Total Marks.';
                            sheetError.classList.remove('hidden');
                        }
                    }
                });
            }
        });
    </script>

</x-app-layout>
