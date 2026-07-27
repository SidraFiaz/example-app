<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Fee Collection
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('fee-collections.update', $fee_collection->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Student -->
                        <div>
                            <x-input-label value="Student" />

                            <select
                                name="student_id"
                                id="student"
                                class="mt-2 block w-full border-gray-300 rounded-md shadow-sm"
                                required>

                                @foreach($students as $student)

                                    <option
                                        value="{{ $student->id }}"
                                        data-class="{{ $student->studentClass->class_name ?? '' }}"
                                        data-fee="{{ $student->studentClass->fee->amount ?? 0 }}"
                                        {{ $fee_collection->student_id == $student->id ? 'selected' : '' }}>

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
                                value="{{ $fee_collection->student->studentClass->class_name }}"
                                class="mt-2 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100"
                                readonly>

                        </div>

                        <!-- Amount -->
                        <div>

                            <x-input-label value="Amount" />

                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                value="{{ $fee_collection->amount }}"
                                class="mt-2 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100"
                                readonly>

                        </div>

                        <!-- Payment Date -->
                        <div>

                            <x-input-label value="Payment Date" />

                            <input
                                type="date"
                                name="payment_date"
                                value="{{ $fee_collection->payment_date }}"
                                class="mt-2 block w-full border-gray-300 rounded-md shadow-sm"
                                required>

                        </div>

                        <!-- Status -->
                        <div>

                            <x-input-label value="Status" />

                            <select
                                name="status"
                                class="mt-2 block w-full border-gray-300 rounded-md shadow-sm">

                                <option value="Paid"
                                    {{ $fee_collection->status == 'Paid' ? 'selected' : '' }}>
                                    Paid
                                </option>

                                <option value="Unpaid"
                                    {{ $fee_collection->status == 'Unpaid' ? 'selected' : '' }}>
                                    Unpaid
                                </option>

                            </select>

                        </div>

                        <!-- Remarks -->
                        <div>

                            <x-input-label value="Remarks" />

                            <textarea
                                name="remarks"
                                rows="3"
                                class="mt-2 block w-full border-gray-300 rounded-md shadow-sm resize-none">{{ $fee_collection->remarks }}</textarea>

                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-3">

                        <a href="{{ route('fee-collections.index') }}">
                            <x-secondary-button>
                                Cancel
                            </x-secondary-button>
                        </a>

                        <x-primary-button>
                            Update Fee
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