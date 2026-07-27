<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Monthly Fee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('fees.update', $fee->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">

                        <x-input-label value="Select Class" />

                        <select name="class_id"
                            class="mt-2 block w-full border-gray-300 rounded-md shadow-sm">

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                    {{ $fee->class_id == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <x-input-label value="Monthly Fee" />

                        <x-text-input
                            type="number"
                            name="amount"
                            value="{{ $fee->amount }}"
                            class="block mt-2 w-full"
                        />

                    </div>

                    <x-primary-button>
                        Update Fee
                    </x-primary-button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>