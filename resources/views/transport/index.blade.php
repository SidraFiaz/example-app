<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Transport
                </h2>

                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:text-blue-800">
                        Home
                    </a>

                    <span class="text-gray-400">/</span>

                    <span class="text-gray-500">
                        Transport view
                    </span>
                </div>
            </div>

            <button
                type="button"
                onclick="document.getElementById('transportModal').classList.remove('hidden')"
                class="bg-black hover:bg-gray-800 text-white
                       px-7 py-2.5 rounded-md text-sm font-medium"
            >
                Create Transport
            </button>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">

                @if(session('success'))
                    <div class="mb-5 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Search --}}
                <div class="mb-7">
                    <label class="block text-sm font-medium text-gray-800 mb-2">
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
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Student</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Class</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Date</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Transport Fee</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Transport Status</th>
                                <th class="px-5 py-3 font-semibold whitespace-nowrap">Action</th>
                            </tr>
                        </thead>

                        <tbody id="transportTable">

                            @forelse($transports as $transport)

                                <tr class="border border-gray-200 transport-row">

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $transport->student->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $transport->student->studentClass->class_name ?? 'N/A' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $transport->date ? $transport->date->format('d-m-Y') : '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $transport->transport_fee !== null ? number_format($transport->transport_fee, 0) : '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        @if($transport->status === 'Active')
                                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                                {{ $transport->status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-2">
                                        <div class="action-btn-group">

                                            <x-action-edit :href="route('transport.edit', $transport->id)" />

                                            <form
                                                action="{{ route('transport.destroy', $transport->id) }}"
                                                method="POST"
                                                data-delete-confirm="Are you sure you want to delete this transport record?"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <x-action-delete />
                                            </form>

                                        </div>
                                    </td>
                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6"
                                        class="px-5 py-10 text-center text-gray-500">
                                        No data available in table
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- Add Transport Modal --}}
    <div
        id="transportModal"
        class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="fixed inset-0 bg-black bg-opacity-50"
            onclick="document.getElementById('transportModal').classList.add('hidden')"
        ></div>

        <div class="relative flex min-h-screen items-center justify-center p-4">

            <div class="relative w-full max-w-5xl bg-white rounded-md shadow-xl">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Add Transport Data
                    </h2>

                    <button
                        type="button"
                        onclick="document.getElementById('transportModal').classList.add('hidden')"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold leading-none"
                    >
                        &times;
                    </button>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('transport.store') }}">
                    @csrf

                    <div class="px-6 py-6">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            {{-- Column 1 --}}
                            <div class="space-y-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Select Student <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        name="student_id"
                                        required
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                        <option value="">Select Student</option>

                                        @foreach($students as $student)
                                            <option
                                                value="{{ $student->id }}"
                                                {{ old('student_id') == $student->id ? 'selected' : '' }}
                                            >
                                                {{ $student->name }}
                                                @if($student->studentClass)
                                                    ({{ $student->studentClass->class_name }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('student_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Vehicle No.
                                    </label>

                                    <input
                                        type="text"
                                        name="vehicle_no"
                                        value="{{ old('vehicle_no') }}"
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Stop Name
                                    </label>

                                    <input
                                        type="text"
                                        name="stop_name"
                                        value="{{ old('stop_name') }}"
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                </div>

                            </div>

                            {{-- Column 2 --}}
                            <div class="space-y-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Date
                                    </label>

                                    <input
                                        type="date"
                                        name="date"
                                        value="{{ old('date', date('Y-m-d')) }}"
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Registration No.
                                    </label>

                                    <input
                                        type="text"
                                        name="registration_no"
                                        value="{{ old('registration_no') }}"
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Select Status <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        name="status"
                                        required
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                        <option value="">Status</option>
                                        <option value="Active" {{ old('status') === 'Active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>

                                    @error('status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- Column 3 --}}
                            <div class="space-y-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Transport Fee
                                    </label>

                                    <input
                                        type="number"
                                        name="transport_fee"
                                        value="{{ old('transport_fee') }}"
                                        min="0"
                                        step="0.01"
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Driver Name
                                    </label>

                                    <input
                                        type="text"
                                        name="driver_name"
                                        value="{{ old('driver_name') }}"
                                        class="w-full h-11 rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2">
                                        Remarks
                                    </label>

                                    <textarea
                                        name="remarks"
                                        rows="4"
                                        class="w-full rounded-md border border-gray-300
                                               focus:border-black focus:ring-black
                                               text-sm text-gray-700"
                                    >{{ old('remarks') }}</textarea>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="flex justify-end gap-3 px-6 py-4 border-t">

                        <button
                            type="button"
                            onclick="document.getElementById('transportModal').classList.add('hidden')"
                            class="bg-black hover:bg-gray-800 text-white
                                   px-6 py-2.5 rounded-md text-sm font-medium"
                        >
                            Close
                        </button>

                        <button
                            type="submit"
                            class="bg-black hover:bg-gray-800 text-white
                                   px-6 py-2.5 rounded-md text-sm font-medium"
                        >
                            Save
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchItems');
            const rows = document.querySelectorAll('.transport-row');

            searchInput.addEventListener('keyup', function () {
                const search = this.value.toLowerCase().trim();

                rows.forEach(function (row) {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(search) ? '' : 'none';
                });
            });
        });
    </script>

</x-app-layout>
