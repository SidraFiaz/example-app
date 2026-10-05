
<!-- Primary Navigation Menu -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="flex justify-between h-16">

        <div class="flex">

            <!-- Logo -->
            <div class="shrink-0 flex items-center">

                <a href="{{ route('dashboard') }}">

                    <x-application-logo
                        class="block h-9 w-auto fill-current text-gray-800"
                    />

                </a>

            </div>


            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-2">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="px-3 py-2 text-sm font-medium
                   {{ request()->routeIs('dashboard')
                        ? 'text-black border-b-2 border-black'
                        : 'text-gray-600 hover:text-black' }}">

                    Dashboard

                </a>


                {{-- Students Dropdown --}}
<div x-data="{ open: false }" class="relative">

    <button
        @click="open = !open"
        @click.outside="open = false"
        class="inline-flex items-center px-3 py-2 text-sm font-medium
        text-gray-600 hover:text-black">

        Students

        <svg class="ml-1 h-4 w-4"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"/>

        </svg>

    </button>


    <div
        x-show="open"
        x-transition
        class="absolute left-0 mt-2 w-52 bg-white border border-gray-200
        rounded-md shadow-lg z-50">

        {{-- Students --}}
        <a href="{{ route('student.index') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Students

        </a>


        {{-- Admission --}}
        <a href="{{ route('admission.index') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Admission

        </a>


        {{-- Classes --}}
        <a href="{{ route('classes') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Classes

        </a>


        {{-- Student Promotion --}}
        <a href="{{ route('student-promotions.index') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Student Promotion

        </a>


        {{-- Promotion History --}}
        <a href="{{ route('student-promotions.history') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Promotion History

        </a>


        {{-- Adjustment --}}
        <a href="{{ route('adjustment.index') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Adjustment

        </a>


        {{-- Student Attendance --}}
        <a href="{{ route('attendance.index') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Student Attendance

        </a>

    </div>

</div>

                <!-- Academics Dropdown -->
                <div x-data="{ open: false }" class="relative">

                    <button
                        @click="open = !open"
                        @click.outside="open = false"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium
                        text-gray-600 hover:text-black">

                        Academics

                        <svg class="ml-1 h-4 w-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>

                        </svg>

                    </button>


                    <div
                        x-show="open"
                        x-transition
                        class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">

                        <!-- Class Group -->
<a href="{{ route('class-groups.index') }}"
   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

    Class Group

</a>
                        <!-- Subjects -->
                        <a href="{{ route('subjects.index') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Subjects

                        </a>

                        <!-- Exams -->
                        <a href="{{ route('exams.index') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Exams

                        </a>

                        <!-- Grades -->
                        <a href="{{ route('grades.index') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Grades

                        </a>

                        <!-- Student Marks -->
                        <a href="{{ route('student-marks.create') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Student Marks

                        </a>

                    </div>

                </div>


                <!-- Fees Dropdown -->
                <div x-data="{ open: false }" class="relative">

                    <button
                        @click="open = !open"
                        @click.outside="open = false"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium
                        text-gray-600 hover:text-black">

                        Fees

                        <svg class="ml-1 h-4 w-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>

                        </svg>

                    </button>


                    <div
                        x-show="open"
                        x-transition
                        class="absolute left-0 mt-2 w-52 bg-white border border-gray-200 rounded-md shadow-lg z-50">

                        <!-- Fees -->
                        <a href="{{ route('fees.index') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Fees

                        </a>

                        <!-- Fee Types -->
                        <a href="{{ route('fee-types.index') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Fee Types

                        </a>

                        <!-- Receive Fees List -->
                        <a href="{{ route('fee-collections.index') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Receive Fees List

                        </a>

                        <!-- Fee Process -->
                        <a href="{{ route('fee-process.index') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Fee Process

                        </a>

                        <!-- Processed Fees -->
                        <a href="{{ route('fee-process.list') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Processed Fees

                        </a>

                        <!-- Class Fees -->
                        <a href="{{ route('classes') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            Class Fees

                        </a>

                        {{-- Advance Fees --}}
<a href="{{ route('advance-fees.index') }}"
   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

    Advance Fees

</a>

                    </div>

                </div>


       <!-- Setting Dropdown -->
<div x-data="{ open: false }" class="relative">

    <button
        @click="open = !open"
        @click.outside="open = false"
        class="inline-flex items-center px-3 py-2 text-sm font-medium
        text-gray-600 hover:text-black">

        Settings

        <svg class="ml-1 h-4 w-4"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"/>

        </svg>

    </button>

    <div
        x-show="open"
        x-transition
        class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">

        <!-- Session -->
        <a href="{{ route('sessions.index') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">

            Session

        </a>

    </div>

