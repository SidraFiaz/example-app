@extends('layouts.app')

@section('content')

<div style="padding: 30px;">

    {{-- PAGE HEADER --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:30px;
    ">

        <div>
            <h1 style="
                margin:0;
                font-size:32px;
                font-weight:700;
                color:#1f2937;
            ">
                Result Grades
            </h1>

            <div style="margin-top:8px; color:#6b7280;">
                <a href="{{ url('/dashboard') }}"
                   style="text-decoration:none; color:#2563eb;">
                    Home
                </a>

                <span style="margin:0 8px;">/</span>

                <span>Result Grades</span>
            </div>
        </div>

        <button type="button"
                onclick="openCreateModal()"
                style="
                    background:#111827;
                    color:white;
                    border:none;
                    padding:13px 22px;
                    border-radius:7px;
                    font-size:15px;
                    cursor:pointer;
                ">
            + Create Grades
        </button>

    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div style="
            background:#d1fae5;
            color:#065f46;
            padding:14px 18px;
            border-radius:7px;
            margin-bottom:20px;
        ">
            {{ session('success') }}
        </div>

    @endif


    {{-- VALIDATION ERRORS --}}
    @if($errors->any())

        <div style="
            background:#fee2e2;
            color:#991b1b;
            padding:15px 20px;
            border-radius:7px;
            margin-bottom:20px;
        ">

            <strong>Please fix the following:</strong>

            <ul style="margin-bottom:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- TABLE CARD --}}
    <div style="
        background:white;
        border-radius:10px;
        padding:25px;
        box-shadow:0 2px 10px rgba(0,0,0,.08);
    ">


      {{-- TERM BUTTONS --}}
<div style="
    display:flex;
    gap:10px;
    margin-bottom:25px;
">

    {{-- FIRST TERM --}}
    <a href="{{ route('result-grades.index', ['term' => 'First Term']) }}"
       style="
           background:#111827;
            color:white;
            text-decoration:none;
            padding:11px 22px;
            border-radius:6px;
       ">
        First Term
    </a>


    {{-- 2ND TERM --}}
    <a href="{{ route('result-grades.index', ['term' => '2nd Term']) }}"
       style="
           background:#111827;
            color:white;
            text-decoration:none;
            padding:11px 22px;
            border-radius:6px;
       ">
        2nd Term
    </a>

</div>

        {{-- TABLE --}}
        <div style="overflow-x:auto;">

            <table style="
                width:100%;
                border-collapse:collapse;
            ">

                <thead>

                    <tr style="
                        background:#f8fafc;
                        text-align:left;
                    ">

                        <th style="padding:15px;">
                            Starting %
                        </th>

                        <th style="padding:15px;">
                            Ending %
                        </th>

                        <th style="padding:15px;">
                            Grade
                        </th>

                        <th style="padding:15px;">
                            Date
                        </th>

                        <th style="padding:15px;">
                            Term
                        </th>

                        <th style="padding:15px;">
                            Class Group
                        </th>

                        <th style="padding:15px;">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($resultGrades as $resultGrade)

                        <tr style="border-top:1px solid #e5e7eb;">

                            <td style="padding:15px;">
                                {{ $resultGrade->starting_percentage }}%
                            </td>

                            <td style="padding:15px;">
                                {{ $resultGrade->ending_percentage }}%
                            </td>

                            <td style="padding:15px;">
                                {{ $resultGrade->grade }}
                            </td>

                            <td style="padding:15px;">
                                {{ $resultGrade->date }}
                            </td>

                            <td style="padding:15px;">
                                {{ $resultGrade->term }}
                            </td>

                            <td style="padding:15px;">
                                {{ $resultGrade->class_group }}
                            </td>

                            <td style="padding:15px;">

                                <div class="action-btn-group">

                                    <x-action-edit
                                        type="button"
                                        class="edit-grade-btn"
                                        data-id="{{ $resultGrade->id }}"
                                        data-grade="{{ $resultGrade->grade }}"
                                        data-starting-percentage="{{ $resultGrade->starting_percentage }}"
                                        data-ending-percentage="{{ $resultGrade->ending_percentage }}"
                                        data-exam-id="{{ $resultGrade->exam_id }}"
                                        data-class-group="{{ $resultGrade->class_group }}"
                                        data-date="{{ $resultGrade->date }}"
                                        data-term="{{ $resultGrade->term }}"
                                    />

                                    <form action="{{ route('result-grades.destroy', $resultGrade->id) }}"
                                          method="POST"
                                          data-delete-confirm="Are you sure you want to delete this grade?">
                                        @csrf
                                        @method('DELETE')
                                        <x-action-delete />
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                style="
                                    padding:40px;
                                    text-align:center;
                                    color:#6b7280;
                                ">

                                No Result Grades Found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>




{{-- ================================================= --}}
{{-- CREATE MODAL --}}
{{-- ================================================= --}}

<div id="gradeModal"
     style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.5);
        z-index:9999;
        padding:40px 15px;
        overflow-y:auto;
     ">


    <div style="
        max-width:700px;
        margin:auto;
        background:white;
        border-radius:10px;
        overflow:hidden;
    ">


        {{-- MODAL HEADER --}}

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 25px;
            border-bottom:1px solid #e5e7eb;
        ">

            <h2 id="modalTitle"
                style="margin:0;">
                Add Grade
            </h2>

            <button type="button"
                    onclick="closeGradeModal()"
                    style="
                        border:none;
                        background:none;
                        font-size:28px;
                        cursor:pointer;
                        line-height:1;
                    ">
                ×
            </button>

        </div>


        {{-- FORM --}}

        <form id="gradeForm"
              action="{{ route('result-grades.store') }}"
              method="POST">

            @csrf

            <div style="padding:25px;">

                <div id="createGradeErrors"
                     style="
                        display:none;
                        background:#fee2e2;
                        color:#991b1b;
                        padding:12px 14px;
                        border-radius:6px;
                        margin-bottom:18px;
                     "></div>

                <div id="createGradeNotice"
                     style="
                        display:none;
                        background:#fff7ed;
                        color:#9a3412;
                        padding:12px 14px;
                        border-radius:6px;
                        margin-bottom:18px;
                     "></div>

                {{-- EXAMS --}}

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Exams <span style="color:#ef4444;">*</span>
                    </label>

                    <select name="exam_id"
                            id="exam_id"
                            required
                            style="
                                width:100%;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                            ">

                        <option value="">
                            Select Exam
                        </option>

                        @foreach($exams as $exam)
                            @php
                                $examLabel = $exam->name ?? $exam->exam_name ?? ('Exam '.$exam->id);
                                $examLabelLower = strtolower(trim((string) $examLabel));
                                $examTerm = null;
                                if (str_contains($examLabelLower, '2nd') || str_contains($examLabelLower, 'second')) {
                                    $examTerm = '2nd Term';
                                } elseif (str_contains($examLabelLower, 'first')) {
                                    $examTerm = 'First Term';
                                }
                            @endphp

                            <option value="{{ $exam->id }}"
                                    data-term="{{ $examTerm ?? $term }}">
                                {{ $examLabel }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- CLASS GROUP --}}

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Class Group <span style="color:#ef4444;">*</span>
                    </label>

                    <select name="class_group"
                            id="class_group"
                            required
                            style="
                                width:100%;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                            ">

                        <option value="">
                            Select group
                        </option>

                        @foreach($classGroups as $classGroup)

                            <option value="{{ $classGroup->group_name }}">
                                {{ $classGroup->group_name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- GRADE --}}

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Grade <span style="color:#ef4444;">*</span>
                    </label>

                    <select name="grade"
                            id="grade"
                            required
                            style="
                                width:100%;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                            ">

                        <option value="">
                            Select Grade
                        </option>

                    </select>

                </div>


                {{-- STARTING PERCENTAGE --}}

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Starting Percentage
                    </label>

                    <input type="number"
                           name="starting_percentage"
                           id="starting_percentage"
                           min="0"
                           max="100"
                           step="0.01"
                           required
                           style="
                                width:100%;
                                box-sizing:border-box;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                           ">

                </div>


                {{-- ENDING PERCENTAGE --}}

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Ending Percentage
                    </label>

                    <input type="number"
                           name="ending_percentage"
                           id="ending_percentage"
                           min="0"
                           max="100"
                           step="0.01"
                           required
                           style="
                                width:100%;
                                box-sizing:border-box;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                           ">

                </div>

                {{-- Kept hidden so DB required columns still save; not shown in Create popup --}}
                <input type="hidden" name="date" id="date" value="">
                <input type="hidden" name="term" id="term" value="{{ $term }}">

            </div>


            {{-- FOOTER --}}

            <div style="
                padding:18px 25px;
                border-top:1px solid #e5e7eb;
                display:flex;
                justify-content:flex-end;
                gap:10px;
            ">

                <button type="button"
                        onclick="closeGradeModal()"
                        style="
                            background:#6b7280;
                            color:white;
                            border:none;
                            padding:11px 22px;
                            border-radius:6px;
                            cursor:pointer;
                        ">
                    Close
                </button>

                <button type="submit"
                        id="createSaveBtn"
                        style="
                            background:#111827;
                            color:white;
                            border:none;
                            padding:11px 22px;
                            border-radius:6px;
                            cursor:pointer;
                        ">
                    Save Grade
                </button>

            </div>

        </form>

    </div>

