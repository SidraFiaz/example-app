<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-normal text-gray-800">
                    Edit Transport
                </h2>

                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 hover:text-blue-800">
                        Home
                    </a>

                    <span class="text-gray-400">/</span>

                    <a href="{{ route('transport.index') }}"
                       class="text-blue-600 hover:text-blue-800">
                        Transport
                    </a>

                    <span class="text-gray-400">/</span>

                    <span class="text-gray-500">
                        Edit
                    </span>
                </div>
            </div>

            <a href="{{ route('transport.index') }}"
               class="bg-black hover:bg-gray-800 text-white
                      px-7 py-2.5 rounded-md text-sm font-medium">
                Back
            </a>
        </div>
    </x-slot>


    <div class="py-3 bg-gray-100 min-h-screen">

        <div class="max-w-full mx-auto px-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">

                @if($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('transport.update', $transport->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Column 1 --}}
                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Select Student <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="student_id"
                                    required
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                                    <option value="">Select Student</option>

                                    @foreach($students as $student)
                                        <option
                                            value="{{ $student->id }}"
                                            {{ old('student_id', $transport->student_id) == $student->id ? 'selected' : '' }}
                                        >
                                            {{ $student->name }}
                                            @if($student->studentClass)
                                                ({{ $student->studentClass->class_name }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Vehicle No.
                                </label>

                                <input
                                    type="text"
                                    name="vehicle_no"
                                    value="{{ old('vehicle_no', $transport->vehicle_no) }}"
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Stop Name
                                </label>

                                <input
                                    type="text"
                                    name="stop_name"
                                    value="{{ old('stop_name', $transport->stop_name) }}"
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                            </div>

                        </div>

                        {{-- Column 2 --}}
                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Date
                                </label>

                                <input
                                    type="date"
                                    name="date"
                                    value="{{ old('date', optional($transport->date)->format('Y-m-d')) }}"
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Registration No.
                                </label>

                                <input
                                    type="text"
                                    name="registration_no"
                                    value="{{ old('registration_no', $transport->registration_no) }}"
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Select Status <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="status"
                                    required
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                                    <option value="">Status</option>
                                    <option value="Active" {{ old('status', $transport->status) === 'Active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="Inactive" {{ old('status', $transport->status) === 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                        </div>

                        {{-- Column 3 --}}
                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Transport Fee
                                </label>

                                <input
                                    type="number"
                                    name="transport_fee"
                                    value="{{ old('transport_fee', $transport->transport_fee) }}"
                                    min="0"
                                    step="0.01"
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Driver Name
                                </label>

                                <input
                                    type="text"
                                    name="driver_name"
                                    value="{{ old('driver_name', $transport->driver_name) }}"
                                    class="w-full h-11 rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Remarks
                                </label>

                                <textarea
                                    name="remarks"
                                    rows="4"
                                    class="w-full rounded-md border border-gray-300
                                           focus:border-black focus:ring-black
                                           text-sm text-gray-700"
                                >{{ old('remarks', $transport->remarks) }}</textarea>
                            </div>

                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-10">

                        <a href="{{ route('transport.index') }}"
                           class="bg-black hover:bg-gray-800 text-white
                                  px-6 py-2.5 rounded-md text-sm font-medium">
                            Close
                        </a>

                        <button
                            type="submit"
                            class="bg-black hover:bg-gray-800 text-white
                                   px-6 py-2.5 rounded-md text-sm font-medium"
                        >
                            Save
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
