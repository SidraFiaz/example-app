<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Fee Collection Details
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <table class="w-full border border-gray-300">

                    <tr>
                        <th class="border p-3 text-left">Student</th>
                        <td class="border p-3">
                            {{ $fee_collection->student->name }}
                        </td>
                    </tr>

                    <tr>
                        <th class="border p-3 text-left">Class</th>
                        <td class="border p-3">
                            {{ $fee_collection->student->studentClass->class_name }}
                        </td>
                    </tr>

                    <tr>
                        <th class="border p-3 text-left">Amount</th>
                        <td class="border p-3">
                            Rs. {{ number_format($fee_collection->amount) }}
                        </td>
                    </tr>

                    <tr>
                        <th class="border p-3 text-left">Payment Date</th>
                        <td class="border p-3">
                            {{ \Carbon\Carbon::parse($fee_collection->payment_date)->format('d-m-Y') }}
                        </td>
                    </tr>

                    <tr>
                        <th class="border p-3 text-left">Status</th>
                        <td class="border p-3">
                            {{ $fee_collection->status }}
                        </td>
                    </tr>

                    <tr>
                        <th class="border p-3 text-left">Remarks</th>
                        <td class="border p-3">
                            {{ $fee_collection->remarks ?? 'N/A' }}
                        </td>
                    </tr>

                </table>

                <div class="mt-6 flex gap-3">

                    <a href="{{ route('fee-collections.index') }}">
                        <x-secondary-button>
                            Back
                        </x-secondary-button>
                    </a>

                    <a href="{{ route('fee-collections.edit', $fee_collection->id) }}">
                        <x-primary-button>
                            Edit
                        </x-primary-button>
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>