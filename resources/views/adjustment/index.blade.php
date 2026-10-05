<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800">
                Adjustment
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Manage student fee adjustments
            </p>
        </div>
    </x-slot>


    <div class="py-5 bg-gray-100 min-h-screen">

        <div class="max-w-6xl mx-auto sm:px-5 lg:px-6">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-3">


                {{-- =====================================================
                    STUDENT / MONTH SELECTION
                ====================================================== --}}

                <form
                    method="GET"
                    action="{{ route('adjustment.index') }}"
                    id="filterForm"
                >

                    <div class="grid grid-cols-4 border border-gray-300 rounded-md relative z-10">


                        {{-- CLASS --}}

                        <div>

                            <select
                                id="class_id"
                                name="class_id"
                                onchange="this.form.submit()"
                                class="w-full h-10 border-0 border-r border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Select Class
                                </option>

                                @foreach($classes as $class)

                                    <option
                                        value="{{ $class->id }}"
                                        {{ request('class_id') == $class->id ? 'selected' : '' }}
                                    >
                                        {{ $class->class_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>



                        {{-- SECTION --}}

                        <div>

                            <select
                                id="section_id"
                                name="section_id"
                                onchange="this.form.submit()"
                                class="w-full h-10 border-0 border-r border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Select Section
                                </option>

                                @foreach($sections as $section)

                                    @if(
                                        !request('class_id')
                                        ||
                                        $section->class_id == request('class_id')
                                    )

                                        <option
                                            value="{{ $section->id }}"
                                            {{ request('section_id') == $section->id ? 'selected' : '' }}
                                        >
                                            {{ $section->section_name }}
                                        </option>

                                    @endif

                                @endforeach

                            </select>

                        </div>



                        {{-- STUDENT --}}

                        <div>

                            <select
                                id="student_id"
                                name="student_id"
                                onchange="this.form.submit()"
                                class="w-full h-10 border-0 border-r border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Select Student
                                </option>

                                @foreach($students as $student)

                                    @if(
                                        (!request('class_id')
                                            ||
                                            $student->class_id == request('class_id'))

                                        &&

                                        (!request('section_id')
                                            ||
                                            $student->section_id == request('section_id'))
                                    )

                                        <option
                                            value="{{ $student->id }}"
                                            {{ request('student_id') == $student->id ? 'selected' : '' }}
                                        >
                                            {{ $student->name }}
                                        </option>

                                    @endif

                                @endforeach

                            </select>

                        </div>



                        {{-- MONTH (searchable; Active from student adjustments) --}}

                        <div class="relative">

                            @php
                                $selectedMonthValue = request('month');
                                $selectedMonthLabel = null;

                                if (!empty($sessionMonths) && $selectedMonthValue !== null && $selectedMonthValue !== '') {
                                    foreach ($sessionMonths as $sessionMonth) {
                                        if ((string) $sessionMonth['value'] === (string) $selectedMonthValue) {
                                            $selectedMonthLabel = $sessionMonth['label'];
                                            break;
                                        }
                                    }
                                }

                                $monthDisabled = empty($sessionMonths);
                                $activeAdjustmentMonths = $activeAdjustmentMonths ?? [];
                            @endphp

                            <input
                                type="hidden"
                                id="month"
                                name="month"
                                value="{{ $monthDisabled ? '' : $selectedMonthValue }}"
                                data-disabled="{{ $monthDisabled ? '1' : '0' }}"
                            >

                            <button
                                type="button"
                                id="monthDropdownTrigger"
                                class="month-dropdown-trigger w-full h-10 px-3 text-sm text-left bg-white
                                       flex items-center justify-between gap-2
                                       focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500
                                       {{ $monthDisabled ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'text-gray-800' }}"
                                @if($monthDisabled) disabled @endif
                                aria-haspopup="listbox"
                                aria-expanded="false"
                            >
                                <span id="monthDropdownLabel" class="truncate">
                                    @if($monthDisabled)
                                        No active session found.
                                    @elseif($selectedMonthLabel)
                                        {{ $selectedMonthLabel }}
                                    @else
                                        Select Month
                                    @endif
                                </span>

                                <svg
                                    class="month-dropdown-chevron w-4 h-4 text-gray-500 shrink-0"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>

                            @unless($monthDisabled)
                                <div
                                    id="monthDropdownPanel"
                                    class="month-dropdown-panel absolute left-0 right-0 top-full z-30 mt-0
                                           hidden border border-gray-300 border-t-0 bg-white shadow-md"
                                >
                                    <div class="p-2 border-b border-gray-200">
                                        <input
                                            type="text"
                                            id="monthSearchInput"
                                            autocomplete="off"
                                            placeholder="Search month..."
                                            class="w-full h-8 px-2 text-sm border border-gray-300 rounded
                                                   focus:border-blue-500 focus:ring-blue-500"
                                        >
                                    </div>

                                    <ul
                                        id="monthDropdownList"
                                        class="max-h-48 overflow-y-auto py-1"
                                        role="listbox"
                                    >
                                        <li
                                            class="month-dropdown-option px-3 py-2 text-sm text-gray-500 cursor-pointer
                                                   hover:bg-gray-50 flex items-center justify-between"
                                            data-value=""
                                            data-label="Select Month"
                                            data-search="select month"
                                            role="option"
                                        >
                                            <span>Select Month</span>
                                        </li>

                                        @foreach($sessionMonths as $sessionMonth)
                                            @php
                                                $isActiveMonth = in_array(
                                                    (int) $sessionMonth['value'],
                                                    $activeAdjustmentMonths,
                                                    true
                                                );
                                            @endphp

                                            <li
                                                class="month-dropdown-option px-3 py-2 text-sm text-gray-800 cursor-pointer
                                                       hover:bg-gray-50 flex items-center justify-between gap-2
                                                       {{ (string) $selectedMonthValue === (string) $sessionMonth['value'] ? 'bg-blue-50' : '' }}"
                                                data-value="{{ $sessionMonth['value'] }}"
                                                data-label="{{ $sessionMonth['label'] }}"
                                                data-search="{{ strtolower($sessionMonth['label']) }}"
                                                data-active="{{ $isActiveMonth ? '1' : '0' }}"
                                                role="option"
                                            >
                                                <span>{{ $sessionMonth['label'] }}</span>

                                                @if($isActiveMonth)
                                                    <span class="text-xs font-medium text-green-600 shrink-0">
                                                        Active
                                                    </span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div
                                        id="monthSearchEmpty"
                                        class="hidden px-3 py-2 text-sm text-gray-500"
                                    >
                                        No months found.
                                    </div>
                                </div>
                            @endunless

                        </div>

                    </div>

                </form>



                {{-- =====================================================
                    MULTIPLE ADJUSTMENTS FORM
                ====================================================== --}}

                <form
                    method="POST"
                    action="{{ route('adjustment.store') }}"
                    id="adjustmentForm"
                    class="mt-4"
                >

                    @csrf


                    {{-- HIDDEN VALUES --}}

                    <input
                        type="hidden"
                        name="class_id"
                        id="save_class_id"
                        value="{{ request('class_id') }}"
                    >

                    <input
                        type="hidden"
                        name="section_id"
                        id="save_section_id"
                        value="{{ request('section_id') }}"
                    >

                    <input
                        type="hidden"
                        name="student_id"
                        id="save_student_id"
                        value="{{ request('student_id') }}"
                    >

                    <input
                        type="hidden"
                        name="month"
                        id="save_month"
                        value="{{ request('month') }}"
                    >



                    {{-- =================================================
                        ADJUSTMENTS BOX
                    ================================================== --}}

                    <div class="border border-gray-300 rounded-md overflow-hidden">


                        {{-- HEADER --}}

                        <div class="bg-gray-100 px-3 py-2 flex justify-between items-center">

                            <h3 class="text-sm font-semibold text-gray-800">
                                Adjustments
                            </h3>

                            <button
                                type="button"
                                onclick="addAdjustmentRow()"
                                class="px-3 py-1.5 bg-black text-white text-xs rounded-md hover:bg-gray-800"
                            >
                                + Add Adjustment
                            </button>

                        </div>



                        {{-- =================================================
                            ADJUSTMENT ROWS
                        ================================================== --}}

                        <div
                            id="adjustmentRows"
                            class="p-3"
                        >


                            {{-- FIRST ROW --}}

                            <div class="adjustment-row grid grid-cols-12 gap-2 mb-2">


                                {{-- FEE TYPE --}}

                                <div class="col-span-7">

                                    <select
                                        name="adjustments[0][fee_id]"
                                        class="adjustment-type w-full h-10 border border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                                        onchange="updateAdjustmentTypes()"
                                    >

                                        <option value="">
                                            Select Adjustment Type
                                        </option>

                                        @foreach($adjustmentTypes as $type)

                                            <option value="{{ $type->id }}">
                                                {{ $type->description }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>



                                {{-- AMOUNT --}}

                                <div class="col-span-4">

                                    <input
                                        type="number"
                                        name="adjustments[0][amount]"
                                        min="0"
                                        step="0.01"
                                        placeholder="Enter Amount"
                                        oninput="calculateTotal()"
                                        class="w-full h-10 border border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                                    >

                                </div>



                                {{-- REMOVE --}}

                                <div class="col-span-1 flex items-center justify-center">

                                    <button
                                        type="button"
                                        onclick="removeAdjustmentRow(this)"
                                        class="text-red-600 text-sm font-bold"
                                    >
                                        ✕
                                    </button>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            TOTAL
                        ================================================== --}}

                        <div class="border-t border-gray-300 bg-gray-50 px-3 py-3 flex justify-end">

                            <div class="text-sm">

                                <span class="font-semibold text-gray-700">
                                    Total:
                                </span>

                                <span
                                    id="totalAmount"
                                    class="font-bold text-gray-900 ml-2"
                                >
                                    Rs. 0.00
                                </span>

                            </div>

                        </div>

                    </div>



                    {{-- SAVE ALL --}}

                    <div class="flex justify-end mt-3">

                        <button
                            type="submit"
                            class="px-5 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800"
                        >
                            Save All
                        </button>

                    </div>

                </form>



                {{-- =====================================================
                    EXISTING ADJUSTMENTS
                ====================================================== --}}

                @if(request('student_id'))

                    <div class="mt-5">

                        <h3 class="text-base font-semibold text-gray-800 mb-3">
                            Adjustment Fees
                        </h3>


                        @if($fees->count())


                            <div class="overflow-x-auto">

                                <table class="w-full border border-gray-200 text-sm">

                                    <thead class="bg-gray-100">

                                        <tr>

                                            <th class="px-3 py-2 text-left">
                                                Fee Type
                                            </th>

                                            <th class="px-3 py-2 text-left">
                                                Month
                                            </th>

                                            <th class="px-3 py-2 text-left">
                                                Year
                                            </th>

                                            <th class="px-3 py-2 text-left">
                                                Amount
                                            </th>

                                            <th class="px-3 py-2 text-left">
                                                Status
                                            </th>

                                        </tr>

                                    </thead>



                                    <tbody>

                                        @php

                                            $months = [

                                                1 => 'January',
                                                2 => 'February',
                                                3 => 'March',
                                                4 => 'April',
                                                5 => 'May',
                                                6 => 'June',
                                                7 => 'July',
                                                8 => 'August',
                                                9 => 'September',
                                                10 => 'October',
                                                11 => 'November',
                                                12 => 'December',

                                            ];

                                        @endphp



                                        @foreach($fees as $fee)

                                            <tr class="border-t">

                                                <td class="px-3 py-2">
                                                    {{ $fee->fee->description ?? '-' }}
                                                </td>

                                                <td class="px-3 py-2">
                                                    {{ $months[$fee->month] ?? $fee->month }}
                                                </td>

                                                <td class="px-3 py-2">
                                                    {{ $fee->year }}
                                                </td>

                                                <td class="px-3 py-2">
                                                    Rs. {{ number_format($fee->amount, 2) }}
                                                </td>

                                                <td class="px-3 py-2">
                                                    {{ $fee->status }}
                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>



                            {{-- TOTAL EXISTING ADJUSTMENT --}}

                            <div class="mt-3 flex justify-end">

                                <div class="bg-gray-100 px-4 py-2 rounded-md text-sm">

                                    <span class="font-semibold text-gray-700">
                                        Total Adjustment:
                                    </span>

                                    <span class="font-bold text-gray-900 ml-2">
                                        Rs. {{ number_format($fees->sum('amount'), 2) }}
                                    </span>

                                </div>

                            </div>


                        @else

                            <p class="text-sm text-gray-500">
                                No adjustment fees found for this student.
                            </p>

                        @endif

                    </div>

                @endif

            </div>

        </div>

    </div>



    {{-- =============================================================
        JAVASCRIPT
    ============================================================== --}}

    <script>


        /*
        |--------------------------------------------------------------
        | Adjustment Row Counter
        |--------------------------------------------------------------
        */

        let adjustmentIndex = 1;



        /*
        |--------------------------------------------------------------
        | ADD NEW ADJUSTMENT ROW
        |--------------------------------------------------------------
        */

        function addAdjustmentRow() {

            const container =
                document.getElementById('adjustmentRows');


            const row =
                document.createElement('div');


            row.className =
                'adjustment-row grid grid-cols-12 gap-2 mb-2';



            row.innerHTML = `

                <div class="col-span-7">

                    <select
                        name="adjustments[${adjustmentIndex}][fee_id]"
                        class="adjustment-type w-full h-10 border border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                        onchange="updateAdjustmentTypes()"
                    >

                        <option value="">
                            Select Adjustment Type
                        </option>

                        @foreach($adjustmentTypes as $type)

                            <option value="{{ $type->id }}">
                                {{ $type->description }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-span-4">

                    <input
                        type="number"
                        name="adjustments[${adjustmentIndex}][amount]"
                        min="0"
                        step="0.01"
                        placeholder="Enter Amount"
                        oninput="calculateTotal()"
                        class="w-full h-10 border border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                <div class="col-span-1 flex items-center justify-center">

                    <button
                        type="button"
                        onclick="removeAdjustmentRow(this)"
                        class="text-red-600 text-sm font-bold"
                    >
                        ✕
                    </button>

                </div>

            `;


            container.appendChild(row);


            adjustmentIndex++;


            /*
            |----------------------------------------------------------
            | Update dropdowns immediately
            |----------------------------------------------------------
            */

            updateAdjustmentTypes();

        }



        /*
        |--------------------------------------------------------------
        | REMOVE ADJUSTMENT ROW
        |--------------------------------------------------------------
        */

        function removeAdjustmentRow(button) {

            const rows =
                document.querySelectorAll('.adjustment-row');


            /*
            |----------------------------------------------------------
            | At least one row must remain
            |----------------------------------------------------------
            */

            if (rows.length === 1) {

                return;

            }


            button
                .closest('.adjustment-row')
                .remove();


            /*
            |----------------------------------------------------------
            | Re-enable removed fee in other dropdowns
            |----------------------------------------------------------
            */

            updateAdjustmentTypes();


            calculateTotal();

        }



        /*
        |--------------------------------------------------------------
        | IMPORTANT FUNCTION
        |
        | Prevent the same fee type from being selected
        | in multiple rows.
        |--------------------------------------------------------------
        */

        function updateAdjustmentTypes() {


            /*
            |----------------------------------------------------------
            | Get all adjustment dropdowns
            |----------------------------------------------------------
            */

            const selects =
                document.querySelectorAll('.adjustment-type');



            /*
            |----------------------------------------------------------
            | Store currently selected fee IDs
            |----------------------------------------------------------
            */

            const selectedValues = [];


            selects.forEach(function(select) {

                if (select.value) {

                    selectedValues.push(
                        select.value
                    );

                }

            });



            /*
            |----------------------------------------------------------
            | Update every dropdown
            |----------------------------------------------------------
            */

            selects.forEach(function(select) {


                /*
                |------------------------------------------------------
                | Current value of this dropdown
                |------------------------------------------------------
                */

                const currentValue =
                    select.value;



                /*
                |------------------------------------------------------
                | Check every option
                |------------------------------------------------------
                */

                select
                    .querySelectorAll('option')
                    .forEach(function(option) {


                        /*
                        |------------------------------------------------
                        | Placeholder
                        |------------------------------------------------
                        */

                        if (option.value === '') {

                            option.hidden = false;

                            return;

                        }



                        /*
                        |------------------------------------------------
                        | If this fee is already selected in another row
                        | hide it.
                        |------------------------------------------------
                        */

                        if (
                            selectedValues.includes(option.value)
                            &&
                            option.value !== currentValue
                        ) {

                            option.hidden = true;

                        }

                        else {

                            option.hidden = false;

                        }

                    });

            });

        }



        /*
        |--------------------------------------------------------------
        | CALCULATE TOTAL
        |--------------------------------------------------------------
        */

        function calculateTotal() {

            let total = 0;


            document
                .querySelectorAll(
                    'input[name*="[amount]"]'
                )
                .forEach(function(input) {


                    const value =
                        parseFloat(input.value) || 0;


                    total += value;

                });



            document
                .getElementById('totalAmount')
                .innerText =
                    'Rs. ' + total.toFixed(2);

        }



        /*
        |--------------------------------------------------------------
        | FORM SUBMIT VALIDATION
        |--------------------------------------------------------------
        */

        document
            .getElementById('adjustmentForm')
            .addEventListener(
                'submit',
                function(event) {


                    /*
                    |--------------------------------------------------
                    | Student
                    |--------------------------------------------------
                    */

                    const studentId =
                        document
                            .getElementById('student_id')
                            .value;



                    /*
                    |--------------------------------------------------
                    | Month
                    |--------------------------------------------------
                    */

                    const month =
                        document
                            .getElementById('month')
                            .value;



                    /*
                    |--------------------------------------------------
                    | Student required
                    |--------------------------------------------------
                    */

                    if (!studentId) {

                        event.preventDefault();

                        if (typeof window.showAppAlert === 'function') {
                            window.showAppAlert('Please select a student.');
                        }

                        return;

                    }



                    /*
                    |--------------------------------------------------
                    | Month required
                    |--------------------------------------------------
                    */

                    if (!month) {

                        event.preventDefault();

                        if (typeof window.showAppAlert === 'function') {
                            const monthField = document.getElementById('month');
                            const noActiveSession = monthField
                                && monthField.getAttribute('data-disabled') === '1';

                            window.showAppAlert(
                                noActiveSession
                                    ? 'No active session found.'
                                    : 'Please select a month.'
                            );
                        }

                        return;

                    }



                    /*
                    |--------------------------------------------------
                    | Save hidden values
                    |--------------------------------------------------
                    */

                    document
                        .getElementById('save_student_id')
                        .value =
                            studentId;


                    document
                        .getElementById('save_month')
                        .value =
                            month;



                    /*
                    |--------------------------------------------------
                    | Validate rows
                    |--------------------------------------------------
                    */

                    const rows =
                        document.querySelectorAll(
                            '.adjustment-row'
                        );


                    let valid = true;



                    rows.forEach(function(row) {


                        const feeType =
                            row
                                .querySelector(
                                    'select'
                                )
                                .value;


                        const amount =
                            row
                                .querySelector(
                                    'input'
                                )
                                .value;



                        if (
                            !feeType
                            ||
                            !amount
                        ) {

                            valid = false;

                        }

                    });



                    /*
                    |--------------------------------------------------
                    | Invalid row
                    |--------------------------------------------------
                    */

                    if (!valid) {

                        event.preventDefault();

                        if (typeof window.showAppAlert === 'function') {
                            window.showAppAlert(
                                'Please select adjustment type and enter amount for every row.'
                            );
                        }

                        return;

                    }

                }
            );



        /*
        |--------------------------------------------------------------
        | SEARCHABLE MONTH DROPDOWN
        |--------------------------------------------------------------
        */

        (function () {
            const trigger = document.getElementById('monthDropdownTrigger');
            const panel = document.getElementById('monthDropdownPanel');
            const searchInput = document.getElementById('monthSearchInput');
            const list = document.getElementById('monthDropdownList');
            const emptyState = document.getElementById('monthSearchEmpty');
            const monthField = document.getElementById('month');
            const labelEl = document.getElementById('monthDropdownLabel');
            const saveMonth = document.getElementById('save_month');

            if (!trigger || !panel || !monthField || !list) {
                return;
            }

            const options = Array.from(
                list.querySelectorAll('.month-dropdown-option')
            );

            function openPanel() {
                panel.classList.remove('hidden');
                trigger.setAttribute('aria-expanded', 'true');
                if (searchInput) {
                    searchInput.value = '';
                    filterOptions('');
                    searchInput.focus();
                }
            }

            function closePanel() {
                panel.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
            }

            function filterOptions(query) {
                const q = (query || '').toLowerCase().trim();
                let visibleCount = 0;

                options.forEach(function (option) {
                    const searchText = option.getAttribute('data-search') || '';
                    const matches = !q || searchText.indexOf(q) !== -1;

                    option.classList.toggle('hidden', !matches);

                    if (matches) {
                        visibleCount += 1;
                    }
                });

                if (emptyState) {
                    emptyState.classList.toggle('hidden', visibleCount > 0);
                }
            }

            function selectOption(option) {
                const value = option.getAttribute('data-value') || '';
                const label = option.getAttribute('data-label') || 'Select Month';

                monthField.value = value;
                labelEl.textContent = label;

                if (saveMonth) {
                    saveMonth.value = value;
                }

                options.forEach(function (item) {
                    item.classList.toggle(
                        'bg-blue-50',
                        item === option && value !== ''
                    );
                });

                closePanel();
            }

            trigger.addEventListener('click', function (event) {
                event.preventDefault();

                if (trigger.disabled) {
                    return;
                }

                if (panel.classList.contains('hidden')) {
                    openPanel();
                } else {
                    closePanel();
                }
            });

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    filterOptions(searchInput.value);
                });

                searchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closePanel();
                        trigger.focus();
                    }
                });
            }

            options.forEach(function (option) {
                option.addEventListener('click', function () {
                    selectOption(option);
                });
            });

            document.addEventListener('click', function (event) {
                if (
                    !panel.classList.contains('hidden')
                    && !trigger.contains(event.target)
                    && !panel.contains(event.target)
                ) {
                    closePanel();
                }
            });
        })();



        /*
        |--------------------------------------------------------------
        | INITIAL LOAD
        |--------------------------------------------------------------
        */

        calculateTotal();

        updateAdjustmentTypes();

    </script>

</x-app-layout>