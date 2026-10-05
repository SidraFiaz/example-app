<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ \App\Support\BrowserTitle::make(isset($title) ? trim(strip_tags((string) $title)) : null) }}
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $initialOpenMenu = null;

    if (request()->routeIs('student.*', 'admission.*', 'admission-tests.*', 'classes*', 'student-promotions.*', 'register-students.*', 'parent-meetings.*', 'adjustment.*', 'attendance.*')) {
        $initialOpenMenu = 'students';
    } elseif (request()->routeIs('subjects.*', 'exams.*', 'grades.*', 'result-grades.*', 'student-marks.*', 'class-groups.*', 'date-sheets.*')) {
        $initialOpenMenu = 'academics';
    } elseif (request()->routeIs('paper-funds.*', 'advance-fees.*', 'discounts.*')) {
        $initialOpenMenu = 'fees';
    } elseif (request()->routeIs('sessions.*', 'session-periods.*', 'fees.*', 'fee-types.*', 'fee-collections.*', 'fee-process.*', 'class-fees.*')) {
        $initialOpenMenu = 'settings';
    } elseif (request()->routeIs('transport.*', 'schedules.*')) {
        $initialOpenMenu = 'userManagement';
    }
@endphp

<body
    class="font-sans antialiased bg-gray-100 text-gray-800"
    x-data="{
        sidebarCollapsed: false,
        mobileOpen: false,
        openMenu: {{ $initialOpenMenu ? "'{$initialOpenMenu}'" : 'null' }},
        toggleMenu(menu) {
            this.openMenu = this.openMenu === menu ? null : menu;
        },
        closeMenu() {
            this.openMenu = null;
        },
        isCollapsedDesktop() {
            return this.sidebarCollapsed && !this.mobileOpen;
        },
        isMenuOpen(menu) {
            return this.openMenu === menu;
        },
        showExpandedSubmenu(menu) {
            return this.openMenu === menu && (!this.sidebarCollapsed || this.mobileOpen);
        },
        showFlyout(menu) {
            return this.openMenu === menu && this.sidebarCollapsed && !this.mobileOpen;
        }
    }"
