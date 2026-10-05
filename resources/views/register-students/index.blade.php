<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Register Students 9th,10th
                </h2>

                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:text-blue-800">
                        Home
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">Students</span>
                </div>
            </div>

            <a href="{{ route('register-students.create') }}"
               class="bg-black hover:bg-gray-800 text-white
                      px-7 py-2.5 rounded-md text-sm font-medium">
                Create
            </a>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                @if(session('success'))
                    <div class="mb-5 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filters --}}
                <form method="GET" action="{{ route('register-students.index') }}" class="mb-6">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Search Student
                            </label>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search Student"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Class
                            </label>
                            <select
                                name="class_id"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm"
                                onchange="this.form.submit()"
                            >
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ (string) request('class_id') === (string) $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <a href="{{ route('register-students.index') }}"
                               class="inline-flex items-center justify-center
                                      bg-black hover:bg-gray-800 text-white
                                      px-6 py-2.5 rounded-md text-sm font-medium">
                                Reset
                            </a>
                        </div>

                    </div>

                </form>

                {{-- Export --}}
                <div class="flex justify-center mb-6">
                    <a href="{{ route('register-students.export', request()->query()) }}"
                       class="inline-flex items-center justify-center
                              bg-green-600 hover:bg-green-700 text-white
                              px-8 py-2.5 rounded-md text-sm font-medium">
                        Export
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-700 text-white">
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold uppercase tracking-wide">
                                    Student Name
                                </th>
                                <th class="px-5 py-3 text-left font-semibold uppercase tracking-wide">
                                    Father Name
                                </th>
                                <th class="px-5 py-3 text-left font-semibold uppercase tracking-wide">
                                    Class
                                </th>
                                <th class="px-5 py-3 text-left font-semibold uppercase tracking-wide">
                                    Admission Date
                                </th>
                                <th class="px-5 py-3 text-left font-semibold uppercase tracking-wide">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">

                            @forelse($registerStudents as $row)

                                <tr class="border-b border-gray-200 hover:bg-gray-50">

                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $row->student->name ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $row->student->father_name ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $row->studentClass->class_name ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $row->admission_date ? $row->admission_date->format('d-m-Y') : '-' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="action-btn-group">

                                            <x-action-edit :href="route('register-students.edit', $row->id)" />

                                            <form
                                                action="{{ route('register-students.destroy', $row->id) }}"
                                                method="POST"
                                                data-delete-confirm="Are you sure you want to delete this record?"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <x-action-delete />
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                        No data available in table
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
