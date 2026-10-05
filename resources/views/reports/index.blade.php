<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Reports
            </h2>

            <div class="text-sm text-gray-500 mt-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Home</a>
                <span class="mx-1">/</span>
                <span>Reports</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8">

                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Reports
                </label>

                <div
                    class="relative"
                    x-data="reportSelector(@js($reportTypes))"
                    @keydown.escape.window="open = false"
                >

                    {{-- Searchable dropdown trigger --}}
                    <div class="relative">
                        <input
                            type="text"
                            x-model="search"
                            @focus="open = true"
                            @click="open = true"
                            @input="open = true; selected = null"
                            :placeholder="selected ? selected.label : 'Select Report Type'"
                            class="w-full h-14 px-4 pr-10 text-base border border-gray-300 rounded-md
                                   focus:border-blue-500 focus:ring-blue-500"
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            @click="open = !open"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Dropdown list --}}
                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-72 overflow-y-auto"
                    >

                        <template x-if="filteredReports.length === 0">
                            <div class="px-4 py-3 text-sm text-gray-500">
                                No reports found
                            </div>
                        </template>

                        <template x-for="report in filteredReports" :key="report.route">
                            <button
                                type="button"
                                @click="selectReport(report)"
                                class="block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100 last:border-b-0"
                                :class="{ 'bg-gray-100 text-gray-900 font-medium': selected && selected.route === report.route }"
                                x-text="report.label"
                            ></button>
                        </template>

                    </div>

                    {{-- View Report --}}
                    <div class="flex justify-center mt-10">
                        <button
                            type="button"
                            @click="viewReport()"
                            :disabled="!selected"
                            :class="selected
                                ? 'bg-[#111827] hover:bg-gray-800 cursor-pointer'
                                : 'bg-gray-300 cursor-not-allowed'"
                            class="px-10 py-2.5 text-white text-sm font-medium rounded-md transition"
                        >
                            View Report
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
        function reportSelector(reports) {
            return {
                open: false,
                search: '',
                selected: null,
                reports: reports,

                get filteredReports() {
                    const query = this.search.trim().toLowerCase();

                    if (!query) {
                        return this.reports;
                    }

                    return this.reports.filter((report) => {
                        return report.label.toLowerCase().includes(query)
                            || report.keywords.toLowerCase().includes(query)
                            || report.group.toLowerCase().includes(query);
                    });
                },

                selectReport(report) {
                    this.selected = report;
                    this.search = report.label;
                    this.open = false;
                },

                viewReport() {
                    if (!this.selected) {
                        return;
                    }

                    window.location.href = this.selected.url;
                },
            };
        }
    </script>

</x-app-layout>
