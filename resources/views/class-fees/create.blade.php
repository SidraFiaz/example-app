<x-app-layout>

    <x-slot name="header">
       <h2 class="font-semibold text-2xl text-gray-800">
    Class Fees
</h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

           <div class="space-y-6">

              @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 rounded p-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('class-fees.store', $studentClass->id) }}" method="POST">

                    @csrf

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Class Id
        </label>

        <input
            type="text"
            value="{{ $studentClass->id }}"
            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3"
            readonly>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Class Name
        </label>

        <input
            type="text"
            value="{{ $studentClass->class_name }}"
            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3"
            readonly>
    </div>

</div>

<input
    type="hidden"
    name="class_id"
    value="{{ $studentClass->id }}">

    <div class="border-t border-gray-200 pt-6 mb-6">
    <h3 class="text-xl font-semibold text-gray-800">
        Add Class Fee
    </h3>
</div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Fee Description
        </label>

        <select
            name="fee_type_id"
            class="w-full rounded-lg border-gray-300">

            <option value="">Select</option>

            @foreach($feeTypes as $feeType)
                <option value="{{ $feeType->id }}">
                    {{ $feeType->fee_name }}
                </option>
            @endforeach

        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Fee Type
        </label>

        <input
            type="text"
            name="fee_type"
            class="w-full rounded-lg border-gray-300">
    </div>

</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Fee Amount
        </label>

        <input
            type="number"
            name="amount"
            placeholder="Enter Fee Amount"
            class="w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Fee Status
        </label>

        <select
            name="status"
            class="w-full rounded-lg border-gray-300">

            <option value="">Select</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>

        </select>
    </div>

</div>

                 <div class="mt-8 flex justify-end gap-3">

    <a href="{{ route('class-fees.index', $studentClass->id) }}"
       class="px-6 py-3 bg-gray-300 hover:bg-gray-400 rounded-lg">
        Cancel
    </a>

    <button
        type="submit"
        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
        Save
    </button>

</div>
              </form>
</div>

        </div>

    </div>

</x-app-layout>