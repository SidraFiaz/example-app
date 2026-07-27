<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Classes') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg">

                <!-- Add Button -->
                <div class="flex justify-end p-6">
                    <a href="{{ route('classes.create') }}">
                        <x-primary-button>
                            Add New Class
                        </x-primary-button>
                    </a>
                </div>

                <!-- Table -->
                <div class="p-6 overflow-x-auto">

                    <table class="w-3/4 border border-gray-300">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-6 py-3 text-left">ID</th>
                                <th class="border px-6 py-3 text-left">Class Name</th>
                                <th class="border px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($classes as $class)

                                <tr class="hover:bg-gray-50">

                                    <td class="border px-6 py-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border px-6 py-3">
                                        {{ $class->class_name }}
                                    </td>

                                    <td class="border px-6 py-3 text-center">

                                        <x-dropdown align="right" width="48">

                                            <x-slot name="trigger">
                                                <button class="text-xl">
                                                    ⚙️
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">

                                                <x-dropdown-link :href="route('classes.edit', $class->id)">
                                                    Edit
                                                </x-dropdown-link>

                                                <x-dropdown-link :href="route('sections.index', $class->id)">
                                                    Sections
                                                </x-dropdown-link>

                                                <x-dropdown-link :href="route('subjects.index')">
                                                    Subjects
                                                </x-dropdown-link>

                                                <form method="POST" action="{{ route('classes.delete', $class->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100"
                                                        onclick="return confirm('Are you sure you want to delete this class?')">

                                                        Delete

                                                    </button>
                                                </form>

                                            </x-slot>

                                        </x-dropdown>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>