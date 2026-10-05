<x-app-layout>

    {{-- ============================================================
         HEADER
    ============================================================= --}}

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Receive Fees List
                </h2>

                <div class="text-sm text-gray-500 mt-1">

                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:underline">
                        Home
                    </a>

                    <span class="mx-1">/</span>

                    <span>Receive Fees List</span>

                </div>

            </div>


            <a href="{{ route('fee-collections.family-defaulters') }}"
   class="bg-black hover:bg-gray-800 text-white text-sm px-4 py-2 rounded">
    Family defaulter list
</a>
        </div>

    </x-slot>


    {{-- ============================================================
         MAIN CONTENT
    ============================================================= --}}

    <div class="py-4">

        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-4">


                    {{-- ==================================================
                         FILTER AREA
                    =================================================== --}}

                    <form
                        method="GET"
                        action="{{ route('fee-collections.index') }}"
                        id="feeFilterForm"
                    >

                        <div class="border border-gray-200 rounded-md p-4 mb-4">

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">


                                {{-- SEARCH STUDENT --}}

                                <div>

                                    <label class="block text-sm text-gray-600 mb-1">
                                        Search Student
                                    </label>

                                    <input
                                        type="text"
                                        name="student"
                                        value="{{ request('student') }}"
                                        placeholder="Search Student"
                                        class="w-full h-10 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                        oninput="filterStudents()"
                                    >

                                </div>


                                {{-- SEARCH FAMILY --}}

                                <div>

                                    <label class="block text-sm text-gray-600 mb-1">
                                        Search Family #
                                    </label>

                                    <input
                                        type="text"
                                        name="family_no"
                                        value="{{ request('family_no') }}"
                                        placeholder="Search Family #"
                                        class="w-full h-10 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                        oninput="filterStudents()"
                                    >

                                </div>


                                {{-- CLASS --}}

                                <div>

                                    <label class="block text-sm text-gray-600 mb-1">
                                        Class
                                    </label>

                                    <select
                                        name="class_id"
                                        id="class_id"
                                        onchange="classChanged()"
                                        class="w-full h-10 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
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

                                    <label class="block text-sm text-gray-600 mb-1">
                                        Section
                                    </label>

                                    <select
                                        name="section_id"
                                        id="section_id"
                                        onchange="sectionChanged()"
                                        class="w-full h-10 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                    >

                                        <option value="">
                                            Select Section
                                        </option>

                                        @foreach($sections as $section)

                                            <option
                                                value="{{ $section->id }}"
                                                data-class-id="{{ $section->class_id }}"
                                                {{ request('section_id') == $section->id ? 'selected' : '' }}
                                            >
                                                {{ $section->section_name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- RESET --}}

                                <div class="flex items-end">

                                    <a
                                        href="{{ route('fee-collections.index') }}"
                                        class="bg-black hover:bg-gray-800 text-white px-5 py-2.5 rounded-md text-sm"
                                    >
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </div>

                    </form>


                    {{-- ==================================================
                         STUDENT TABLE
                    =================================================== --}}

                    <div class="border border-gray-300 rounded-md overflow-x-auto">

                        <table class="w-full min-w-[1400px] text-sm">


                            {{-- TABLE HEADER --}}

                            <thead>

                                <tr class="bg-gray-500 text-white">

                                    <th class="px-4 py-3 text-left">
                                        Image
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Roll #
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Name
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Father Name
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Family #
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Class
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Section
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Fee Status
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Arrear Status
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            {{-- TABLE BODY --}}

                            <tbody class="bg-white">

                                @forelse($collections as $collection)

                                    @php
                                        $student = $collection->student;
                                    @endphp


                                    @if($student)

                                        <tr class="border-b border-gray-200 hover:bg-gray-50">


                                            {{-- IMAGE --}}

                                            <td class="px-4 py-3">

                                                <div class="w-11 h-11 rounded-full bg-gray-200 flex items-center justify-center">

                                                    <span class="text-gray-700 text-xl">
                                                        👤
                                                    </span>

                                                </div>

                                            </td>


                                            {{-- ROLL --}}

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $student->id ?? '-' }}
                                            </td>


                                            {{-- NAME --}}

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $student->name ?? '-' }}
                                            </td>


                                            {{-- FATHER NAME --}}

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $student->father_name ?? '-' }}
                                            </td>


                                            {{-- FAMILY NUMBER --}}

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $student->family_no ?? '-' }}
                                            </td>


                                            {{-- CLASS --}}

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ optional($student->studentClass)->class_name ?? '-' }}
                                            </td>


                                            {{-- SECTION --}}

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ optional($student->section)->section_name ?? '-' }}
                                            </td>


                                            {{-- FEE STATUS --}}

                                            <td class="px-4 py-3">

                                                @if(strtolower($collection->status ?? '') === 'paid')

                                                    <span class="inline-block bg-green-500 text-white text-xs font-semibold px-5 py-1.5 rounded">
                                                        Paid
                                                    </span>

                                                @else

                                                    <span class="inline-block bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded">
                                                        Not Processed
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- ARREAR STATUS --}}

                                            <td class="px-4 py-3">

                                                <span class="text-green-600 font-medium">
                                                    Clear
                                                </span>

                                            </td>


                                       {{-- ==================================================
     ACTION
=================================================== --}}

