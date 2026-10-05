<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Class Group
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Create Class Group
                </h3>


                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-100 border border-red-300 p-4">
                        <ul class="list-disc list-inside text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form method="POST" action="{{ route('class-groups.store') }}">
                    @csrf


                    {{-- Select Group --}}
                    <div class="mb-5">

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Select Group
                        </label>

                        <select name="group_name"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                required>

                            <option value="">
                                Select Group
                            </option>

                            <option value="Pre-Primary"
                                {{ old('group_name') == 'Pre-Primary' ? 'selected' : '' }}>
                                Pre-Primary
                            </option>

                            <option value="Primary"
                                {{ old('group_name') == 'Primary' ? 'selected' : '' }}>
                                Primary
                            </option>

                            <option value="Middle"
                                {{ old('group_name') == 'Middle' ? 'selected' : '' }}>
                                Middle
                            </option>

                            <option value="Secondary"
                                {{ old('group_name') == 'Secondary' ? 'selected' : '' }}>
                                Secondary
                            </option>

                        </select>

                    </div>


                    {{-- Select Class --}}
                    <div class="mb-6">

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Select Class
                        </label>

                        <select name="class_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                required>

                            <option value="">
                                Select Class
                            </option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex items-center gap-3">

                        <button type="submit"
                                class="px-5 py-2.5 bg-black text-white rounded-md hover:bg-gray-800">
                            Save Group
                        </button>

                        <a href="{{ route('class-groups.index') }}"
                           class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>