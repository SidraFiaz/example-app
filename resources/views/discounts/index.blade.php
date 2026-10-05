
<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Discounts
            </h2>

            <a href="{{ route('discounts.create') }}"
               class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                Add Discount
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl overflow-hidden">

                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Discount List
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Class</th>
                                <th class="px-6 py-3">Student</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3">Value</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($discounts as $discount)

                                <tr class="border-b hover:bg-gray-50">

                                    <td class="px-6 py-4">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $discount->studentClass->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $discount->student->name ?? 'All Students' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ ucfirst($discount->discount_type) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if(
                                            strtolower($discount->discount_type) === 'percentage' ||
                                            strtolower($discount->discount_type) === 'percent'
                                        )
                                            {{ $discount->discount_value }}%
                                        @else
                                            {{ number_format($discount->discount_value, 2) }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">

                                        @if($discount->status === 'Active')

                                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                                Active
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                                {{ $discount->status }}
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        <form
                                            action="{{ route('discounts.destroy', $discount->id) }}"
                                            method="POST"
                                            data-delete-confirm="Are you sure you want to delete this discount?"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <x-action-delete />
                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        No discounts found.
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

