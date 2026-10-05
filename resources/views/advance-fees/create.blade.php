<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-normal text-gray-800">
                Advance Fee
            </h2>

            <div class="flex items-center gap-2 text-sm mt-1">
                <a href="{{ route('advance-fees.index') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Home
                </a>

                <span class="text-gray-400">/</span>

                <span class="text-gray-500">
                    Create Advance Fee
                </span>
            </div>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

                <form
                    method="POST"
                    action="{{ route('advance-fees.store') }}"
                >

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        {{-- Student --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                student <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="student_id"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600"
                            >

                                <option value="">
                                    Select Student
                                </option>

                                @foreach($students as $student)

                                    <option
                                        value="{{ $student->id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}
                                    >
                                        {{ $student->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('student_id')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Advance Month --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Advance Month List <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="advance_month"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600"
                            >

                                <option value="">
                                    Select Month
                                </option>

                                <option value="2025-06-01"
                                    {{ old('advance_month') == '2025-06-01' ? 'selected' : '' }}>
                                    Jun-2025
                                </option>

                                <option value="2025-07-01"
                                    {{ old('advance_month') == '2025-07-01' ? 'selected' : '' }}>
                                    Jul-2025
                                </option>

                                <option value="2025-08-01"
                                    {{ old('advance_month') == '2025-08-01' ? 'selected' : '' }}>
                                    Aug-2025
                                </option>

                                <option value="2025-09-01"
                                    {{ old('advance_month') == '2025-09-01' ? 'selected' : '' }}>
                                    Sep-2025
                                </option>

                                <option value="2025-10-01"
                                    {{ old('advance_month') == '2025-10-01' ? 'selected' : '' }}>
                                    Oct-2025
                                </option>

                                <option value="2025-11-01"
                                    {{ old('advance_month') == '2025-11-01' ? 'selected' : '' }}>
                                    Nov-2025
                                </option>

                                <option value="2025-12-01"
                                    {{ old('advance_month') == '2025-12-01' ? 'selected' : '' }}>
                                    Dec-2025
                                </option>

                                <option value="2026-01-01"
                                    {{ old('advance_month') == '2026-01-01' ? 'selected' : '' }}>
                                    Jan-2026
                                </option>

                                <option value="2026-02-01"
                                    {{ old('advance_month') == '2026-02-01' ? 'selected' : '' }}>
                                    Feb-2026
                                </option>

                                <option value="2026-03-01"
                                    {{ old('advance_month') == '2026-03-01' ? 'selected' : '' }}>
                                    Mar-2026
                                </option>

                                <option value="2026-04-01"
                                    {{ old('advance_month') == '2026-04-01' ? 'selected' : '' }}>
                                    Apr-2026
                                </option>

                                <option value="2026-05-01"
                                    {{ old('advance_month') == '2026-05-01' ? 'selected' : '' }}>
                                    May-2026
                                </option>

                                <option value="2026-06-01"
                                    {{ old('advance_month') == '2026-06-01' ? 'selected' : '' }}>
                                    Jun-2026
                                </option>

                                <option value="2026-07-01"
                                    {{ old('advance_month') == '2026-07-01' ? 'selected' : '' }}>
                                    Jul-2026
                                </option>

                                <option value="2026-08-01"
                                    {{ old('advance_month') == '2026-08-01' ? 'selected' : '' }}>
                                    Aug-2026
                                </option>

                                <option value="2026-09-01"
                                    {{ old('advance_month') == '2026-09-01' ? 'selected' : '' }}>
                                    Sep-2026
                                </option>

                                <option value="2026-10-01"
                                    {{ old('advance_month') == '2026-10-01' ? 'selected' : '' }}>
                                    Oct-2026
                                </option>

                                <option value="2026-11-01"
                                    {{ old('advance_month') == '2026-11-01' ? 'selected' : '' }}>
                                    Nov-2026
                                </option>

                                <option value="2026-12-01"
                                    {{ old('advance_month') == '2026-12-01' ? 'selected' : '' }}>
                                    Dec-2026
                                </option>

                            </select>

                            @error('advance_month')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Date --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Date
                            </label>

                            <input
                                type="date"
                                name="payment_date"
                                value="{{ old('payment_date', date('Y-m-d')) }}"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600"
                            >

                            @error('payment_date')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Advance Amount --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Advance Amount <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                name="amount"
                                value="{{ old('amount') }}"
                                min="0"
                                step="0.01"
                                required
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600"
                            >

                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 mt-8">

                        <a
                            href="{{ route('advance-fees.index') }}"
                            class="px-6 py-2.5 rounded-md border border-gray-300
                                   bg-white text-gray-700 text-sm font-medium
                                   hover:bg-gray-50"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-md bg-blue-600
                                   text-white text-sm font-medium
                                   hover:bg-blue-700"
                        >
                            Save
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>