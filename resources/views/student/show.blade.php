<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student View
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                @if(session('success'))
                    <div class="m-5 p-4 bg-green-100 border border-green-300 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- =====================================================
                    TOP STUDENT SUMMARY
                ====================================================== --}}

                <div class="p-6 border-b">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                        {{-- COLUMN 1 --}}
                        <div>

                            <div class="text-sm text-gray-600">
                                Student Name
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $student->name ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Class
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ optional($student->studentClass)->class_name ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Code
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $student->id }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                B-form Number
                            </div>

                            <div class="font-semibold text-gray-900">
                                -
                            </div>

                        </div>


                        {{-- COLUMN 2 --}}
                        <div>

                            <div class="text-sm text-gray-600">
                                Permanent Address
                            </div>

                            <div class="font-semibold text-gray-900">
                                -
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student City
                            </div>

                            <div class="font-semibold text-gray-900">
                                -
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Country
                            </div>

                            <div class="font-semibold text-gray-900">
                                -
                            </div>

                        </div>


                        {{-- COLUMN 3 --}}
                        <div>

                            <div class="text-sm text-gray-600">
                                Student Status
                            </div>

                            <div class="font-semibold text-gray-900">
                                <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700">
                                    Active
                                </span>
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Blood Group
                            </div>

                            <div class="font-semibold text-gray-900">
                                -
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Gender
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $student->gender ?? '-' }}
                            </div>

                        </div>


                        {{-- COLUMN 4 --}}
                        <div>

                            <div class="text-sm text-gray-600">
                                Father Contact
                            </div>

                            <div class="font-semibold text-gray-900">
                                -
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Father Name
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $student->father_name ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Father CNIC
                            </div>

                            <div class="font-semibold text-gray-900">
                                -
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}

                <div class="p-6">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                        {{-- =================================================
                            BASIC INFO
                        ================================================== --}}

                        <div class="lg:col-span-2">

                            <div class="flex items-center justify-between border-b pb-3 mb-6">

                                <h3 class="text-xl font-semibold text-gray-800">
                                    Basic Info
                                </h3>

                                <a
                                    href="{{ route('student.edit', $student->id) }}"
                                    class="px-5 py-2 bg-[#111827] hover:bg-gray-800 text-white rounded-md text-sm"
                                >
                                    Edit
                                </a>

                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                                <div>
                                    <label class="text-sm text-gray-700">Student Name</label>
                                    <input
                                        type="text"
                                        value="{{ $student->name ?? '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">B-form No.</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Date Of Birth</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Family No.</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Father Name</label>
                                    <input
                                        type="text"
                                        value="{{ $student->father_name ?? '-' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Father CNIC</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Father Email</label>
                                    <input
                                        type="text"
                                        value="{{ $student->email ?? '-' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Mother Name</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Mother CNIC</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Mother Email</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Permanent Address</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Admission Date</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Father Mobile</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Mother Mobile</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Identification Mark</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Blood Group</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Gender</label>
                                    <input
                                        type="text"
                                        value="{{ $student->gender ?? '-' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Age</label>
                                    <input
                                        type="text"
                                        value="{{ $student->age ?? '-' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Student Country</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Student City</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Student Status</label>
                                    <input
                                        type="text"
                                        value="Active"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label class="text-sm text-gray-700">Status Date</label>
                                    <input
                                        type="text"
                                        value="-"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                        readonly
                                    >
                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            CLASS & SECTION + FEES
                        ================================================== --}}

                        <div>

                            <div class="flex items-center justify-between border-b pb-3 mb-6">

                                <h3 class="text-xl font-semibold text-gray-800">
                                    Class & Section Info
                                </h3>

                            </div>

                            <div class="mb-5">
                                <label class="text-sm text-gray-700">
                                    Class <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                    disabled
                                >
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option
                                            value="{{ $class->id }}"
                                            {{ (int) $student->class_id === (int) $class->id ? 'selected' : '' }}
                                        >
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6">
                                <label class="text-sm text-gray-700">
                                    Section <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                    disabled
                                >
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        @if((int) $section->class_id === (int) $student->class_id)
                                            <option
                                                value="{{ $section->id }}"
                                                {{ (int) $student->section_id === (int) $section->id ? 'selected' : '' }}
                                            >
                                                {{ $section->section_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            {{-- =================================================
                                STUDENT FEES
                            ================================================== --}}

                            @php
                                $feeAmount = $classFee->amount ?? 0;
                                $feeDiscount = 0;
                                $feeActual = $feeAmount - $feeDiscount;
                            @endphp

                            <div class="border rounded-md overflow-hidden">

                                {{-- TITLE --}}
                                <div class="bg-gray-200 px-4 py-3">

                                    <h4 class="font-semibold text-gray-800">
                                        Student Fees
                                    </h4>

                                </div>


                                <div class="p-4">

                                    {{-- HEADER --}}
                                    <div class="grid grid-cols-5 gap-2 text-sm font-semibold text-gray-700 mb-3">

                                        <div>
                                            Name
                                        </div>

                                        <div>
                                            Amount
                                        </div>

                                        <div>
                                            Discount
                                        </div>

                                        <div>
                                            Actual
                                        </div>

                                        <div class="text-center">
                                            Action
                                        </div>

                                    </div>


                                    {{-- FEE ROW --}}
                                    <div class="border-t pt-3">

                                        <div class="grid grid-cols-5 gap-2 text-sm items-center">

                                            {{-- NAME --}}
                                            <div>
                                                Monthly Fee
                                            </div>


                                            {{-- AMOUNT --}}
                                            <div>

                                                <input
                                                    type="number"
                                                    id="monthlyFeeAmount"
                                                    value="{{ $feeAmount }}"
                                                    min="0"
                                                    class="w-full rounded-md border-gray-300 text-sm"
                                                >

                                            </div>


                                            {{-- DISCOUNT --}}
                                            <div>

                                                <input
                                                    type="number"
                                                    id="monthlyFeeDiscount"
                                                    value="{{ $feeDiscount }}"
                                                    min="0"
                                                    class="w-full rounded-md border-gray-300 text-sm bg-gray-100"
                                                    readonly
                                                >

                                            </div>


                                            {{-- ACTUAL --}}
                                            <div>

                                                <input
                                                    type="number"
                                                    id="monthlyFeeActual"
                                                    value="{{ $feeActual }}"
                                                    class="w-full rounded-md border-gray-300 text-sm bg-gray-100"
                                                    readonly
                                                >

                                            </div>


                                            {{-- ACTION --}}
                                            <div>

                                                <div class="flex items-center justify-center gap-2">

                                                    {{-- PLUS BUTTON --}}
                                                    <button
                                                        type="button"
                                                        onclick="openDiscountModal()"
                                                        title="Add/Edit Discount"
                                                        class="w-10 h-10 flex items-center justify-center rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xl font-bold"
                                                    >
                                                        +
                                                    </button>


                                                    {{-- EYE BUTTON --}}
                                                    <button
                                                        type="button"
                                                        onclick="openDiscountView()"
                                                        title="View Discount"
                                                        class="w-10 h-10 flex items-center justify-center rounded-md bg-gray-600 hover:bg-gray-700 text-white"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                            />
                                                        </svg>
                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- TOTAL --}}
                                    <div class="mt-4 bg-green-300 p-3">

                                        <div class="grid grid-cols-5 gap-2 font-bold">

                                            <div>
                                                Total
                                            </div>

                                            <div id="totalAmount">
                                                {{ $feeAmount }}
                                            </div>

                                            <div id="totalDiscount">
                                                {{ $feeDiscount }}
                                            </div>

                                            <div id="totalActual">
                                                {{ $feeActual }}
                                            </div>

                                            <div></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- BACK / EDIT --}}
                <div class="border-t bg-gray-50 p-5 flex flex-wrap gap-3">

                    <a
                        href="{{ route('student.index') }}"
                        class="inline-flex items-center px-5 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100"
                    >
                        BACK TO STUDENTS
                    </a>

                    <a
                        href="{{ route('student.edit', $student->id) }}"
                        class="inline-flex items-center px-5 py-2 bg-[#111827] hover:bg-gray-800 text-white rounded-md text-sm font-medium"
                    >
                        EDIT
                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================================
        ADD / EDIT DISCOUNT MODAL
    ================================================================= --}}

    <div
        id="discountModal"
        class="fixed inset-0 z-50 hidden"
        aria-hidden="true"
    >

        {{-- OVERLAY --}}
        <div
            class="absolute inset-0 bg-black bg-opacity-50"
            onclick="closeDiscountModal()"
        ></div>


        {{-- MODAL BOX --}}
        <div class="relative flex min-h-screen items-center justify-center p-4">

            <div class="bg-white w-full max-w-lg rounded-md shadow-xl overflow-hidden">

                {{-- HEADER --}}
                <div class="flex items-center justify-between px-4 py-3 border-b">

                    <h3 class="text-xl font-semibold text-gray-800">
                        Add/Edit Student Fee Discounts
                    </h3>

                    <button
                        type="button"
                        onclick="closeDiscountModal()"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold"
                    >
                        &times;
                    </button>

                </div>


                {{-- BODY --}}
                <div class="p-5">


                    {{-- DISCOUNTS --}}
                    <div class="mb-6">

                        <label
                            for="discountName"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Discounts
                        </label>

                        <select
                            id="discountName"
                            class="w-full rounded-md border-gray-300"
                        >

                            <option value="Fee Discount">
                                Fee Discount
                            </option>

                        </select>

                    </div>


                    {{-- DISCOUNT TYPE --}}
                    <div class="mb-6">

                        <label
                            for="discountType"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Discount Type
                        </label>

                        <select
                            id="discountType"
                            class="w-full rounded-md border-gray-300"
                            onchange="calculateDiscount()"
                        >

                            <option value="Amount">
                                Amount
                            </option>

                            <option value="Percentage">
                                Percentage
                            </option>

                        </select>

                    </div>


                    {{-- DISCOUNT AMOUNT --}}
                    <div class="mb-2">

                        <label
                            for="discountAmount"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Discount Amount
                        </label>

                        <input
                            type="number"
                            id="discountAmount"
                            value="0"
                            min="0"
                            class="w-full rounded-md border-gray-300"
                            oninput="calculateDiscount()"
                        >

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="flex items-center justify-end gap-2 px-4 py-3 border-t bg-gray-50">

                    <button
                        type="button"
                        onclick="closeDiscountModal()"
                        class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm"
                    >
                        Close
                    </button>

                    <button
                        type="button"
                        onclick="saveDiscount()"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm"
                    >
                        Add/Edit Discount
                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================================
        VIEW DISCOUNT MODAL
    ================================================================= --}}

    <div
        id="discountViewModal"
        class="fixed inset-0 z-50 hidden"
    >

        {{-- OVERLAY --}}
        <div
            class="absolute inset-0 bg-black bg-opacity-50"
            onclick="closeDiscountView()"
        ></div>


        <div class="relative flex min-h-screen items-center justify-center p-4">

            <div class="bg-white w-full max-w-md rounded-md shadow-xl overflow-hidden">

                {{-- HEADER --}}
                <div class="flex items-center justify-between px-5 py-4 border-b">

                    <h3 class="text-xl font-semibold text-gray-800">
                        Student Fee Discount
                    </h3>

                    <button
                        type="button"
                        onclick="closeDiscountView()"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold"
                    >
                        &times;
                    </button>

                </div>


                {{-- BODY --}}
                <div class="p-5">

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <div class="text-sm text-gray-500">
                                Fee
                            </div>

                            <div
                                id="viewDiscountName"
                                class="font-semibold text-gray-800"
                            >
                                Fee Discount
                            </div>
                        </div>


                        <div>
                            <div class="text-sm text-gray-500">
                                Discount Type
                            </div>

                            <div
                                id="viewDiscountType"
                                class="font-semibold text-gray-800"
                            >
                                Amount
                            </div>
                        </div>


                        <div>
                            <div class="text-sm text-gray-500">
                                Discount
                            </div>

                            <div
                                id="viewDiscountAmount"
                                class="font-semibold text-gray-800"
                            >
                                0
                            </div>
                        </div>


                        <div>
                            <div class="text-sm text-gray-500">
                                Actual Fee
                            </div>

                            <div
                                id="viewActualAmount"
                                class="font-semibold text-green-700"
                            >
                                {{ $feeActual }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="flex justify-end px-5 py-4 border-t bg-gray-50">

                    <button
                        type="button"
                        onclick="closeDiscountView()"
                        class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm"
                    >
                        Close
                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================================
        JAVASCRIPT
    ================================================================= --}}

    <script>

        let currentDiscount = 0;
        let currentDiscountType = 'Amount';


        /*
        |--------------------------------------------------------------------------
        | OPEN ADD / EDIT MODAL
        |--------------------------------------------------------------------------
        */

        function openDiscountModal()
        {
            document
                .getElementById('discountModal')
                .classList
                .remove('hidden');

            document
                .getElementById('discountAmount')
                .value = currentDiscount;

            document
                .getElementById('discountType')
                .value = currentDiscountType;

            calculateDiscount();
        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE ADD / EDIT MODAL
        |--------------------------------------------------------------------------
        */

        function closeDiscountModal()
        {
            document
                .getElementById('discountModal')
                .classList
                .add('hidden');
        }


        /*
        |--------------------------------------------------------------------------
        | CALCULATE DISCOUNT
        |--------------------------------------------------------------------------
        */

        function calculateDiscount()
        {
            let fee = parseFloat(
                document.getElementById('monthlyFeeAmount').value
            ) || 0;

            let discount = parseFloat(
                document.getElementById('discountAmount').value
            ) || 0;

            let type = document.getElementById('discountType').value;

            if (type === 'Percentage') {

                discount = (fee * discount) / 100;

            }

            if (discount > fee) {
                discount = fee;
            }

            let actual = fee - discount;

            document.getElementById('monthlyFeeDiscount').value =
                discount.toFixed(0);

            document.getElementById('monthlyFeeActual').value =
                actual.toFixed(0);

            document.getElementById('totalAmount').innerText =
                fee.toFixed(0);

            document.getElementById('totalDiscount').innerText =
                discount.toFixed(0);

            document.getElementById('totalActual').innerText =
                actual.toFixed(0);
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE DISCOUNT
        |--------------------------------------------------------------------------
        */

        function saveDiscount()
        {
            currentDiscount =
                parseFloat(
                    document.getElementById('discountAmount').value
                ) || 0;

            currentDiscountType =
                document.getElementById('discountType').value;

            calculateDiscount();

            closeDiscountModal();
        }


        /*
        |--------------------------------------------------------------------------
        | OPEN VIEW DISCOUNT
        |--------------------------------------------------------------------------
        */

        function openDiscountView()
        {
            let discount =
                parseFloat(
                    document.getElementById('monthlyFeeDiscount').value
                ) || 0;

            let actual =
                parseFloat(
                    document.getElementById('monthlyFeeActual').value
                ) || 0;

            document.getElementById('viewDiscountName').innerText =
                document.getElementById('discountName').value;

            document.getElementById('viewDiscountType').innerText =
                currentDiscountType;

            document.getElementById('viewDiscountAmount').innerText =
                discount;

            document.getElementById('viewActualAmount').innerText =
                actual;

            document
                .getElementById('discountViewModal')
                .classList
                .remove('hidden');
        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE VIEW DISCOUNT
        |--------------------------------------------------------------------------
        */

        function closeDiscountView()
        {
            document
                .getElementById('discountViewModal')
                .classList
                .add('hidden');
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE ACTUAL WHEN FEE AMOUNT CHANGES
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('monthlyFeeAmount')
            .addEventListener('input', function () {

                calculateDiscount();

            });


        /*
        |--------------------------------------------------------------------------
        | INITIAL CALCULATION
        |--------------------------------------------------------------------------
        */

        document.addEventListener('DOMContentLoaded', function () {

            calculateDiscount();

        });

    </script>

</x-app-layout>
