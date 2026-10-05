<x-app-layout>

    <x-slot name="header">

    <div class="flex items-center justify-between">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Session
        </h2>

        <a href="{{ route('sessions.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200
                  border border-transparent rounded-md font-semibold
                  text-xs text-gray-700 uppercase tracking-widest
                  hover:bg-gray-300 transition">
            Back
        </a>

    </div>

</x-slot>


<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm sm:rounded-lg">

            <div class="p-6">

                <form method="POST" action="{{ route('sessions.store') }}">

                    @csrf


                    {{-- Session Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                        {{-- Session From --}}
                        <div>

                            <label
                                for="session_from"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Session From
                                <span class="text-red-600">*</span>
                            </label>

                            <input
                                type="date"
                                name="session_from"
                                id="session_from"
                                value="{{ old('session_from') }}"
                                class="mt-1 block w-full border-gray-300
                                       rounded-md shadow-sm
                                       focus:border-blue-500 focus:ring-blue-500"
                                required
                            >

                            @error('session_from')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Session To --}}
                        <div>

                            <label
                                for="session_to"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Session To
                            </label>

                            <input
                                type="date"
                                name="session_to"
                                id="session_to"
                                value="{{ old('session_to') }}"
                                class="mt-1 block w-full border-gray-300
                                       rounded-md shadow-sm
                                       bg-gray-100
                                       focus:border-blue-500 focus:ring-blue-500"
                                readonly
                            >

                            @error('session_to')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Session Name --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Session Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                placeholder="e.g. 2025-2026"
                                class="mt-1 block w-full border-gray-300
                                       rounded-md shadow-sm
                                       bg-gray-100
                                       focus:border-blue-500 focus:ring-blue-500"
                                readonly
                            >

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- Session Status --}}
                    <div class="mt-6">

                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Session Status
                        </label>

                        <div class="relative inline-flex items-center cursor-pointer">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="sr-only"
                                id="is_active"
                                {{ old('is_active') ? 'checked' : '' }}
                            >

                            <span
                                class="toggle-switch {{ old('is_active') ? 'active' : '' }}"
                                role="switch"
                                aria-checked="{{ old('is_active') ? 'true' : 'false' }}"
                                tabindex="0"
                                onclick="toggleSessionStatus(event)"
                                onkeydown="if(event.key==='Enter'||event.key===' '){toggleSessionStatus(event);}"
                            >
                                <span class="toggle-circle"></span>
                            </span>

                        </div>

                    </div>


                    <style>

                        .toggle-switch {
                            display: block;
                            width: 42px;
                            height: 24px;
                            background: #cbd5e1;
                            border-radius: 9999px;
                            position: relative;
                            transition: 0.2s;
                        }

                        .toggle-circle {
                            position: absolute;
                            width: 20px;
                            height: 20px;
                            background: white;
                            border-radius: 50%;
                            top: 2px;
                            left: 2px;
                            transition: 0.2s;
                            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
                        }

                        .toggle-switch.active {
                            background: #2563eb;
                        }

                        .toggle-switch.active .toggle-circle {
                            transform: translateX(18px);
                        }

                    </style>


                    {{-- Buttons --}}
                    <div class="mt-12 flex justify-center gap-6">

                        {{-- Cancel --}}
                        <a
                            href="{{ route('sessions.index') }}"
                            class="inline-flex items-center justify-center
                                   w-48 h-12
                                   bg-black
                                   border border-black
                                   rounded-md
                                   font-medium
                                   text-base
                                   text-white
                                   hover:bg-gray-800
                                   transition"
                        >
                            Cancel
                        </a>


                        {{-- Save --}}
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center
                                   w-48 h-14
                                   bg-black
                                   border border-black
                                   rounded-md
                                   font-medium
                                   text-base
                                   text-white
                                   hover:bg-gray-800
                                   transition"
                        >
                            Save
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- Automatic Session Calculation --}}
<script>

    document.addEventListener('DOMContentLoaded', function () {

        const sessionFrom = document.getElementById('session_from');
        const sessionTo = document.getElementById('session_to');
        const sessionName = document.getElementById('name');


        function calculateSession() {

            if (!sessionFrom.value) {

                sessionTo.value = '';
                sessionName.value = '';

                return;
            }


            // Get selected date
            const parts = sessionFrom.value.split('-');

            const year = parseInt(parts[0]);
            const month = parseInt(parts[1]) - 1;
            const day = parseInt(parts[2]);


            // Create starting date
            const startDate = new Date(year, month, day);


            // Calculate exactly 12 months session
            const endDate = new Date(year, month, day);

            endDate.setFullYear(endDate.getFullYear() + 1);

            endDate.setDate(endDate.getDate() - 1);


            // Format date as YYYY-MM-DD
            const endYear = endDate.getFullYear();

            const endMonth = String(
                endDate.getMonth() + 1
            ).padStart(2, '0');

            const endDay = String(
                endDate.getDate()
            ).padStart(2, '0');


            sessionTo.value =
                `${endYear}-${endMonth}-${endDay}`;


            // Automatically create Session Name
            sessionName.value =
                `${year}-${endYear}`;

        }


        // When Session From changes
        sessionFrom.addEventListener(
            'change',
            calculateSession
        );


        // Calculate automatically if old value exists
        if (sessionFrom.value) {
            calculateSession();
        }

    });


    // Session Status Toggle
    function toggleSessionStatus(event) {

        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        const checkbox =
            document.getElementById('is_active');

        const toggle =
            checkbox.nextElementSibling;

        checkbox.checked = !checkbox.checked;

        toggle.classList.toggle(
            'active',
            checkbox.checked
        );

        toggle.setAttribute(
            'aria-checked',
            checkbox.checked ? 'true' : 'false'
        );

    }

</script>

</x-app-layout>
