<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            View Monthly Fee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <div class="mb-4">
                    <strong>Class Name:</strong>
                    {{ $fee->studentClass->class_name }}
                </div>

                <div class="mb-4">
                    <strong>Monthly Fee:</strong>
                    Rs. {{ number_format($fee->amount) }}
                </div>

                <div class="mb-4">
                    <strong>Created At:</strong>
                    {{ $fee->created_at->format('d-m-Y') }}
                </div>

                <a href="{{ route('fees.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded">
                    Back
                </a>

            </div>

        </div>
    </div>

</x-app-layout>