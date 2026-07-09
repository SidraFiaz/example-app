<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Add Button -->
            <div class="flex justify-between items-center mb-6">

                <form action="{{ route('subjects.index') }}" method="GET" class="flex items-center gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search Subject..."
                        class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">

                   <button
    type="submit"
    class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg">
    Search
</button>

                </form>

                <a href="{{ route('subjects.create') }}"
   class="bg-black hover:bg-gray-800 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-200">
    + Add Subject
</a>
            </div>

            <!-- Table -->
            <div class="bg-white shadow-xl rounded-xl p-6 overflow-hidden">

                <table class="min-w-full border border-gray-200 rounded-lg">

                    <thead>
                        <tr class="bg-black text-white">
                            <th class="border px-4 py-3 text-center">ID</th>
<th class="border px-4 py-3 text-center">Subject Name</th>
<th class="border px-4 py-3 text-center">Class</th>
<th class="border px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($subjects as $subject)

                            <tr class="hover:bg-gray-100 transition duration-200">

                                <td class="border px-4 py-3 text-center">
                                   {{ $loop->iteration }}
                                </td>

                                <td class="border px-4 py-3 text-center">
    {{ $subject->subject_name }}
</td>

<td class="border px-4 py-3 text-center">
    {{ $subject->studentClass->class_name ?? 'N/A' }}
</td>

                                <td class="border px-4 py-3 text-center">

                                    <div class="flex justify-center items-center gap-3">

                                        <a href="{{ route('subjects.edit', $subject->id ) }}"
   class="bg-black hover:bg-gray-800 text-white font-medium px-4 py-2 rounded-lg transition duration-200">
    Edit
</a>

                                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Delete this subject?')"
                                                class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="border py-6 text-center text-gray-500">
                                    No Subjects Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $subjects->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>