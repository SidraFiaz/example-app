<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800">
                Create Exam
            </h2>

            <a href="{{ $session
                ? route('exams.index', ['session_id' => $session->id])
                : route('exams.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200
                      rounded-md font-semibold text-xs text-gray-700
                      uppercase tracking-widest hover:bg-gray-300 transition">

                Back

            </a>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">


                    {{-- Validation Errors --}}

                    @if ($errors->any())

                        <div class="mb-6 p-4 bg-red-100 border border-red-200
                                    text-red-700 rounded-md">

                            <ul class="list-disc list-inside">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <form action="{{ route('exams.store') }}" method="POST">

                        @csrf


                        {{-- Selected Session --}}

                        <div class="mb-6">

                            <label for="session_id"
                                   class="block text-sm font-medium text-gray-700">

                                Session

                                <span class="text-red-600">*</span>

                            </label>


                            <select
                                name="session_id"
                                id="session_id"
                                class="mt-1 block w-full border-gray-300
                                       rounded-md shadow-sm
                                       focus:border-black focus:ring-black"
                                required
                            >

                                <option value="">
                                    Select Session
                                </option>


                                @foreach ($sessions as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ old('session_id', $session?->id) == $item->id ? 'selected' : '' }}
                                    >

                                        {{ $item->name }}

                                    </option>

                                @endforeach

                            </select>


                            @error('session_id')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Exam Details --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                            {{-- Exam Description --}}

                            <div>

                                <label for="exam_name"
                                       class="block text-sm font-medium text-gray-700">

                                    Exam Description

                                    <span class="text-red-600">*</span>

                                </label>


                                <input
                                    type="text"
                                    name="exam_name"
                                    id="exam_name"
                                    value="{{ old('exam_name') }}"
                                    placeholder="e.g. First Term"
                                    class="mt-1 block w-full border-gray-300
                                           rounded-md shadow-sm
                                           focus:border-black focus:ring-black"
                                    required
                                >


                                @error('exam_name')

                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Total Marks --}}

                            <div>

                                <label for="total_marks"
                                       class="block text-sm font-medium text-gray-700">

                                    Total Marks

                                    <span class="text-red-600">*</span>

                                </label>


                                <input
                                    type="number"
                                    name="total_marks"
                                    id="total_marks"
                                    value="{{ old('total_marks') }}"
                                    placeholder="e.g. 440"
                                    min="1"
                                    class="mt-1 block w-full border-gray-300
                                           rounded-md shadow-sm
                                           focus:border-black focus:ring-black"
                                    required
                                >


                                @error('total_marks')

                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Start Date --}}

                            <div>

                                <label for="start_date"
                                       class="block text-sm font-medium text-gray-700">

                                    Start Date

                                    <span class="text-red-600">*</span>

                                </label>


                                <input
                                    type="date"
                                    name="start_date"
                                    id="start_date"
                                    value="{{ old('start_date') }}"
                                    class="mt-1 block w-full border-gray-300
                                           rounded-md shadow-sm
                                           focus:border-black focus:ring-black"
                                    required
                                >


                                @error('start_date')

                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- End Date --}}

                            <div>

                                <label for="end_date"
                                       class="block text-sm font-medium text-gray-700">

                                    End Date

                                    <span class="text-red-600">*</span>

                                </label>


                                <input
                                    type="date"
                                    name="end_date"
                                    id="end_date"
                                    value="{{ old('end_date') }}"
                                    class="mt-1 block w-full border-gray-300
                                           rounded-md shadow-sm
                                           focus:border-black focus:ring-black"
                                    required
                                >


                                @error('end_date')

                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Remarks --}}

                            <div class="md:col-span-2">

                                <label for="remarks"
                                       class="block text-sm font-medium text-gray-700">

                                    Remarks

                                </label>


                                <textarea
                                    name="remarks"
                                    id="remarks"
                                    rows="4"
                                    placeholder="Enter remarks (optional)"
                                    class="mt-1 block w-full border-gray-300
                                           rounded-md shadow-sm
                                           focus:border-black focus:ring-black"
                                >{{ old('remarks') }}</textarea>


                                @error('remarks')

                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>


                        {{-- Buttons --}}

                        <div class="mt-10 flex justify-center gap-6">


                            {{-- Cancel --}}

                            <a href="{{ $session
                                ? route('exams.index', ['session_id' => $session->id])
                                : route('exams.index') }}"
                               class="inline-flex items-center justify-center
                                      w-48 h-12 bg-black border border-black
                                      rounded-md font-medium text-base text-white
                                      hover:bg-gray-800 transition">

                                Cancel

                            </a>


                            {{-- Save --}}

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center
                                       w-48 h-12 bg-black border border-black
                                       rounded-md font-medium text-base text-white
                                       hover:bg-gray-800 transition">

                                Save

                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>