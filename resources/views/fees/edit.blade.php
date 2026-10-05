<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">
                Edit Fee
            </h2>
            <div class="flex items-center gap-2 text-sm mt-1">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-black">
                    Home
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-500">Edit</span>
            </div>
        </div>
    </x-slot>

    @php
        $currentDescription = old(
            'description',
            $fee->description ?: (optional($fee->feeType)->fee_name ?? '')
        );
        $currentFeeTypeId = old('fee_type_id', $fee->fee_type_id);
        $currentAmount = old('amount', $fee->amount);
        $currentDiscountType = old('discount_type', $fee->discount_type);
        $currentDiscountValue = old('discount_value', $fee->discount_value);
        $currentIsAdjustment = old(
            'is_adjustment',
            $fee->is_adjustment ? '1' : '0'
        );

        // Resolve Fee Type from the selected id first, then fall back to the record relation.
        $resolvedFeeType = $feeTypes->firstWhere('id', (int) $currentFeeTypeId) ?? $fee->feeType;
        $selectedFeeTypeKey = strtolower(trim((string) optional($resolvedFeeType)->fee_name));
        $isFeeMode = $selectedFeeTypeKey === 'fee';
        $isDiscountMode = $selectedFeeTypeKey === 'discount';
    @endphp

    <div class="py-6 bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-[0_1px_8px_rgba(0,0,0,0.06)] p-6 sm:p-10">

                @if ($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('fees.update', $fee) }}"
                    method="POST"
                    id="feeForm"
                    data-initial-fee-type="{{ $selectedFeeTypeKey }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="fee-form-grid">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Fee Description <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="description"
                                name="description"
                                value="{{ $currentDescription }}"
                                class="fee-form-control"
                                required
                            >
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fee_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Fee Type <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="fee_type_id"
                                id="fee_type_id"
                                class="fee-form-control"
                                required
                            >
                                <option value="">Select Fee Type</option>
                                @foreach($feeTypes as $feeType)
                                    <option
                                        value="{{ $feeType->id }}"
                                        data-fee-name="{{ strtolower(trim($feeType->fee_name)) }}"
                                        {{ (string) $currentFeeTypeId === (string) $feeType->id ? 'selected' : '' }}
                                    >
                                        {{ $feeType->fee_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fee_type_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div
                        id="feeFields"
                        class="fee-form-grid fee-conditional-section{{ $isFeeMode ? '' : ' is-hidden' }}"
                        @if(! $isFeeMode) hidden @endif
                    >
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Fee Amount <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                value="{{ $currentAmount }}"
                                step="any"
                                min="0"
                                class="fee-form-control"
                                @if(! $isFeeMode) disabled @endif
                                @if($isFeeMode) required @endif
                            >
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div
                        id="discountFields"
                        class="fee-form-grid fee-conditional-section{{ $isDiscountMode ? '' : ' is-hidden' }}"
                        @if(! $isDiscountMode) hidden @endif
                    >
                        <div>
                            <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Type <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="discount_type"
                                id="discount_type"
                                class="fee-form-control"
                                @if(! $isDiscountMode) disabled @endif
                                @if($isDiscountMode) required @endif
                            >
                                <option value="">Select Type</option>
                                <option value="amount" {{ in_array((string) $currentDiscountType, ['amount', 'fixed'], true) ? 'selected' : '' }}>
                                    Amount
                                </option>
                                <option value="percentage" {{ (string) $currentDiscountType === 'percentage' ? 'selected' : '' }}>
                                    Percentage
                                </option>
                            </select>
                            @error('discount_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Value <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="discount_value"
                                name="discount_value"
                                value="{{ $currentDiscountValue }}"
                                step="0.01"
                                min="0"
                                class="fee-form-control"
                                @if(! $isDiscountMode) disabled @endif
                                @if($isDiscountMode) required @endif
                            >
                            @error('discount_value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="fee-form-adjustment">
                        <input type="hidden" name="is_adjustment" value="0">
                        <label for="is_adjustment" class="fee-form-adjustment-label">
                            <input
                                type="checkbox"
                                id="is_adjustment"
                                name="is_adjustment"
                                value="1"
                                class="fee-form-adjustment-checkbox"
                                {{ (string) $currentIsAdjustment === '1' ? 'checked' : '' }}
                            >
                            <span>Is Adjustment</span>
                        </label>
                    </div>

                    <div class="fee-form-actions">
                        <div class="fee-form-actions-right">
                            <a href="{{ route('fees.index') }}" class="fee-form-cancel">Cancel</a>
                            <button type="submit" class="fee-form-save">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <style>
        .fee-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 28px;
            row-gap: 24px;
        }

        .fee-conditional-section {
            margin-top: 24px;
        }

        .fee-conditional-section.is-hidden {
            display: none !important;
        }

        .fee-form-control {
            display: block;
            width: 100%;
            height: 44px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            padding: 0 12px;
        }

        .fee-form-control:focus {
            outline: none;
            border-color: #9ca3af;
        }

        select.fee-form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
        }

        .fee-form-adjustment {
            margin-top: 28px;
        }

        .fee-form-adjustment-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            user-select: none;
        }

        .fee-form-adjustment-checkbox {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: #111827;
            cursor: pointer;
        }

        .fee-form-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 28px;
            margin-top: 40px;
        }

        .fee-form-actions-right {
            grid-column: 2;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
        }

        .fee-form-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 96px;
            height: 40px;
            padding: 0 20px;
            border-radius: 8px;
            background: #e5e7eb;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }

        .fee-form-cancel:hover {
            background: #d1d5db;
        }

        .fee-form-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 96px;
            height: 40px;
            padding: 0 20px;
            border: 0;
            border-radius: 8px;
            background: #111827;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .fee-form-save:hover {
            background: #1f2937;
        }

        @media (max-width: 768px) {
            .fee-form-grid,
            .fee-form-actions {
                grid-template-columns: 1fr;
            }

            .fee-form-actions-right {
                grid-column: 1;
                justify-content: flex-start;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const feeForm = document.getElementById('feeForm');
            const feeTypeSelect = document.getElementById('fee_type_id');
            const feeFields = document.getElementById('feeFields');
            const discountFields = document.getElementById('discountFields');

            function getSelectedFeeTypeKey() {
                if (!feeTypeSelect) {
                    return '';
                }

                const selected = feeTypeSelect.options[feeTypeSelect.selectedIndex];

                if (!selected || !selected.value) {
                    return '';
                }

                return String(selected.getAttribute('data-fee-name') || '')
                    .toLowerCase()
                    .trim();
            }

            function setSectionEnabled(sectionEl, enabled, requiredIds) {
                if (!sectionEl) {
                    return;
                }

                if (enabled) {
                    sectionEl.hidden = false;
                    sectionEl.classList.remove('is-hidden');
                } else {
                    sectionEl.hidden = true;
                    sectionEl.classList.add('is-hidden');
                }

                sectionEl.querySelectorAll('input, select, textarea').forEach(function (el) {
                    el.disabled = !enabled;

                    if (requiredIds.indexOf(el.id) !== -1) {
                        if (enabled) {
                            el.setAttribute('required', 'required');
                        } else {
                            el.removeAttribute('required');
                        }
                    }
                });
            }

            function applyFeeTypeUi() {
                const key = getSelectedFeeTypeKey()
                    || String((feeForm && feeForm.getAttribute('data-initial-fee-type')) || '')
                        .toLowerCase()
                        .trim();

                const isFee = key === 'fee';
                const isDiscount = key === 'discount';

                setSectionEnabled(feeFields, isFee, ['amount']);
                setSectionEnabled(discountFields, isDiscount, ['discount_type', 'discount_value']);
            }

            if (feeTypeSelect) {
                // Ensure the option matching the record is selected before applying UI.
                const initialId = String({{ (int) $currentFeeTypeId }});
                if (initialId && feeTypeSelect.value !== initialId) {
                    feeTypeSelect.value = initialId;
                }

                feeTypeSelect.addEventListener('change', applyFeeTypeUi);
                applyFeeTypeUi();
            }
        });
    </script>

</x-app-layout>
