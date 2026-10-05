<x-app-layout>

    <div class="py-4">

        <div class="px-6">

            {{-- Heading --}}
            <div class="flex justify-between items-center border-b pb-3">

                <div>
                    <h1 class="text-2xl font-normal text-gray-800">
                        Class group
                    </h1>

                    <div class="text-sm text-gray-500 mt-1">
                        <span class="text-blue-600">Home</span>
                        <span class="mx-2">/</span>
                        <span>Class group List</span>
                    </div>
                </div>

                {{-- Create Button --}}
                <button
                    type="button"
                    onclick="openModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md text-sm">
                    Create class group
                </button>

            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table Card --}}
            <div class="mt-4 bg-white rounded-xl shadow border border-gray-200 p-6">

                @if($classGroups->count())

                    <table class="w-full">

                        <thead>
                            <tr>

                                <th class="text-left px-3 py-4 text-gray-600 font-semibold">
                                    Class Name
                                </th>

                                <th class="text-left px-3 py-4 text-gray-600 font-semibold">
                                    Group Name
                                </th>

                                <th class="text-center px-3 py-4 text-gray-600 font-semibold">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach($classGroups as $group)

                                <tr class="border-t">

                                    {{-- Class Name --}}
                                    <td class="border border-gray-200 px-3 py-4 text-gray-600">
                                        {{ $group->studentClass->class_name ?? '-' }}
                                    </td>

                                    {{-- Group Name --}}
                                    <td class="border border-gray-200 px-3 py-4 text-gray-600">
                                       {{ $group->group_name }}
                                    </td>

                                    {{-- Delete --}}
                                    <td class="border border-gray-200 px-3 py-2 text-center">

                                        <form
                                            action="{{ route('class-groups.destroy', $group->id) }}"
                                            method="POST"
                                            data-delete-confirm="Are you sure you want to delete this class group?"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <x-action-delete />
                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="text-center py-10 text-gray-500">
                        No class groups found.
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- CREATE CLASS GROUP MODAL --}}
    <div
        id="classGroupModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
    >

        <div class="bg-white rounded-md shadow-xl w-full max-w-xl">

            {{-- Modal Header --}}
            <div class="flex justify-between items-center px-5 py-4 border-b">

                <h2 class="text-2xl font-normal text-gray-800">
                    Create class group
                </h2>

                <button
                    type="button"
                    onclick="closeModal()"
                    class="text-gray-500 text-2xl"
                >
                    ×
                </button>

            </div>


            {{-- Modal Form --}}
            <form method="POST" action="{{ route('class-groups.store') }}">

                @csrf

                <div class="p-5">

                    {{-- Select Group --}}
                    <div class="mb-4">

                        <label class="block text-gray-600 mb-2">
                            Select group:
                        </label>

                        <select
                            name="name"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-600"
                            required
                        >
                            <option value="">-- Select group --</option>
                            <option value="Pre-Primary">Pre-Primary</option>
                            <option value="Primary">Primary</option>
                            <option value="Middle">Middle</option>
                            <option value="Secondary">Secondary</option>
                        </select>

                    </div>


                    {{-- Select Class --}}
                    <div>

                        <label class="block text-gray-600 mb-2">
                            Select class:
                        </label>

                        <select
                            name="class_id"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-600"
                            required
                        >
                            <option value="">-- Select class --</option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}">
                                    {{ $class->class_name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- Modal Footer --}}
                <div class="flex justify-end gap-2 px-5 py-4 border-t">

                    <button
                        type="button"
                        onclick="closeModal()"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-md"
                    >
                        Close
                    </button>

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md"
                    >
                        Save group
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- Modal JavaScript --}}
    <script>

        function openModal() {
            document.getElementById('classGroupModal')
                .classList.remove('hidden');

            document.getElementById('classGroupModal')
                .classList.add('flex');
        }

        function closeModal() {
            document.getElementById('classGroupModal')
                .classList.add('hidden');

            document.getElementById('classGroupModal')
                .classList.remove('flex');
        }

    </script>

</x-app-layout>