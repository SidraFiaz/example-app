<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student View
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                    <div class="m-5 p-4 bg-green-100 border border-green-300 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- VALIDATION ERRORS --}}
                @if($errors->any())
                    <div class="m-5 p-4 bg-red-100 border border-red-300 text-red-700 rounded-md">
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                                {{ $admission->student_name }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Class
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ optional($admission->studentClass)->class_name ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Code
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->student_code ?? $admission->id }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                B-form Number
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->b_form_no ?? '-' }}
                            </div>

                        </div>


                        {{-- COLUMN 2 --}}
                        <div>

                            <div class="text-sm text-gray-600">
                                Permanent Address
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->permanent_address ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student City
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->student_city ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Country
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->student_country ?? '-' }}
                            </div>

                        </div>


                        {{-- COLUMN 3 --}}
                        <div>

                            <div class="text-sm text-gray-600">
                                Student Status
                            </div>

                            <div class="font-semibold text-gray-900">

                                <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700">
                                    {{ $admission->status ?? 'Active' }}
                                </span>

                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Blood Group
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->blood_group ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Student Gender
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->gender ?? '-' }}
                            </div>

                        </div>


                        {{-- COLUMN 4 --}}
                        <div>

                            <div class="text-sm text-gray-600">
                                Father Contact
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->father_contact ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Father Name
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->father_name ?? '-' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-3">
                                Father CNIC
                            </div>

                            <div class="font-semibold text-gray-900">
                                {{ $admission->father_cnic ?? '-' }}
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

                            <form
                                method="POST"
                                action="{{ route('admission.updateBasicInfo', $admission) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <div class="flex items-center justify-between border-b pb-3 mb-6">

                                    <h3 class="text-xl font-semibold text-gray-800">
                                        Basic Info
                                    </h3>

                                    <button
                                        type="submit"
                                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm"
                                    >
                                        Save
                                    </button>

                                </div>


                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                                    {{-- 1 Student Name --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Student Name
                                        </label>

                                        <input
                                            type="text"
                                            name="student_name"
                                            value="{{ old('student_name', $admission->student_name) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                            required
                                        >
                                    </div>


                                    {{-- 2 B-form --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            B-form No.
                                        </label>

                                        <input
                                            type="text"
                                            name="b_form_no"
                                            value="{{ old('b_form_no', $admission->b_form_no) }}"
                                            placeholder="Enter B-form No"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 3 DOB --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Date Of Birth
                                        </label>

                                        <input
                                            type="date"
                                            name="date_of_birth"
                                            value="{{ old('date_of_birth', $admission->date_of_birth ? \Carbon\Carbon::parse($admission->date_of_birth)->format('Y-m-d') : '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 4 Family --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Family No.
                                        </label>

                                        <input
                                            type="text"
                                            name="family_no"
                                            value="{{ old('family_no', $admission->family_no) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 5 Father Name --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Father Name
                                        </label>

                                        <input
                                            type="text"
                                            name="father_name"
                                            value="{{ old('father_name', $admission->father_name) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                            required
                                        >
                                    </div>


                                    {{-- 6 Father CNIC --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Father CNIC
                                        </label>

                                        <input
                                            type="text"
                                            name="father_cnic"
                                            value="{{ old('father_cnic', $admission->father_cnic) }}"
                                            placeholder="33333-3333333-3"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 7 Father Email --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Father Email
                                        </label>

                                        <input
                                            type="email"
                                            name="father_email"
                                            value="{{ old('father_email', $admission->father_email) }}"
                                            placeholder="Enter Father Email"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 8 Mother Name --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Mother Name
                                        </label>

                                        <input
                                            type="text"
                                            name="mother_name"
                                            value="{{ old('mother_name', $admission->mother_name) }}"
                                            placeholder="Enter Mother Name"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 9 Mother CNIC --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Mother CNIC
                                        </label>

                                        <input
                                            type="text"
                                            name="mother_cnic"
                                            value="{{ old('mother_cnic', $admission->mother_cnic) }}"
                                            placeholder="Enter Mother CNIC"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 10 Mother Email --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Mother Email
                                        </label>

                                        <input
                                            type="email"
                                            name="mother_email"
                                            value="{{ old('mother_email', $admission->mother_email) }}"
                                            placeholder="Enter Mother Email"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 11 Permanent Address --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Permanent Address
                                        </label>

                                        <input
                                            type="text"
                                            name="permanent_address"
                                            value="{{ old('permanent_address', $admission->permanent_address) }}"
                                            placeholder="Enter Permanent Address"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 12 Admission Date --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Admission Date
                                        </label>

                                        <input
                                            type="date"
                                            name="admission_date"
                                            value="{{ old('admission_date', $admission->admission_date ? \Carbon\Carbon::parse($admission->admission_date)->format('Y-m-d') : '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                            required
                                        >
                                    </div>


                                    {{-- 13 Father Mobile --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Father Mobile
                                        </label>

                                        <input
                                            type="text"
                                            name="father_contact"
                                            value="{{ old('father_contact', $admission->father_contact) }}"
                                            placeholder="Enter Father Mobile"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 14 Mother Mobile --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Mother Mobile
                                        </label>

                                        <input
                                            type="text"
                                            name="mother_mobile"
                                            value="{{ old('mother_mobile', $admission->mother_mobile) }}"
                                            placeholder="Enter Mother Mobile"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 15 Identification Mark --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Identification Mark
                                        </label>

                                        <input
                                            type="text"
                                            name="identification_mark"
                                            value="{{ old('identification_mark', $admission->identification_mark) }}"
                                            placeholder="Enter Identification Mark"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>


                                    {{-- 16 Blood Group --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Blood Group
                                        </label>

                                        <select
                                            name="blood_group"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >

                                            <option value="">
                                                Select Blood Group
                                            </option>

                                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $blood)

                                                <option
                                                    value="{{ $blood }}"
                                                   {{ old('blood_group', $admission->blood_group) == $blood ? 'selected' : '' }}
                                                >
                                                    {{ $blood }}
                                                </option>

                                            @endforeach

                                        </select>
                                    </div>


                                    {{-- 17 Gender --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Gender
                                        </label>

                                        <select
                                            name="gender"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >

                                            <option value="">
                                                Select Gender
                                            </option>

                                            <option
                                                value="Male"
                                               {{ old('gender', $admission->gender) == 'Male' ? 'selected' : '' }}
                                            >
                                                Male
                                            </option>

                                            <option
                                                value="Female"
                                               {{ old('gender', $admission->gender) == 'Male' ? 'selected' : '' }}
                                            >
                                                Female
                                            </option>

                                        </select>
                                    </div>


                                    {{-- 18 Student Country --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Student Country
                                        </label>

                                        <select
                                            name="student_country"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >

                                            <option value="">
                                                Select Country
                                            </option>

                                            <option
                                                value="Pakistan"
                                               {{ old('student_country', $admission->student_country) == 'Pakistan' ? 'selected' : '' }}
                                            >
                                                Pakistan
                                            </option>

                                            <option
                                                value="Other"
                                               {{ old('student_country', $admission->student_country) == 'Pakistan' ? 'selected' : '' }}
                                            >
                                                Other
                                            </option>

                                        </select>
                                    </div>


                                    {{-- 19 Student City --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Student City
                                        </label>

                                        <select
                                            name="student_city"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >

                                            <option value="">
                                                Select City
                                            </option>

                                            @foreach([
                                                'Lahore',
                                                'Karachi',
                                                'Islamabad',
                                                'Rawalpindi',
                                                'Multan',
                                                'Faisalabad'
                                            ] as $city)

                                                <option
                                                    value="{{ $city }}"
                                                    {{ old('student_city', $admission->student_city) == $city ? 'selected' : '' }}
                                                >
                                                    {{ $city }}
                                                </option>

                                            @endforeach

                                        </select>
                                    </div>


                                    {{-- 20 Student Status --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Student Status
                                        </label>

                                        <select
                                            name="status"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >

                                            @foreach([
                                                'Active',
                                                'Passed out',
                                                'Rusticate',
                                                'Expelled',
                                                'Transfer',
                                                'Double'
                                            ] as $status)

                                                <option
                                                    value="{{ $status }}"
                                                    {{ old('status', $admission->status) == $status ? 'selected' : '' }}
                                                >
                                                    {{ $status }}
                                                </option>

                                            @endforeach

                                        </select>
                                    </div>


                                    {{-- 21 Status Date --}}
                                    <div>
                                        <label class="text-sm text-gray-700">
                                            Status Date
                                        </label>

                                        <input
                                            type="date"
                                            name="status_date"
                                            value="{{ old('status_date', $admission->status_date ? \Carbon\Carbon::parse($admission->status_date)->format('Y-m-d') : '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300"
                                        >
                                    </div>

                                </div>

                            </form>

                        </div>


                        {{-- =================================================
                            CLASS & SECTION + FEES
                        ================================================== --}}

                        <div>

                            <form
                                method="POST"
                                action="{{ route('admission.updateClassSection', $admission) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <div class="flex items-center justify-between border-b pb-3 mb-6">

                                    <h3 class="text-xl font-semibold text-gray-800">
                                        Class & Section Info
                                    </h3>

                                    <button
                                        type="submit"
                                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm"
                                    >
                                        Save
                                    </button>

                                </div>


                                {{-- CLASS --}}
                                <div class="mb-5">

                                    <label
                                        for="class_id"
                                        class="text-sm text-gray-700"
                                    >
                                        Class
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="class_id"
                                        name="class_id"
                                        class="mt-1 block w-full rounded-md border-gray-300"
                                        required
                                    >

                                        <option value="">
                                            Select Class
                                        </option>

                                        @foreach($classes as $class)

                                            <option
                                                value="{{ $class->id }}"
                                               {{ old('class_id', $admission->class_id) == $class->id ? 'selected' : '' }}
                                            >
                                                {{ $class->class_name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- SECTION --}}
                                <div class="mb-6">

                                    <label
                                        for="section_id"
                                        class="text-sm text-gray-700"
                                    >
                                        Section
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="section_id"
                                        name="section_id"
                                        class="mt-1 block w-full rounded-md border-gray-300"
                                        required
                                    >

                                        <option value="">
                                            Select Section
                                        </option>

                                    </select>

                                </div>

                            </form>


                            {{-- =================================================
                                STUDENT FEES
                            ================================================== --}}

                            <div class="border rounded-md overflow-hidden">

                                {{-- TITLE --}}
                                <div class="bg-gray-200 px-4 py-3">

                                    <h4 class="font-semibold text-gray-800">
                                        Student Fees
                                    </h4>

                                </div>


                                <div class="p-4">

                                    <style>
                                        .student-fees-panel {
                                            width: 100%;
                                            max-width: 100%;
                                            overflow: hidden;
                                        }

                                        .student-fees-panel input[type="number"] {
                                            width: 100%;
                                            box-sizing: border-box;
                                            padding: 0.5rem 0.65rem;
                                            text-align: right;
                                            font-variant-numeric: tabular-nums;
                                        }

                                        .student-fees-amounts {
                                            display: grid;
                                            grid-template-columns: repeat(3, minmax(0, 1fr));
                                            gap: 12px;
                                        }

                                        @media (max-width: 640px) {
                                            .student-fees-amounts {
                                                grid-template-columns: 1fr;
                                            }
                                        }
                                    </style>

                                    <div class="student-fees-panel space-y-4">

                                        {{-- Row 1: Name --}}
                                        <div>
                                            <div class="text-sm font-semibold text-gray-700 mb-1">
                                                Name
                                            </div>
                                            <div class="w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-800">
                                                Monthly Fee
                                            </div>
                                        </div>

                                        {{-- Row 2: Amount | Discount | Actual --}}
                                        <div class="student-fees-amounts">

                                            <div>
                                                <label for="monthlyFeeAmount" class="block text-sm font-semibold text-gray-700 mb-1">
                                                    Amount
                                                </label>
                                                <input
                                                    type="number"
                                                    id="monthlyFeeAmount"
                                                    value="3000"
                                                    min="0"
                                                    class="rounded-md border-gray-300 text-sm"
                                                >
                                            </div>

                                            <div>
                                                <label for="monthlyFeeDiscount" class="block text-sm font-semibold text-gray-700 mb-1">
                                                    Discount
                                                </label>
                                                <input
                                                    type="number"
                                                    id="monthlyFeeDiscount"
                                                    value="300"
                                                    min="0"
                                                    class="rounded-md border-gray-300 text-sm bg-gray-100"
                                                    readonly
                                                >
                                            </div>

                                            <div>
                                                <label for="monthlyFeeActual" class="block text-sm font-semibold text-gray-700 mb-1">
                                                    Actual
                                                </label>
                                                <input
                                                    type="number"
                                                    id="monthlyFeeActual"
                                                    value="2700"
                                                    class="rounded-md border-gray-300 text-sm bg-gray-100"
                                                    readonly
                                                >
                                            </div>

                                        </div>

                                        {{-- Row 3: Action --}}
                                        <div>
                                            <div class="text-sm font-semibold text-gray-700 mb-2">
                                                Action
                                            </div>
                                            <div class="flex items-center gap-2">

                                                <button
                                                    type="button"
                                                    onclick="openDiscountModal()"
                                                    title="Add/Edit Discount"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium"
                                                >
                                                    <span class="text-lg leading-none font-bold">+</span>
                                                    Add
                                                </button>

                                                <button
                                                    type="button"
                                                    onclick="openDiscountView()"
                                                    title="View Discount"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4"
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
                                                    View
                                                </button>

                                            </div>
                                        </div>

                                        {{-- Total --}}
                                        <div class="bg-green-300 rounded-md p-3">
                                            <div class="text-sm font-bold text-gray-900 mb-2">
                                                Total
                                            </div>
                                            <div class="student-fees-amounts font-bold text-gray-900">
                                                <div>
                                                    <div class="text-xs font-semibold text-gray-700 mb-1">Amount</div>
                                                    <div id="totalAmount">3000</div>
                                                </div>
                                                <div>
                                                    <div class="text-xs font-semibold text-gray-700 mb-1">Discount</div>
                                                    <div id="totalDiscount">300</div>
                                                </div>
                                                <div>
                                                    <div class="text-xs font-semibold text-gray-700 mb-1">Actual</div>
                                                    <div id="totalActual">2700</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- BACK --}}
                <div class="border-t bg-gray-50 p-5">

                    <a
                        href="{{ route('admission.index') }}"
                        class="inline-flex items-center px-5 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100"
                    >
                        BACK TO STUDENTS
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
                            value="300"
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
                                300
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
                                2700
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

        let currentDiscount = 300;
        let currentDiscountType = 'Amount';

        /*
        |--------------------------------------------------------------------------
        | CLASS → SECTION DEPENDENCY
        |--------------------------------------------------------------------------
        */
        (function () {
            const classDropdown = document.getElementById('class_id');
            const sectionDropdown = document.getElementById('section_id');

            if (!classDropdown || !sectionDropdown) {
                return;
            }

            const selectedSectionId = @json(old('section_id', $admission->section_id));

            function resetSections(message) {
                sectionDropdown.innerHTML =
                    '<option value="">' + message + '</option>';
            }

            function loadSections(classId, selectedId) {
                resetSections('Select Section');

                if (!classId) {
                    sectionDropdown.disabled = true;
                    return;
                }

                sectionDropdown.disabled = true;

                fetch('/get-sections/' + classId)
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        resetSections('Select Section');

                        if (!data || data.length === 0) {
                            resetSections('No sections available');
                            sectionDropdown.disabled = true;
                            return;
                        }

                        data.forEach(function (section) {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.section_name;

                            if (selectedId && String(selectedId) === String(section.id)) {
                                option.selected = true;
                            }

                            sectionDropdown.appendChild(option);
                        });

                        sectionDropdown.disabled = false;
                    })
                    .catch(function (error) {
                        console.error(error);
                        resetSections('Select Section');
                        sectionDropdown.disabled = true;
                    });
            }

            classDropdown.addEventListener('change', function () {
                loadSections(this.value, null);
            });

            loadSections(classDropdown.value, selectedSectionId);
        })();


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