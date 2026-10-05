<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">
                    Classes
                </h2>
                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-black">
                        Home
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">Classes</span>
                </div>
            </div>

            <button
                type="button"
                id="openCreateClassModal"
                class="classes-create-btn"
            >
                Create
            </button>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="classes-page-wrap mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-[0_1px_8px_rgba(0,0,0,0.06)] p-6 sm:p-10">

                <div class="mb-10">
                    <label for="classSearch" class="block text-sm text-gray-600 mb-2">
                        Search Class
                    </label>
                    <input
                        type="text"
                        id="classSearch"
                        class="classes-search"
                        autocomplete="off"
                    >
                </div>

                <div class="classes-list-head">
                    <div class="classes-list-head-name">Class Name</div>
                    <div class="classes-list-head-action">Action</div>
                </div>

                <div class="classes-list">
                    @forelse($classes as $class)
                        <div
                            class="classes-row"
                            data-name="{{ strtolower($class->class_name) }}"
                        >
                            <div class="classes-row-name">
                                {{ $class->class_name }}
                            </div>

                            <div class="classes-row-action">
                                <div
                                    x-data="{
                                        open: false,
                                        top: 0,
                                        left: 0,
                                        toggleMenu() {
                                            const rect = this.$refs.button.getBoundingClientRect();
                                            const menuWidth = 180;
                                            const menuHeight = 300;

                                            this.left = Math.min(
                                                rect.right - menuWidth,
                                                window.innerWidth - menuWidth - 10
                                            );

                                            if (rect.bottom + menuHeight > window.innerHeight) {
                                                this.top = Math.max(8, rect.top - menuHeight - 8);
                                            } else {
                                                this.top = rect.bottom + 8;
                                            }

                                            this.open = !this.open;
                                        }
                                    }"
                                    class="inline-block"
                                >
                                    <button
                                        type="button"
                                        x-ref="button"
                                        @click="toggleMenu()"
                                        class="classes-gear-btn"
                                        aria-label="Actions for {{ $class->class_name }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>

                                    <template x-teleport="body">
                                        <div
                                            x-show="open"
                                            x-transition
                                            @click.outside="open = false"
                                            :style="`position: fixed; top: ${top}px; left: ${left}px;`"
                                            style="display: none;"
                                            class="classes-gear-menu"
                                        >
                                            <a
                                                href="{{ route('classes.edit', $class->id) }}"
                                                class="classes-gear-item"
                                            >
                                                Edit
                                            </a>

                                            <a
                                                href="{{ route('sections.index', $class->id) }}"
                                                class="classes-gear-item"
                                            >
                                                Sections
                                            </a>

                                            <a
                                                href="{{ route('subjects.index', ['class_id' => $class->id]) }}"
                                                class="classes-gear-item"
                                            >
                                                Subjects
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('classes.delete', $class->id) }}"
                                                data-delete-confirm="Are you sure you want to delete this class?"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="classes-gear-item classes-gear-item-button"
                                                >
                                                    Delete
                                                </button>
                                            </form>

                                            <button
                                                type="button"
                                                class="classes-gear-item classes-gear-item-button"
                                                data-open-add-discount
                                                data-class-id="{{ $class->id }}"
                                                data-class-name="{{ $class->class_name }}"
                                            >
                                                Add Discount
                                            </button>

                                            <a
                                                href="{{ route('result-grades.index') }}"
                                                class="classes-gear-item"
                                            >
                                                Sample Result
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="classes-empty">No classes found.</p>
                    @endforelse
                </div>

                <p id="classNoResults" class="classes-empty" style="display: none;">
                    No matching classes found.
                </p>

            </div>
        </div>
    </div>

    {{-- Add Class Modal --}}
    <div
        id="createClassModal"
        class="classes-modal"
        aria-hidden="true"
        @if($errors->has('class_name')) data-open-on-load="1" @endif
    >
        <div class="classes-modal-overlay"></div>

        <div
            class="classes-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="createClassModalTitle"
        >
            <div class="classes-modal-header">
                <h3 id="createClassModalTitle">Add Class Data</h3>
                <button
                    type="button"
                    class="classes-modal-x"
                    data-close-create-class
                    aria-label="Close"
                >
                    &times;
                </button>
            </div>

            <form method="POST" action="{{ route('classes.store') }}" id="createClassForm">
                @csrf

                <div class="classes-modal-body">
                    <label for="modal_class_name" class="classes-modal-label">
                        Class Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="modal_class_name"
                        name="class_name"
                        value="{{ old('class_name') }}"
                        class="classes-modal-input"
                        required
                        autocomplete="off"
                    >
                    @error('class_name')
                        <p class="classes-modal-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="classes-modal-footer">
                    <button
                        type="button"
                        class="classes-modal-close"
                        data-close-create-class
                    >
                        Close
                    </button>
                    <button type="submit" class="classes-modal-save">
                        Save Class
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Class Discount Modal --}}
    <div
        id="addDiscountModal"
        class="classes-modal"
        aria-hidden="true"
        @if($errors->has('discount_value') && old('return_to') === 'classes') data-open-on-load="1" @endif
    >
        <div class="classes-modal-overlay"></div>

        <div
            class="classes-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="addDiscountModalTitle"
        >
            <div class="classes-modal-header">
                <h3 id="addDiscountModalTitle">
                    Add
                    [
                    <span id="addDiscountClassName">{{ old('class_name_label', '') }}</span>
                    ]
                    Class Discount
                </h3>
                <button
                    type="button"
                    class="classes-modal-x"
                    data-close-add-discount
                    aria-label="Close"
                >
                    &times;
                </button>
            </div>

            <form method="POST" action="{{ route('discounts.store') }}" id="addDiscountForm">
                @csrf

                <input type="hidden" name="class_id" id="addDiscountClassId" value="{{ old('class_id') }}">
                <input type="hidden" name="class_name_label" id="addDiscountClassNameInput" value="{{ old('class_name_label') }}">
                <input type="hidden" name="discount_type" value="fixed">
                <input type="hidden" name="status" value="Active">
                <input type="hidden" name="return_to" value="classes">

                <div class="classes-modal-body">
                    <label for="modal_discount_value" class="classes-modal-label">
                        Class Discount <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        step="any"
                        min="0"
                        id="modal_discount_value"
                        name="discount_value"
                        value="{{ old('discount_value') }}"
                        class="classes-modal-input"
                        required
                        autocomplete="off"
                    >
                    @error('discount_value')
                        <p class="classes-modal-error">{{ $message }}</p>
                    @enderror
                    @error('class_id')
                        <p class="classes-modal-error">{{ $message }}</p>
                    @enderror
                    @error('discount')
                        <p class="classes-modal-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="classes-modal-footer">
                    <button
                        type="button"
                        class="classes-modal-close"
                        data-close-add-discount
                    >
                        Close
                    </button>
                    <button type="submit" class="classes-modal-save">
                        Save Discount
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .classes-page-wrap {
            width: 55%;
            max-width: 900px;
            min-width: 500px;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .classes-page-wrap {
                width: 100%;
                max-width: 100%;
                min-width: 0;
            }
        }

        .classes-create-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 96px;
            height: 40px;
            padding: 0 22px;
            border-radius: 8px;
            background: #111827;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
        }

        .classes-create-btn:hover {
            background: #1f2937;
            color: #ffffff;
        }

        .classes-search {
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

        .classes-search:focus {
            outline: none;
            border-color: #9ca3af;
            box-shadow: none;
        }

        .classes-list-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 0 4px;
        }

        .classes-list-head-name,
        .classes-list-head-action {
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
        }

        .classes-list-head-name {
            flex: 1 1 auto;
            padding-left: 16px;
            text-align: left;
        }

        .classes-list-head-action {
            width: 88px;
            flex: 0 0 88px;
            padding-right: 16px;
            text-align: right;
        }

        .classes-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .classes-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            min-height: 58px;
            padding: 10px 16px;
            box-sizing: border-box;
        }

        .classes-row-name {
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            padding-right: 16px;
            font-size: 15px;
            color: #374151;
            min-width: 0;
            word-break: break-word;
        }

        .classes-row-action {
            width: 56px;
            flex: 0 0 56px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .classes-gear-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 0;
            background: #e5e7eb;
            color: #374151;
            cursor: pointer;
            border-radius: 6px;
            padding: 0;
        }

        .classes-gear-btn:hover {
            background: #d1d5db;
            color: #111827;
        }

        .classes-gear-menu {
            width: 180px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            z-index: 9999;
            overflow: hidden;
            padding: 4px 0;
        }

        .classes-gear-item {
            display: block;
            width: 100%;
            padding: 10px 16px;
            font-size: 14px;
            line-height: 1.25;
            color: #374151;
            text-decoration: none;
            text-align: left;
            background: transparent;
            border: 0;
            cursor: pointer;
            box-sizing: border-box;
        }

        .classes-gear-item:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .classes-gear-item-button {
            font-family: inherit;
        }

        .classes-empty {
            text-align: center;
            padding: 36px 16px;
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 640px) {
            .classes-list-head-name {
                padding-left: 12px;
            }

            .classes-list-head-action {
                padding-right: 12px;
            }

            .classes-row {
                padding: 10px 12px;
            }
        }

        .classes-modal {
            position: fixed;
            inset: 0;
            z-index: 80;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .classes-modal.is-open {
            display: flex;
        }

        .classes-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .classes-modal-dialog {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 560px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
            overflow: hidden;
        }

        .classes-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .classes-modal-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            padding-right: 12px;
            line-height: 1.35;
            word-break: break-word;
        }

        .classes-modal-x {
            border: 0;
            background: transparent;
            color: #6b7280;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
            padding: 0 4px;
        }

        .classes-modal-x:hover {
            color: #111827;
        }

        .classes-modal-body {
            padding: 22px 20px;
        }

        .classes-modal-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .classes-modal-input {
            display: block;
            width: 100%;
            height: 44px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
            padding: 0 12px;
        }

        .classes-modal-input:focus {
            outline: none;
            border-color: #9ca3af;
        }

        .classes-modal-error {
            margin-top: 8px;
            font-size: 13px;
            color: #dc2626;
        }

        .classes-modal-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            padding: 16px 20px;
            border-top: 1px solid #e5e7eb;
        }

        .classes-modal-close {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 88px;
            height: 40px;
            padding: 0 18px;
            border: 0;
            border-radius: 8px;
            background: #9ca3af;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .classes-modal-close:hover {
            background: #6b7280;
        }

        .classes-modal-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 110px;
            height: 40px;
            padding: 0 18px;
            border: 0;
            border-radius: 8px;
            background: #111827;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .classes-modal-save:hover {
            background: #1f2937;
        }

        .classes-create-btn {
            border: 0;
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('classSearch');
            const rows = document.querySelectorAll('.classes-row');
            const noResults = document.getElementById('classNoResults');

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();
                    let visibleCount = 0;

                    rows.forEach(function (row) {
                        const name = row.getAttribute('data-name') || '';
                        const matches = name.indexOf(query) !== -1;
                        row.style.display = matches ? 'flex' : 'none';
                        if (matches) {
                            visibleCount++;
                        }
                    });

                    if (noResults) {
                        noResults.style.display = (visibleCount > 0 || rows.length === 0) ? 'none' : 'block';
                    }
                });
            }

            const modal = document.getElementById('createClassModal');
            const openBtn = document.getElementById('openCreateClassModal');
            const classInput = document.getElementById('modal_class_name');
            const createForm = document.getElementById('createClassForm');

            function openCreateModal() {
                if (!modal) return;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
                setTimeout(function () {
                    if (classInput) {
                        classInput.focus();
                    }
                }, 50);
            }

            function closeCreateModal() {
                if (!modal) return;
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
                if (createForm && !modal.hasAttribute('data-keep-values')) {
                    createForm.reset();
                }
                modal.removeAttribute('data-keep-values');
            }

            if (openBtn) {
                openBtn.addEventListener('click', openCreateModal);
            }

            if (modal) {
                modal.querySelectorAll('[data-close-create-class]').forEach(function (el) {
                    el.addEventListener('click', closeCreateModal);
                });

                if (modal.getAttribute('data-open-on-load') === '1') {
                    modal.setAttribute('data-keep-values', '1');
                    openCreateModal();
                }
            }

            const discountModal = document.getElementById('addDiscountModal');
            const discountForm = document.getElementById('addDiscountForm');
            const discountValueInput = document.getElementById('modal_discount_value');
            const discountClassId = document.getElementById('addDiscountClassId');
            const discountClassName = document.getElementById('addDiscountClassName');
            const discountClassNameInput = document.getElementById('addDiscountClassNameInput');

            function openDiscountModal(classId, className) {
                if (!discountModal) return;

                if (discountClassId) {
                    discountClassId.value = classId || '';
                }
                if (discountClassName) {
                    discountClassName.textContent = className || '';
                }
                if (discountClassNameInput) {
                    discountClassNameInput.value = className || '';
                }

                discountModal.classList.add('is-open');
                discountModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');

                setTimeout(function () {
                    if (discountValueInput) {
                        discountValueInput.focus();
                    }
                }, 50);
            }

            function closeDiscountModal() {
                if (!discountModal) return;
                discountModal.classList.remove('is-open');
                discountModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');

                if (discountForm && !discountModal.hasAttribute('data-keep-values')) {
                    if (discountValueInput) {
                        discountValueInput.value = '';
                    }
                }
                discountModal.removeAttribute('data-keep-values');
            }

            document.querySelectorAll('[data-open-add-discount]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    openDiscountModal(
                        btn.getAttribute('data-class-id'),
                        btn.getAttribute('data-class-name')
                    );
                });
            });

            if (discountModal) {
                discountModal.querySelectorAll('[data-close-add-discount]').forEach(function (el) {
                    el.addEventListener('click', closeDiscountModal);
                });

                if (discountModal.getAttribute('data-open-on-load') === '1') {
                    discountModal.setAttribute('data-keep-values', '1');
                    openDiscountModal(
                        discountClassId ? discountClassId.value : '',
                        discountClassNameInput ? discountClassNameInput.value : ''
                    );
                }
            }

            document.addEventListener('keydown', function (event) {
                if (event.key !== 'Escape') {
                    return;
                }

                if (discountModal && discountModal.classList.contains('is-open')) {
                    closeDiscountModal();
                    return;
                }

                if (modal && modal.classList.contains('is-open')) {
                    closeCreateModal();
                }
            });
        });
    </script>

</x-app-layout>
