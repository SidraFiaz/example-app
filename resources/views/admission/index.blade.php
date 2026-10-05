<x-app-layout>

    <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Student List') }}
</h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Header --}}
                <div class="p-6 flex items-center justify-between">

                   <div></div>

                    <div class="flex items-center gap-2">

    <button
    type="button"
    onclick="document.getElementById('polioModal').classList.remove('hidden')"
    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300
           rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest
           shadow-sm hover:bg-gray-50">
    Polio Report
</button>
<a href="{{ route('admission.deleted') }}">
    <x-secondary-button type="button">
        Restore
    </x-secondary-button>
</a>

    <a href="{{ route('admission.create') }}">
        <x-primary-button>
            Create
        </x-primary-button>
    </a>

</div>

                </div>

                {{-- Search & Filters --}}
<div class="px-6 pb-6">

    <div class="flex items-end gap-4">

        {{-- Search Student --}}
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Search Student
            </label>

            <input
                type="text"
                placeholder="Search Student"
                class="w-full border-gray-300 rounded-md shadow-sm"
            >
        </div>

        {{-- Search Family --}}
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Search Family #
            </label>

            <input
                type="text"
                placeholder="Search Family #"
                class="w-full border-gray-300 rounded-md shadow-sm"
            >
        </div>

        {{-- Student Status --}}
       <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Student Status
    </label>

    <select
        name="status"
        class="w-full border-gray-300 rounded-md shadow-sm"
    >
        <option value="">Select Status</option>
        <option value="Active">Active</option>
        <option value="Passed out">Passed out</option>
        <option value="Rusticate">Rusticate</option>
        <option value="Expelled">Expelled</option>
        <option value="Transfer">Transfer</option>
        <option value="Double">Double</option>
    </select>
</div>

        {{-- Class --}}
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Class
            </label>

            <div>

   <select
    id="class_id"
    name="class_id"
    class="w-full border-gray-300 rounded-md shadow-sm"
>
        <option value="">Select Class</option>

        @foreach($classes as $class)
            <option value="{{ $class->id }}">
                {{ $class->class_name }}
            </option>
        @endforeach
    </select>
</div>
        </div>
{{-- Section --}}
<div class="flex-1">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Section
    </label>

    <select
        id="section_id"
        name="section_id"
        class="w-full border-gray-300 rounded-md shadow-sm"
    >
        <option value="">Select Section</option>
    </select>
</div>
        {{-- Reset --}}
        <div>
            <x-secondary-button type="button">
                Reset
            </x-secondary-button>
        </div>

        {{-- Export --}}
        <div>
           <a href="{{ route('admission.export') }}">
    <x-primary-button type="button">
        Export
    </x-primary-button>
</a>
        </div>

    </div>

