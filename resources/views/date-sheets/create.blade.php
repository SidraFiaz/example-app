<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-normal text-gray-800">
                Create Date Sheet
            </h2>

            <div class="flex items-center gap-2 text-sm mt-1">
                <a href="{{ route('dashboard') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Home
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-500">Create</span>
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

                <form method="POST" action="{{ route('date-sheets.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Date Sheet (Session) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Date Sheet <span class="text-red-500">*</span>
                            </label>

                            @if($activeSession)
                                <input
                                    type="text"
                                    value="{{ $activeSession->name }}"
                                    disabled
                                    class="w-full h-11 rounded-md border border-gray-300
                                           bg-gray-100 text-sm text-gray-700"
                                >
                                <input type="hidden" name="session_id" value="{{ old('session_id', $activeSession->id) }}">
                            @else
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
                            @endif

                            @error('session_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Select Exam --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Select Exam <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="exam_id"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-black focus:ring-black text-sm text-gray-700"
                            >
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}"
                                        {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->exam_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exam_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Select Class --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Select Class <span class="text-red-500">*</span>
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

                    </div>

                    <div class="flex justify-center gap-4 mt-12">
                        <a href="{{ route('date-sheets.index') }}"
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