</div>


{{-- ================================================= --}}
{{-- EDIT GRADE MODAL --}}
{{-- ================================================= --}}

<div id="editGradeModal"
     style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.5);
        z-index:9999;
        padding:40px 15px;
        overflow-y:auto;
     ">

    <div style="
        max-width:700px;
        margin:auto;
        background:white;
        border-radius:10px;
        overflow:hidden;
    ">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 25px;
            border-bottom:1px solid #e5e7eb;
        ">

            <h2 style="margin:0;">
                Edit Grade
            </h2>

            <button type="button"
                    onclick="closeEditGradeModal()"
                    style="
                        border:none;
                        background:none;
                        font-size:28px;
                        cursor:pointer;
                        line-height:1;
                    ">
                ×
            </button>

        </div>

        <form id="editGradeForm">

            @csrf
            @method('PUT')

            <div style="padding:25px;">

                <div id="editGradeErrors"
                     style="
                        display:none;
                        background:#fee2e2;
                        color:#991b1b;
                        padding:12px 14px;
                        border-radius:6px;
                        margin-bottom:18px;
                     "></div>

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Grade <span style="color:#ef4444;">*</span>
                    </label>

                    <select name="grade"
                            id="edit_grade"
                            required
                            style="
                                width:100%;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                            ">

                        <option value="">
                            Select Grade
                        </option>

                    </select>

                </div>

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Starting Percentage
                    </label>

                    <input type="number"
                           name="starting_percentage"
                           id="edit_starting_percentage"
                           min="0"
                           max="100"
                           step="0.01"
                           required
                           style="
                                width:100%;
                                box-sizing:border-box;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                           ">

                </div>

                <div style="margin-bottom:18px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                    ">
                        Ending Percentage
                    </label>

                    <input type="number"
                           name="ending_percentage"
                           id="edit_ending_percentage"
                           min="0"
                           max="100"
                           step="0.01"
                           required
                           style="
                                width:100%;
                                box-sizing:border-box;
                                padding:12px;
                                border:1px solid #d1d5db;
                                border-radius:6px;
                           ">

                </div>

            </div>

            <div style="
                padding:18px 25px;
                border-top:1px solid #e5e7eb;
                display:flex;
                justify-content:flex-end;
                gap:10px;
            ">

                <button type="button"
                        onclick="closeEditGradeModal()"
                        style="
                            background:#6b7280;
                            color:white;
                            border:none;
                            padding:11px 22px;
                            border-radius:6px;
                            cursor:pointer;
                        ">
                    Close
                </button>

                <button type="submit"
                        id="editSaveBtn"
                        style="
                            background:#111827;
                            color:white;
                            border:none;
                            padding:11px 22px;
                            border-radius:6px;
                            cursor:pointer;
                        ">
                    Save Grade
                </button>

            </div>

        </form>

    </div>