</div>

                </div>

            </div>

        </div>


        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">

            <x-dropdown align="right" width="48">

                <x-slot name="trigger">

                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent
                        text-sm leading-4 font-medium rounded-md text-gray-500 bg-white
                        hover:text-gray-700 focus:outline-none transition">

                        <div>
                            {{ Auth::user()->name }}
                        </div>

                        <div class="ms-1">

                            <svg
                                class="fill-current h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">

                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />

                            </svg>

                        </div>

                    </button>

                </x-slot>


                <x-slot name="content">

                    <!-- Profile -->
                    <x-dropdown-link :href="route('profile.edit')">

                        {{ __('Profile') }}

                    </x-dropdown-link>


                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <x-dropdown-link
                            :href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">

                            {{ __('Log Out') }}

                        </x-dropdown-link>

                    </form>

                </x-slot>

            </x-dropdown>

        </div>


        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">

            <button
                @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md
                text-gray-400 hover:text-gray-500 hover:bg-gray-100
                focus:outline-none transition">

                <svg
                    class="h-6 w-6"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 24 24">

                    <path
                        :class="{'hidden': open, 'inline-flex': ! open}"
                        class="inline-flex"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />

                    <path
                        :class="{'hidden': ! open, 'inline-flex': open}"
                        class="hidden"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />

                </svg>

            </button>

        </div>

    </div>

</div>


<!-- Responsive Navigation Menu -->
<div
    :class="{'block': open, 'hidden': ! open}"
    class="hidden sm:hidden">

    <div class="pt-2 pb-3 space-y-1">

        <!-- Dashboard -->
        <x-responsive-nav-link
            :href="route('dashboard')"
            :active="request()->routeIs('dashboard')">

            Dashboard

        </x-responsive-nav-link>


        <!-- Students -->
        <div x-data="{ open: false }">

            <button
                @click="open = !open"
                class="w-full flex justify-between items-center px-4 py-2
                text-sm text-gray-700">

                Students

                <span>⌄</span>

            </button>

            <div x-show="open" class="pl-6">

                <a href="{{ route('student.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Students

                </a>

                <a href="{{ route('classes') }}"
                   class="block py-2 text-sm text-gray-600">

                    Classes

                </a>

            </div>

        </div>


        <!-- Academics -->
        <div x-data="{ open: false }">

            <button
                @click="open = !open"
                class="w-full flex justify-between items-center px-4 py-2
                text-sm text-gray-700">

                Academics

                <span>⌄</span>

            </button>

            <div x-show="open" class="pl-6">

                <a href="{{ route('subjects.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Subjects

                </a>

                <a href="{{ route('exams.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Exams

                </a>

                <a href="{{ route('grades.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Grades

                </a>

                <a href="{{ route('student-marks.create') }}"
                   class="block py-2 text-sm text-gray-600">

                    Student Marks

                </a>

            </div>

        </div>


        <!-- Fees -->
        <div x-data="{ open: false }">

            <button
                @click="open = !open"
                class="w-full flex justify-between items-center px-4 py-2
                text-sm text-gray-700">

                Fees

                <span>⌄</span>

            </button>

            <div x-show="open" class="pl-6">

                <a href="{{ route('fees.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Fees

                </a>

                <a href="{{ route('fee-types.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Fee Types

                </a>

                <a href="{{ route('fee-collections.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Receive Fees List

                </a>

                <a href="{{ route('fee-process.index') }}"
                   class="block py-2 text-sm text-gray-600">

                    Fee Process

                </a>

                <a href="{{ route('fee-process.list') }}"
                   class="block py-2 text-sm text-gray-600">

                    Processed Fees

                </a>

                <a href="{{ route('classes') }}"
                   class="block py-2 text-sm text-gray-600">

                    Class Fees

                </a>

            </div>

        </div>


        <!-- Reports -->
        <div x-data="{ open: false }">

            <button
                @click="open = !open"
                class="w-full flex justify-between items-center px-4 py-2
                text-sm text-gray-700">

                Reports

                <span>⌄</span>

            </button>

            <div x-show="open" class="pl-6">

                <a href="{{ route('reports.index') }}"
                   class="block py-2 text-sm text-gray-600">
                    School Reports
                </a>

            </div>

        </div>

    </div>


    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200">

        <div class="px-4">

            <div class="font-medium text-base text-gray-800">

                {{ Auth::user()->name }}

            </div>

            <div class="font-medium text-sm text-gray-500">

                {{ Auth::user()->email }}

            </div>

        </div>


        <div class="mt-3 space-y-1">

            <!-- Profile -->
            <x-responsive-nav-link :href="route('profile.edit')">

                Profile

            </x-responsive-nav-link>


            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <x-responsive-nav-link
                    :href="route('logout')"
                    onclick="event.preventDefault();
                    this.closest('form').submit();">

                    Log Out

                </x-responsive-nav-link>

            </form>

        </div>

    </div>

</div>

