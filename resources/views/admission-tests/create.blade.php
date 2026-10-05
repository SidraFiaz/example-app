<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-normal text-gray-800">
                Admission Tests
            </h2>

            <div class="flex items-center gap-2 text-sm mt-1">
                <a href="{{ route('dashboard') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Home
                </a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('admission-tests.index') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Admission Tests
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-500">Add Admission Test</span>
            </div>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

                @if($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('admission-tests.store') }}"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Class <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="class_id"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Session <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="session_id"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                                <option value="">Select Session</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}"
                                        {{ old('session_id') == $session->id ? 'selected' : '' }}>
                                        {{ $session->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('session_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-800 mb-2">
                            File
                        </label>
                        <input
                            type="file"
                            name="file"
                            class="block w-full text-sm text-gray-700
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-md file:border-0
                                   file:bg-[#111827] file:text-white
                                   hover:file:bg-gray-800"
                        >
                        @error('file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center gap-4 mt-12">
                        <a href="{{ route('admission-tests.index') }}"
                           class="bg-[#111827] hover:bg-gray-800 text-white
                                  px-10 py-2.5 rounded-md text-sm font-medium">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="bg-[#111827] hover:bg-gray-800 text-white
                                   px-10 py-2.5 rounded-md text-sm font-medium"
                        >
                            Save
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