</div>



<script>

let preferredGradeValue = null;
let editingResultGradeId = null;
let editSaving = false;
let createSaving = false;

function resetGradeDropdown(selectEl, placeholderMessage)
{
    selectEl.innerHTML = '';

    const placeholder = document.createElement('option');
    placeholder.value = '';
    placeholder.textContent = placeholderMessage || 'Select Grade';
    selectEl.appendChild(placeholder);
}

function syncTermFromSelectedExam()
{
    const examSelect = document.getElementById('exam_id');
    const selected = examSelect.options[examSelect.selectedIndex];
    const mappedTerm = selected ? selected.getAttribute('data-term') : null;

    if (mappedTerm) {
        document.getElementById('term').value = mappedTerm;
    }
}

function hideCreateNotices()
{
    const errors = document.getElementById('createGradeErrors');
    const notice = document.getElementById('createGradeNotice');

    errors.style.display = 'none';
    errors.innerHTML = '';
    notice.style.display = 'none';
    notice.innerHTML = '';
}

function showCreateErrors(errors)
{
    const box = document.getElementById('createGradeErrors');
    let messages = [];

    if (typeof errors === 'string') {
        messages = [errors];
    } else if (errors && typeof errors === 'object') {
        Object.keys(errors).forEach(function (key) {
            const value = errors[key];
            if (Array.isArray(value)) {
                messages = messages.concat(value);
            } else {
                messages.push(value);
            }
        });
    }

    if (!messages.length) {
        messages = ['Unable to save grade. Please try again.'];
    }

    box.innerHTML = '<ul style="margin:0;padding-left:18px;">' +
        messages.map(function (msg) {
            return '<li>' + msg + '</li>';
        }).join('') +
        '</ul>';
    box.style.display = 'block';
}

