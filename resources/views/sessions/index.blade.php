<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">
                    Sessions
                </h2>
                <div class="flex items-center gap-2 text-sm mt-1">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-black">
                        Home
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-500">Sessions</span>
                </div>
            </div>

            <a
                href="{{ route('sessions.create') }}"
                class="sessions-create-btn"
            >
                Create Session
            </a>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="sessions-page-wrap mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-[0_1px_8px_rgba(0,0,0,0.06)] p-6 sm:p-10">

                <div class="mb-10">
                    <label for="sessionSearch" class="block text-sm text-gray-600 mb-2">
                        Search Session
                    </label>
                    <input
                        type="text"
                        id="sessionSearch"
                        class="sessions-search"
                        autocomplete="off"
                        placeholder="Search session..."
                    >
                </div>

                <div class="overflow-x-auto">
                    <table class="sessions-table">
                        <thead>
                            <tr>
                                <th class="sessions-th-name">Session Name</th>
                                <th class="sessions-th-status">Status</th>
                                <th class="sessions-th-action">Action</th>
                            </tr>
                        </thead>

                        <tbody id="sessionTable">
                            @forelse ($sessions as $session)
                                <tr class="session-row">
                                    <td class="sessions-td-name">
                                        {{ $session->name }}
                                    </td>

                                    <td class="sessions-td-status">
                                        @if ($session->is_active)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>

                                    <td class="sessions-td-action">
                                        <div
                                            x-data="{
                                                open: false,
                                                top: 0,
                                                left: 0,
                                                toggleMenu() {
                                                    const rect = this.$refs.button.getBoundingClientRect();
                                                    const menuWidth = 180;
                                                    const menuHeight = 220;

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
                                                class="sessions-gear-btn"
                                                aria-label="Actions for {{ $session->name }}"
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
                                                    class="sessions-gear-menu"
                                                >
                                                    <a
                                                        href="{{ route('sessions.edit', $session->id) }}"
                                                        class="sessions-gear-item"
                                                    >
                                                        Edit
                                                    </a>

                                                    <a
                                                        href="{{ route('exams.index', ['session_id' => $session->id]) }}"
                                                        class="sessions-gear-item"
                                                    >
                                                        Exam
                                                    </a>

                                                    <a
                                                        href="{{ route('session-periods.index', $session->id) }}"
                                                        class="sessions-gear-item"
                                                    >
                                                        Session Period
                                                    </a>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('sessions.destroy', $session->id) }}"
                                                        data-delete-confirm="Are you sure you want to delete this session?"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit"
                                                            class="sessions-gear-item sessions-gear-item-button sessions-gear-item-delete"
                                                        >
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="sessions-empty">
                                        No sessions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p id="sessionNoResults" class="sessions-empty" style="display: none;">
                    No matching sessions found.
                </p>

            </div>
        </div>
    </div>

    <style>
        .sessions-page-wrap {
            width: 100%;
            max-width: 1100px;
            box-sizing: border-box;
        }

        .sessions-create-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 132px;
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

        .sessions-create-btn:hover {
            background: #1f2937;
            color: #ffffff;
        }

        .sessions-search {
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

        .sessions-search:focus {
            outline: none;
            border-color: #9ca3af;
            box-shadow: none;
        }

        .sessions-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 520px;
        }

        .sessions-table thead th {
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
            text-align: left;
            padding: 0 12px 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .sessions-th-name {
            width: auto;
        }

        .sessions-th-status {
            width: 140px;
        }

        .sessions-th-action {
            width: 88px;
            text-align: right !important;
            padding-right: 8px !important;
        }

        .sessions-table tbody td {
            padding: 16px 12px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .sessions-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .sessions-td-name {
            font-size: 15px;
            color: #374151;
            word-break: break-word;
        }

        .sessions-td-status {
            font-size: 14px;
            color: #4b5563;
        }

        .sessions-td-action {
            text-align: right;
        }

        .sessions-gear-btn {
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

        .sessions-gear-btn:hover {
            background: #d1d5db;
            color: #111827;
        }

        .sessions-gear-menu {
            width: 180px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            padding: 6px 0;
            z-index: 9999;
        }

        .sessions-gear-item {
            display: block;
            width: 100%;
            padding: 10px 16px;
            font-size: 14px;
            color: #374151;
            text-decoration: none;
            text-align: left;
            background: transparent;
            border: 0;
            cursor: pointer;
            box-sizing: border-box;
        }

        .sessions-gear-item:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .sessions-gear-item-button {
            font-family: inherit;
        }

        .sessions-gear-item-delete {
            color: #dc2626;
        }

        .sessions-gear-item-delete:hover {
            background: #fef2f2;
            color: #b91c1c;
        }

        .sessions-empty {
            padding: 28px 12px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .sessions-page-wrap {
                max-width: 100%;
            }

            .sessions-th-status,
            .sessions-td-status {
                width: 100px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('sessionSearch');
            const rows = document.querySelectorAll('.session-row');
            const noResults = document.getElementById('sessionNoResults');
            const table = document.querySelector('.sessions-table');

            if (!searchInput) {
                return;
            }

            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach(function (row) {
                    const sessionName = row.querySelector('td').textContent.toLowerCase();
                    const matches = sessionName.includes(searchValue);

                    row.style.display = matches ? '' : 'none';

                    if (matches) {
                        visibleCount += 1;
                    }
                });

                if (noResults) {
                    noResults.style.display = (rows.length > 0 && visibleCount === 0) ? '' : 'none';
                }

                if (table) {
                    table.style.display = (rows.length > 0 && visibleCount === 0) ? 'none' : '';
                }
            });
        });
    </script>

</x-app-layout>
