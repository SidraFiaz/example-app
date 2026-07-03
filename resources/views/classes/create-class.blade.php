<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h2 class="text-2xl font-bold mb-4">
                    Add New Class
                </h2>

                <form method="POST" action="{{ route('classes.store') }}">
                    @csrf

                    <div class="mt-4">
                        <label class="block mb-2">Class Name</label>

                        <input
                            type="text"
                            name="class_name"
                            class="border rounded w-100 p-2"
                            placeholder="Enter Class Name">
                    </div>

                    <div class="mt-6">
                        <x-primary-button>
                            Save Class
                        </x-primary-button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>