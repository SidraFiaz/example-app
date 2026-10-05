<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students') }}
        </h2>
    </x-slot>


    <div class="min-h-screen bg-gray-100">

        {{-- Page Header --}}
        <div class="px-6 pt-6 pb-4">

            <div class="flex items-start justify-between">

                <div>

                    <h1 class="text-2xl font-semibold text-gray-900">
                        Students
                    </h1>

                    <div class="mt-1 text-sm">

                        <a
                            href="{{ route('admission.index') }}"
                            class="text-blue-600 hover:text-blue-800"
                        >
                            Home
                        </a>

                        <span class="mx-2 text-gray-400">/</span>

                        <span class="text-gray-500">
                            Admission Fee
                        </span>

                    </div>

                </div>


                {{-- Student Information --}}
                <div class="bg-gray-200 px-5 py-2 text-sm text-gray-700 min-w-[175px]">

                    <div>
                        <strong>Name:</strong>
                        {{ $admission->student_name }}
                    </div>

                    <div>
                        <strong>Roll No:</strong>
                        {{ $admission->family_no ?? $admission->id }}
                    </div>

                    <div>
                        <strong>Class:</strong>
                        {{ $admission->studentClass->class_name ?? 'N/A' }}
                    </div>

                </div>

            </div>

        </div>


        {{-- Main Card --}}
        <div class="px-6 pb-8">

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

                <div class="grid grid-cols-1 lg:grid-cols-2">


                    {{-- LEFT SIDE --}}
                    <div class="p-6 border-r border-gray-200">

                        <div class="flex items-center justify-between mb-6">

                            <h2 class="text-xl font-medium text-gray-900">
                                Create Admission Fee
                            </h2>

                            <button
                                type="submit"
                                form="admissionFeeForm"
                                class="inline-flex items-center px-4 py-2
                                       bg-blue-600 border border-transparent
                                       rounded-md font-semibold text-xs
                                       text-white uppercase tracking-widest
                                       hover:bg-blue-700"
                            >
                                Save
                            </button>

                        </div>


                        {{-- Success Message --}}
                        @if(session('success'))

                            <div class="mb-5 p-3 bg-green-100 border border-green-300
                                        text-green-700 rounded-md text-sm">

                                {{ session('success') }}

                            </div>

                        @endif


                        {{-- Validation Errors --}}
                        @if($errors->any())

                            <div class="mb-5 p-3 bg-red-100 border border-red-300
                                        text-red-700 rounded-md text-sm">

                                <ul class="list-disc ml-5">

                                    @foreach($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <form
                            id="admissionFeeForm"
                            method="POST"
                            action="{{ route('admission-fees.store', $admission->id) }}"
                        >

                            @csrf


                            {{-- Paper Fund --}}
                            <div class="mb-4">

                                <label class="block text-sm font-semibold text-gray-900 mb-1">
                                    Paper Fund
                                </label>

                                <input
                                    type="number"
                                    name="paper_fund"
                                    value="{{ old('paper_fund') }}"
                                    step="0.01"
                                    min="0"
                                    placeholder="Paper Fund"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                           focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- Prospectus --}}
                            <div class="mb-4">

                                <label class="block text-sm font-semibold text-gray-900 mb-1">
                                    Prospectus
                                </label>

                                <input
                                    type="number"
                                    name="prospectus"
                                    value="{{ old('prospectus') }}"
                                    step="0.01"
                                    min="0"
                                    placeholder="Prospectus"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                           focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- Arrears Opening --}}
                            <div class="mb-4">

                                <label class="block text-sm font-semibold text-gray-900 mb-1">
                                    Arrears Opening
                                </label>

                                <input
                                    type="number"
                                    name="arrears_opening"
                                    value="{{ old('arrears_opening') }}"
                                    step="0.01"
                                    min="0"
                                    placeholder="Arrears Opening"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                           focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- Registration Fee --}}
                            <div class="mb-4">

                                <label class="block text-sm font-semibold text-gray-900 mb-1">
                                    Registration fee
                                </label>

                                <input
                                    type="number"
                                    name="registration_fee"
                                    value="{{ old('registration_fee') }}"
                                    step="0.01"
                                    min="0"
                                    placeholder="Registration fee"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                           focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- Security Fee --}}
                            <div class="mb-4">

                                <label class="block text-sm font-semibold text-gray-900 mb-1">
                                    Security Fee
                                </label>

                                <input
                                    type="number"
                                    name="security_fee"
                                    value="{{ old('security_fee') }}"
                                    step="0.01"
                                    min="0"
                                    placeholder="Security Fee"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                           focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- Annual Charges --}}
                            <div class="mb-4">

                                <label class="block text-sm font-semibold text-gray-900 mb-1">
                                    Annual Charges
                                </label>

                                <input
                                    type="number"
                                    name="annual_charges"
                                    value="{{ old('annual_charges') }}"
                                    step="0.01"
                                    min="0"
                                    placeholder="Annual Charges"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                           focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- Admission Charges --}}
                            <div class="mb-4">

                                <label class="block text-sm font-semibold text-gray-900 mb-1">
                                    ADMISSION CHARGES
                                </label>

                                <input
                                    type="number"
                                    name="admission_charges"
                                    value="{{ old('admission_charges') }}"
                                    step="0.01"
                                    min="0"
                                    placeholder="ADMISSION CHARGES"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                           focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                        </form>

                    </div>


                    {{-- RIGHT SIDE --}}
                    <div class="p-6">

                        <h2 class="text-xl font-medium text-gray-900 mb-6">
                            Admission Fee list
                        </h2>


                        <div class="overflow-x-auto">

                            <table class="w-full text-left">

                                <thead>

                                    <tr class="border-t border-b border-gray-300">

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Type
                                        </th>

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Amount
                                        </th>

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($admissionFees as $fee)

                                        <tr class="border-b border-gray-200">

                                            <td class="px-2 py-3 text-sm text-gray-700">
                                                {{ $fee->type }}
                                            </td>

                                            <td class="px-2 py-3 text-sm text-gray-700">
                                                {{ number_format($fee->amount, 2) }}
                                            </td>

                                           <td class="px-2 py-3">

    <x-action-edit
        type="button"
        onclick="openEditFeeModal(
            '{{ $fee->id }}',
            '{{ $fee->type }}',
            '{{ $fee->amount }}'
        )"
    />

