<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Receive Fee
            </h2>

            <div class="text-sm text-gray-500 mt-1">

                <a href="{{ route('dashboard') }}"
                   class="text-blue-600 hover:underline">
                    Home
                </a>

                <span class="mx-1">/</span>

                <span>Edit Fee</span>

            </div>

        </div>

    </x-slot>


    <div class="py-4">

        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-8">

                    <form
                        method="POST"
                        action="{{ route('fee-collections.update', $fee_collection->id) }}"
                    >

                        @csrf

                        @method('PUT')


                        {{-- FEE AMOUNT --}}

                        <div class="max-w-md">

                            <label
                                for="amount"
                                class="block text-sm text-gray-700 mb-2"
                            >
                                Fee Amount<span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                value="{{ old('amount', $fee_collection->amount) }}"
                                min="0"
                                step="0.01"
                                required
                                class="w-full h-11 border border-gray-300 rounded-md px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- UPDATE BUTTON --}}

                        <div class="mt-6">

                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-md text-sm"
                            >
                                Update Fee
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>