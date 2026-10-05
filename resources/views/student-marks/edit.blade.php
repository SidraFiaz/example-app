<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Edit Student Marks
            </h2>
            <div class="text-sm mt-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('student-marks.index') }}" class="text-blue-600 hover:text-blue-800">View and Edit Student Marks</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-500">Edit</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 sm:p-8">

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-md text-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('student-marks.update', $studentMark->id) }}" id="marks-edit-form">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- ROW 1: Current Date | Session | Exams --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1.5">
                                    Current Date
                                </label>
                                <input
                                    type="date"
                                    value="{{ optional($studentMark->date)->format('Y-m-d') ?? '' }}"
                                    readonly
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1.5">
                                    Session
                                </label>
                                <input
                                    type="text"
                                    value="{{ $studentMark->session->name ?? '-' }}"
                                    readonly
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1.5">
                                    Exams
                                </label>
                                <input
                                    type="text"
                                    value="{{ $studentMark->exam->exam_name ?? '-' }}"
                                    readonly
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                                >
                            </div>
                        </div>

                        {{-- ROW 2: Class | Section --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1.5">
                                    Class
                                </label>
                                <input
                                    type="text"
                                    value="{{ $studentMark->studentClass->class_name ?? '-' }}"
                                    readonly
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1.5">
                                    Section
                                </label>
                                <input
                                    type="text"
                                    value="{{ $studentMark->section->section_name ?? '-' }}"
                                    readonly
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                                >
                            </div>
                        </div>

                        {{-- ROW 3: Subject | Student --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1.5">
                                    Subject
                                </label>
                                <input
                                    type="text"
                                    value="{{ $studentMark->subject->subject_name ?? '-' }}"
                                    readonly
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-1.5">
                                    Student
                                </label>
                                <input
                                    type="text"
                                    value="{{ $studentMark->student->name ?? '-' }}"
                                    readonly
                                    class="block w-full h-11 rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-700 text-sm cursor-default"
                                >
                            </div>
                        </div>

                        {{-- ROW 4: Total Marks * --}}
                        <div>
                            <label for="total_marks" class="block text-sm font-medium text-gray-800 mb-1.5">
                                Total Marks <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="total_marks"
                                id="total_marks"
                                min="0.01"
                                step="0.01"
                                value="{{ old('total_marks', $studentMark->total_marks) }}"
                                placeholder="Enter Total Marks"
                                required
                                class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                        {{-- ROW 5: Obtained Marks * (existing edit field) --}}
                        <div>
                            <label for="obtained_marks" class="block text-sm font-medium text-gray-800 mb-1.5">
                                Obtained Marks <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="obtained_marks"
                                id="obtained_marks"
                                min="0"
                                step="0.01"
                                value="{{ old('obtained_marks', $studentMark->obtained_marks) }}"
                                required
                                class="block w-full h-11 rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black text-sm"
                            >
                            <p id="obtained-error" class="mt-2 text-xs text-red-600 hidden"></p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center gap-3">
                        <a
                            href="{{ route('student-marks.index') }}"
                            class="inline-flex items-center justify-center border border-gray-300 bg-white hover:bg-gray-50 text-gray-800 font-medium px-8 py-2.5 rounded-md shadow-sm transition text-sm"
                        >
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center bg-black hover:bg-gray-800 text-white font-medium px-8 py-2.5 rounded-md shadow-sm transition text-sm"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('marks-edit-form');
            const totalInput = document.getElementById('total_marks');
            const obtainedInput = document.getElementById('obtained_marks');
            const errorEl = document.getElementById('obtained-error');

            function validateMarks() {
                const total = Number(totalInput.value);
                const obtained = Number(obtainedInput.value);

                if (obtainedInput.value !== '' && totalInput.value !== '' && obtained > total) {
                    errorEl.textContent = 'Obtained Marks cannot be greater than Total Marks.';
                    errorEl.classList.remove('hidden');
                    return false;
                }

                errorEl.textContent = '';
                errorEl.classList.add('hidden');
                return true;
            }

            totalInput.addEventListener('input', validateMarks);
            obtainedInput.addEventListener('input', validateMarks);

            form.addEventListener('submit', function (event) {
                if (!validateMarks()) {
                    event.preventDefault();
                    obtainedInput.focus();
                }
            });
        });
    </script>

</x-app-layout>
