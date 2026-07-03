<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Section') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg p-6">

<form method="POST" action="{{ route('sections.store', $class_id) }}">                
                    @csrf

                    <div>
                        <label>Section Name</label>

                        <input type="text"
                               name="section_name"
                               class="border rounded w-full p-2"
                               placeholder="Enter Section Name">
                    </div>

                    <div class="mt-6">
                        <x-primary-button>
                            Save Section
                        </x-primary-button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>