
<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Discount
            </h2>

            <a href="{{ route('discounts.index') }}"
               class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl p-6 discount-create-form">

                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Create Discount
                </h3>

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('discounts.store') }}" method="POST">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Class --}}
                        <div>
                            <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Class
                            </label>

                            <select
                                name="class_id"
                                id="class_id"
                                class="discount-select w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="">Select Class</option>

                                @forelse($classes as $class)
                                    <option
                                        value="{{ $class->id }}"
                                        {{ (string) old('class_id', request('class_id')) === (string) $class->id ? 'selected' : '' }}
                                    >
                                        {{ $class->class_name }}
                                    </option>
                                @empty
                                    <option value="" disabled>No classes available</option>
                                @endforelse

                            </select>
                        </div>


                        {{-- Student --}}
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Student
                            </label>

                            <select
                                name="student_id"
                                id="student_id"
                                class="discount-select w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">All Students</option>

                                @foreach($students as $student)
                                    <option
                                        value="{{ $student->id }}"
                                        data-class-id="{{ $student->class_id }}"
                                        {{ (string) old('student_id') === (string) $student->id ? 'selected' : '' }}
                                    >
                                        {{ $student->name }}
                                    </option>
                                @endforeach

                            </select>

                            <p class="text-xs text-gray-500 mt-1">
                                Leave empty to apply discount to the whole class.
                            </p>
                        </div>


                        {{-- Discount Type --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Type
                            </label>

                            <select
                                name="discount_type"
                                class="discount-select w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="">Select Type</option>

                                <option
                                    value="percentage"
                                    {{ old('discount_type') == 'percentage' ? 'selected' : '' }}
                                >
                                    Percentage (%)
                                </option>

                                <option
                                    value="fixed"
                                    {{ old('discount_type') == 'fixed' ? 'selected' : '' }}
                                >
                                    Fixed Amount
                                </option>

                            </select>
                        </div>


                        {{-- Discount Value --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Value
                            </label>

                            <input
                                type="number"
                                name="discount_value"
                                value="{{ old('discount_value') }}"
                                step="0.01"
                                min="0"
                                placeholder="Enter discount value"
                                class="discount-input w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>


                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>

                            <select
                                name="status"
                                class="discount-select w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option
                                    value="Active"
                                    {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="Inactive"
                                    {{ old('status') == 'Inactive' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                            </select>
                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 mt-8">

                        <a
                            href="{{ route('discounts.index') }}"
                            class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="bg-black text-white px-5 py-2 rounded-lg hover:bg-gray-800"
                        >
                            Save Discount
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

    {{--
      Double-arrow fix:
      @tailwindcss/forms already draws ONE chevron via background-image + appearance:none.
      Forcing appearance:auto/menulist re-enables the browser arrow on top of that = two arrows.
      Keep appearance:none so only the Forms plugin arrow remains.
    --}}
    <style>
        .discount-create-form .discount-select,
        .discount-create-form .discount-input {
            height: 42px;
            min-height: 42px;
            max-height: 42px;
            line-height: 1.25;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            box-sizing: border-box;
        }

        .discount-create-form select.discount-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const classSelect = document.getElementById('class_id');
            const studentSelect = document.getElementById('student_id');

            if (!classSelect || !studentSelect) {
                return;
            }

            const allStudentOptions = Array.from(
                studentSelect.querySelectorAll('option[data-class-id]')
            );

            function filterStudentsByClass() {
                const selectedClassId = String(classSelect.value || '');
                const previousStudentId = String(studentSelect.value || '');
                let keepStudent = false;

                allStudentOptions.forEach(function (option) {
                    const optionClassId = String(option.getAttribute('data-class-id') || '');
                    const matches = selectedClassId !== '' && optionClassId === selectedClassId;

                    option.hidden = !matches;
                    option.disabled = !matches;

                    if (matches && option.value === previousStudentId) {
                        keepStudent = true;
                    }
                });

                // Reset student if it does not belong to the newly selected class
                if (!keepStudent) {
                    studentSelect.value = '';
                }
            }

            classSelect.addEventListener('change', filterStudentsByClass);

            // Run once on load (also handles old() validation repopulation)
            filterStudentsByClass();
        });
    </script>

</x-app-layout>