function refreshAvailableGrades()
{
    const examId = document.getElementById('exam_id').value;
    const classGroup = document.getElementById('class_group').value;
    const term = document.getElementById('term').value;
    const gradeSelect = document.getElementById('grade');
    const keepValue = preferredGradeValue;
    const notice = document.getElementById('createGradeNotice');

    notice.style.display = 'none';
    notice.innerHTML = '';

    if (!examId || !classGroup || !term) {
        resetGradeDropdown(gradeSelect, 'Select Grade');
        return Promise.resolve();
    }

    const params = new URLSearchParams({
        exam_id: examId,
        class_group: classGroup,
        term: term
    });

    return fetch("{{ route('result-grades.available-grades') }}?" + params.toString(), {
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
            resetGradeDropdown(gradeSelect, 'Select Grade');

            if (!result.ok) {
                console.error('Available grades validation failed:', result.data);
                return;
            }

            const grades = result.data.grades || [];

            if (!grades.length) {
                notice.textContent = result.data.message
                    || 'All grades have already been created for this Exam and Class Group.';
                notice.style.display = 'block';
                return;
            }

            grades.forEach(function (grade) {
                const option = document.createElement('option');
                option.value = grade.grade_name;
                option.textContent = grade.grade_name;
                gradeSelect.appendChild(option);
            });

            if (keepValue) {
                const exists = Array.from(gradeSelect.options).some(function (option) {
                    return option.value === keepValue;
                });

                if (exists) {
                    gradeSelect.value = keepValue;
                }
            }
        })
        .catch(function (error) {
            console.error('Available grades error:', error);
            resetGradeDropdown(gradeSelect, 'Select Grade');
        });
}

