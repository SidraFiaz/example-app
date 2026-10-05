<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects') }}
            @if(request('class_id'))
                @php
                    $selectedClass = $classes->firstWhere('id', (int) request('class_id'));
                @endphp
                @if($selectedClass)
                    <span class="text-gray-500 font-normal">— {{ $selectedClass->class_name }}</span>
                @endif
            @endif
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search / Class Filter / Add -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-6">

                <form action="{{ route('subjects.index') }}" method="GET" class="flex flex-wrap items-center gap-3">

                    <select
                        name="class_id"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ (string) request('class_id') === (string) $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search Subject..."
                        class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                    <button
                        type="submit"
                        class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg"
                    >
                        Search
                    </button>

                    @if(request()->filled('class_id') || request()->filled('search'))
                        <a href="{{ route('subjects.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Clear
                        </a>
                    @endif
                </form>

                <a href="{{ route('subjects.create', array_filter(['class_id' => request('class_id')])) }}"
                   class="bg-black hover:bg-gray-800 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-200 inline-flex justify-center">
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
                                   {{ $subjects->firstItem() + $loop->index }}
                                </td>

                                <td class="border px-4 py-3 text-center">
                                    {{ $subject->subject_name }}
                                </td>

                                <td class="border px-4 py-3 text-center">
                                    {{ $subject->studentClass->class_name ?? 'N/A' }}
                                </td>

                                <td class="border px-4 py-3 text-center">

                                    <div class="action-btn-group justify-center">

                                        <x-action-edit :href="route('subjects.edit', $subject->id)" />

                                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                            data-delete-confirm="Are you sure you want to delete this subject?">
                                            @csrf
                                            @method('DELETE')
                                            @if(request('class_id'))
                                                <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                                            @endif
                                            <x-action-delete />
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="border py-6 text-center text-gray-500">
                                    @if(request('class_id'))
                                        No subjects found for this class.
                                    @else
                                        No Subjects Found
                                    @endif
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
