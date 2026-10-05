<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Advance Fee
                </h2>

                <div class="flex items-center gap-2 text-sm mt-1">

                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:text-blue-800">
                        Home
                    </a>

                    <span class="text-gray-400">/</span>

                    <span class="text-gray-500">
                        View Advance Fee
                    </span>

                </div>
            </div>


            {{-- Create Button --}}
            <a href="{{ route('advance-fees.create') }}"
               class="bg-black hover:bg-gray-800 text-white
                      px-7 py-2.5 rounded-md text-sm font-medium">
                Create
            </a>

        </div>

    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            {{-- Main Card --}}
            <div class="bg-white border border-gray-200
                        rounded-xl shadow-sm p-5">

                {{-- Success Message --}}
                @if(session('success'))

                    <div class="mb-5 px-4 py-3 rounded-md
                                bg-green-100 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>

                @endif


                {{-- Search --}}
                <div class="mb-7">

                    <label class="block text-sm font-medium
                                  text-gray-800 mb-2">
                        Search Items
                    </label>

                    <input
                        type="text"
                        id="searchItems"
                        placeholder=""
                        class="w-full h-11 rounded-md border border-gray-300
                               focus:border-blue-500 focus:ring-blue-500
                               text-sm text-gray-700"
                    >

                </div>


                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="w-full border-collapse text-sm">

                        <thead>

                            <tr class="text-left text-gray-700">

                                <th class="px-5 py-3 font-semibold whitespace-nowrap">
                                    Student Name
                                </th>

                                <th class="px-5 py-3 font-semibold whitespace-nowrap">
                                    Student Class
                                </th>

                                <th class="px-5 py-3 font-semibold whitespace-nowrap">
                                    Advance Fee Receive
                                </th>

                                <th class="px-5 py-3 font-semibold whitespace-nowrap">
                                    Advance amount
                                </th>

                                <th class="px-5 py-3 font-semibold whitespace-nowrap">
                                    Remaining
                                </th>

                                <th class="px-5 py-3 font-semibold whitespace-nowrap">
                                    Adjusted
                                </th>

                                <th class="px-5 py-3 font-semibold whitespace-nowrap">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody id="advanceFeeTable">

                            @forelse($advanceFees as $advanceFee)

                                @php

                                    $amount = (float) $advanceFee->amount;

                                    $adjusted = (float) ($advanceFee->adjusted_amount ?? 0);

                                    $remaining = $amount - $adjusted;

                                @endphp


                                <tr class="border border-gray-200 advance-row">

                                    {{-- Student Name --}}
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $advanceFee->student->name ?? 'N/A' }}
                                    </td>


                                    {{-- Student Class --}}
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $advanceFee->student->studentClass->class_name ?? 'N/A' }}
                                    </td>


                                    {{-- Advance Fee Receive --}}
                                    <td class="px-5 py-4 text-gray-600">

                                        @if($advanceFee->payment_date)

                                            {{ \Carbon\Carbon::parse($advanceFee->payment_date)->format('d-m-Y') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- Advance Amount --}}
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ number_format($amount, 0) }}
                                    </td>


                                    {{-- Remaining --}}
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ number_format($remaining, 0) }}
                                    </td>


                                    {{-- Adjusted --}}
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ number_format($adjusted, 0) }}
                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-5 py-2">

                                        <div class="action-btn-group">

                                            <x-action-edit :href="route('advance-fees.edit', $advanceFee->id)" />

                                            <a href="{{ route('advance-fees.show', $advanceFee->id) }}"
                                               class="action-btn bg-gray-700 hover:bg-gray-800 text-white">
                                                View
                                            </a>

                                            <form
                                                action="{{ route('advance-fees.destroy', $advanceFee->id) }}"
                                                method="POST"
                                                data-delete-confirm="Are you sure you want to delete this advance fee?"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <x-action-delete />
                                            </form>

                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="7"
                                        class="px-5 py-10 text-center text-gray-500">

                                        No Advance Fee records found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- Search Script --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput = document.getElementById('searchItems');

            const rows = document.querySelectorAll('.advance-row');

            searchInput.addEventListener('keyup', function () {

                const search = this.value.toLowerCase().trim();

                rows.forEach(function (row) {

                    const text = row.innerText.toLowerCase();

                    if (text.includes(search)) {

                        row.style.display = '';

                    } else {

                        row.style.display = 'none';

                    }

                });

            });

        });

    </script>

</x-app-layout>