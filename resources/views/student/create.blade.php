<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Student Form
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">

                @if(session('success'))
                    <div class="mb-4 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('student.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" class="block mt-1 w-80" required />
                    </div>

                    <!-- Age -->
                    <div class="mb-4">
                        <x-input-label for="age" value="Age" />
                        <x-text-input id="age" type="number" name="age" class="block mt-1 w-80" required />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" type="email" name="email" class="block mt-1 w-80" required />
                    </div>

                    <!-- Gender -->
                    <div class="mb-4">
                        <x-input-label for="gender" value="Gender" />

                        <select name="gender" class="block mt-1 w-80 border-gray-300 rounded-md" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <!-- Class -->
                    <div class="mb-4">
                        <x-input-label for="class_id" value="Class" />

                        <select id="class_id" name="class_id"
                            class="block mt-1 w-80 border-gray-300 rounded-md" required>
                            <option value="">Select Class</option>

                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="mb-4">
                        <x-input-label for="section_id" value="Section" />

                        <select id="section_id" name="section_id"
                            class="block mt-1 w-80 border-gray-300 rounded-md" required>
                            <option value="">Select Section</option>
                        </select>
                    </div>

                    <x-primary-button>
                        Save Student
                    </x-primary-button>

                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const classDropdown = document.getElementById("class_id");
            const sectionDropdown = document.getElementById("section_id");

            classDropdown.addEventListener("change", function () {

                let classId = this.value;

                sectionDropdown.innerHTML =
                    '<option value="">Select Section</option>';

                if (classId !== "") {

                    fetch('/get-sections/' + classId)
                        .then(response => response.json())
                        .then(data => {

                            data.forEach(function (section) {

                                let option = document.createElement("option");
                                option.value = section.id;
                                option.textContent = section.section_name;

                                sectionDropdown.appendChild(option);

                            });

                        })
                        .catch(error => console.error(error));

                }

            });

        });
    </script>

</x-app-layout>