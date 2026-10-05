<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Student Promotion
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Student Name</th>
                            <th class="px-4 py-3 text-left">Current Class</th>
                            <th class="px-4 py-3 text-left">Promote To</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($students as $student)

                            <tr class="border-b">

                                <td class="px-4 py-3">
                                    {{ method_exists($students, 'firstItem') && $students->firstItem()
                                        ? $students->firstItem() + $loop->index
                                        : $loop->iteration }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $student->name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $student->studentClass->class_name ?? 'N/A' }}
                                </td>

                                <td class="px-4 py-3">

                                    <form action="{{ route('student-promotions.promote', $student->id) }}"
                                          method="POST"
                                          class="flex items-center gap-2">

                                        @csrf
                                        @method('PUT')

                                        <select name="class_id"
                                                class="border-gray-300 rounded-md">

                                            <option value="">
                                                Select Class
                                            </option>

                                            @foreach($classes as $class)

                                                @if($class->id != $student->class_id)

                                                    <option value="{{ $class->id }}">
                                                        {{ $class->class_name }}
                                                    </option>

                                                @endif

                                            @endforeach

                                        </select>

                                </td>

                                <td class="px-4 py-3">

                                        <button type="submit"
                                                class="bg-black text-white px-4 py-2 rounded">
                                            Promote
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-4 py-4 text-center">
                                    No students found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>