<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Fee Process Details
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                {{-- Student Information --}}
                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Student Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="font-semibold text-gray-600">
                            Student Code
                        </p>
                        <p class="mt-1">
                            {{ $selectedFee->student->id ?? '' }}
                        </p>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-600">
                            Student
                        </p>
                        <p class="mt-1">
                            {{ $selectedFee->student->name ?? '' }}
                        </p>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-600">
                            Class
                        </p>
                        <p class="mt-1">
                            {{ $selectedFee->studentClass->class_name ?? '' }}
                        </p>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-600">
                            Section
                        </p>
                        <p class="mt-1">
                            {{ $selectedFee->student->section->section_name ?? '' }}
                        </p>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-600">
                            Fee Month
                        </p>
                        <p class="mt-1">
                            {{ $selectedFee->month }} - {{ $selectedFee->year }}
                        </p>
                    </div>

                </div>


                {{-- Multiple Fees --}}
                <div class="mt-10">

                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Fee Details
                    </h3>

                    <div class="overflow-x-auto">

                        <table class="w-full border-collapse">

                            <thead>
                                <tr class="bg-gray-100 text-left">

                                    <th class="px-4 py-3 border">
                                        Fee Type
                                    </th>

                                    <th class="px-4 py-3 border">
                                        Amount
                                    </th>

                                    <th class="px-4 py-3 border">
                                        Status
                                    </th>

                                    <th class="px-4 py-3 border">
                                        Issue Date
                                    </th>

                                    <th class="px-4 py-3 border">
                                        Due Date
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @forelse($fees as $fee)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-3 border">
                                            {{ $fee->feeType->fee_name ?? 'Fee' }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            Rs. {{ number_format($fee->amount) }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $fee->status }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $fee->issue_date ?? '' }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $fee->due_date ?? '' }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="5"
                                            class="text-center py-6 text-gray-500">

                                            No fees found for this month.

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- Total --}}
                <div class="mt-6 flex justify-end">

                    <div class="text-lg font-semibold">

                        Total:
                        Rs. {{ number_format($fees->sum('amount')) }}

                    </div>

                </div>


                {{-- Back --}}
                <div class="mt-8">

                    <a
                        href="{{ route('fee-process.list') }}"
                        class="bg-black text-white px-5 py-2 rounded-lg hover:bg-gray-800">

                        Back

                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>