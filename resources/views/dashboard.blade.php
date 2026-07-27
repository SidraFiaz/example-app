<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="bg-white shadow rounded-lg p-6 mb-8">

                <h2 class="text-2xl font-bold text-gray-800">
                    Welcome to School Management System
                </h2>

                <p class="text-gray-600 mt-2">
                    Manage students, classes, subjects and fee collections from one dashboard.
                </p>

            </div>

            <!-- Statistics Cards -->

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Students -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-600">

                    <h3 class="text-gray-500 font-semibold">
                        Total Students
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $totalStudents }}
                    </p>

                </div>

                <!-- Classes -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-600">

                    <h3 class="text-gray-500 font-semibold">
                        Total Classes
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $totalClasses }}
                    </p>

                </div>

                <!-- Subjects -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-yellow-500">

                    <h3 class="text-gray-500 font-semibold">
                        Total Subjects
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $totalSubjects }}
                    </p>

                </div>

                <!-- Fee Collections -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-purple-600">

                    <h3 class="text-gray-500 font-semibold">
                        Fee Collections
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $totalCollections }}
                    </p>

                </div>

                <!-- Paid Amount -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-emerald-600">

                    <h3 class="text-gray-500 font-semibold">
                        Total Paid Amount
                    </h3>

                    <p class="text-3xl font-bold mt-3">
                        Rs. {{ number_format($totalPaidAmount) }}
                    </p>

                </div>

                <!-- Unpaid Fees -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-red-600">

                    <h3 class="text-gray-500 font-semibold">
                        Unpaid Fees
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $totalUnpaid }}
                    </p>

                </div>

            </div>

            <!-- Recent Fee Collections -->

            <div class="mt-10">

                <div class="bg-white shadow rounded-lg p-6">

                    <h2 class="text-xl font-bold text-gray-800 mb-5">
                        Recent Fee Collections
                    </h2>

                    <table class="w-full border border-gray-300 border-collapse">

                        <thead class="bg-gray-100">

                            <tr>

                                <th class="border p-3">#</th>
                                <th class="border p-3">Student</th>
                                <th class="border p-3">Class</th>
                                <th class="border p-3">Amount</th>
                                <th class="border p-3">Status</th>
                                <th class="border p-3">Payment Date</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($recentCollections as $collection)

                                <tr>

                                    <td class="border p-3 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border p-3">
                                        {{ $collection->student->name }}
                                    </td>

                                    <td class="border p-3">
                                        {{ $collection->student->studentClass->class_name ?? 'N/A' }}
                                    </td>

                                    <td class="border p-3">
                                        Rs. {{ number_format($collection->amount) }}
                                    </td>

                                    <td class="border p-3 text-center">

                                        @if($collection->status == 'Paid')

                                            <span class="px-3 py-1 rounded bg-green-100 text-green-700 font-semibold">
                                                Paid
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded bg-red-100 text-red-700 font-semibold">
                                                Unpaid
                                            </span>

                                        @endif

                                    </td>

                                    <td class="border p-3 text-center">
                                        {{ \Carbon\Carbon::parse($collection->payment_date)->format('d-m-Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="border p-5 text-center text-gray-500">
                                        No Fee Collections Found
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