>

    {{-- Mobile overlay --}}
    <div
        x-show="mobileOpen"
        x-transition.opacity
        @click="mobileOpen = false; closeMenu()"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        style="display: none;"
    ></div>

    {{-- ========================================================= --}}
    {{-- LEFT SIDEBAR (ORIGINAL BLACK / DARK) --}}
    {{-- ========================================================= --}}
    <aside
        :class="[
            mobileOpen ? 'translate-x-0' : '-translate-x-full',
            sidebarCollapsed ? 'lg:w-20' : 'lg:w-64',
            isCollapsedDesktop() ? 'overflow-visible' : 'overflow-hidden',
            'lg:translate-x-0'
        ]"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-[#111827] text-gray-200
               flex flex-col transition-all duration-300 ease-in-out"
    >

        {{-- Branding --}}
        <div
            class="flex items-center h-16 border-b border-gray-800 shrink-0"
            :class="isCollapsedDesktop() ? 'justify-center px-2' : 'px-4'"
        >
            <a href="{{ route('dashboard') }}"
               class="min-w-0 w-full"
               :class="isCollapsedDesktop() ? 'flex justify-center' : ''">
                <span
                    x-show="!sidebarCollapsed || mobileOpen"
                    class="block text-[13px] font-semibold text-white leading-snug tracking-wide"
                >
                    School Management System
                </span>
            </a>
        </div>

        {{-- Menu --}}
        <nav
            class="flex-1 py-4 px-2 space-y-1"
            :class="isCollapsedDesktop() ? 'overflow-visible' : 'overflow-y-auto'"
        >

            {{-- Dashboard (no submenu) --}}
            <a href="{{ route('dashboard') }}"
               @click="closeMenu()"
               :class="isCollapsedDesktop() ? 'justify-center px-2' : 'gap-3 px-3'"
               class="flex items-center py-2.5 rounded-md text-sm transition
               {{ request()->routeIs('dashboard')
                    ? 'bg-gray-800 text-white'
                    : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
                </svg>
                <span x-show="!sidebarCollapsed || mobileOpen">Dashboard</span>
            </a>

            {{-- Students --}}
            <div
                class="relative"
                @click.outside="if (isCollapsedDesktop() && openMenu === 'students') closeMenu()"
            >
                <button
                    type="button"
                    @click="toggleMenu('students')"
                    :class="isCollapsedDesktop() ? 'justify-center px-2' : 'justify-between gap-3 px-3'"
                    class="w-full flex items-center py-2.5 rounded-md text-sm transition
                    {{ request()->routeIs('student.*', 'admission.*', 'admission-tests.*', 'classes*', 'student-promotions.*', 'register-students.*', 'parent-meetings.*', 'adjustment.*', 'attendance.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                >
                    <span class="flex items-center min-w-0" :class="isCollapsedDesktop() ? '' : 'gap-3'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 4a4 4 0 100-8 4 4 0 000 8z"/>
                        </svg>
                        <span x-show="!sidebarCollapsed || mobileOpen">Students</span>
                    </span>
                    <svg
                        x-show="!sidebarCollapsed || mobileOpen"
                        :class="isMenuOpen('students') ? 'rotate-180' : ''"
                        class="w-4 h-4 shrink-0 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="showExpandedSubmenu('students')"
                    x-transition
                    class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-1"
                    style="display: none;"
                >
                    <a href="{{ route('student.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('student.index', 'student.show', 'student.edit') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Students
                    </a>
                    <a href="{{ route('admission.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('admission.*') && !request()->routeIs('admission-tests.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Admission
                    </a>
                    <a href="{{ route('admission-tests.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('admission-tests.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Admission Test
                    </a>
                    <a href="{{ route('classes') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('classes*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Classes
                    </a>
                    <a href="{{ route('student-promotions.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('student-promotions.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Student Promotion
                    </a>
                    <a href="{{ route('parent-meetings.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('parent-meetings.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Parent Meeting
                    </a>
                    <a href="{{ route('register-students.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('register-students.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Register Students 9th,10th
                    </a>
                    <a href="{{ route('adjustment.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('adjustment.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Adjustment
                    </a>
                    <a href="{{ route('attendance.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('attendance.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Attendance
                    </a>
                </div>

                <div
                    x-show="showFlyout('students')"
                    x-transition
                    class="absolute left-full top-0 z-[60] ml-1 w-64 max-h-[calc(100vh-5rem)] overflow-y-auto
                           rounded-md bg-[#111827] border border-gray-700 shadow-xl py-2"
                    style="display: none;"
                >
                    <div class="px-4 py-2 text-[11px] font-semibold tracking-wider uppercase text-gray-400">
                        Students Management
                    </div>
                    <a href="{{ route('student.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('student.index', 'student.show', 'student.edit') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Students
                    </a>
                    <a href="{{ route('admission.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('admission.*') && !request()->routeIs('admission-tests.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Admission
                    </a>
                    <a href="{{ route('admission-tests.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('admission-tests.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Admission Test
                    </a>
                    <a href="{{ route('classes') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('classes*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Classes
                    </a>
                    <a href="{{ route('student-promotions.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('student-promotions.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Student Promotion
                    </a>
                    <a href="{{ route('parent-meetings.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('parent-meetings.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Parent Meeting
                    </a>
                    <a href="{{ route('register-students.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('register-students.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Register Students 9th,10th
                    </a>
                    <a href="{{ route('adjustment.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('adjustment.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Adjustment
                    </a>
                    <a href="{{ route('attendance.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('attendance.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Attendance
                    </a>
                </div>
            </div>

            {{-- Academics --}}
            <div
                class="relative"
                @click.outside="if (isCollapsedDesktop() && openMenu === 'academics') closeMenu()"
            >
                <button
                    type="button"
                    @click="toggleMenu('academics')"
                    :class="isCollapsedDesktop() ? 'justify-center px-2' : 'justify-between gap-3 px-3'"
                    class="w-full flex items-center py-2.5 rounded-md text-sm transition
                    {{ request()->routeIs('subjects.*', 'exams.*', 'grades.*', 'result-grades.*', 'student-marks.*', 'class-groups.*', 'date-sheets.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                >
                    <span class="flex items-center min-w-0" :class="isCollapsedDesktop() ? '' : 'gap-3'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span x-show="!sidebarCollapsed || mobileOpen">Academics</span>
                    </span>
                    <svg
                        x-show="!sidebarCollapsed || mobileOpen"
                        :class="isMenuOpen('academics') ? 'rotate-180' : ''"
                        class="w-4 h-4 shrink-0 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="showExpandedSubmenu('academics')"
                    x-transition
                    class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-1"
                    style="display: none;"
                >
                    <a href="{{ route('subjects.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('subjects.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Subjects
                    </a>
                    <a href="{{ route('exams.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('exams.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Exams
                    </a>
                    <a href="{{ route('date-sheets.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('date-sheets.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Date Sheet
                    </a>
                    <a href="{{ route('grades.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('grades.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Grades
                    </a>
                    <a href="{{ route('result-grades.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('result-grades.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Result Grades
                    </a>
                    <a href="{{ route('student-marks.create') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('student-marks.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Student Marks
                    </a>
                    <a href="{{ route('class-groups.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('class-groups.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Class Groups
                    </a>
                </div>

                <div
                    x-show="showFlyout('academics')"
                    x-transition
                    class="absolute left-full top-0 z-[60] ml-1 w-64 max-h-[calc(100vh-5rem)] overflow-y-auto
                           rounded-md bg-[#111827] border border-gray-700 shadow-xl py-2"
                    style="display: none;"
                >
                    <div class="px-4 py-2 text-[11px] font-semibold tracking-wider uppercase text-gray-400">
                        Academics
                    </div>
                    <a href="{{ route('subjects.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('subjects.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Subjects
                    </a>
                    <a href="{{ route('exams.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('exams.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Exams
                    </a>
                    <a href="{{ route('date-sheets.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('date-sheets.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Date Sheet
                    </a>
                    <a href="{{ route('grades.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('grades.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Grades
                    </a>
                    <a href="{{ route('result-grades.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('result-grades.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Result Grades
                    </a>
                    <a href="{{ route('student-marks.create') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('student-marks.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Student Marks
                    </a>
                    <a href="{{ route('class-groups.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('class-groups.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Class Groups
                    </a>
                </div>
            </div>

            {{-- Fees --}}
            <div
                class="relative"
                @click.outside="if (isCollapsedDesktop() && openMenu === 'fees') closeMenu()"
            >
                <button
                    type="button"
                    @click="toggleMenu('fees')"
                    :class="isCollapsedDesktop() ? 'justify-center px-2' : 'justify-between gap-3 px-3'"
                    class="w-full flex items-center py-2.5 rounded-md text-sm transition
                    {{ request()->routeIs('paper-funds.*', 'advance-fees.*', 'discounts.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                >
                    <span class="flex items-center min-w-0" :class="isCollapsedDesktop() ? '' : 'gap-3'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span x-show="!sidebarCollapsed || mobileOpen">Fees</span>
                    </span>
                    <svg
                        x-show="!sidebarCollapsed || mobileOpen"
                        :class="isMenuOpen('fees') ? 'rotate-180' : ''"
                        class="w-4 h-4 shrink-0 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="showExpandedSubmenu('fees')"
                    x-transition
                    class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-1"
                    style="display: none;"
                >
                    <a href="{{ route('paper-funds.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('paper-funds.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Paper Funds
                    </a>
                    <a href="{{ route('advance-fees.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('advance-fees.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Advance Fees
                    </a>
                    <a href="{{ route('discounts.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('discounts.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Discounts
                    </a>
                </div>

                <div
                    x-show="showFlyout('fees')"
                    x-transition
                    class="absolute left-full top-0 z-[60] ml-1 w-64 max-h-[calc(100vh-5rem)] overflow-y-auto
                           rounded-md bg-[#111827] border border-gray-700 shadow-xl py-2"
                    style="display: none;"
                >
                    <div class="px-4 py-2 text-[11px] font-semibold tracking-wider uppercase text-gray-400">
                        Fees
                    </div>
                    <a href="{{ route('paper-funds.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('paper-funds.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Paper Funds
                    </a>
                    <a href="{{ route('advance-fees.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('advance-fees.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Advance Fees
                    </a>
                    <a href="{{ route('discounts.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('discounts.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Discounts
                    </a>
                </div>
            </div>

            {{-- Reports (no submenu) --}}
            <a href="{{ route('reports.index') }}"
               @click="closeMenu()"
               :class="isCollapsedDesktop() ? 'justify-center px-2' : 'gap-3 px-3'"
               class="flex items-center py-2.5 rounded-md text-sm transition
               {{ request()->routeIs('reports.*')
                    ? 'bg-gray-800 text-white'
                    : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span x-show="!sidebarCollapsed || mobileOpen">Reports</span>
            </a>

            {{-- Settings --}}
            <div
                class="relative"
                @click.outside="if (isCollapsedDesktop() && openMenu === 'settings') closeMenu()"
            >
                <button
                    type="button"
                    @click="toggleMenu('settings')"
                    :class="isCollapsedDesktop() ? 'justify-center px-2' : 'justify-between gap-3 px-3'"
                    class="w-full flex items-center py-2.5 rounded-md text-sm transition
                    {{ request()->routeIs('sessions.*', 'session-periods.*', 'fees.*', 'fee-types.*', 'fee-collections.*', 'fee-process.*', 'class-fees.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                >
                    <span class="flex items-center min-w-0" :class="isCollapsedDesktop() ? '' : 'gap-3'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span x-show="!sidebarCollapsed || mobileOpen">Settings</span>
                    </span>
                    <svg
                        x-show="!sidebarCollapsed || mobileOpen"
                        :class="isMenuOpen('settings') ? 'rotate-180' : ''"
                        class="w-4 h-4 shrink-0 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="showExpandedSubmenu('settings')"
                    x-transition
                    class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-1"
                    style="display: none;"
                >
                    <a href="{{ route('sessions.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('sessions.*', 'session-periods.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Sessions
                    </a>
                    <a href="{{ route('fees.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('fees.index', 'fees.show', 'fees.edit') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Fees
                    </a>
                    <a href="{{ route('fee-types.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('fee-types.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Fee Types
                    </a>
                    <a href="{{ route('fees.create') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('fees.create') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Add Fee
                    </a>
                    <a href="{{ route('fee-collections.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('fee-collections.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Receive Fees List
                    </a>
                    <a href="{{ route('fee-process.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('fee-process.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Fee Process
                    </a>
                    <a href="{{ route('fees.index') }}"
                       class="block px-3 py-2 rounded-md text-sm text-gray-400 hover:bg-gray-800 hover:text-white">
                        Class Fees
                    </a>
                </div>

                <div
                    x-show="showFlyout('settings')"
                    x-transition
                    class="absolute left-full top-0 z-[60] ml-1 w-64 max-h-[calc(100vh-5rem)] overflow-y-auto
                           rounded-md bg-[#111827] border border-gray-700 shadow-xl py-2"
                    style="display: none;"
                >
                    <div class="px-4 py-2 text-[11px] font-semibold tracking-wider uppercase text-gray-400">
                        Settings
                    </div>
                    <a href="{{ route('sessions.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('sessions.*', 'session-periods.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Sessions
                    </a>
                    <a href="{{ route('fees.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('fees.index', 'fees.show', 'fees.edit') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Fees
                    </a>
                    <a href="{{ route('fee-types.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('fee-types.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Fee Types
                    </a>
                    <a href="{{ route('fees.create') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('fees.create') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Add Fee
                    </a>
                    <a href="{{ route('fee-collections.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('fee-collections.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Receive Fees List
                    </a>
                    <a href="{{ route('fee-process.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('fee-process.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Fee Process
                    </a>
                    <a href="{{ route('fees.index') }}"
                       class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white">
                        Class Fees
                    </a>
                </div>
            </div>

            {{-- User Management --}}
            <div
                class="relative"
                @click.outside="if (isCollapsedDesktop() && openMenu === 'userManagement') closeMenu()"
            >
                <button
                    type="button"
                    @click="toggleMenu('userManagement')"
                    :class="isCollapsedDesktop() ? 'justify-center px-2' : 'justify-between gap-3 px-3'"
                    class="w-full flex items-center py-2.5 rounded-md text-sm transition
                    {{ request()->routeIs('transport.*', 'schedules.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                >
                    <span class="flex items-center min-w-0" :class="isCollapsedDesktop() ? '' : 'gap-3'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span x-show="!sidebarCollapsed || mobileOpen">User Management</span>
                    </span>
                    <svg
                        x-show="!sidebarCollapsed || mobileOpen"
                        :class="isMenuOpen('userManagement') ? 'rotate-180' : ''"
                        class="w-4 h-4 shrink-0 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="showExpandedSubmenu('userManagement')"
                    x-transition
                    class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-1"
                    style="display: none;"
                >
                    <a href="{{ route('transport.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('transport.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Transport
                    </a>
                    <a href="{{ route('schedules.index') }}"
                       class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('schedules.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Time Table
                    </a>
                </div>

                <div
                    x-show="showFlyout('userManagement')"
                    x-transition
                    class="absolute left-full top-0 z-[60] ml-1 w-64 max-h-[calc(100vh-5rem)] overflow-y-auto
                           rounded-md bg-[#111827] border border-gray-700 shadow-xl py-2"
                    style="display: none;"
                >
                    <div class="px-4 py-2 text-[11px] font-semibold tracking-wider uppercase text-gray-400">
                        User Management
                    </div>
                    <a href="{{ route('transport.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('transport.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Transport
                    </a>
                    <a href="{{ route('schedules.index') }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('schedules.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Time Table
                    </a>
                </div>
            </div>

        </nav>
    </aside>

    {{-- ========================================================= --}}
    {{-- MAIN CONTENT AREA --}}
    {{-- ========================================================= --}}
    <div
        :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'"
        class="min-h-screen transition-all duration-300"
    >

        {{-- Top header (ORIGINAL LIGHT NAVBAR) --}}
        <header class="sticky top-0 z-30 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6">

            <button
                type="button"
                @click="
                    if (window.innerWidth < 1024) {
                        mobileOpen = !mobileOpen;
                    } else {
                        sidebarCollapsed = !sidebarCollapsed;
                        closeMenu();
                    }
                "
                class="inline-flex items-center justify-center w-10 h-10 rounded-full
                       bg-white border border-gray-200 shadow-sm
                       text-gray-700 hover:bg-gray-50"
                aria-label="Toggle sidebar"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="relative" x-data="{ open: false }">
                @auth
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100"
                    >
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50"
                        style="display: none;"
                    >
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Log Out
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-black">
                        Login
                    </a>
                @endauth
            </div>
        </header>

        @isset($header)
            <div class="bg-white border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8 py-5">
                    {{ $header }}
                </div>
            </div>
        @endisset

        <main class="min-h-[calc(100vh-4rem)]">
            @if(isset($slot))
                {{ $slot }}
            @elseif(View::hasSection('content'))
                @yield('content')
            @endif
        </main>

    </div>

    {{-- ========================================================= --}}
    {{-- GLOBAL DELETE CONFIRMATION MODAL --}}
    {{-- ========================================================= --}}
    <div
        id="global-delete-modal"
        class="fixed inset-0 z-[100] hidden"
        aria-hidden="true"
    >
        <div
            class="absolute inset-0 bg-black/50"
            data-delete-modal-cancel
        ></div>

        <div class="relative flex min-h-full items-center justify-center p-4">
            <div
                class="w-full max-w-md rounded-lg bg-white shadow-xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="global-delete-modal-title"
            >
                <div class="px-6 pt-6 pb-2">
                    <h3
                        id="global-delete-modal-title"
                        class="text-lg font-semibold text-gray-900"
                    >
                        Confirm Delete
                    </h3>
                    <p
                        id="global-delete-modal-message"
                        class="mt-3 text-sm text-gray-700 leading-relaxed"
                    >
                        Are you sure you want to delete this item?
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-5">
                    <button
                        type="button"
                        data-delete-modal-cancel
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md
                               border border-gray-300 bg-white text-gray-800 text-sm font-medium
                               hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300"
                    >
                        CANCEL
                    </button>

                    <button
                        type="button"
                        id="global-delete-modal-confirm"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md
                               bg-red-600 hover:bg-red-700 text-white text-sm font-medium
                               focus:outline-none focus:ring-2 focus:ring-red-500"
                    >
                        DELETE
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- GLOBAL ALERT / NOTICE MODAL (same style as delete modal) --}}
    {{-- ========================================================= --}}
    <div
        id="global-alert-modal"
        class="fixed inset-0 z-[100] hidden"
        aria-hidden="true"
    >
        <div
            class="absolute inset-0 bg-black/50"
            data-alert-modal-close
        ></div>

        <div class="relative flex min-h-full items-center justify-center p-4">
            <div
                class="w-full max-w-md rounded-lg bg-white shadow-xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="global-alert-modal-title"
            >
                <div class="px-6 pt-6 pb-2">
                    <h3
                        id="global-alert-modal-title"
                        class="text-lg font-semibold text-gray-900"
                    >
                        Notice
                    </h3>
                    <p
                        id="global-alert-modal-message"
                        class="mt-3 text-sm text-gray-700 leading-relaxed"
                    ></p>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-5">
                    <button
                        type="button"
                        id="global-alert-modal-ok"
                        data-alert-modal-close
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md
                               bg-black hover:bg-gray-800 text-white text-sm font-medium
                               focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('global-delete-modal');
            if (!modal) return;

            const messageEl = document.getElementById('global-delete-modal-message');
            const confirmBtn = document.getElementById('global-delete-modal-confirm');
            let pendingForm = null;

            function openDeleteModal(form) {
                pendingForm = form;
                const message = form.getAttribute('data-delete-confirm')
                    || 'Are you sure you want to delete this item?';
                messageEl.textContent = message;
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
            }

            function closeDeleteModal() {
                pendingForm = null;
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
            }

            document.addEventListener('submit', function (event) {
                const form = event.target;

                if (!(form instanceof HTMLFormElement)) return;
                if (!form.hasAttribute('data-delete-confirm')) return;
                if (form.dataset.deleteConfirmed === '1') return;

                event.preventDefault();
                event.stopPropagation();
                openDeleteModal(form);
            }, true);

            confirmBtn.addEventListener('click', function () {
                if (!pendingForm) return;

                const form = pendingForm;
                form.dataset.deleteConfirmed = '1';
                closeDeleteModal();
                form.submit();
            });

            modal.querySelectorAll('[data-delete-modal-cancel]').forEach(function (el) {
                el.addEventListener('click', function () {
                    closeDeleteModal();
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeDeleteModal();
                }
            });
        })();

        (function () {
            const alertModal = document.getElementById('global-alert-modal');
            if (!alertModal) return;

            const alertMessageEl = document.getElementById('global-alert-modal-message');
            const alertOkBtn = document.getElementById('global-alert-modal-ok');

            function closeAlertModal() {
                alertModal.classList.add('hidden');
                alertModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
            }

            window.showAppAlert = function (message) {
                alertMessageEl.textContent = message || '';
                alertModal.classList.remove('hidden');
                alertModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
                if (alertOkBtn) {
                    alertOkBtn.focus();
                }
            };

            alertModal.querySelectorAll('[data-alert-modal-close]').forEach(function (el) {
                el.addEventListener('click', closeAlertModal);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !alertModal.classList.contains('hidden')) {
                    closeAlertModal();
                }
            });
        })();
    </script>

</body>

</html>
