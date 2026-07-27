<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Fees
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

                <div class="flex justify-between mb-6">

                    <form action="{{ route('fees.index') }}" method="GET" class="flex gap-2">

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search Class"
                            class="border rounded-md px-3 py-2">

                        <x-primary-button>
                            Search
                        </x-primary-button>

                    </form>

                    

                </div>

                <table class="w-full border border-gray-300">

                    <thead class="bg-gray-100">
                        <tr>
                           <th class="border p-3">#</th>
<th class="border p-3">Class Name</th>
<th class="border p-3">Created At</th>
<th class="border p-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                       @forelse($classes as $class)

                            <tr>

                                <td class="border p-3 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border p-3">
    {{ $class->class_name }}
</td>

                                <td class="border p-3">
    {{ $class->created_at->format('d M Y') }}
</td>

                                

                                <td class="border p-3 text-center">

    <a href="{{ route('class-fees.create', $class->id) }}"
        class="text-green-600 text-xl">
        ➕
    </a>

    <a href="{{ route('class-fees.index', $class->id) }}"
        class="text-blue-600 text-xl ml-4">
        👁️
    </a>

</td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="border p-4 text-center">
                                    No Fees Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>