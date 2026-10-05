<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Collect Fee
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-8">

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-300 text-red-700 rounded p-4">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('fee-collections.store') }}" method="POST">

                    @csrf


                    <!-- Student + Class -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Student -->

                        <div>
                            <x-input-label value="Student" />

                            <select
                                name="student_id"
                                id="student"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm"
                                required>

                                <option value="">Select Student</option>

                                @foreach($students as $student)

                                    <option
                                        value="{{ $student->id }}"
                                        data-class="{{ $student->studentClass->class_name ?? '' }}">

                                        {{ $student->name }}

                                    </option>

                                @endforeach

                            </select>
                        </div>


                        <!-- Class -->

                        <div>
                            <x-input-label value="Class" />

                            <input
                                type="text"
                                id="class_name"
                                class="mt-2 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                                placeholder="Auto Selected"
                                readonly>
                        </div>

                    </div>


                    <!-- Month + Year -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                        <!-- Month -->

                        <div>
                            <x-input-label value="Month" />

                            <select
                                name="month"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm"
                                required>

                                <option value="">Select Month</option>

                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>

                            </select>
                        </div>


                        <!-- Year -->

                        <div>
                            <x-input-label value="Year" />

                            <input
                                type="number"
                                name="year"
                                value="{{ date('Y') }}"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm"
                                required>
                        </div>

                    </div>

                    <!-- Payment Date -->

<div class="mt-6">

    <x-input-label value="Payment Date" />

    <input
        type="date"
        name="payment_date"
        value="{{ old('payment_date', date('Y-m-d')) }}"
        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm"
        required>

</div>


                    <!-- Fees -->

                    <div class="mt-8">

                        <div class="flex justify-between items-center mb-4">

                            <h3 class="text-lg font-semibold text-gray-800">
                                Fees
                            </h3>

                            <button
                                type="button"
                                id="addFee"
                                class="bg-black text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-800">

                                + Add Another Fee

                            </button>

                        </div>


                        <div id="feesContainer">

                            <!-- First Fee Row -->

                            <div class="fee-row grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                                <!-- Fee Type -->

                                <div>

                                    <x-input-label value="Fee Type" />

                                    <select
                                        name="fee_type_id[]"
                                        class="fee-type mt-2 block w-full rounded-md border-gray-300 shadow-sm"
                                        required>

                                        <option value="">
                                            Select Fee Type
                                        </option>

                                        @foreach($feeTypes as $feeType)

                                            <option value="{{ $feeType->id }}">
                                                {{ $feeType->fee_name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <!-- Amount -->

                                <div>

                                    <x-input-label value="Amount" />

                                    <input
                                        type="number"
                                        name="amount[]"
                                        class="amount mt-2 block w-full rounded-md border-gray-300 shadow-sm"
                                        placeholder="Enter Amount"
                                        min="0"
                                        required>

                                </div>


                                <!-- Remove -->

                                <div class="flex items-end">

                                    <button
                                        type="button"
                                        class="remove-fee bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700">

                                        Remove

                                    </button>

                                </div>

                            </div>

                        </div>


                        <!-- Total -->

                        <div class="flex justify-end mt-6">

                            <div class="bg-gray-100 border border-gray-300 rounded-lg px-6 py-4">

                                <span class="font-semibold text-lg">
                                    Total:
                                </span>

                                <span
                                    id="totalAmount"
                                    class="font-bold text-lg ml-2">

                                    Rs. 0

                                </span>

                            </div>

                        </div>

                    </div>


                    <!-- Status + Remarks -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

                        <!-- Status -->

                        <div>

                            <x-input-label value="Status" />

                            <select
                                name="status"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm">

                                <option value="Paid">
                                    Paid
                                </option>

                                <option value="Unpaid">
                                    Unpaid
                                </option>

                            </select>

                        </div>


                        <!-- Remarks -->

                        <div>

                            <x-input-label value="Remarks" />

                            <textarea
                                name="remarks"
                                rows="4"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Optional"></textarea>

                        </div>

                    </div>


                    <!-- Save Button -->

                    <div class="mt-8 flex justify-end">

                        <x-primary-button>
                            Save
                        </x-primary-button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script>

        // Student -> Class

        document.getElementById('student').addEventListener('change', function () {

            let option = this.options[this.selectedIndex];

            document.getElementById('class_name').value =
                option.dataset.class || '';

        });


        // Add Another Fee

        document.getElementById('addFee').addEventListener('click', function () {

            let container = document.getElementById('feesContainer');

            let firstRow = document.querySelector('.fee-row');

            let newRow = firstRow.cloneNode(true);


            // Reset values

            newRow.querySelector('.fee-type').value = '';

            newRow.querySelector('.amount').value = '';


            container.appendChild(newRow);

        });


        // Remove Fee

        document.addEventListener('click', function (event) {

            if (event.target.classList.contains('remove-fee')) {

                let rows = document.querySelectorAll('.fee-row');


                // Kam az kam 1 fee row rahe

                if (rows.length > 1) {

                    event.target.closest('.fee-row').remove();

                    calculateTotal();

                }

            }

        });


        // Calculate Total

        document.addEventListener('input', function (event) {

            if (event.target.classList.contains('amount')) {

                calculateTotal();

            }

        });


        function calculateTotal() {

            let amounts = document.querySelectorAll('.amount');

            let total = 0;


            amounts.forEach(function (input) {

                let value = parseFloat(input.value) || 0;

                total += value;

            });


            document.getElementById('totalAmount').innerText =
                'Rs. ' + total.toLocaleString();

        }

    </script>

</x-app-layout>