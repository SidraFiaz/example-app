<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                <table class="table-auto w-full border border-gray-300">

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100">ID</th>
                        <td class="border px-4 py-2">{{ $student->id }}</td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100">Name</th>
                        <td class="border px-4 py-2">{{ $student->name }}</td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100">Email</th>
                        <td class="border px-4 py-2">{{ $student->email }}</td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100">Age</th>
                        <td class="border px-4 py-2">{{ $student->age }}</td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100">Gender</th>
                        <td class="border px-4 py-2">{{ $student->gender }}</td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100">Class</th>
                        <td class="border px-4 py-2">
                            {{ $student->studentClass?->class_name ?? 'N/A' }}
                        </td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100">Section</th>
                        <td class="border px-4 py-2">
                            {{ $student->section?->section_name ?? 'N/A' }}
                        </td>
                    </tr>

                </table>

                <div class="mt-6 flex gap-3">

                    <a href="{{ route('student.index') }}">
                        <x-secondary-button>
                            Back
                        </x-secondary-button>
                    </a>

                    <a href="{{ route('student.edit', $student->id) }}">
                        <x-primary-button>
                            Edit
                        </x-primary-button>
                    </a>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>