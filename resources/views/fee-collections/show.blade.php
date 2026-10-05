<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Received Fee Records
            </h2>

            <div class="text-sm mt-1">
                <a
                    href="{{ route('dashboard') }}"
                    class="text-blue-600 hover:text-blue-800"
                >
                    Home
                </a>
                <span class="mx-2 text-gray-500">/</span>
                <a
                    href="{{ route('fee-collections.index') }}"
                    class="text-blue-600 hover:text-blue-800"
                >
                    Fee Records
                </a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-500">Details</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6">

            @if (session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                {{-- STUDENT INFORMATION --}}
                <div class="p-5 sm:p-6 border-b border-gray-200 bg-gray-50/60">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">
                        Student Information
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

                        <div class="flex items-center gap-4">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-white shadow flex-shrink-0 bg-gray-200">
                                @if(!empty($fee_collection->student->image))
                                    <img
                                        src="{{ asset('storage/' . $fee_collection->student->image) }}"
                                        alt="Student"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-14 h-14 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                                            <path d="M12 14c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 truncate">
                                    {{ $fee_collection->student->name ?? '-' }}
                                </h3>
                                <p class="text-sm sm:text-base text-gray-600 mt-1">
                                    {{ optional($fee_collection->student->studentClass)->class_name ?? '-' }}
                                    @if(optional($fee_collection->student->section)->section_name)
                                        <span class="text-gray-400">/</span>
                                        {{ $fee_collection->student->section->section_name }}
                                    @endif
                                </p>
                                <p class="text-sm font-semibold text-gray-900 mt-2">
                                    Roll No: {{ $fee_collection->student->roll_no ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="lg:border-l lg:border-gray-200 lg:pl-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                                <div>
                                    <dt class="font-semibold text-gray-800">Admission Date</dt>
                                    <dd class="text-gray-600 mt-0.5">
                                        {{ $fee_collection->student->admission_date ?? '-' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-800">Gender</dt>
                                    <dd class="text-gray-600 mt-0.5">
                                        {{ $fee_collection->student->gender ?? '-' }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="font-semibold text-gray-800">Address</dt>
                                    <dd class="text-gray-600 mt-0.5">
                                        {{ $fee_collection->student->address ?? '-' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="lg:border-l lg:border-gray-200 lg:pl-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                                <div class="sm:col-span-2">
                                    <dt class="font-semibold text-gray-800">Father Name</dt>
                                    <dd class="text-gray-600 mt-0.5">
                                        {{ $fee_collection->student->father_name ?? '-' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-800">Father Contact</dt>
                                    <dd class="text-gray-600 mt-0.5">
                                        {{ $fee_collection->student->father_contact ?? '-' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-800">Father CNIC</dt>
                                    <dd class="text-gray-600 mt-0.5">
                                        {{ $fee_collection->student->father_cnic ?? '-' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                    </div>
                </div>

                {{-- FEE RECORDS --}}
                <div class="p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Student Received Fee Records
                        </h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Month
                                    </th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Year
                                    </th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Previous Balance
                                    </th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Current Fees
                                    </th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Total Due
                                    </th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Paid
                                    </th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Remaining
                                    </th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700 whitespace-nowrap">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($monthGroups as $group)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50/80">
                                        <td class="py-3 px-3 text-gray-800 font-medium whitespace-nowrap">
                                            {{ $group['month_label'] }}
                                        </td>

                                        <td class="py-3 px-3 text-gray-700 whitespace-nowrap">
                                            {{ $group['year'] }}
                                        </td>

                                        <td class="py-3 px-3 text-gray-700 whitespace-nowrap">
                                            Rs. {{ number_format((float) $group['previous_balance'], 2) }}
                                        </td>

                                        <td class="py-3 px-3 text-gray-700 whitespace-nowrap">
                                            Rs. {{ number_format((float) $group['current_fees_total'], 2) }}
                                        </td>

                                        <td class="py-3 px-3 text-gray-800 font-medium whitespace-nowrap">
                                            Rs. {{ number_format((float) $group['total_due'], 2) }}
                                        </td>

                                        <td class="py-3 px-3 text-gray-700 whitespace-nowrap">
                                            Rs. {{ number_format((float) $group['paid'], 2) }}
                                        </td>

                                        <td class="py-3 px-3 whitespace-nowrap {{ $group['remaining'] > 0 ? 'text-red-600 font-medium' : 'text-green-700' }}">
                                            Rs. {{ number_format((float) $group['remaining'], 2) }}
                                        </td>

                                        <td class="py-3 px-3">
                                            <div class="action-btn-group">
                                                <x-action-edit
                                                    :href="route('fee-collections.month-edit', [
                                                        'fee_collection' => $fee_collection->id,
                                                        'month' => $group['month'],
                                                        'year' => $group['year'],
                                                    ])"
                                                />

                                                <form
                                                    method="POST"
                                                    action="{{ route('fee-collections.month-destroy', $fee_collection->id) }}"
                                                    data-delete-confirm="Delete ALL {{ $group['record_count'] }} received fee record(s) for {{ $group['title'] }}? This cannot be undone."
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="month" value="{{ $group['month'] }}">
                                                    <input type="hidden" name="year" value="{{ $group['year'] }}">
                                                    <x-action-delete />
                                                </form>

                                                <button
                                                    type="button"
                                                    class="action-btn action-btn-edit"
                                                    data-receive-fees-trigger
                                                    data-month-key="{{ $group['key'] }}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                                    </svg>
                                                    <span>Receive Fees</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-8 px-3 text-center text-gray-500">
                                            No received fee records found for this student.
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

    {{-- RECEIVED FEES MODAL --}}
    <div
        id="received-fees-modal"
        class="fixed inset-0 z-[200] hidden"
        aria-hidden="true"
    >
        <div
            class="absolute inset-0 bg-black/55"
            data-received-fees-close
        ></div>

        <div class="relative flex min-h-full items-start justify-center px-4 pt-[8vh] sm:pt-[10vh] pb-8 pointer-events-none">
            <div
                id="received-fees-modal-card"
                class="pointer-events-auto w-full max-w-xl rounded-xl bg-white shadow-2xl border border-gray-200 overflow-hidden transform transition-all duration-200 scale-95 opacity-0 flex flex-col max-h-[90vh]"
                role="dialog"
                aria-modal="true"
                aria-labelledby="received-fees-modal-title"
            >
                {{-- Dark header --}}
                <div class="shrink-0 bg-[#111827] px-5 py-4 flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="mt-0.5 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/10 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h3
                                id="received-fees-modal-title"
                                class="text-lg font-semibold text-white leading-tight"
                            >
                                Receive Fees
                            </h3>
                            <p class="mt-1 text-sm text-gray-300 truncate">
                                <span id="received-fees-modal-student" class="font-medium text-white">{{ $fee_collection->student->name ?? '-' }}</span>
                                <span class="text-gray-400"> · </span>
                                <span id="received-fees-modal-period" class="font-medium text-white"></span>
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        onclick="closeReceiveFeeModal()"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white/10 text-white hover:bg-white/20 transition text-xl font-bold leading-none"
                        aria-label="Close"
                        title="Close"
                    >
                        &times;
                    </button>
                </div>

                <form
                    id="received-fees-payment-form"
                    method="POST"
                    action="{{ route('fee-collections.month-receive', $fee_collection->id) }}"
                    class="flex flex-col flex-1 min-h-0"
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="month" id="received-fees-input-month" value="">
                    <input type="hidden" name="year" id="received-fees-input-year" value="">

                {{-- Body (scrollable) --}}
                <div class="px-5 py-4 overflow-y-auto flex-1 min-h-0">

                    @if ($errors->any())
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Summary --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                            <p class="text-[11px] uppercase tracking-wide text-gray-500 font-semibold">Receive Date</p>
                            <p id="received-fees-summary-date" class="mt-1 text-sm font-semibold text-gray-900">-</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                            <p class="text-[11px] uppercase tracking-wide text-gray-500 font-semibold">Month</p>
                            <p id="received-fees-summary-month" class="mt-1 text-sm font-semibold text-gray-900">-</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                            <p class="text-[11px] uppercase tracking-wide text-gray-500 font-semibold">Year</p>
                            <p id="received-fees-summary-year" class="mt-1 text-sm font-semibold text-gray-900">-</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                            <p class="text-[11px] uppercase tracking-wide text-gray-500 font-semibold">Total Due</p>
                            <p id="received-fees-summary-total" class="mt-1 text-sm font-semibold text-gray-900">Rs. 0.00</p>
                        </div>
                    </div>

                    {{-- Previous balance --}}
                    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 flex items-center justify-between gap-3">
                        <span class="text-sm font-semibold text-gray-800">Previous Month Balance</span>
                        <span id="received-fees-previous-balance" class="text-sm font-bold text-amber-800 whitespace-nowrap">Rs. 0.00</span>
                    </div>

                    {{-- Fees table --}}
                    <div class="mb-2">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">
                            Current Month Fees
                        </h4>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-2.5 px-3 font-semibold text-gray-600 w-10">#</th>
                                        <th class="text-left py-2.5 px-3 font-semibold text-gray-600">Fee Name</th>
                                        <th class="text-right py-2.5 px-3 font-semibold text-gray-600">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="received-fees-modal-body">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Totals / payment --}}
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium text-gray-700">Current Month Fees</span>
                            <span id="received-fees-current-total" class="font-semibold text-gray-900 whitespace-nowrap">Rs. 0.00</span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium text-gray-700">Previous Month Balance</span>
                            <span id="received-fees-previous-balance-repeat" class="font-semibold text-gray-900 whitespace-nowrap">Rs. 0.00</span>
                        </div>
                        <div class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 flex items-center justify-between gap-3">
                            <span class="text-sm font-semibold text-gray-800">Total Due</span>
                            <span id="received-fees-modal-total" class="text-base font-bold text-gray-900 whitespace-nowrap">Rs. 0.00</span>
                        </div>

                        <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3">
                            <label for="received-fees-amount-paid" class="block text-sm font-semibold text-gray-800 mb-2">
                                Amount Paid
                            </label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-600">Rs.</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="amount_paid"
                                    id="received-fees-amount-paid"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-semibold"
                                    required
                                >
                            </div>
                            <p id="received-fees-paid-error" class="mt-2 text-xs text-red-600 hidden"></p>
                        </div>

                        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 flex items-center justify-between gap-3">
                            <span class="text-sm font-semibold text-gray-800">Remaining Balance</span>
                            <span id="received-fees-remaining" class="text-base font-bold text-green-700 whitespace-nowrap">Rs. 0.00</span>
                        </div>
                    </div>
                </div>

                {{-- Sticky footer: always visible at bottom of modal --}}
                <div class="shrink-0 flex flex-col sm:flex-row justify-end gap-2 px-5 py-4 border-t border-gray-200 bg-gray-50">
                    <button
                        type="button"
                        id="received-fees-close-btn"
                        onclick="closeReceiveFeeModal(); return false;"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 rounded-md border-2 border-gray-400 bg-white hover:bg-gray-100 text-gray-900 text-sm font-semibold shadow-sm transition"
                    >
                        Close
                    </button>
                    <button
                        type="submit"
                        id="received-fees-save-btn"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 rounded-md bg-black hover:bg-gray-800 text-white text-sm font-medium shadow-sm transition"
                    >
                        Save Payment
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Always available for Close button onclick (uses existing modal close mechanism)
        window.closeReceiveFeeModal = function () {
            const modal = document.getElementById('received-fees-modal');
            const card = document.getElementById('received-fees-modal-card');

            if (!modal) {
                return;
            }

            if (card) {
                card.classList.remove('scale-100', 'opacity-100');
                card.classList.add('scale-95', 'opacity-0');
            }

            window.setTimeout(function () {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
            }, 160);
        };

        (function () {
            const feesByMonth = @json($receivedFeesByMonth);
            const modal = document.getElementById('received-fees-modal');
            const card = document.getElementById('received-fees-modal-card');
            const bodyEl = document.getElementById('received-fees-modal-body');
            const totalEl = document.getElementById('received-fees-modal-total');
            const periodEl = document.getElementById('received-fees-modal-period');
            const summaryDate = document.getElementById('received-fees-summary-date');
            const summaryMonth = document.getElementById('received-fees-summary-month');
            const summaryYear = document.getElementById('received-fees-summary-year');
            const summaryTotal = document.getElementById('received-fees-summary-total');
            const previousBalanceEl = document.getElementById('received-fees-previous-balance');
            const previousBalanceRepeatEl = document.getElementById('received-fees-previous-balance-repeat');
            const currentTotalEl = document.getElementById('received-fees-current-total');
            const paidInput = document.getElementById('received-fees-amount-paid');
            const paidErrorEl = document.getElementById('received-fees-paid-error');
            const remainingEl = document.getElementById('received-fees-remaining');
            const monthInput = document.getElementById('received-fees-input-month');
            const yearInput = document.getElementById('received-fees-input-year');
            const formEl = document.getElementById('received-fees-payment-form');

            let currentTotalDue = 0;

            if (!modal || !bodyEl || !totalEl || !card) {
                return;
            }

            function formatAmount(amount) {
                return Number(amount || 0).toLocaleString('en-PK', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function setText(el, value) {
                if (el) {
                    el.textContent = value;
                }
            }

            function updateRemaining() {
                const paid = Number(paidInput ? paidInput.value : 0);
                const remaining = Math.max(0, Math.round((currentTotalDue - paid) * 100) / 100);
                setText(remainingEl, 'Rs. ' + formatAmount(remaining));

                if (remainingEl) {
                    remainingEl.classList.toggle('text-green-700', remaining <= 0);
                    remainingEl.classList.toggle('text-red-600', remaining > 0);
                }

                if (paidErrorEl) {
                    if (paid - currentTotalDue > 0.009) {
                        paidErrorEl.textContent = 'Paid amount cannot be greater than total due.';
                        paidErrorEl.classList.remove('hidden');
                    } else {
                        paidErrorEl.textContent = '';
                        paidErrorEl.classList.add('hidden');
                    }
                }
            }

            function openModal(monthKey) {
                const group = feesByMonth[String(monthKey)] || feesByMonth[monthKey] || null;
                const lines = group && group.fees ? group.fees : [];

                bodyEl.innerHTML = '';

                setText(periodEl, group ? (group.title || '-') : '-');
                setText(
                    summaryDate,
                    group
                        ? (group.mixed_dates ? 'Multiple dates' : (group.receive_date || '-'))
                        : '-'
                );
                setText(summaryMonth, group ? (group.month_label || '-') : '-');
                setText(summaryYear, group ? (group.year || '-') : '-');

                if (monthInput) {
                    monthInput.value = group ? group.month : '';
                }
                if (yearInput) {
                    yearInput.value = group ? group.year : '';
                }

                if (!lines.length) {
                    const emptyRow = document.createElement('tr');
                    const emptyTd = document.createElement('td');
                    emptyTd.colSpan = 3;
                    emptyTd.className = 'py-8 px-3 text-center text-gray-500';
                    emptyTd.textContent = 'No fees found for this month.';
                    emptyRow.appendChild(emptyTd);
                    bodyEl.appendChild(emptyRow);
                } else {
                    lines.forEach(function (line, index) {
                        const row = document.createElement('tr');
                        row.className = 'border-b border-gray-100 last:border-0 hover:bg-gray-50/80';

                        const indexTd = document.createElement('td');
                        indexTd.className = 'py-2.5 px-3 text-gray-500';
                        indexTd.textContent = String(index + 1);

                        const nameTd = document.createElement('td');
                        nameTd.className = 'py-2.5 px-3 text-gray-800 font-medium';
                        nameTd.textContent = line.fee_name || '-';

                        const amountTd = document.createElement('td');
                        amountTd.className = 'py-2.5 px-3 text-right text-gray-800 whitespace-nowrap tabular-nums';
                        amountTd.textContent = 'Rs. ' + formatAmount(line.amount);

                        row.appendChild(indexTd);
                        row.appendChild(nameTd);
                        row.appendChild(amountTd);
                        bodyEl.appendChild(row);
                    });
                }

                const previousBalance = group ? Number(group.previous_balance || 0) : 0;
                const currentFees = group ? Number(group.current_fees_total || 0) : 0;
                const totalDue = group ? Number(group.total_due || 0) : 0;
                const paid = group ? Number(group.paid || 0) : 0;

                currentTotalDue = totalDue;

                const previousText = 'Rs. ' + formatAmount(previousBalance);
                const currentText = 'Rs. ' + formatAmount(currentFees);
                const dueText = 'Rs. ' + formatAmount(totalDue);

                setText(summaryTotal, dueText);
                setText(previousBalanceEl, previousText);
                setText(previousBalanceRepeatEl, previousText);
                setText(currentTotalEl, currentText);
                setText(totalEl, dueText);

                if (paidInput) {
                    paidInput.value = paid.toFixed(2);
                    paidInput.max = totalDue.toFixed(2);
                }

                updateRemaining();

                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');

                requestAnimationFrame(function () {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                    if (paidInput) {
                        paidInput.focus();
                        paidInput.select();
                    }
                });
            }

            function closeModal() {
                window.closeReceiveFeeModal();
            }

            if (paidInput) {
                paidInput.addEventListener('input', updateRemaining);
                paidInput.addEventListener('change', updateRemaining);
            }

            if (formEl) {
                formEl.addEventListener('submit', function (event) {
                    const paid = Number(paidInput ? paidInput.value : 0);
                    if (paid - currentTotalDue > 0.009) {
                        event.preventDefault();
                        updateRemaining();
                        if (paidInput) {
                            paidInput.focus();
                        }
                    }
                });
            }

            document.querySelectorAll('[data-receive-fees-trigger]').forEach(function (button) {
                button.addEventListener('click', function () {
                    openModal(button.getAttribute('data-month-key'));
                });
            });

            modal.querySelectorAll('[data-received-fees-close]').forEach(function (el) {
                el.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        })();
    </script>

</x-app-layout>
