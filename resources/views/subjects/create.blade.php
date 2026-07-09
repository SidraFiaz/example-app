<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Subject') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf

                    <!-- Select Class -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Select Class
                        </label>

                        <select
                            name="class_id"
                            class="w-full border rounded px-3 py-2">

                            <option value="">-- Select Class --</option>

                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->class_name }}
                                </option>
                            @endforeach

                        </select>

                        @error('class_id')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Name -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Subject Name
                        </label>

                        <input
                            type="text"
                            name="subject_name"
                            value="{{ old('subject_name') }}"
                            class="w-full border rounded px-3 py-2">

                        @error('subject_name')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
    type="submit"
    class="bg-black hover:bg-gray-800 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-200">
    Save
</button>
                    <a href="{{ route('subjects.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded ml-2">
                        Cancel
                    </a>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>