<td class="px-4 py-3">

    <div
        x-data="{ open: false }"
        class="flex items-center gap-4"
    >

        {{-- HISTORY ICON --}}
        <button
            type="button"
            onclick="openFeeHistory({{ $collection->id }})"
            title="Student Fee History"
            class="text-black hover:text-gray-700"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-7 h-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2.5"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 4v5h5"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M20 20v-5h-5"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5.5 9A7 7 0 0117.5 6.5L20 9"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M18.5 15A7 7 0 016.5 17.5L4 15"
                />

            </svg>

        </button>


        {{-- SETTINGS / ACTION BUTTON --}}
        <button
            type="button"
            x-ref="actionButton"
            @click="
                open = !open;

                if (open) {
                    $nextTick(() => {

                        const button = $refs.actionButton;
                        const menu = $refs.actionMenu;

                        const rect = button.getBoundingClientRect();

                        const menuHeight = 176;
                        const menuWidth = 176;
                        const gap = 6;

                        const spaceBelow =
                            window.innerHeight - rect.bottom;

                        const spaceAbove =
                            rect.top;

                        menu.style.right =
                            (window.innerWidth - rect.right) + 'px';

                        menu.style.left = 'auto';

                        menu.style.width =
                            menuWidth + 'px';

                        if (
                            spaceBelow < menuHeight &&
                            spaceAbove > menuHeight
                        ) {

                            menu.style.top = 'auto';

                            menu.style.bottom =
                                (window.innerHeight - rect.top + gap) + 'px';

                        } else {

                            menu.style.bottom = 'auto';

                            menu.style.top =
                                (rect.bottom + gap) + 'px';

                        }

                    });
                }
            "
            title="Actions"
            class="text-black hover:text-gray-700"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-7 h-7"
                fill="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    d="M19.43 12.98c.04-.32.07-.65.07-.98s-.02-.66-.07-.98l2.11-1.65a.5.5 0 00.12-.64l-2-3.46a.5.5 0 00-.61-.22l-2.49 1a7.03 7.03 0 00-1.69-.98L14.5 2.42A.5.5 0 0014 2h-4a.5.5 0 00-.5.42L9.12 5.07c-.61.25-1.18.58-1.69.98l-2.49-1a.5.5 0 00-.61.22l-2 3.46a.5.5 0 00.12.64l2.11 1.65c-.04.32-.08.65-.08.98s.03.66.08.98l-2.11 1.65a.5.5 0 00-.12.64l2 3.46c.14.24.43.34.7.22l2.49-1c.51.4 1.08.73 1.69.98l.38 2.65c.04.28.28.48.5.48h4c.25 0 .46-.18.5-.42l.38-2.65c.61-.25 1.18-.58 1.69-.98l2.49 1c.27.11.56.01.7-.22l2-3.46a.5.5 0 00-.12-.64l-2.11-1.65zM12 15.5A3.5 3.5 0 1112 8a3.5 3.5 0 010 7.5z"
                />

            </svg>

        </button>


        {{-- ==================================================
             ACTION DROPDOWN
             FIXED = TABLE SCROLL SE ISOLATED
        =================================================== --}}

        <div
            x-show="open"
            x-ref="actionMenu"
            @click.outside="open = false"
            x-transition
            style="display: none;"
            class="fixed bg-white border border-gray-200 rounded-md shadow-xl z-[9999] overflow-hidden"
        >

            <a
                href="{{ route('fee-collections.show', $collection->id) }}"
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100"
            >
                View
            </a>

          <a
    href="{{ route('fee-collections.receive', $collection->id) }}"
    class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100"