function loadEditAvailableGrades(examId, classGroup, term, excludeId, keepValue)
{
    const gradeSelect = document.getElementById('edit_grade');

    if (!examId || !classGroup || !term) {
        resetGradeDropdown(gradeSelect, 'Select Grade');
        if (keepValue) {
            const option = document.createElement('option');
            option.value = keepValue;
            option.textContent = keepValue;
            option.selected = true;
            gradeSelect.appendChild(option);
        }
        return Promise.resolve();
    }

    const params = new URLSearchParams({
        exam_id: examId,
        class_group: classGroup,
        term: term,
        exclude_id: excludeId
    });

    return fetch("{{ route('result-grades.available-grades') }}?" + params.toString(), {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(function (response) { return response.json(); })
        .then(function (data) {
            resetGradeDropdown(gradeSelect, 'Select Grade');

            (data.grades || []).forEach(function (grade) {
                const option = document.createElement('option');
                option.value = grade.grade_name;
                option.textContent = grade.grade_name;
                gradeSelect.appendChild(option);
            });

            if (keepValue) {
                const exists = Array.from(gradeSelect.options).some(function (option) {
                    return option.value === keepValue;
                });

                if (!exists) {
                    const option = document.createElement('option');
                    option.value = keepValue;
                    option.textContent = keepValue;
                    gradeSelect.appendChild(option);
                }

                gradeSelect.value = keepValue;
            }
        })
        .catch(function (error) {
            console.error('Edit available grades error:', error);
            resetGradeDropdown(gradeSelect, 'Select Grade');
            if (keepValue) {
                const option = document.createElement('option');
                option.value = keepValue;
                option.textContent = keepValue;
                option.selected = true;
                gradeSelect.appendChild(option);
            }
        });
}

function openCreateModal()
{
    preferredGradeValue = null;
    editingResultGradeId = null;
    createSaving = false;

    document.getElementById('modalTitle').innerText = 'Add Grade';
    document.getElementById('gradeForm').action = "{{ route('result-grades.store') }}";

    document.getElementById('exam_id').value = '';
    document.getElementById('class_group').value = '';
    document.getElementById('starting_percentage').value = '';
    document.getElementById('ending_percentage').value = '';
    document.getElementById('date').value = new Date().toISOString().split('T')[0];
    document.getElementById('term').value = @json($term);

    hideCreateNotices();
    resetGradeDropdown(document.getElementById('grade'), 'Select Grade');

    const saveBtn = document.getElementById('createSaveBtn');
    saveBtn.disabled = false;
    saveBtn.textContent = 'Save Grade';

    document.getElementById('gradeModal').style.display = 'block';
}

function openEditGradeModal(button)
{
    const data = button.dataset;

    editingResultGradeId = data.id || null;

    document.getElementById('editGradeErrors').style.display = 'none';
    document.getElementById('editGradeErrors').innerHTML = '';

    document.getElementById('edit_starting_percentage').value = data.startingPercentage ?? '';
    document.getElementById('edit_ending_percentage').value = data.endingPercentage ?? '';

    document.getElementById('editGradeModal').style.display = 'block';

    loadEditAvailableGrades(
        data.examId,
        data.classGroup,
        data.term,
        data.id,
        data.grade
    );
}

function closeGradeModal()
{
    if (createSaving) {
        return;
    }

    preferredGradeValue = null;
    hideCreateNotices();
    document.getElementById('gradeModal').style.display = 'none';
}

function closeEditGradeModal()
{
    if (editSaving) {
        return;
    }

    editingResultGradeId = null;
    document.getElementById('editGradeModal').style.display = 'none';
    document.getElementById('editGradeErrors').style.display = 'none';
    document.getElementById('editGradeErrors').innerHTML = '';
}

function showEditErrors(errors)
{
    const box = document.getElementById('editGradeErrors');
    let messages = [];

    if (typeof errors === 'string') {
        messages = [errors];
    } else if (errors && typeof errors === 'object') {
        Object.keys(errors).forEach(function (key) {
            const value = errors[key];
            if (Array.isArray(value)) {
                messages = messages.concat(value);
            } else {
                messages.push(value);
            }
        });
    }

    if (!messages.length) {
        messages = ['Unable to update grade. Please try again.'];
    }

    box.innerHTML = '<ul style="margin:0;padding-left:18px;">' +
        messages.map(function (msg) {
            return '<li>' + msg + '</li>';
        }).join('') +
        '</ul>';
    box.style.display = 'block';
}

document.querySelectorAll('.edit-grade-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        openEditGradeModal(button);
    });
});

