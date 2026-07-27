<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Add Fee Type
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                @if ($errors->any())

                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('fee-types.store') }}" method="POST">

                    @csrf

                    <div class="mb-5">

                        <x-input-label value="Fee Type Name" />

                        <x-text-input
                            type="text"
                            name="fee_name"
                            class="block w-full mt-2"
                            placeholder="Enter Fee Type"
                            required
                        />

                    </div>

                    <div class="flex justify-end">

                        <x-primary-button>
                            Save Fee Type
                        </x-primary-button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>