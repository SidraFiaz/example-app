<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Student Promotion History
            </h2>

            <a href="{{ route('student-promotions.index') }}"
               class="bg-black text-white px-4 py-2 rounded">
                Promote Student
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Student</th>
                            <th class="px-4 py-3 text-left">From Class</th>
                            <th class="px-4 py-3 text-left">To Class</th>
                            <th class="px-4 py-3 text-left">Promotion Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($promotions as $promotion)

                            <tr class="border-b">

                                <td class="px-4 py-3">
                                  {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $promotion->student->name ?? 'N/A' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $promotion->fromClass->class_name ?? 'N/A' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $promotion->toClass->class_name ?? 'N/A' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $promotion->promotion_date }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-4 py-4 text-center">
                                    No promotion history found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>