document.getElementById('exam_id').addEventListener('change', function () {
    preferredGradeValue = null;
    syncTermFromSelectedExam();
    refreshAvailableGrades();
});

document.getElementById('class_group').addEventListener('change', function () {
    preferredGradeValue = null;
    refreshAvailableGrades();
});

document.getElementById('gradeForm').addEventListener('submit', function (event) {
    event.preventDefault();

    if (createSaving) {
        return;
    }

    const grade = document.getElementById('grade').value;
    const starting = parseFloat(document.getElementById('starting_percentage').value);
    const ending = parseFloat(document.getElementById('ending_percentage').value);

    hideCreateNotices();

    if (!document.getElementById('exam_id').value || !document.getElementById('class_group').value) {
        showCreateErrors('Please select Exam and Class Group.');
        return;
    }

    if (!grade) {
        showCreateErrors({ grade: ['Grade is required.'] });
        return;
    }

    if (Number.isNaN(starting) || Number.isNaN(ending)) {
        showCreateErrors({
            starting_percentage: ['Starting Percentage and Ending Percentage must be numeric.']
        });
        return;
    }

    if (starting > ending) {
        showCreateErrors({
            starting_percentage: ['Starting Percentage must not be greater than Ending Percentage.']
        });
        return;
    }

    createSaving = true;

    const saveBtn = document.getElementById('createSaveBtn');
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    const formData = new FormData(document.getElementById('gradeForm'));

    fetch("{{ route('result-grades.store') }}", {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
        .then(async function (response) {
            const data = await response.json().catch(function () { return {}; });

            if (!response.ok) {
                showCreateErrors(data.errors || data.message || 'Unable to save grade.');
                return;
            }

            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        })
        .catch(function () {
            showCreateErrors('Unable to save grade. Please try again.');
        })
        .finally(function () {
            createSaving = false;
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save Grade';
        });
});

document.getElementById('editGradeForm').addEventListener('submit', function (event) {
    event.preventDefault();

    if (editSaving || !editingResultGradeId) {
        return;
    }

    const starting = parseFloat(document.getElementById('edit_starting_percentage').value);
    const ending = parseFloat(document.getElementById('edit_ending_percentage').value);
    const grade = document.getElementById('edit_grade').value;

    if (!grade) {
        showEditErrors({ grade: ['Grade is required.'] });
        return;
    }

    if (Number.isNaN(starting) || Number.isNaN(ending)) {
        showEditErrors({
            starting_percentage: ['Starting Percentage and Ending Percentage must be numeric.']
        });
        return;
    }

    if (starting > ending) {
        showEditErrors({
            starting_percentage: ['Starting Percentage must not be greater than Ending Percentage.']
        });
        return;
    }

    editSaving = true;

    const saveBtn = document.getElementById('editSaveBtn');
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    const formData = new FormData(document.getElementById('editGradeForm'));

    fetch("/result-grades/" + editingResultGradeId, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
        .then(async function (response) {
            const data = await response.json().catch(function () { return {}; });

            if (!response.ok) {
                showEditErrors(data.errors || data.message || 'Unable to update grade.');
                return;
            }

            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        })
        .catch(function () {
            showEditErrors('Unable to update grade. Please try again.');
        })
        .finally(function () {
            editSaving = false;
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save Grade';
        });
});

window.addEventListener('click', function (event) {
    if (event.target === document.getElementById('gradeModal') && !createSaving) {
        closeGradeModal();
    }

    if (event.target === document.getElementById('editGradeModal') && !editSaving) {
        closeEditGradeModal();
    }
});

</script>

@endsection