</td>
                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="3"
                                                class="px-2 py-4 text-sm text-gray-500"
                                            >
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

        </div>

    </div>

    {{-- Edit Admission Fee Modal --}}

<div
    id="editFeeModal"
    class="hidden fixed inset-0 z-50 overflow-y-auto"
>

    {{-- Background --}}
    <div
        class="fixed inset-0 bg-black bg-opacity-50"
        onclick="closeEditFeeModal()"
    ></div>


    {{-- Modal --}}
    <div class="relative flex min-h-screen items-center justify-center p-4">

        <div
            class="relative w-full max-w-lg
                   bg-white rounded-md shadow-xl"
        >

            {{-- Header --}}
            <div
                class="flex items-center justify-between
                       px-6 py-4 border-b"
            >

                <h2
                    class="text-xl font-semibold text-gray-800"
                >
                    Edit Admission Fee
                </h2>


                <button
                    type="button"
                    onclick="closeEditFeeModal()"
                    class="text-gray-500
                           hover:text-gray-800
                           text-2xl font-bold"
                >
                    &times;
                </button>

            </div>


            {{-- Form --}}
            <form
                id="editFeeForm"
                method="POST"
            >

                @csrf

                @method('PATCH')


                <div class="px-6 py-6">

                    {{-- Fee Type --}}
                    <div class="mb-5">

                        <label
                            class="block text-sm
                                   font-medium text-gray-700
                                   mb-2"
                        >
                            Type
                        </label>

                        <input
                            type="text"
                            id="editFeeType"
                            readonly
                            class="w-full
                                   border-gray-300
                                   rounded-md
                                   bg-gray-100
                                   shadow-sm"
                        >

                    </div>


                    {{-- Amount --}}
                    <div>

                        <label
                            class="block text-sm
                                   font-medium text-gray-700
                                   mb-2"
                        >
                            Amount
                        </label>

                        <input
                            type="number"
                            id="editFeeAmount"
                            name="amount"
                            step="0.01"
                            min="0"
                            required
                            class="w-full
                                   border-gray-300
                                   rounded-md
                                   shadow-sm
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                        >

                    </div>

                </div>


                {{-- Footer --}}
                <div
                    class="flex justify-end gap-3
                           px-6 py-4
                           border-t"
                >

                    <button
                        type="button"
                        onclick="closeEditFeeModal()"
                        class="px-5 py-2
                               bg-gray-500
                               text-white
                               rounded-md
                               hover:bg-gray-600"
                    >
                        Close
                    </button>


                    <button
                        type="submit"
                        class="px-5 py-2
                               bg-blue-600
                               text-white
                               rounded-md
                               hover:bg-blue-700"
                    >
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

function openEditFeeModal(id, type, amount)
{
    const modal = document.getElementById('editFeeModal');

    const form = document.getElementById('editFeeForm');

    const typeInput = document.getElementById('editFeeType');

    const amountInput = document.getElementById('editFeeAmount');


    /*
    |--------------------------------------------------------------------------
    | Fill Modal
    |--------------------------------------------------------------------------
    */

    typeInput.value = type;

    amountInput.value = amount;


    /*
    |--------------------------------------------------------------------------
    | Update Form Action
    |--------------------------------------------------------------------------
    */

    form.action = '/admission-fees/' + id;


    /*
    |--------------------------------------------------------------------------
    | Show Modal
    |--------------------------------------------------------------------------
    */

    modal.classList.remove('hidden');
}


function closeEditFeeModal()
{
    const modal = document.getElementById('editFeeModal');

    modal.classList.add('hidden');
}

</script>


</x-app-layout>