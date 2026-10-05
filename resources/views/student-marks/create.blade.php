<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Student Marks
                </h2>
                <div class="text-sm mt-1">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Home</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-500">Add Student Marks</span>
                </div>
            </div>

            <a
                href="{{ route('student-marks.index') }}"
                class="inline-flex items-center justify-center bg-black hover:bg-gray-800 text-white font-medium px-5 py-2.5 rounded-md shadow-sm transition"
            >
                View and Edit Students Marks
            </a>
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

                {{-- Selection filters: exact 4-row reference layout --}}
                <style>
                    .student-marks-add-form {
                        display: flex;
                        flex-direction: column;
                        gap: 24px;
                    }
                    .student-marks-add-form .form-row {
                        display: grid;
                        column-gap: 24px;
                        row-gap: 24px;
                    }
                    .student-marks-add-form .form-row-3 {
                        grid-template-columns: repeat(1, minmax(0, 1fr));
                    }
                    .student-marks-add-form .form-row-2 {
                        grid-template-columns: repeat(1, minmax(0, 1fr));
                    }
                    @media (min-width: 768px) {
                        .student-marks-add-form .form-row-3 {
                            grid-template-columns: repeat(3, minmax(0, 1fr));
                        }
                        .student-marks-add-form .form-row-2 {
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                        }
                    }
                    .student-marks-add-form .form-group {
                        margin: 0;
                        padding: 0;
                    }
                    .student-marks-add-form .form-group label {
                        display: block;
                        margin-bottom: 8px;
                    }
                    .student-marks-add-form .form-row-total {
                        margin-top: 4px;
                    }
                    .student-marks-add-form-actions {
                        margin-top: 15px;
                    }
                </style>

                <div class="student-marks-add-form">

                    {{-- ROW 1: Current Date | Session | Exams * --}}
                    <div class="form-row form-row-3">
                        <div class="form-group">
                            <label for="current_date" class="text-sm font-medium text-gray-800">
                                Current Date
                            </label>
                            <input
                                type="date"
                                id="current_date"
                                value="{{ $currentDate }}"
                                class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-50 focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                        <div class="form-group">
                            <label for="session_display" class="text-sm font-medium text-gray-800">
                                Session
                            </label>
                            <input
                                type="text"
                                id="session_display"
                                value="{{ $activeSession->name ?? 'No active session' }}"
                                readonly
                                class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                            >
                            <input type="hidden" id="session_id" value="{{ $activeSession->id ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label for="exam_id" class="text-sm font-medium text-gray-800">
                                Exams <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="exam_id"
                                class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">
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
                                id="class_id"
                                class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="section_id" class="text-sm font-medium text-gray-800">
                                Section <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="section_id"
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
                                id="subject_id"
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
                                id="student_id"
                                class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                            >
                                <option value="">Select Student Id</option>
                            </select>
                        </div>
                    </div>

                    {{-- ROW 4: Total Marks * --}}
                    <div class="form-group form-row-total">
                        <label for="total_marks" class="text-sm font-medium text-gray-800">
                            Total Marks <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="total_marks"
                            name="total_marks_input"
                            min="0.01"
                            step="0.01"
                            value=""
                            placeholder="Enter Total Marks"
                            required
                            class="block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                        >
                    </div>
                </div>

                <div id="add-marks-error" class="mb-4 hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm text-center"></div>

                <div id="already-recorded-notice" class="mb-4 hidden bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg text-sm"></div>

                <div class="mb-8 flex justify-center student-marks-add-form-actions">
                    <button
                        type="button"
                        id="add-marks-btn"
                        class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-10 py-2.5 rounded-md shadow-sm transition text-sm"
                    >
                        Add Marks
                    </button>
                </div>

                {{-- Students marks sheet --}}
                <div id="students-sheet" class="hidden">
                    <form
                        method="POST"
                        action="{{ route('student-marks.sheet.store') }}"
                        id="marks-sheet-form"
                    >
                        @csrf
                        <input type="hidden" name="exam_id" id="form_exam_id" value="">
                        <input type="hidden" name="class_id" id="form_class_id" value="">
                        <input type="hidden" name="section_id" id="form_section_id" value="">
                        <input type="hidden" name="subject_id" id="form_subject_id" value="">
                        <input type="hidden" name="session_id" id="form_session_id" value="{{ $activeSession->id ?? '' }}">
                        <input type="hidden" name="date" id="form_date" value="{{ $currentDate }}">
                        <input type="hidden" name="total_marks" id="form_total_marks" value="">

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Students</h3>
                            <button
                                type="submit"
                                id="save-marks-sheet-btn"
                                class="inline-flex items-center justify-center bg-black hover:bg-gray-800 text-white font-medium px-5 py-2.5 rounded-md shadow-sm transition text-sm"
                            >
                                Save Marks Sheet
                            </button>
                        </div>

                        <div id="sheet-client-error" class="mb-4 hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"></div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr class="border-b border-gray-200">
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 w-20">ID</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Student Name</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Subject</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 w-36">Total Marks</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 w-44">Obtained Marks</th>
                                    </tr>
                                </thead>
                                <tbody id="students-sheet-body">
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                <div id="students-sheet-empty" class="hidden text-sm text-gray-500 border border-dashed border-gray-300 rounded-lg px-4 py-8 text-center">
                    Select Exam, Class, Section and Subject, then click Add Marks.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const examSelect = document.getElementById('exam_id');
            const classSelect = document.getElementById('class_id');
            const sectionSelect = document.getElementById('section_id');
            const subjectSelect = document.getElementById('subject_id');
            const studentSelect = document.getElementById('student_id');
            const totalMarksInput = document.getElementById('total_marks');
            const sessionIdInput = document.getElementById('session_id');
            const currentDateInput = document.getElementById('current_date');

            const sheetWrap = document.getElementById('students-sheet');
            const sheetEmpty = document.getElementById('students-sheet-empty');
            const sheetBody = document.getElementById('students-sheet-body');
            const sheetForm = document.getElementById('marks-sheet-form');
            const sheetError = document.getElementById('sheet-client-error');

            const formExam = document.getElementById('form_exam_id');
            const formClass = document.getElementById('form_class_id');
            const formSection = document.getElementById('form_section_id');
            const formSubject = document.getElementById('form_subject_id');
            const formSession = document.getElementById('form_session_id');
            const formDate = document.getElementById('form_date');
            const formTotalMarks = document.getElementById('form_total_marks');
            const addMarksBtn = document.getElementById('add-marks-btn');
            const addMarksError = document.getElementById('add-marks-error');
            const alreadyRecordedNotice = document.getElementById('already-recorded-notice');

            function resetSelect(selectEl, placeholder) {
                selectEl.innerHTML = '<option value="">' + placeholder + '</option>';
            }

            function hideAlreadyRecordedNotice() {
                alreadyRecordedNotice.classList.add('hidden');
                alreadyRecordedNotice.textContent = '';
            }

            function showAlreadyRecordedNotice(students) {
                if (!students || !students.length) {
                    hideAlreadyRecordedNotice();
                    return;
                }

                const names = students.map(function (student) {
                    return student.name || ('ID ' + student.id);
                }).join(', ');

                alreadyRecordedNotice.textContent = students.length === 1
                    ? 'Marks already recorded for ' + names + '. That student was excluded from Add Marks.'
                    : 'Marks already recorded for ' + students.length + ' student(s): ' + names + '. They were excluded from Add Marks.';
                alreadyRecordedNotice.classList.remove('hidden');
            }

            function hideSheet() {
                sheetWrap.classList.add('hidden');
                sheetBody.innerHTML = '';
                sheetEmpty.classList.add('hidden');
                sheetError.classList.add('hidden');
                sheetError.textContent = '';
                hideAlreadyRecordedNotice();
            }

            function showHint() {
                sheetWrap.classList.add('hidden');
                sheetBody.innerHTML = '';
                sheetEmpty.classList.remove('hidden');
            }

            function requiredReady() {
                return examSelect.value && classSelect.value && sectionSelect.value && subjectSelect.value;
            }

            function getEnteredTotalMarks() {
                const value = totalMarksInput.value;
                if (value === '' || value === null) {
                    return null;
                }
                const number = Number(value);
                if (Number.isNaN(number) || number <= 0) {
                    return null;
                }
                return number;
            }

            function showAddMarksError(message) {
                addMarksError.textContent = message;
                addMarksError.classList.remove('hidden');
            }

            function clearAddMarksError() {
                addMarksError.textContent = '';
                addMarksError.classList.add('hidden');
            }

            function loadSections(classId) {
                resetSelect(sectionSelect, 'Select Section');
                resetSelect(studentSelect, 'Select Student Id');

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
                            sectionSelect.appendChild(option);
                        });
                    })
                    .catch(function (error) {
                        console.error('Section Error:', error);
                    });
            }

            function loadSubjects(classId) {
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
                            subjectSelect.appendChild(option);
                        });
                    })
                    .catch(function (error) {
                        console.error('Subject Error:', error);
                    });
            }

            function loadStudentOptions(classId, sectionId) {
                resetSelect(studentSelect, 'Select Student Id');

                if (!classId || !sectionId) {
                    return Promise.resolve();
                }

                let url = "{{ url('/get-students') }}/" + classId + '?section_id=' + encodeURIComponent(sectionId);

                if (examSelect.value) {
                    url += '&exam_id=' + encodeURIComponent(examSelect.value);
                }
                if (subjectSelect.value) {
                    url += '&subject_id=' + encodeURIComponent(subjectSelect.value);
                }
                if (sessionIdInput.value) {
                    url += '&session_id=' + encodeURIComponent(sessionIdInput.value);
                }

                return fetch(url)
                    .then(function (response) { return response.json(); })
                    .then(function (students) {
                        students.forEach(function (student) {
                            const option = document.createElement('option');
                            option.value = student.id;

                            if (student.already_recorded) {
                                option.textContent = student.name + ' (ID: ' + student.id + ') — Marks already recorded';
                                option.disabled = true;
                                option.style.color = '#b45309';
                            } else {
                                option.textContent = student.name + ' (ID: ' + student.id + ')';
                            }

                            studentSelect.appendChild(option);
                        });
                    })
                    .catch(function (error) {
                        console.error('Student Error:', error);
                    });
            }

            function renderSheet(payload) {
                sheetBody.innerHTML = '';
                sheetError.classList.add('hidden');
                sheetError.textContent = '';

                showAlreadyRecordedNotice(payload.already_recorded || []);

                if (!payload.students || !payload.students.length) {
                    sheetWrap.classList.remove('hidden');
                    sheetEmpty.classList.add('hidden');
                    const emptyRow = document.createElement('tr');
                    const emptyMessage = (payload.already_recorded && payload.already_recorded.length)
                        ? 'All students already have marks recorded for this Exam, Session, Class, Section and Subject.'
                        : 'No students found for the selected Class and Section.';
                    emptyRow.innerHTML = '<td colspan="5" class="px-4 py-8 text-center text-gray-500">' + emptyMessage + '</td>';
                    sheetBody.appendChild(emptyRow);
                    return;
                }

                payload.students.forEach(function (student, index) {
                    const totalValue = student.total_marks === null || student.total_marks === undefined
                        ? ''
                        : Number(student.total_marks).toFixed(2);

                    const row = document.createElement('tr');
                    row.className = 'border-b border-gray-100';
                    row.innerHTML =
                        '<td class="px-4 py-3 text-gray-700">' + student.id + '</td>' +
                        '<td class="px-4 py-3 text-gray-900 font-medium">' + (student.name || '-') + '</td>' +
                        '<td class="px-4 py-3 text-gray-700">' + (student.subject_name || '-') + '</td>' +
                        '<td class="px-4 py-3 text-gray-700">' +
                            '<input type="hidden" name="marks[' + index + '][student_id]" value="' + student.id + '">' +
                            '<input type="hidden" name="marks[' + index + '][total_marks]" value="' + totalValue + '">' +
                            '<span class="tabular-nums">' + (totalValue !== '' ? totalValue : '-') + '</span>' +
                        '</td>' +
                        '<td class="px-4 py-3">' +
                            '<input type="number" min="0" step="0.01" ' +
                                'name="marks[' + index + '][obtained_marks]" ' +
                                'value="" ' +
                                'data-total="' + totalValue + '" ' +
                                'class="obtained-input w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm" ' +
                                'placeholder="Enter marks">' +
                        '</td>';

                    sheetBody.appendChild(row);
                });

                sheetEmpty.classList.add('hidden');
                sheetWrap.classList.remove('hidden');
            }

            function loadSheet() {
                clearAddMarksError();
                hideAlreadyRecordedNotice();

                if (!requiredReady()) {
                    hideSheet();
                    showAddMarksError('Please select Exams, Class, Section and Subject before clicking Add Marks.');
                    return;
                }

                const enteredTotal = getEnteredTotalMarks();
                if (enteredTotal === null) {
                    hideSheet();
                    showAddMarksError('Please enter Total Marks (greater than 0) before clicking Add Marks.');
                    totalMarksInput.focus();
                    return;
                }

                const selectedOption = studentSelect.options[studentSelect.selectedIndex];
                if (studentSelect.value && selectedOption && selectedOption.disabled) {
                    hideSheet();
                    showAddMarksError('Marks already recorded for this student.');
                    return;
                }

                formExam.value = examSelect.value;
                formClass.value = classSelect.value;
                formSection.value = sectionSelect.value;
                formSubject.value = subjectSelect.value;
                formSession.value = sessionIdInput.value || '';
                formDate.value = currentDateInput.value || '';
                formTotalMarks.value = enteredTotal;

                const params = new URLSearchParams({
                    exam_id: examSelect.value,
                    class_id: classSelect.value,
                    section_id: sectionSelect.value,
                    subject_id: subjectSelect.value,
                    total_marks: String(enteredTotal)
                });

                if (sessionIdInput.value) {
                    params.append('session_id', sessionIdInput.value);
                }

                if (studentSelect.value) {
                    params.append('student_id', studentSelect.value);
                }

                fetch("{{ route('student-marks.sheet-students') }}?" + params.toString(), {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(function (response) {
                        return response.json().then(function (data) {
                            return { ok: response.ok, data: data };
                        });
                    })
                    .then(function (result) {
                        if (!result.ok) {
                            hideSheet();
                            const message = result.data.message
                                || (result.data.errors && result.data.errors.total_marks && result.data.errors.total_marks[0])
                                || 'Unable to load students for marks entry.';
                            showAddMarksError(message);
                            if (result.data.already_recorded) {
                                showAlreadyRecordedNotice(result.data.already_recorded);
                            }
                            return;
                        }

                        renderSheet(result.data);
                        sheetWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    })
                    .catch(function (error) {
                        console.error('Sheet Error:', error);
                        hideSheet();
                        showAddMarksError('Unable to load students. Please try again.');
                    });
            }

            classSelect.addEventListener('change', function () {
                const classId = this.value;
                clearAddMarksError();
                hideSheet();
                Promise.all([
                    loadSections(classId),
                    loadSubjects(classId)
                ]).then(function () {
                    resetSelect(studentSelect, 'Select Student Id');
                });
            });

            sectionSelect.addEventListener('change', function () {
                clearAddMarksError();
                hideSheet();
                loadStudentOptions(classSelect.value, this.value);
            });

            examSelect.addEventListener('change', function () {
                clearAddMarksError();
                hideSheet();
                if (classSelect.value && sectionSelect.value) {
                    loadStudentOptions(classSelect.value, sectionSelect.value);
                }
            });

            subjectSelect.addEventListener('change', function () {
                clearAddMarksError();
                hideSheet();
                if (classSelect.value && sectionSelect.value) {
                    loadStudentOptions(classSelect.value, sectionSelect.value);
                }
            });

            studentSelect.addEventListener('change', function () {
                clearAddMarksError();
                hideSheet();
            });

            totalMarksInput.addEventListener('input', function () {
                clearAddMarksError();
                formTotalMarks.value = this.value || '';
            });

            currentDateInput.addEventListener('change', function () {
                formDate.value = this.value;
            });

            addMarksBtn.addEventListener('click', function () {
                loadSheet();
            });

            sheetForm.addEventListener('submit', function (event) {
                sheetError.classList.add('hidden');
                sheetError.textContent = '';

                const enteredTotal = getEnteredTotalMarks();
                if (enteredTotal === null) {
                    event.preventDefault();
                    sheetError.textContent = 'Please enter Total Marks (greater than 0) before saving.';
                    sheetError.classList.remove('hidden');
                    totalMarksInput.focus();
                    return;
                }

                formTotalMarks.value = enteredTotal;

                const inputs = sheetForm.querySelectorAll('.obtained-input');
                let hasValue = false;
                let invalid = false;

                inputs.forEach(function (input) {
                    if (input.value === '' || input.value === null) {
                        return;
                    }

                    hasValue = true;
                    const obtained = Number(input.value);
                    const total = Number(input.getAttribute('data-total') || enteredTotal);

                    if (Number.isNaN(obtained) || obtained < 0) {
                        invalid = true;
                    }

                    if (!Number.isNaN(total) && total > 0 && obtained > total) {
                        invalid = true;
                    }
                });

                if (!hasValue) {
                    event.preventDefault();
                    sheetError.textContent = 'Please enter Obtained Marks for at least one student before saving.';
                    sheetError.classList.remove('hidden');
                    return;
                }

                if (invalid) {
                    event.preventDefault();
                    sheetError.textContent = 'Obtained Marks must be numeric, not negative, and cannot be greater than Total Marks.';
                    sheetError.classList.remove('hidden');
                }
            });
        });
    </script>

</x-app-layout>