</div>


                {{-- Success Message --}}
                @if(session('success'))

                    <div class="mx-6 mb-4 p-3 bg-green-100
                                border border-green-300 text-green-700
                                rounded-md">

                        {{ session('success') }}

                    </div>

                @endif


                {{-- Table --}}
                <div class="p-6 overflow-x-auto">

                    <table class="w-full border border-gray-400 border-collapse text-center">

                        <thead>

                            <tr class="bg-gray-200">

                                <th class="border border-gray-400 px-4 py-2">
                                    ID
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Student Name
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Father Name
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Family No
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Class
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Section
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Status
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Admission Date
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Father Contact
                                </th>

                                <th class="border border-gray-400 px-4 py-2">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($admissions as $admission)

                                <tr>

                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->student_name }}
                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->father_name }}
                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->family_no ?? 'N/A' }}
                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->studentClass->class_name ?? 'N/A' }}
                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->section->section_name ?? 'N/A' }}
                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">

                                        @if($admission->status === 'Active')

                                            <span class="text-green-600 font-semibold">
                                                Active
                                            </span>

                                        @else

                                            <span class="text-red-600 font-semibold">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->admission_date?->format('d-m-Y') }}
                                    </td>


                                    <td class="border border-gray-400 px-4 py-2">
                                        {{ $admission->father_contact ?? 'N/A' }}
                                    </td>


                                   <td class="border border-gray-400 px-4 py-2">

    <div
        x-data="{
            open: false,
            top: 0,
            left: 0,

            toggleMenu() {
                const rect = this.$refs.button.getBoundingClientRect();
                const menuWidth = 208;
                const menuHeight = 260;

                this.left = Math.min(
                    rect.right - menuWidth,
                    window.innerWidth - menuWidth - 10
                );

                if (rect.bottom + menuHeight > window.innerHeight) {
                    this.top = rect.top - menuHeight - 8;
                } else {
                    this.top = rect.bottom + 8;
                }

                this.open = !this.open;
            }
        }"
        class="inline-block"
    >

        {{-- Settings Button --}}
        <button
            type="button"
            x-ref="button"
            @click="toggleMenu()"
            class="inline-flex items-center justify-center
                   w-10 h-10
                   text-black
                   hover:text-gray-800
                   focus:outline-none"
        >

            {{-- Gear Icon --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M10.325 4.317c.426-1.756
                       2.924-1.756 3.35 0a1.724
                       1.724 0 002.573 1.066
                       c1.543-.94 3.31.826
                       2.37 2.37a1.724 1.724 0 001.065 2.572
                       c1.756.426 1.756 2.924
                       0 3.35a1.724 1.724 0 00-1.066 2.573
                       c.94 1.543-.826 3.31-2.37
                       2.37a1.724 1.724 0 00-2.572
                       1.065c-.426 1.756-2.924
                       1.756-3.35 0a1.724 1.724
                       0 00-2.573-1.066
                       c-1.543.94-3.31-.826-2.37-2.37
                       a1.724 1.724 0 00-1.065-2.572
                       c-1.756-.426-1.756-2.924
                       0-3.35a1.724 1.724
                       0 001.066-2.573
                       c-.94-1.543.826-3.31 2.37-2.37
                       .996.608 2.296.07 2.572-1.065z"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0
                       3 3 0 016 0z"
                />
            </svg>

        </button>


        {{-- Dropdown --}}
        <template x-teleport="body">

            <div
                x-show="open"
                x-transition
                @click.outside="open = false"
                :style="`position: fixed; top: ${top}px; left: ${left}px;`"
                style="display: none;"
                class="w-52
                       bg-white
                       border border-gray-200
                       rounded-md
                       shadow-xl
                       z-[9999]"
            >

                {{-- View --}}
                <a
                    href="{{ route('admission.show', $admission->id) }}"
                    class="block px-4 py-2 text-sm text-gray-700
                           hover:bg-gray-100"
                >
                    View
                </a>


                {{-- Attachment --}}
                <a
                    href="{{ route('student-attachments.create', $admission->id) }}"
                    class="block px-4 py-2 text-sm text-gray-700
                           hover:bg-gray-100"
                >
                    Attachment
                </a>


                {{-- Admission Fee --}}
                <a
                    href="{{ route('admission-fees.create', $admission->id) }}"
                    class="block px-4 py-2 text-sm text-gray-700
                           hover:bg-gray-100"
                >
                    Admission fee
                </a>


                {{-- Leaving Certificate --}}
                <a
                    href="{{ route('admission.leaving-certificate', $admission->id) }}"
                    class="block px-4 py-2 text-sm text-gray-700
                           hover:bg-gray-100"
                >
                    Leaving Certificate
                </a>


                {{-- Transfer Student --}}
                <a
                    href="{{ route('admission.transfer.create', $admission->id) }}"
                    class="block px-4 py-2 text-sm text-gray-700
                           hover:bg-gray-100"
                >
                    Transfer Student
                </a>


                {{-- Delete --}}
                <form
                    method="POST"
                    action="{{ route('admission.destroy', $admission->id) }}"
                    data-delete-confirm="Are you sure you want to delete this admission?"
                    class="px-2 py-2"
                >
                    @csrf
                    @method('DELETE')
                    <x-action-delete>Delete</x-action-delete>
                </form>

            </div>

        </template>

    </div>

</td>
                                </tr>

                            @empty

                                <tr>

                                    <td colspan="10"
                                        class="border border-gray-400 px-4 py-8 text-gray-500">

                                        No admissions found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {

    const classDropdown = document.getElementById('class_id');
    const sectionDropdown = document.getElementById('section_id');

    if (!classDropdown || !sectionDropdown) {
        return;
    }

    function resetSections(message) {
        sectionDropdown.innerHTML =
            '<option value="">' + message + '</option>';
    }

    function loadSections(classId) {
        resetSections('Select Section');

        if (!classId) {
            sectionDropdown.disabled = true;
            return;
        }

        sectionDropdown.disabled = true;

        fetch('/get-sections/' + classId)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                resetSections('Select Section');

                if (!data || data.length === 0) {
                    resetSections('No sections available');
                    sectionDropdown.disabled = true;
                    return;
                }

                data.forEach(function (section) {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.section_name;
                    sectionDropdown.appendChild(option);
                });

                sectionDropdown.disabled = false;
            })
            .catch(function (error) {
                console.error(error);
                resetSections('Select Section');
                sectionDropdown.disabled = true;
            });
    }

    classDropdown.addEventListener('change', function () {
        loadSections(this.value);
    });

    if (classDropdown.value) {
        loadSections(classDropdown.value);
    } else {
        sectionDropdown.disabled = true;
    }

});
</script>

{{-- Polio Report Modal --}}
<div
    id="polioModal"
    class="hidden fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="polioModalTitle"
    role="dialog"
    aria-modal="true"
>
    {{-- Background --}}
    <div
        class="fixed inset-0 bg-black bg-opacity-50"
        onclick="document.getElementById('polioModal').classList.add('hidden')"
    ></div>

    {{-- Modal Box --}}
    <div class="relative flex min-h-screen items-center justify-center p-4">

        <div class="relative w-full max-w-xl bg-white rounded-md shadow-xl">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b">

                <h2
                    id="polioModalTitle"
                    class="text-xl font-semibold text-gray-800"
                >
                    Under 5 Student Polio Report
                </h2>

                <button
                    type="button"
                    onclick="document.getElementById('polioModal').classList.add('hidden')"
                    class="text-gray-500 hover:text-gray-800 text-2xl font-bold"
                >
                    &times;
                </button>

            </div>

            {{-- Body --}}
            <div class="px-6 py-6">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Class
                </label>

                <select
                    id="polioClass"
                    name="class_id"
                    class="w-full border-gray-300 rounded-md shadow-sm"
                >
                    <option value="">
                        Select Class
                    </option>

                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->class_name }}
                        </option>
                    @endforeach

                </select>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 px-6 py-4 border-t">

                <button
                    type="button"
                    onclick="document.getElementById('polioModal').classList.add('hidden')"
                    class="px-5 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                >
                    Close
                </button>

                <a
    id="takePolioReport"
    href="#"
    class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
>
    Take Report
</a>

            </div>

        </div>

    </div>

</div>

<script>
    document.getElementById('polioClass').addEventListener('change', function () {

        let classId = this.value;
        let button = document.getElementById('takePolioReport');

        if (classId) {
            button.href = "{{ url('/admission/polio-report') }}/" + classId;
        } else {
            button.href = "#";
        }

    });
</script>

</x-app-layout>