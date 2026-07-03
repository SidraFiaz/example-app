<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('student.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label>Name</label>
                        <input type="text"
                               name="name"
                               value="{{ $student->name }}"
                               class="w-70 rounded border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label>Age</label>
                        <input type="number"
                               name="age"
                               value="{{ $student->age }}"
                               class="w-100 rounded border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               value="{{ $student->email }}"
                               class="w-70 rounded border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label>Gender</label>

                        <select name="gender" class="w-70 rounded border-gray-300">
                            <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <x-primary-button>
                        Update Student
                    </x-primary-button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>