>
    Receive Fee
</a>

            <a
                href="{{ route('fee-collections.challan', $collection->id) }}"
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100"
            >
                Print Challan
            </a>

            <a href="{{ route('fee-collections.fee-warning', $collection->id) }}"
   target="_blank"
   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">
    Fee Warning
</a>

        </div>

    </div>

</td>

                                        </tr>

                                    @endif

                                @empty

                                    <tr>

                                        <td
                                            colspan="10"
                                            class="px-4 py-10 text-center text-gray-500"
                                        >
                                            No Receive Fees List records found.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ============================================================
         STUDENT FEE HISTORY MODAL
    ============================================================= --}}

    <div
        id="feeHistoryModal"
        class="fixed inset-0 z-[9999] hidden"
        aria-hidden="true"
    >

        {{-- DARK OVERLAY --}}

        <div
            class="absolute inset-0 bg-black/60"
            onclick="closeFeeHistory()"
        ></div>


        {{-- MODAL BOX --}}

        <div class="relative min-h-screen flex items-start justify-center px-4 pt-6 sm:pt-8">

            <div
                class="relative bg-white rounded-md shadow-2xl w-full max-w-6xl overflow-hidden"
                style="max-height: 85vh;"
            >


                {{-- ==================================================
                     MODAL HEADER
                =================================================== --}}

                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-300">

                    <h3
                        id="feeHistoryStudentName"
                        class="text-xl font-semibold text-gray-800"
                    >
                        Student Fee History
                    </h3>


                    <button
                        type="button"
                        onclick="closeFeeHistory()"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold leading-none"
                    >
                        &times;
                    </button>

                </div>


                {{-- ==================================================
                     MODAL TABLE
                =================================================== --}}

                <div class="p-3 overflow-auto">

                    <table class="w-full min-w-[1050px] text-sm border-collapse">


                        {{-- HEADER --}}

                        <thead>

                            <tr class="bg-gray-700 text-white">

                                <th class="px-3 py-3 border border-gray-500 text-center">
                                    #
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-left">
                                    Month ID
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-left">
                                    Month
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-right">
                                    Total Charged
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-right">
                                    Discount
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-right">
                                    Processed
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-right">
                                    Received
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-right">
                                    Monthly Difference
                                </th>

                                <th class="px-3 py-3 border border-gray-500 text-right">
                                    Defaulter (Cumulative)
                                </th>

                            </tr>

                        </thead>


                        {{-- BODY --}}

                        <tbody id="feeHistoryBody">

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>



    {{-- ============================================================
         JAVASCRIPT
    ============================================================= --}}

    <script>

        let filterTimer;


        /* ============================================================
           SEARCH STUDENT / FAMILY
        ============================================================= */

        function filterStudents()
        {
            clearTimeout(filterTimer);

            filterTimer = setTimeout(function()
            {
                document.getElementById('feeFilterForm').submit();

            }, 500);
        }


        /* ============================================================
           CLASS CHANGE
        ============================================================= */

        function classChanged()
        {
            const classSelect =
                document.getElementById('class_id');

            const sectionSelect =
                document.getElementById('section_id');

            const selectedClassId =
                classSelect.value;


            sectionSelect.value = "";


            Array.from(sectionSelect.options).forEach(function(option)
            {

                if (option.value === "")
                {
                    option.hidden = false;
                    return;
                }


                const sectionClassId =
                    option.getAttribute('data-class-id');


                if (selectedClassId === "")
                {
                    option.hidden = false;
                }
                else if (sectionClassId === selectedClassId)
                {
                    option.hidden = false;
                }
                else
                {
                    option.hidden = true;
                }

            });


            document.getElementById('feeFilterForm').submit();
        }


        /* ============================================================
           SECTION CHANGE
        ============================================================= */

        function sectionChanged()
        {
            document.getElementById('feeFilterForm').submit();
        }


        /* ============================================================
           PAGE LOAD - FILTER SECTIONS
        ============================================================= */

        document.addEventListener('DOMContentLoaded', function()
        {

            const classSelect =
                document.getElementById('class_id');

            const sectionSelect =
                document.getElementById('section_id');

            const selectedClassId =
                classSelect.value;


            Array.from(sectionSelect.options).forEach(function(option)
            {

                if (option.value === "")
                {
                    option.hidden = false;
                    return;
                }


                const sectionClassId =
                    option.getAttribute('data-class-id');


                if (selectedClassId === "")
                {
                    option.hidden = false;
                }
                else if (sectionClassId === selectedClassId)
                {
                    option.hidden = false;
                }
                else
                {
                    option.hidden = true;
                }

            });

        });


        /* ============================================================
           OPEN STUDENT FEE HISTORY
           
           IMPORTANT:
           Modal pehle open hoga.
           "Loading..." ka koi text nahi hai.
        ============================================================= */

        function openFeeHistory(feeCollectionId)
        {

            const modal =
                document.getElementById('feeHistoryModal');

            const body =
                document.getElementById('feeHistoryBody');

            const title =
                document.getElementById('feeHistoryStudentName');


            /*
             * Modal immediately open
             */

            modal.classList.remove('hidden');

            document.body.classList.add('overflow-hidden');


            /*
             * Header immediately show
             */

            title.innerText =
                'Student Fee History';


            /*
             * Body empty
             */

            body.innerHTML = '';


            /*
             * History URL
             */

            let url =
                "{{ route('fee-collections.history', ':id') }}";

            url =
                url.replace(':id', feeCollectionId);


            /*
             * Get history
             */

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(response)
            {

                if (!response.ok)
                {
                    throw new Error('History could not be loaded.');
                }

                return response.json();

            })
            .then(function(data)
            {

                /*
                 * Student name
                 */

                if (
                    data.student &&
                    data.student.name
                )
                {
                    title.innerText =
                        'Student Fee History';
                }


                /*
                 * History rows
                 */

                if (
                    !data.history ||
                    data.history.length === 0
                )
                {

                    body.innerHTML = `

                        <tr>

                            <td
                                colspan="9"
                                class="px-4 py-6 text-center text-gray-500 border border-gray-200"
                            >
                                No fee history found.
                            </td>

                        </tr>

                    `;

                    return;
                }


                /*
                 * Create rows
                 */

                let rows = '';


                data.history.forEach(function(item, index)
                {

                    rows += `

                        <tr class="bg-white">

                            <td
                                class="px-3 py-2 border border-gray-200 text-center text-gray-700"
                            >
                                ${index + 1}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-gray-700"
                            >
                                ${item.month_id ?? '-'}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-gray-700"
                            >
                                ${item.month ?? '-'}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-right font-semibold text-blue-600"
                            >
                                ${formatAmount(item.total_charged)}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-right font-semibold text-green-600"
                            >
                                ${formatAmount(item.discount)}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-right font-semibold text-blue-600"
                            >
                                ${formatAmount(item.processed)}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-right font-semibold text-green-600"
                            >
                                ${formatAmount(item.received)}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-right font-semibold text-yellow-600"
                            >
                                ${formatAmount(item.monthly_difference)}
                            </td>


                            <td
                                class="px-3 py-2 border border-gray-200 text-right font-semibold text-red-600"
                            >
                                ${formatAmount(item.defaulter)}
                            </td>

                        </tr>

                    `;

                });


                body.innerHTML = rows;

            })
            .catch(function(error)
            {

                console.error(error);

                body.innerHTML = `

                    <tr>

                        <td
                            colspan="9"
                            class="px-4 py-6 text-center text-red-500 border border-gray-200"
                        >
                            Unable to load fee history.
                        </td>

                    </tr>

                `;

            });

        }


        /* ============================================================
           FORMAT AMOUNT
        ============================================================= */

        function formatAmount(amount)
        {

            if (
                amount === null ||
                amount === undefined ||
                amount === ''
            )
            {
                return '0';
            }


            return Number(amount).toLocaleString('en-US');

        }


        /* ============================================================
           CLOSE STUDENT FEE HISTORY
        ============================================================= */

        function closeFeeHistory()
        {

            const modal =
                document.getElementById('feeHistoryModal');


            modal.classList.add('hidden');


            document.body.classList.remove('overflow-hidden');

        }


        /* ============================================================
           ESC KEY CLOSE
        ============================================================= */

        document.addEventListener('keydown', function(event)
        {

            if (event.key === 'Escape')
            {
                closeFeeHistory();
            }

        });

    </script>


</x-app-layout>