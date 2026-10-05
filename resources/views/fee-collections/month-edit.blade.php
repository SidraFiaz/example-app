<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Month Fees
            </h2>

            <div class="text-sm text-gray-500 mt-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                    Home
                </a>
                <span class="mx-1">/</span>
                <a
                    href="{{ route('fee-collections.show', $fee_collection->id) }}"
                    class="text-blue-600 hover:underline"
                >
                    Fee Records
                </a>
                <span class="mx-1">/</span>
                <span>Edit {{ $monthLabel }} {{ $year }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-base font-semibold text-gray-900">
                        {{ $fee_collection->student->name ?? '-' }} — {{ $monthLabel }} {{ $year }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Update amounts for each fee in this month. Individual records are kept separate.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('fee-collections.month-update', $fee_collection->id) }}"
                    class="p-5"
                >
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-2.5 px-3 font-semibold text-gray-700">#</th>
                                    <th class="text-left py-2.5 px-3 font-semibold text-gray-700">Fee Name</th>
                                    <th class="text-left py-2.5 px-3 font-semibold text-gray-700">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthRecords as $index => $record)
                                    @php
                                        $feeName = $record->fee->description
                                            ?? (
                                                $record->feeType
                                                && ! in_array($record->feeType->fee_name, ['Fee', 'Discount'], true)
                                                    ? $record->feeType->fee_name
                                                    : null
                                            )
                                            ?? '-';
                                    @endphp
                                    <tr class="border-b border-gray-100">
                                        <td class="py-2.5 px-3 text-gray-500">{{ $index + 1 }}</td>
                                        <td class="py-2.5 px-3 text-gray-800">{{ $feeName }}</td>
                                        <td class="py-2.5 px-3">
                                            <input
                                                type="number"
                                                name="amounts[{{ $record->id }}]"
                                                value="{{ old('amounts.'.$record->id, $record->amount) }}"
                                                min="0"
                                                step="0.01"
                                                required
                                                class="w-full max-w-[180px] h-10 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                            >
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @error('amounts')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <div class="mt-6 flex items-center gap-3">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-md bg-black hover:bg-gray-800 text-white text-sm font-medium"
                        >
                            Update Fees
                        </button>

                        <a
                            href="{{ route('fee-collections.show', $fee_collection->id) }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-md border border-gray-300 bg-white text-gray-800 text-sm font-medium hover:bg-gray-50"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
