<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Fee Collections
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if(session('success'))
                    <div class="mx-6 mt-6 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex items-center justify-end p-6">

                    <a href="{{ route('fee-collections.create') }}">
                        <x-primary-button>
                            Collect Fee
                        </x-primary-button>
                    </a>

                </div>

                <div class="p-6">

                    <table class="w-full border border-gray-400 border-collapse text-center">

                        <thead>

                            <tr class="bg-gray-200">

                                <th class="border border-gray-400 px-4 py-2">#</th>
                                <th class="border border-gray-400 px-4 py-2">Student</th>
                                <th class="border border-gray-400 px-4 py-2">Class</th>
                                <th class="border border-gray-400 px-4 py-2">Amount</th>
                                <th class="border border-gray-400 px-4 py-2">Payment Date</th>
                                <th class="border border-gray-400 px-4 py-2">Status</th>
                                <th class="border border-gray-400 px-4 py-2">Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($collections as $collection)

                                <tr>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $collection->student->name }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $collection->student->studentClass->class_name ?? 'N/A' }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        Rs. {{ number_format($collection->amount) }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ \Carbon\Carbon::parse($collection->payment_date)->format('d-m-Y') }}
                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">

                                        @if($collection->status == 'Paid')
                                            <span class="text-green-600 font-semibold">
                                                Paid
                                            </span>
                                        @else
                                            <span class="text-red-600 font-semibold">
                                                Unpaid
                                            </span>
                                        @endif

                                    </td>

                                    <td class="border border-gray-400 px-4 py-2">

                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('fee-collections.show', $collection->id) }}">
                                                <x-secondary-button>
                                                    View
                                                </x-secondary-button>
                                            </a>

                                            <a href="{{ route('fee-collections.edit', $collection->id) }}">
                                                <x-primary-button>
                                                    Edit
                                                </x-primary-button>
                                            </a>

                                            <form action="{{ route('fee-collections.destroy', $collection->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this fee collection?')">

                                                @csrf
                                                @method('DELETE')

                                                <x-danger-button>
                                                    Delete
                                                </x-danger-button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="border border-gray-400 px-4 py-6 text-gray-500">
                                        No Fee Collection Found
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