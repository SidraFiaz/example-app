<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Add New Admission
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg">

                <form method="POST" action="{{ route('admission.store') }}">

                    @csrf

                    <div
                        class="admission-create-grid"
                        style="display: grid; grid-template-columns: 1fr; column-gap: 24px; row-gap: 16px;"
                    >

                        {{-- Student Name --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="student_name"
                                value="Student Name"
                            />

                            <x-text-input
                                id="student_name"
                                name="student_name"
                                type="text"
                                class="block mt-1 w-full"
                                value="{{ old('student_name') }}"
                                required
                            />

                            @error('student_name')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Father Name --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="father_name"
                                value="Father Name"
                            />

                            <x-text-input
                                id="father_name"
                                name="father_name"
                                type="text"
                                class="block mt-1 w-full"
                                value="{{ old('father_name') }}"
                                required
                            />

                            @error('father_name')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Family No --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="family_no"
                                value="Family No"
                            />

                            <x-text-input
                                id="family_no"
                                name="family_no"
                                type="text"
                                class="block mt-1 w-full"
                                value="{{ old('family_no') }}"
                            />

                        </div>


                        {{-- Class --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="class_id"
                                value="Class"
                            />

                            <select
                                id="class_id"
                                name="class_id"
                                class="block mt-1 w-full border-gray-300 rounded-md"
                                required
                            >

                                <option value="">
                                    Select Class
                                </option>

                                @foreach($classes as $class)

                                    <option
                                        value="{{ $class->id }}"
                                        {{ old('class_id') == $class->id ? 'selected' : '' }}
                                    >
                                        {{ $class->class_name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('class_id')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Section --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="section_id"
                                value="Section"
                            />

                            <select
                                id="section_id"
                                name="section_id"
                                class="block mt-1 w-full border-gray-300 rounded-md"
                                required
                                {{ old('class_id') ? '' : 'disabled' }}
                            >

                                <option value="">
                                    Select Section
                                </option>

                            </select>

                            @error('section_id')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="status"
                                value="Status"
                            />

                            <select
                                id="status"
                                name="status"
                                class="block mt-1 w-full border-gray-300 rounded-md"
                                required
                            >

                                <option value="Active">
                                    Active
                                </option>

                                <option value="Inactive">
                                    Inactive
                                </option>

                            </select>

                        </div>


                        {{-- Admission Date --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="admission_date"
                                value="Admission Date"
                            />

                            <x-text-input
                                id="admission_date"
                                name="admission_date"
                                type="date"
                                class="block mt-1 w-full"
                                value="{{ old('admission_date', date('Y-m-d')) }}"
                                required
                            />

                            @error('admission_date')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Father Contact --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="father_contact"
                                value="Father Contact"
                            />

                            <x-text-input
                                id="father_contact"
                                name="father_contact"
                                type="text"
                                class="block mt-1 w-full"
                                value="{{ old('father_contact') }}"
                            />

                        </div>

                    </div>

                    <style>
                        @media (min-width: 768px) {
                            .admission-create-grid {
                                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                            }
                        }

                        .admission-create-grid input,
                        .admission-create-grid select {
                            width: 100%;
                            box-sizing: border-box;
                        }
                    </style>


                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 mt-6">

                        <x-primary-button>
                            Save Admission
                        </x-primary-button>

                        <a href="{{ route('admission.index') }}">
                            <x-secondary-button type="button">
                                Cancel
                            </x-secondary-button>
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- Class → Section --}}
    <script>

        document.addEventListener("DOMContentLoaded", function () {

            const classDropdown = document.getElementById("class_id");
            const sectionDropdown = document.getElementById("section_id");
            const selectedSectionId = @json(old('section_id'));

            function resetSections(message) {
                sectionDropdown.innerHTML =
                    '<option value="">' + message + '</option>';
            }

            function loadSections(classId, selectedId) {
                resetSections('Select Section');

                if (!classId) {
                    sectionDropdown.disabled = true;
                    return;
                }

                sectionDropdown.disabled = true;

                fetch('/get-sections/' + classId)
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        resetSections('Select Section');

                        if (!data || data.length === 0) {
                            resetSections('No sections available');
                            sectionDropdown.disabled = true;
                            return;
                        }

                        data.forEach(function (section) {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.section_name;

                            if (selectedId && String(selectedId) === String(section.id)) {
                                option.selected = true;
                            }

                            sectionDropdown.appendChild(option);
                        });

                        sectionDropdown.disabled = false;
                    })
                    .catch(function (error) {
                        console.error(error);
                        resetSections('Select Section');
                        sectionDropdown.disabled = true;
                    });
            }

            classDropdown.addEventListener('change', function () {
                loadSections(this.value, null);
            });

            // Preserve sections after validation errors / page refresh
            if (classDropdown.value) {
                loadSections(classDropdown.value, selectedSectionId);
            } else {
                sectionDropdown.disabled = true;
            }

        });

    </script>

</x-app-layout>