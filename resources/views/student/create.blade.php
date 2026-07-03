<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Student Form
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">

                @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

                <form method="POST" action="{{ route('student.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name"
                            class="block mt-1 w-half" />
                    </div>

                    <!-- Age -->
                    <div class="mb-4">
                        <x-input-label for="age" value="Age" />
                        <x-text-input id="age" type="number"
                            name="age" class="block mt-1 w-80" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" type="email"
                            name="email" class="block mt-1 w-80" />
                    </div>

                    <!-- Gender -->
                    <div class="mb-4">
                        <x-input-label for="gender" value="Gender" />

                        <select name="gender"
                            class="block mt-1 w-80 border-gray-300 rounded-md">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <x-primary-button>
                        Save Student
                    </x-primary-button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>