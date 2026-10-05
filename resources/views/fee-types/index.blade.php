<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900">
            Fee Types
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-[0_1px_8px_rgba(0,0,0,0.06)] p-6 sm:p-10">

                <form method="GET" action="{{ route('fee-types.index') }}" id="feeTypeSearchForm" class="mb-10">
                    <label for="feeTypeSearch" class="block text-sm text-gray-600 mb-2">
                        Search Fee Type
                    </label>
                    <input
                        type="text"
                        id="feeTypeSearch"
                        name="search"
                        value="{{ $search }}"
                        class="ft-search"
                        autocomplete="off"
                    >
                </form>

                <table class="ft-table">
                    <colgroup>
                        <col style="width: 50%;">
                        <col style="width: 50%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="ft-th-name">Fee Type</th>
                            <th class="ft-th-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feeTypes as $feeType)
                            <tr class="ft-row">
                                <td class="ft-td-name">
                                    {{ $feeType->fee_name }}
                                </td>
                                <td class="ft-td-action">
                                    <a
                                        href="{{ route('fee-types.edit', $feeType) }}"
                                        class="ft-edit"
                                        aria-label="Edit {{ $feeType->fee_name }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="ft-empty">No fee types found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <style>
        .ft-search {
            display: block;
            width: 100%;
            height: 48px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
            padding: 0 14px;
            box-shadow: none;
        }

        .ft-search:focus {
            outline: none;
            border-color: #9ca3af;
            box-shadow: none;
        }

        .ft-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .ft-table thead th {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            padding: 0 20px 2px;
            vertical-align: middle;
            text-align: left;
        }

        .ft-table tbody tr.ft-row td {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 20px;
            vertical-align: middle;
            height: 58px;
        }

        .ft-td-name {
            border-left: 1px solid #e5e7eb;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            font-size: 15px;
            color: #1f2937;
        }

        .ft-td-action {
            border-right: 1px solid #e5e7eb;
            border-left: 1px solid #e5e7eb;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .ft-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #e5e7eb;
            color: #111827;
            border-radius: 6px;
            text-decoration: none;
        }

        .ft-edit:hover {
            background: #d1d5db;
            color: #111827;
        }

        .ft-empty {
            text-align: center;
            padding: 36px 16px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('feeTypeSearchForm');
            const input = document.getElementById('feeTypeSearch');
            if (!form || !input) {
                return;
            }

            let timer = null;
            input.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    form.submit();
                }, 350);
            });
        });
    </script>

</x-app-layout>
