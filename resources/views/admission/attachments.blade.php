<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Students
        </h2>
    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="mb-2">

                <div class="flex items-center justify-between">

                    <div>

                        <h1 class="text-2xl font-semibold text-gray-800">
                            Students
                        </h1>

                        <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">

                            <a
                                href="{{ route('admission.index') }}"
                                class="text-blue-600 hover:text-blue-800"
                            >
                                Home
                            </a>

                            <span>/</span>

                            <span>
                                Student Attachments
                            </span>

                        </div>

                    </div>


                    {{-- Student Information --}}
                    <div class="bg-gray-200 px-4 py-2 text-sm text-gray-700 min-w-[180px]">

                        <div>
                            <strong>Name:</strong>
                            {{ $admission->student_name }}
                        </div>

                        <div>
                            <strong>Roll No:</strong>
                            {{ $admission->id }}
                        </div>

                        <div>
                            <strong>Class:</strong>
                            {{ $admission->studentClass->class_name ?? 'N/A' }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- Main Card --}}
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">

                <div class="grid grid-cols-1 md:grid-cols-2">


                    {{-- LEFT SIDE --}}
                    <div class="p-6 border-r border-gray-200">

                        <div class="flex items-center justify-between mb-6">

                            <h2 class="text-xl font-semibold text-gray-800">
                                Create Attachment
                            </h2>

                            <button
                                type="submit"
                                form="attachmentForm"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700"
                            >
                                Save
                            </button>

                        </div>


                        {{-- Success Message --}}
                        @if(session('success'))

                            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-md text-sm">

                                {{ session('success') }}

                            </div>

                        @endif


                        {{-- Validation Errors --}}
                        @if($errors->any())

                            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-md text-sm">

                                <ul class="list-disc pl-5">

                                    @foreach($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        {{-- Attachment Form --}}
                        <form
                            id="attachmentForm"
                            method="POST"
                            action="{{ route('student-attachments.store', $admission->id) }}"
                            enctype="multipart/form-data"
                        >

                            @csrf


                            {{-- Attachment Name --}}
                            <div class="mb-5">

                                <label
                                    for="attachment_name"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Attachment Name
                                </label>

                                <input
                                    type="text"
                                    id="attachment_name"
                                    name="attachment_name"
                                    value="{{ old('attachment_name') }}"
                                    placeholder="Attachment Name"
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- Remarks --}}
                            <div class="mb-5">

                                <label
                                    for="remarks"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Remarks
                                </label>

                                <textarea
                                    id="remarks"
                                    name="remarks"
                                    rows="3"
                                    placeholder="Remarks"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                >{{ old('remarks') }}</textarea>

                            </div>


                            {{-- File --}}
                            <div>

                                <input
                                    type="file"
                                    id="file"
                                    name="file"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                                >

                            </div>

                        </form>

                    </div>


                    {{-- RIGHT SIDE --}}
                    <div class="p-6">

                        <div class="flex items-center justify-between mb-6">

                            <h2 class="text-xl font-semibold text-gray-800">
                                Attachment List
                            </h2>

                        </div>


                        {{-- Attachment Table --}}
                        <div class="overflow-x-auto">

                            <table class="w-full text-left border-collapse">

                                <thead>

                                    <tr class="border-b border-gray-300">

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Type
                                        </th>

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Attachment name
                                        </th>

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Remarks
                                        </th>

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Certificate Given
                                        </th>

                                        <th class="px-2 py-3 text-sm font-semibold text-gray-700">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($attachments as $attachment)

                                        <tr class="border-b border-gray-200">

                                            {{-- Type --}}
                                            <td class="px-2 py-3 text-sm text-gray-600">

                                                {{ pathinfo($attachment->file_path, PATHINFO_EXTENSION) ?: 'File' }}

                                            </td>


                                            {{-- Attachment Name --}}
                                            <td class="px-2 py-3 text-sm text-gray-800">

                                                {{ $attachment->attachment_name }}

                                            </td>


                                            {{-- Remarks --}}
                                            <td class="px-2 py-3 text-sm text-gray-600">

                                                {{ $attachment->remarks ?? '-' }}

                                            </td>


                                            {{-- Certificate Given --}}
                                            <td class="px-2 py-3 text-sm">

                                                @if($attachment->certificate_given)

                                                    <span class="text-green-600 font-semibold">
                                                        Yes
                                                    </span>

                                                @else

                                                    <span class="text-gray-500">
                                                        No
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- Actions --}}
                                            <td class="px-2 py-3 text-sm">

                                                <div class="flex items-center gap-2">

                                                    <a
                                                        href="{{ route('student-attachments.download', $attachment->id) }}"
                                                        class="text-blue-600 hover:text-blue-800"
                                                    >
                                                        Download
                                                    </a>


                                                    <form
                                                        method="POST"
                                                        action="{{ route('student-attachments.destroy', $attachment->id) }}"
                                                        data-delete-confirm="Are you sure you want to delete this attachment?"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-action-delete />
                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="5"
                                                class="px-2 py-4 text-sm text-gray-500"
                                            >
                                                No data available in table
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Back Button --}}
            <div class="mt-4">

                <a href="{{ route('admission.index') }}">

                    <x-secondary-button type="button">
                        Back to Students
                    </x-secondary-button>

                </a>

            </div>


        </div>

    </div>

</x-app-layout>