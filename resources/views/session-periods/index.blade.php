<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-semibold text-xl text-gray-800">
                    Session Period
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Session: {{ $session->name }}
                </p>
            </div>

            {{-- Generate Period Button --}}
            <form
                action="{{ route('session-periods.generate', $session->id) }}"
                method="POST"
            >
                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2
                           bg-black border border-transparent
                           rounded-md font-semibold text-xs
                           text-white uppercase tracking-widest
                           hover:bg-gray-800 transition"
                >
                    + Generate Period
                </button>

            </form>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-4 p-4 bg-green-100
                            border border-green-200
                            text-green-700 rounded-md">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Error Message --}}
            @if(session('error'))

                <div class="mb-4 p-4 bg-red-100
                            border border-red-200
                            text-red-700 rounded-md">

                    {{ session('error') }}

                </div>

            @endif


            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-3 text-left
                                               text-xs font-medium
                                               text-gray-500 uppercase">

                                        Period

                                    </th>


                                    <th class="px-6 py-3 text-left
                                               text-xs font-medium
                                               text-gray-500 uppercase">

                                        Status

                                    </th>


                                    <th class="px-6 py-3 text-right
                                               text-xs font-medium
                                               text-gray-500 uppercase">

                                        Action

                                    </th>

                                </tr>

                            </thead>


                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse($periods as $period)

                                    <tr>

                                        {{-- Period --}}
                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-sm font-medium
                                                   text-gray-900">

                                            {{ $period->period_month->format('M-Y') }}

                                        </td>


                                        {{-- Status --}}
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @if($period->is_active)

                                                <span class="inline-flex px-2 py-1
                                                             text-xs font-semibold
                                                             rounded-full
                                                             bg-green-100
                                                             text-green-700">

                                                    Active

                                                </span>

                                            @else

                                                <span class="inline-flex px-2 py-1
                                                             text-xs font-semibold
                                                             rounded-full
                                                             bg-gray-100
                                                             text-gray-600">

                                                    Deactive

                                                </span>

                                            @endif

                                        </td>


                                        {{-- Action --}}
                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-right">

                                            <form
                                                action="{{ route(
                                                    'session-periods.toggle',
                                                    $period->id
                                                ) }}"
                                                method="POST"
                                                class="inline"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="px-3 py-1
                                                           bg-gray-800
                                                           text-white
                                                           rounded
                                                           hover:bg-black"
                                                >
                                                    ↔
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="3"
                                            class="px-6 py-8
                                                   text-center
                                                   text-sm
                                                   text-gray-500"
                                        >

                                            No periods generated yet.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>