<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Class Fees
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
<div class="flex justify-end gap-3 mb-6">

    <a href="{{ route('class-fees.create', $studentClass->id) }}"
        class="inline-flex items-center px-5 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">
        Add Class Fee
    </a>

    <form action="{{ route('class-fees.process', $studentClass->id) }}" method="POST">
        @csrf

        <button type="submit"
            class="px-5 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            Process
        </button>
    </form>

</div>
                <table class="w-full border border-gray-300 border-collapse">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border p-3">#</th>
                            <th class="border p-3">Class</th>
                            <th class="border p-3">Fee Type</th>
                            <th class="border p-3">Amount</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($classFees as $fee)

                            <tr>

                                <td class="border p-3 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border p-3">
                                    {{ $fee->studentClass->class_name }}
                                </td>

                                <td class="border p-3">
                                    {{ $fee->feeType->fee_name }}
                                </td>

                                <td class="border p-3 text-center">
                                    Rs. {{ number_format($fee->amount) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="border p-4 text-center text-gray-500">
                                    No Class Fees Found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>