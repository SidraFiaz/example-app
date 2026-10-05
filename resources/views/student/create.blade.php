
<x-app-layout>

    {{-- ============================================================
         HEADER
    ============================================================= --}}

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Form
        </h2>

    </x-slot>


    {{-- ============================================================
         MAIN CONTENT
    ============================================================= --}}

    <div class="py-12">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg">

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))

                    <div class="mb-4 text-green-600">
                        {{ session('success') }}
                    </div>

                @endif


                {{-- VALIDATION ERRORS --}}
                @if($errors->any())

                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">

                        <ul class="text-red-600 text-sm list-disc list-inside">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- ==================================================
                     STUDENT FORM
                =================================================== --}}

                <form
                    method="POST"
                    action="{{ route('student.store') }}"
                >

                    @csrf


                    <div
                        class="student-form-grid grid grid-cols-1 md:grid-cols-2"
                        style="column-gap: 24px; row-gap: 22px;"
                    >

                        {{-- Row 1: Name | Father Name --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="name"
                                value="Name"
                            />

                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                class="block mt-1 w-full box-border"
                                required
                                autofocus
                            />

                            @error('name')

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <div class="min-w-0">

                            <x-input-label
                                for="father_name"
                                value="Father Name"
                            />

                            <x-text-input
                                id="father_name"
                                name="father_name"
                                type="text"
                                value="{{ old('father_name') }}"
                                class="block mt-1 w-full box-border"
                            />

                            @error('father_name')

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Row 2: Age | Email --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="age"
                                value="Age"
                            />

                            <x-text-input
                                id="age"
                                type="number"
                                name="age"
                                value="{{ old('age') }}"
                                class="block mt-1 w-full box-border"
                                required
                            />

                            @error('age')

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <div class="min-w-0">

                            <x-input-label
                                for="email"
                                value="Email"
                            />

                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="block mt-1 w-full box-border"
                                required
                            />

                            @error('email')

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Row 3: Gender | Class --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="gender"
                                value="Gender"
                            />

                            <select
                                id="gender"
                                name="gender"
                                class="block mt-1 w-full border-gray-300 rounded-md box-border"
                                required
                            >

                                <option value="">
                                    Select Gender
                                </option>

                                <option
                                    value="Male"
                                    {{ old('gender') == 'Male' ? 'selected' : '' }}
                                >
                                    Male
                                </option>

                                <option
                                    value="Female"
                                    {{ old('gender') == 'Female' ? 'selected' : '' }}
                                >
                                    Female
                                </option>

                            </select>

                            @error('gender')

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <div class="min-w-0">

                            <x-input-label
                                for="class_id"
                                value="Class"
                            />

                            <select
                                id="class_id"
                                name="class_id"
                                class="block mt-1 w-full border-gray-300 rounded-md box-border"
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

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Row 4: Section | empty --}}
                        <div class="min-w-0">

                            <x-input-label
                                for="section_id"
                                value="Section"
                            />

                            <select
                                id="section_id"
                                name="section_id"
                                class="block mt-1 w-full border-gray-300 rounded-md box-border"
                                required
                            >

                                <option value="">
                                    Select Section
                                </option>

                                {{-- Sections will load according to selected class --}}

                            </select>

                            @error('section_id')

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        <div class="hidden md:block"></div>

                    </div>

                    <style>
                        .student-form-grid {
                            display: grid;
                            grid-template-columns: 1fr;
                            column-gap: 24px;
                            row-gap: 22px;
                        }

                        @media (min-width: 768px) {
                            .student-form-grid {
                                grid-template-columns: repeat(2, minmax(0, 1fr));
                            }
                        }

                        .student-form-grid input,
                        .student-form-grid select {
                            width: 100%;
                            box-sizing: border-box;
                        }
                    </style>


                    {{-- ==================================================
                         SAVE BUTTON
                    =================================================== --}}

                    <div class="mt-6">

                        <x-primary-button>
                            Save Student
                        </x-primary-button>

                    </div>


                </form>

            </div>

        </div>

    </div>


    {{-- ============================================================
         CLASS → SECTION JAVASCRIPT
    ============================================================= --}}

    <script>

        document.addEventListener(
            "DOMContentLoaded",
            function () {

                const classDropdown =
                    document.getElementById("class_id");

                const sectionDropdown =
                    document.getElementById("section_id");


                classDropdown.addEventListener(
                    "change",
                    function () {

                        let classId =
                            this.value;


                        sectionDropdown.innerHTML =
                            '<option value="">Select Section</option>';


                        if (classId !== "") {

                            fetch(
                                '/get-sections/' + classId
                            )

                            .then(
                                response => response.json()
                            )

                            .then(
                                data => {

                                    data.forEach(
                                        function (section) {

                                            let option =
                                                document.createElement(
                                                    "option"
                                                );

                                            option.value =
                                                section.id;

                                            option.textContent =
                                                section.section_name;

                                            sectionDropdown.appendChild(
                                                option
                                            );

                                        }
                                    );

                                }
                            )

                            .catch(
                                error =>
                                    console.error(error)
                            );

                        }

                    }
                );

            }
        );

    </script>

</x-app-layout>

