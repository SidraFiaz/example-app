<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Add Fee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('fees.store') }}" method="POST">

                    @csrf

                    <!-- Class -->
                    <div class="mb-4">
                        <x-input-label value="Select Class" />

                        <select name="class_id"
                            class="mt-2 block w-full border-gray-300 rounded-md shadow-sm"
                            required>

                            <option value="">Select Class</option>

                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ isset($selectedClass) && $selectedClass == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Fee Type -->
                    <div class="mb-4">
                        <x-input-label value="Fee Type" />

                        <select
                            name="fee_type_id"
                            id="fee_type_id"
                            class="mt-2 block w-full border-gray-300 rounded-md shadow-sm"
                            required>

                            <option value="">Select Fee Type</option>

                            @foreach($feeTypes as $feeType)
                                <option value="{{ $feeType->id }}">
                                    {{ $feeType->fee_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <x-input-label value="Amount" />

                        <x-text-input
                            id="amount"
                            type="number"
                            name="amount"
                            class="block mt-2 w-full"
                            placeholder="Enter Amount"
                            required
                        />
                    </div>

                    <div class="mt-6">
                        <x-primary-button>
                            Save Fee
                        </x-primary-button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const feeType = document.getElementById("fee_type_id");
            const amount = document.getElementById("amount");

            feeType.addEventListener("change", function () {

                if (this.options[this.selectedIndex].text === "Monthly Fee") {
                    amount.placeholder = "Enter Monthly Fee";
                } else {
                    amount.placeholder = "Enter Fee Amount";
                }

            });

        });
    </script>

</x-app-layout>