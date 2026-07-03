<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sections') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg p-6">

                <div class="flex justify-end mb-6">

                    <a href="">
                        <x-primary-button>
                            Add New Section
                        </x-primary-button>
                    </a>

                </div>

                <h2 class="text-xl font-bold">
                    Sections List
                </h2>

            </div>

        </div>

    </div>

</x-app-layout>