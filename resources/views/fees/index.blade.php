<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">
                    Fees
                </h2>
                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                        Home
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">Fees</span>
                </div>
            </div>

            <a href="{{ route('fees.create') }}"
               class="inline-flex items-center justify-center bg-black text-white
                      px-6 py-2.5 rounded-md text-sm font-medium hover:bg-gray-800">
                Create Fee
            </a>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-[0_1px_8px_rgba(0,0,0,0.06)] p-6 sm:p-8">

                <div class="mb-8">
                    <label for="searchFee" class="block text-sm text-gray-700 mb-2">
                        Search Fee
                    </label>
                    <input
                        type="text"
                        id="searchFee"
                        name="search"
                        value="{{ $search }}"
                        class="w-full h-12 rounded-lg border border-gray-300 bg-white
                               text-sm text-gray-800
                               focus:border-gray-400 focus:ring-0"
                    >
                </div>

                <div class="overflow-x-auto">
                    <table class="fees-table">
                        <colgroup>
                            <col style="width: 34%;">
                            <col style="width: 18%;">
                            <col style="width: 14%;">
                            <col style="width: 16%;">
                            <col style="width: 18%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount/Percentage</th>
                                <th>Type</th>
                                <th>Is Adjustment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fees as $fee)
                                @php
                                    $feeDescription = $fee->description ?: ($fee->feeType->fee_name ?? '-');
                                    $feeTypeLabel = $fee->feeType->fee_name ?? '-';
                                    $isAdjustmentLabel = $fee->is_adjustment ? 'Yes' : 'No';
                                @endphp
                                <tr class="fee-row"
                                    data-search="{{ strtolower(
                                        $feeDescription
                                        .' '.
                                        ($fee->amount ?? '')
                                        .' '.
                                        $feeTypeLabel
                                        .' '.
                                        $isAdjustmentLabel
                                    ) }}">
                                    <td>
                                        {{ $feeDescription }}
                                    </td>
                                    <td>
                                        {{ $fee->amount !== null && $fee->amount !== '' ? $fee->amount : '' }}
                                    </td>
                                    <td>
                                        {{ $feeTypeLabel }}
                                    </td>
                                    <td>
                                        {{ $isAdjustmentLabel }}
                                    </td>
                                    <td>
                                        <div class="fees-action-group">
                                            <a
                                                href="{{ route('fees.edit', $fee) }}"
                                                class="fees-edit-btn"
                                                aria-label="Edit {{ $feeDescription }}"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>

                                            <form
                                                action="{{ route('fees.destroy', $fee) }}"
                                                method="POST"
                                                data-delete-confirm="Are you sure you want to delete this fee?"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="fees-delete-btn" aria-label="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center; padding:40px 16px; color:#6b7280;">
                                        No Fees Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p id="feeNoResults" style="display:none; text-align:center; padding:40px 16px; color:#6b7280; font-size:14px;">
                    No matching fees found.
                </p>
            </div>
        </div>
    </div>

    <style>
        .fees-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .fees-table th {
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .fees-table td {
            text-align: left;
            font-size: 14px;
            color: #4b5563;
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
            word-break: break-word;
        }

        .fees-action-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .fees-edit-btn,
        .fees-delete-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .fees-edit-btn {
            background: #111827;
            color: #ffffff;
        }

        .fees-edit-btn:hover {
            background: #1f2937;
        }

        .fees-delete-btn {
            background: #dc2626;
            color: #ffffff;
        }

        .fees-delete-btn:hover {
            background: #b91c1c;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchFee');
            const rows = document.querySelectorAll('.fee-row');
            const noResults = document.getElementById('feeNoResults');

            if (!searchInput) {
                return;
            }

            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach(function (row) {
                    const haystack = row.getAttribute('data-search') || '';
                    const matches = haystack.indexOf(query) !== -1;
                    row.style.display = matches ? 'table-row' : 'none';
                    if (matches) {
                        visibleCount++;
                    }
                });

                if (noResults) {
                    noResults.style.display = (visibleCount > 0 || rows.length === 0) ? 'none' : 'block';
                }
            });
        });
    </script>

</x-app-layout>
