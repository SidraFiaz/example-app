<x-app-layout>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h1 class="text-4xl font-semibold text-gray-800">
                        Grades
                    </h1>

                    <div class="flex items-center gap-3 mt-2 text-lg">
                        <a href="{{ url('/dashboard') }}"
                           class="text-blue-600 hover:text-blue-800">
                            Home
                        </a>

                        <span class="text-gray-400">/</span>

                        <span class="text-gray-500">
                            Grades
                        </span>
                    </div>
                </div>

                <button
                    type="button"
                    onclick="openGradeModal()"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-lg font-medium"
                >
                    Create Grades
                </button>

            </div>

            <hr class="mb-6">

            {{-- SUCCESS MESSAGE --}}
            <div
                id="grades-success-banner"
                class="mb-5 px-4 py-3 rounded-md bg-green-100 border border-green-300 text-green-800 {{ session('success') ? '' : 'hidden' }}"
            >
                {{ session('success') }}
            </div>

            {{-- VALIDATION ERRORS (page-level, e.g. create) --}}
            @if($errors->any())
                <div class="mb-5 px-4 py-3 rounded-md bg-red-100 border border-red-300 text-red-800">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- GRADES TABLE --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="text-left text-gray-700 text-xl">

                                <th class="px-4 py-5 border-b font-semibold">
                                    Grade
                                </th>

                                <th class="px-4 py-5 border-b font-semibold">
                                    Remarks
                                </th>

                                <th class="px-4 py-5 border-b font-semibold">
                                    Teacher Comment
                                </th>

                                <th class="px-4 py-5 border-b font-semibold text-center whitespace-nowrap" style="min-width: 220px;">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody id="grades-table-body">

                            @forelse($grades as $grade)

                                <tr class="hover:bg-gray-50" data-grade-id="{{ $grade->id }}">

                                    <td class="px-4 py-4 border-b text-lg text-gray-700 grade-name-cell">
                                        {{ $grade->grade_name }}
                                    </td>

                                    <td class="px-4 py-4 border-b text-lg text-gray-700 grade-remarks-cell">
                                        {{ $grade->remarks }}
                                    </td>

                                    <td class="px-4 py-4 border-b text-lg text-gray-700 grade-comment-cell">
                                        {{ $grade->teacher_comment }}
                                    </td>

                                    <td class="px-4 py-4 border-b text-center whitespace-nowrap" style="min-width: 220px;">

                                        <div class="grades-action-btns">
                                            <x-action-edit
                                                type="button"
                                                class="edit-grade-btn"
                                                data-id="{{ $grade->id }}"
                                                data-grade-name="{{ $grade->grade_name }}"
                                                data-remarks="{{ $grade->remarks }}"
                                                data-teacher-comment="{{ $grade->teacher_comment }}"
                                            />

                                            <form
                                                action="{{ route('grades.destroy', $grade->id) }}"
                                                method="POST"
                                                data-delete-confirm="Are you sure you want to delete this grade?"
                                                class="grades-action-delete-form"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <x-action-delete />
                                            </form>
                                        </div>

                                    </td>

                                </tr>

                            @empty
                                <tr id="grades-empty-row">
                                    <td colspan="4" class="px-4 py-10 text-center text-gray-500 text-lg border-b">
                                        No grades found. Click “Create Grades” to add one.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>


    {{-- ========================= --}}
    {{-- ADD / EDIT MODAL --}}
    {{-- ========================= --}}

    <div
        id="gradeModal"
        class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[9999] p-4"
    >

        <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg mx-auto">

            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-5 border-b">

                <h2
                    id="modalTitle"
                    class="text-2xl font-semibold text-gray-800"
                >
                    Edit Grade
                </h2>

                <button
                    type="button"
                    onclick="closeGradeModal()"
                    class="text-gray-500 hover:text-gray-800 text-3xl leading-none"
                    aria-label="Close"
                >
                    ×
                </button>

            </div>


            {{-- FORM --}}
            <form
                id="gradeForm"
                action="{{ route('grades.store') }}"
                method="POST"
            >

                @csrf

                <div id="methodField"></div>

                <div
                    id="grade-modal-errors"
                    class="mx-6 mt-5 hidden px-4 py-3 rounded-md bg-red-100 border border-red-300 text-red-800 text-sm"
                >
                    <ul id="grade-modal-errors-list" class="list-disc ml-5 space-y-1"></ul>
                </div>

                <div class="p-6 space-y-5">

                    <div>

                        <label for="grade_name" class="block text-gray-700 mb-2 text-lg">
                            Grade <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="grade_name"
                            id="grade_name"
                            required
                            maxlength="255"
                            placeholder="Enter Grade"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 text-lg focus:border-black focus:ring-black"
                        >

                    </div>


                    <div>

                        <label for="remarks" class="block text-gray-700 mb-2 text-lg">
                            Remarks <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="remarks"
                            id="remarks"
                            required
                            maxlength="255"
                            placeholder="Enter Remarks"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 text-lg focus:border-black focus:ring-black"
                        >

                    </div>


                    <div>

                        <label for="teacher_comment" class="block text-gray-700 mb-2 text-lg">
                            Teacher comment <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            name="teacher_comment"
                            id="teacher_comment"
                            rows="4"
                            required
                            placeholder="Enter Teacher Comment"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 text-lg focus:border-black focus:ring-black"
                        ></textarea>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-4 border-t">

                    <button
                        type="button"
                        onclick="closeGradeModal()"
                        class="px-5 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-md"
                    >
                        Close
                    </button>

                    <button
                        type="submit"
                        id="grade-save-btn"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md"
                    >
                        Save Grade
                    </button>

                </div>

            </form>

        </div>

    </div>


    <style>
        .grades-action-btns {
            display: inline-flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
        }

        .grades-action-delete-form {
            display: inline-flex;
            margin: 0;
            padding: 0;
            flex-shrink: 0;
        }

        .grades-action-btns .action-btn {
            flex-shrink: 0;
            white-space: nowrap;
        }
    </style>

    <script>
        let editingGradeId = null;
        const gradesBaseUrl = @json(url('/grades'));
        const gradesDestroyConfirm = 'Are you sure you want to delete this grade?';

        function clearModalErrors() {
            const box = document.getElementById('grade-modal-errors');
            const list = document.getElementById('grade-modal-errors-list');
            list.innerHTML = '';
            box.classList.add('hidden');
        }

        function showModalErrors(messages) {
            const box = document.getElementById('grade-modal-errors');
            const list = document.getElementById('grade-modal-errors-list');
            list.innerHTML = '';

            (messages || []).forEach(function (message) {
                const li = document.createElement('li');
                li.textContent = message;
                list.appendChild(li);
            });

            box.classList.remove('hidden');
        }

        function showSuccessBanner(message) {
            const banner = document.getElementById('grades-success-banner');
            banner.textContent = message;
            banner.classList.remove('hidden');
            banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function bindEditButton(btn) {
            btn.addEventListener('click', function () {
                editGrade(
                    btn.getAttribute('data-id'),
                    btn.getAttribute('data-grade-name'),
                    btn.getAttribute('data-remarks'),
                    btn.getAttribute('data-teacher-comment')
                );
            });
        }

        function openGradeModal() {
            const modal = document.getElementById('gradeModal');
            const form = document.getElementById('gradeForm');

            editingGradeId = null;
            clearModalErrors();

            document.getElementById('modalTitle').innerText = 'Add Grade';
            form.action = gradesBaseUrl;
            document.getElementById('methodField').innerHTML = '';

            document.getElementById('grade_name').value = '';
            document.getElementById('remarks').value = '';
            document.getElementById('teacher_comment').value = '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('grade_name').focus();
        }

        function closeGradeModal() {
            const modal = document.getElementById('gradeModal');
            editingGradeId = null;
            clearModalErrors();
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editGrade(id, gradeName, remarks, teacherComment) {
            const modal = document.getElementById('gradeModal');
            const form = document.getElementById('gradeForm');

            editingGradeId = id;
            clearModalErrors();

            document.getElementById('modalTitle').innerText = 'Edit Grade';
            form.action = gradesBaseUrl + '/' + id;
            document.getElementById('methodField').innerHTML =
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('grade_name').value = gradeName ?? '';
            document.getElementById('remarks').value = remarks ?? '';
            document.getElementById('teacher_comment').value = teacherComment ?? '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('grade_name').focus();
        }

        function updateGradeRow(grade) {
            const row = document.querySelector('tr[data-grade-id="' + grade.id + '"]');
            if (!row) {
                return;
            }

            row.querySelector('.grade-name-cell').textContent = grade.grade_name || '';
            row.querySelector('.grade-remarks-cell').textContent = grade.remarks || '';
            row.querySelector('.grade-comment-cell').textContent = grade.teacher_comment || '';

            const editBtn = row.querySelector('.edit-grade-btn');
            if (editBtn) {
                editBtn.setAttribute('data-grade-name', grade.grade_name || '');
                editBtn.setAttribute('data-remarks', grade.remarks || '');
                editBtn.setAttribute('data-teacher-comment', grade.teacher_comment || '');
            }
        }

        function appendGradeRow(grade) {
            const tbody = document.getElementById('grades-table-body');
            const emptyRow = document.getElementById('grades-empty-row');
            if (emptyRow) {
                emptyRow.remove();
            }

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50';
            tr.setAttribute('data-grade-id', grade.id);

            tr.innerHTML =
                '<td class="px-4 py-4 border-b text-lg text-gray-700 grade-name-cell">' + escapeHtml(grade.grade_name) + '</td>' +
                '<td class="px-4 py-4 border-b text-lg text-gray-700 grade-remarks-cell">' + escapeHtml(grade.remarks) + '</td>' +
                '<td class="px-4 py-4 border-b text-lg text-gray-700 grade-comment-cell">' + escapeHtml(grade.teacher_comment) + '</td>' +
                '<td class="px-4 py-4 border-b text-center whitespace-nowrap" style="min-width: 220px;">' +
                    '<div class="grades-action-btns">' +
                        '<button type="button" class="action-btn action-btn-edit edit-grade-btn"' +
                            ' data-id="' + escapeHtml(grade.id) + '"' +
                            ' data-grade-name="' + escapeHtml(grade.grade_name) + '"' +
                            ' data-remarks="' + escapeHtml(grade.remarks) + '"' +
                            ' data-teacher-comment="' + escapeHtml(grade.teacher_comment) + '">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />' +
                            '</svg>' +
                            '<span>Edit</span>' +
                        '</button>' +
                        '<form action="' + gradesBaseUrl + '/' + encodeURIComponent(grade.id) + '" method="POST"' +
                            ' data-delete-confirm="' + gradesDestroyConfirm + '"' +
                            ' class="grades-action-delete-form">' +
                            '<input type="hidden" name="_token" value="' + escapeHtml(document.querySelector('meta[name="csrf-token"]').getAttribute('content')) + '">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="action-btn action-btn-delete">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
                                    '<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />' +
                                '</svg>' +
                                '<span>Delete</span>' +
                            '</button>' +
                        '</form>' +
                    '</div>' +
                '</td>';

            tbody.appendChild(tr);
            bindEditButton(tr.querySelector('.edit-grade-btn'));
        }

        function parseErrorMessages(data, fallback) {
            let messages = [];

            if (data && data.errors) {
                Object.keys(data.errors).forEach(function (key) {
                    messages = messages.concat(data.errors[key]);
                });
            } else if (data && data.message) {
                messages = [data.message];
            } else {
                messages = [fallback];
            }

            return messages;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('gradeModal');
            const form = document.getElementById('gradeForm');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                || form.querySelector('input[name="_token"]')?.value;

            document.querySelectorAll('.edit-grade-btn').forEach(bindEditButton);

            if (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeGradeModal();
                    }
                });
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                clearModalErrors();

                const saveBtn = document.getElementById('grade-save-btn');
                saveBtn.disabled = true;

                const isEdit = !!editingGradeId;
                const payload = {
                    grade_name: document.getElementById('grade_name').value,
                    remarks: document.getElementById('remarks').value,
                    teacher_comment: document.getElementById('teacher_comment').value
                };

                if (isEdit) {
                    payload._method = 'PUT';
                }

                const url = isEdit
                    ? (gradesBaseUrl + '/' + editingGradeId)
                    : gradesBaseUrl;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                })
                    .then(function (response) {
                        return response.json().then(function (data) {
                            return { ok: response.ok, data: data };
                        });
                    })
                    .then(function (result) {
                        saveBtn.disabled = false;

                        if (!result.ok) {
                            showModalErrors(parseErrorMessages(
                                result.data,
                                isEdit
                                    ? 'Unable to update grade. Please try again.'
                                    : 'Unable to create grade. Please try again.'
                            ));
                            return;
                        }

                        if (isEdit) {
                            updateGradeRow(result.data.grade);
                            showSuccessBanner(result.data.message || 'Grade Updated Successfully');
                        } else {
                            appendGradeRow(result.data.grade);
                            showSuccessBanner(result.data.message || 'Grade Created Successfully');
                        }

                        closeGradeModal();
                    })
                    .catch(function () {
                        saveBtn.disabled = false;
                        showModalErrors([
                            isEdit
                                ? 'Unable to update grade. Please try again.'
                                : 'Unable to create grade. Please try again.'
                        ]);
                    });
            });
        });
    </script>

</x-app-layout>
