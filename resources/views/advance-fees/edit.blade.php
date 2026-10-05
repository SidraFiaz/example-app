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
                    Edit Advance Fee
                </span>
            </div>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

                {{-- UPDATE FORM --}}
                <form method="POST"
                      action="{{ route('advance-fees.update', $advanceFee->id) }}">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        {{-- Student --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                student <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="student_id"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600">

                                @foreach($students as $student)

                                    <option
                                        value="{{ $student->id }}"
                                        {{ $advanceFee->student_id == $student->id ? 'selected' : '' }}>

                                        {{ $student->name }}

                                        @if($student->roll_no ?? false)
                                            ({{ $student->roll_no }})
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                            @error('student_id')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Advance Month List --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Advance Month List <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="advance_month"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600">

                                @php
                                    $startYear = 2025;
                                    $endYear = 2026;
                                @endphp

                                @for($year = $startYear; $year <= $endYear; $year++)

                                    @for($month = 1; $month <= 12; $month++)

                                        @php
                                            $monthValue = sprintf('%04d-%02d-01', $year, $month);
                                            $monthText = \Carbon\Carbon::create($year, $month, 1)->format('M-Y');
                                        @endphp

                                        <option
                                            value="{{ $monthValue }}"
                                            {{ \Carbon\Carbon::parse($advanceFee->advance_month)->format('Y-m') == \Carbon\Carbon::parse($monthValue)->format('Y-m') ? 'selected' : '' }}>

                                            {{ $monthText }}

                                        </option>

                                    @endfor

                                @endfor

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
                                value="{{ old('payment_date', \Carbon\Carbon::parse($advanceFee->payment_date)->format('Y-m-d')) }}"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600">

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
                                value="{{ old('amount', $advanceFee->amount) }}"
                                min="0"
                                step="0.01"
                                class="w-full h-11 rounded-md border border-gray-300
                                       focus:border-blue-500 focus:ring-blue-500
                                       text-sm text-gray-600">

                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-center gap-7 mt-8">

                        <a href="{{ route('advance-fees.index') }}"
                           class="px-11 py-2.5 rounded-md
                                  bg-slate-200 text-slate-700
                                  text-sm font-medium hover:bg-slate-300">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-11 py-2.5 rounded-md
                                   bg-blue-600 text-white
                                   text-sm font-medium hover:bg-blue-700">
                            Save
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>