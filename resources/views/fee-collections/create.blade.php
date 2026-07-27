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
                                        data-class="{{ $student->studentClass->class_name ?? '' }}"
                                        

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

                        <!-- Monthly Fee -->
                        <div>
                            <x-input-label value="Monthly Fee" />
                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                class="mt-2 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                                placeholder="Auto Selected"
                                readonly>
                        </div>

                        <!-- Fee Type -->
<div>
    <x-input-label value="Fee Type" />

    <select
        id="fee_type"
        name="fee_type_id"
        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm"
        required>

        <option value="">Select Fee Type</option>

    </select>
</div>

<!-- Amount -->
<div>
    <x-input-label value="Amount" />

    <input
        type="number"
        name="amount"
        id="amount"
        class="mt-2 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
        readonly>
</div>

                        <!-- Payment Date -->
                        <div>
                            <x-input-label value="Payment Date" />
                            <input
                                type="date"
                                name="payment_date"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm"
                                required>
                        </div>

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

                    <!-- Button -->

                    <div class="mt-8 flex justify-end">

                        <x-primary-button>
                            Save Fee Collection
                        </x-primary-button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>

        document.getElementById('student').addEventListener('change', function () {

            let option = this.options[this.selectedIndex];

            document.getElementById('class_name').value = option.dataset.class;

            document.getElementById('amount').value = option.dataset.fee;

        });

    </script>

</x-app-layout>