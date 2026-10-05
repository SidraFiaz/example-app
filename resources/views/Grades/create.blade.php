<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Add Grade
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('grades.store') }}" method="POST">
                    @csrf

                    <!-- Exam -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">
                            Exam
                        </label>

                        <select
                            name="exam_id"
                            class="border-gray-300 rounded-md w-full mt-1"
                            required>

                            <option value="">Select Exam</option>

                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">
                                    {{ $exam->exam_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <!-- Class Group -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">
                            Class Group
                        </label>

                        <input
                            type="text"
                            name="class_group"
                            class="border-gray-300 rounded-md w-full mt-1"
                            placeholder="Example: Primary"
                            required>
                    </div>


                    <!-- Grade -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">
                            Grade
                        </label>

                        <input
                            type="text"
                            name="grade_name"
                            class="border-gray-300 rounded-md w-full mt-1"
                            placeholder="Example: A+"
                            required>
                    </div>


                    <!-- Starting Percentage -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">
                            Starting Percentage
                        </label>

                        <input
                            type="number"
                            name="percentage_from"
                            step="0.01"
                            min="0"
                            max="100"
                            class="border-gray-300 rounded-md w-full mt-1"
                            placeholder="Example: 90"
                            required>
                    </div>


                    <!-- Ending Percentage -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">
                            Ending Percentage
                        </label>

                        <input
                            type="number"
                            name="percentage_to"
                            step="0.01"
                            min="0"
                            max="100"
                            class="border-gray-300 rounded-md w-full mt-1"
                            placeholder="Example: 100"
                            required>
                    </div>


                    <!-- Remarks -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">
                            Remarks
                        </label>

                        <input
                            type="text"
                            name="remarks"
                            class="border-gray-300 rounded-md w-full mt-1"
                            placeholder="Optional">
                    </div>


                    <button
                        type="submit"
                        class="bg-black text-white px-4 py-2 rounded">

                        Save Grade

                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>