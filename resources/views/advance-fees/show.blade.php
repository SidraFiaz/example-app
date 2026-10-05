<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-2xl font-normal text-gray-800">
                Advance Fee
            </h2>

            <div class="flex items-center gap-2 text-sm mt-1">

                <a
                    href="{{ route('advance-fees.index') }}"
                    class="text-blue-600 hover:text-blue-800"
                >
                    Home
                </a>

                <span class="text-gray-400">/</span>

                <span class="text-gray-500">
                    Show Advance Fee
                </span>

            </div>

        </div>

    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg p-9">

                <!-- Title -->
                <h3
                    class="text-xl font-medium text-gray-900
                           pb-5 border-b border-gray-300"
                >
                    Student Advance Adjustment
                </h3>


                <!-- Table -->
                <div class="mt-5 overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>

                            <tr class="border-b-2 border-gray-300">

                                <th
                                    class="text-left px-2 py-2
                                           text-lg font-semibold
                                           text-gray-600"
                                >
                                    Receive Id
                                </th>

                                <th
                                    class="text-left px-2 py-2
                                           text-lg font-semibold
                                           text-gray-600"
                                >
                                    Receive date
                                </th>

                                <th
                                    class="text-left px-2 py-2
                                           text-lg font-semibold
                                           text-gray-600"
                                >
                                    Fee Amount
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <tr class="border-b border-gray-200">

                                {{-- Actual Advance Fee ID --}}
                                <td
                                    class="px-2 py-3
                                           text-lg text-gray-600"
                                >
                                    {{ $advanceFee->id }}
                                </td>


                                {{-- Actual Payment Date --}}
                                <td
                                    class="px-2 py-3
                                           text-lg text-gray-600"
                                >
                                    {{ $advanceFee->payment_date
                                        ? \Carbon\Carbon::parse($advanceFee->payment_date)->format('d-m-Y')
                                        : '-' }}
                                </td>


                                {{-- Actual Advance Amount --}}
                                <td
                                    class="px-2 py-3
                                           text-lg text-gray-600"
                                >
                                    {{ number_format($advanceFee->amount, 0) }}
                                </td>

                            </tr>

                        </tbody>


                        <!-- Total -->
                        <tfoot>

                            <tr class="bg-gray-100">

                                <td></td>

                                <td
                                    class="px-2 py-3
                                           text-right
                                           text-lg
                                           font-semibold
                                           text-gray-700"
                                >
                                    Total
                                </td>

                                <td
                                    class="px-2 py-3
                                           text-lg
                                           text-gray-600"
                                >
                                    {{ number_format($advanceFee->amount, 0) }}
                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>