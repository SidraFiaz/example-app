<x-app-layout>

    {{-- ============================================================
         HEADER
    ============================================================= --}}

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Receive Fee
                </h2>

                <div class="text-sm text-gray-500 mt-1">

                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:underline">
                        Home
                    </a>

                    <span class="mx-1">/</span>

                    <span>Receive Fee</span>

                </div>

            </div>


            {{-- PAYMENT RECEIPT --}}

            <a href="#"
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2.5 rounded-md">
                Payment Receipt
            </a>

        </div>

    </x-slot>


    {{-- ============================================================
         MAIN CONTENT
    ============================================================= --}}

    <div class="py-4">

        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-8">

                    <form
                        method="POST"
                        action="{{ route('fee-collections.receive.update', $fee_collection->id) }}"
                    >

                        @csrf
                        @method('PUT')


                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-5">


                            {{-- ==================================================
                                 STUDENT NAME
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Student Name
                                </label>

                                <input
                                    type="text"
                                    value="{{ $student->name ?? '' }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 STUDENT CLASS
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Student Class
                                </label>

                                <input
                                    type="text"
                                    value="{{ optional($student->studentClass)->class_name ?? '' }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 FATHER NAME
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Father Name
                                </label>

                                <input
                                    type="text"
                                    value="{{ $student->father_name ?? '' }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 RECEIVE DATE
                            =================================================== --}}

                            <div>

                                <label
                                    for="payment_date"
                                    class="block text-sm text-gray-700 mb-2"
                                >
                                    Receive Date
                                </label>

                                <input
                                    type="date"
                                    name="payment_date"
                                    id="payment_date"
                                    value="{{ old('payment_date', $receiveDate) }}"
                                    required
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                >

                                @error('payment_date')
                                    <p class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- ==================================================
                                 FEE AMOUNT
                            =================================================== --}}

                            <div>

                                <label
                                    for="amount"
                                    class="block text-sm text-gray-700 mb-2"
                                >
                                    Fee Amount<span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    value="{{ old('amount', $feeAmount) }}"
                                    min="0"
                                    step="0.01"
                                    required
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                >

                                @error('amount')
                                    <p class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- ==================================================
                                 DEFAULTER
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Defaulter<span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="number"
                                    value="{{ $defaulter }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 CURRENT MONTH FEE
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Current Month Fee
                                </label>

                                <input
                                    type="number"
                                    value="{{ $currentMonthFee }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 TOTAL RECEIVED
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Total Received
                                </label>

                                <input
                                    type="number"
                                    value="{{ $totalReceived }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 TOTAL ARREARS
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Total Arrears
                                </label>

                                <input
                                    type="number"
                                    value="{{ $totalArrears }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 REMAINING BALANCE
                            =================================================== --}}

                            <div>

                                <label class="block text-sm text-gray-700 mb-2">
                                    Remaining Balance
                                </label>

                                <input
                                    type="number"
                                    value="{{ $remainingBalance }}"
                                    readonly
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm bg-white text-gray-600"
                                >

                            </div>


                            {{-- ==================================================
                                 RELIEF AMOUNT
                            =================================================== --}}

                            <div>

                                <label
                                    for="relief_amount"
                                    class="block text-sm text-gray-700 mb-2"
                                >
                                    Relief Amount
                                </label>

                                <input
                                    type="number"
                                    name="relief_amount"
                                    id="relief_amount"
                                    value="{{ old('relief_amount', $reliefAmount) }}"
                                    min="0"
                                    step="0.01"
                                    class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                >

                                @error('relief_amount')
                                    <p class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- ============================================================
                             BUTTON
                        ============================================================= --}}

                        <div class="flex justify-center mt-5">

                            @if(strtolower($fee_collection->status ?? '') === 'paid')

                                <button
                                    type="button"
                                    disabled
                                    class="bg-blue-400 text-white text-sm px-5 py-2.5 rounded-md cursor-not-allowed"
                                >
                                    Fee Already Received
                                </button>

                            @else

                                <button
                                    type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-5 py-2.5 rounded-md"
                                >
                                    Receive Fee
                                </button>

                            @endif

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>