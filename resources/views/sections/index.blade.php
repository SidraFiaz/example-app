<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sections') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg p-6">

                <div class="flex justify-end mb-6">
                    <a href="{{ route('sections.create', $class_id) }}">
                        <x-primary-button>
                            Add New Section
                        </x-primary-button>
                    </a>
                </div>

                <h2 class="text-xl font-bold mb-4">
                    Sections List
                </h2>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">ID</th>
                            <th class="border p-2">Section Name</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sections as $section)
                            <tr>
                                <td class="border p-2">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $section->section_name }}</td>

                                <td class="border p-2">
    <form action="{{ route('sections.delete', [$class_id, $section->id]) }}"
      method="POST"
      onsubmit="return confirm('Are you sure you want to delete this section?')">

    @csrf
    @method('DELETE')

    <x-danger-button>
        Delete
    </x-danger-button>
</form>
    </form>
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</x-app-layout>