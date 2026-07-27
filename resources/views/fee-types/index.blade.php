<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Fee Types
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

                <div class="flex justify-end mb-6">

                    <a href="{{ route('fee-types.create') }}">
                        <x-primary-button>
                            Add Fee Type
                        </x-primary-button>
                    </a>

                </div>

                <table class="w-full border border-gray-300 border-collapse">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border p-3">#</th>
                            <th class="border p-3">Fee Type</th>
                            <th class="border p-3">Created At</th>
                            <th class="border p-3">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($feeTypes as $feeType)

                            <tr>

                                <td class="border p-3 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border p-3">
                                    {{ $feeType->fee_name }}
                                </td>

                                <td class="border p-3 text-center">
                                    {{ $feeType->created_at->format('d-m-Y') }}
                                </td>

                                <td class="border p-3 text-center">

                                    <div class="flex justify-center items-center gap-3">

                                        <a href="{{ route('fee-types.edit', $feeType->id) }}"
                                           class="text-blue-600 hover:text-blue-800 text-xl">
                                            ✏️
                                        </a>

                                        <form action="{{ route('fee-types.destroy', $feeType->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this Fee Type?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-xl">
                                                🗑
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="border p-4 text-center text-gray-500">

                                    No Fee Types Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>