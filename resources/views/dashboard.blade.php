<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">
                    Dashboard
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    School Management System
                </p>
            </div>

            <div class="sm:text-right">
                <p class="text-sm font-medium text-gray-700">
                    Welcome, {{ Auth::user()->name }}
                </p>
            </div>
        </div>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Primary Statistic Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                <div class="bg-[#111827] text-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[140px]">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-sm font-medium text-gray-300">Total Students</h3>
                        <span class="text-2xl leading-none" aria-hidden="true">👨‍🎓</span>
                    </div>
                    <p class="text-4xl font-bold tracking-tight mt-4">{{ $totalStudents }}</p>
                </div>

                <div class="bg-[#111827] text-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[140px]">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-sm font-medium text-gray-300">Total Classes</h3>
                        <span class="text-2xl leading-none" aria-hidden="true">🏫</span>
                    </div>
                    <p class="text-4xl font-bold tracking-tight mt-4">{{ $totalClasses }}</p>
                </div>

                <div class="bg-[#111827] text-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[140px]">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-sm font-medium text-gray-300">Total Subjects</h3>
                        <span class="text-2xl leading-none" aria-hidden="true">📚</span>
                    </div>
                    <p class="text-4xl font-bold tracking-tight mt-4">{{ $totalSubjects }}</p>
                </div>

                <div class="bg-[#111827] text-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[140px]">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-sm font-medium text-gray-300">Receive Fees List</h3>
                        <span class="text-2xl leading-none" aria-hidden="true">💳</span>
                    </div>
                    <p class="text-4xl font-bold tracking-tight mt-4">{{ $totalCollections }}</p>
                </div>

                <div class="bg-[#111827] text-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[140px]">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-sm font-medium text-gray-300">Total Paid Amount</h3>
                        <span class="text-2xl leading-none" aria-hidden="true">💰</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight mt-4">
                        Rs. {{ number_format($totalPaidAmount) }}
                    </p>
                </div>

                <div class="bg-[#111827] text-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[140px]">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-sm font-medium text-gray-300">Unpaid Fees</h3>
                        <span class="text-2xl leading-none" aria-hidden="true">❌</span>
                    </div>
                    <p class="text-4xl font-bold tracking-tight mt-4">{{ $totalUnpaid }}</p>
                </div>

            </div>


            {{-- Secondary Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-500">Total Classes</h3>
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalClasses }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-500">Total Subjects</h3>
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalSubjects }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-500">Receive Fees List</h3>
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-violet-500"></span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalCollections }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-500">Total Paid Amount</h3>
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-teal-500"></span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">
                        Rs. {{ number_format($totalPaidAmount) }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-500">Unpaid Fees</h3>
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalUnpaid }}</p>
                </div>

            </div>


            {{-- Recent Receive Fees List --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Recent Receive Fees List
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Latest fee payment activity
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold">#</th>
                                <th class="px-5 py-3 text-left font-semibold">Student</th>
                                <th class="px-5 py-3 text-left font-semibold">Class</th>
                                <th class="px-5 py-3 text-left font-semibold">Amount</th>
                                <th class="px-5 py-3 text-left font-semibold">Status</th>
                                <th class="px-5 py-3 text-left font-semibold">Payment Date</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($recentCollections as $collection)

                                <tr class="hover:bg-gray-50/80">

                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-5 py-4 font-medium text-gray-900">
                                        {{ $collection->student->name }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $collection->student->studentClass->class_name ?? 'N/A' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-700">
                                        Rs. {{ number_format($collection->amount) }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if($collection->status == 'Paid')
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                Paid
                                            </span>
                                        @else
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                                Unpaid
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-gray-700">
                                        {{ \Carbon\Carbon::parse($collection->payment_date)->format('d-m-Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                        No Receive Fees List Found
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
