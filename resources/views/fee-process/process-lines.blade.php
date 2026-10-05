<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Fee Process Lines
            </h2>

            <a href="{{ route('fee-process.index') }}"
               class="bg-black text-white px-4 py-2 rounded">
                Process New Fee
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Total Students</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $fees->unique('student_id')->count() }}
                        </p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Total Fee Lines</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $fees->count() }}
                        </p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Processed</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $fees->where('status', 'Processed')->count() }}
                        </p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="text-2xl font-bold text-gray-800">
                            Rs. {{ number_format($fees->sum('amount'), 2) }}
                        </p>
                    </div>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full border border-gray-200">

                        <thead class="bg-gray-100">

                            <tr>
                                <th class="border px-4 py-3 text-left">#</th>
                                <th class="border px-4 py-3 text-left">Student</th>
                                <th class="border px-4 py-3 text-left">Class</th>
                                <th class="border px-4 py-3 text-left">Fee Type</th>
                                <th class="border px-4 py-3 text-left">Month</th>
                                <th class="border px-4 py-3 text-left">Amount</th>
                                <th class="border px-4 py-3 text-left">Issue Date</th>
                                <th class="border px-4 py-3 text-left">Due Date</th>
                                <th class="border px-4 py-3 text-left">Status</th>
                                <th class="border px-4 py-3 text-left">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($fees as $fee)

                                <tr class="hover:bg-gray-50">

                                    <td class="border px-4 py-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border px-4 py-3 font-medium">
                                        {{ $fee->student->name ?? 'N/A' }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        {{ $fee->studentClass->class_name ?? 'N/A' }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        {{ $fee->feeType->fee_name ?? 'N/A' }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        {{ $fee->month }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        Rs. {{ number_format($fee->amount, 2) }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        {{ $fee->issue_date }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        {{ $fee->due_date }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        <span class="px-3 py-1 rounded text-sm bg-gray-200 text-gray-800">
                                            {{ $fee->status }}
                                        </span>
                                    </td>

                                    <td class="border px-4 py-3">

                                        <div class="action-btn-group">

                                            <a href="{{ route('fee-process.show', $fee->id) }}"
                                               class="action-btn bg-gray-700 hover:bg-gray-800 text-white">
                                                View
                                            </a>

                                            <form action="{{ route('fee-process.destroy', $fee->id) }}"
                                                  method="POST"
                                                  data-delete-confirm="Are you sure you want to delete this fee?">
                                                @csrf
                                                @method('DELETE')
                                                <x-action-delete />
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="10"
                                        class="border px-4 py-6 text-center text-gray-500">
                                        No fee process lines found.
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