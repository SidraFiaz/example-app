<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Paper fund list
            </h2>

            <div class="text-sm text-gray-500 mt-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Home</a>
                <span class="mx-1">/</span>
                <span>Paper Funds</span>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="card border shadow-sm">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-3 px-4">
                    <div>
                        <h5 class="mb-1 fw-semibold text-dark">Paper fund list</h5>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 small">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Paper Funds</li>
                            </ol>
                        </nav>
                    </div>

                    <button
                        type="button"
                        class="btn btn-primary btn-sm px-3"
                        data-bs-toggle="modal"
                        data-bs-target="#receivePaperFundModal"
                    >
                        Receive Paper Fund
                    </button>
                </div>

                <div class="card-body p-4">

                    <form method="GET" action="{{ route('paper-funds.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="searchStudent" class="form-label mb-1">Search Student</label>
                                <input
                                    type="text"
                                    name="student"
                                    id="searchStudent"
                                    value="{{ request('student') }}"
                                    placeholder="Search Student"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="searchFamily" class="form-label mb-1">Search Family #</label>
                                <input
                                    type="text"
                                    name="family_no"
                                    id="searchFamily"
                                    value="{{ request('family_no') }}"
                                    placeholder="Search Family #"
                                    class="form-control"
                                >
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ROLL #</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">FATHER NAME</th>
                                    <th scope="col">FAMILY #</th>
                                    <th scope="col">CLASS</th>
                                    <th scope="col">SECION</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paperFunds as $paperFund)
                                    @php
                                        $admission = $paperFund->admission;
                                    @endphp

                                    <tr>
                                        <td>{{ $admission?->id ?? '-' }}</td>
                                        <td>{{ $admission?->student_name ?? '-' }}</td>
                                        <td>{{ $admission?->father_name ?? '-' }}</td>
                                        <td>{{ $admission?->family_no ?? '-' }}</td>
                                        <td>{{ $admission?->studentClass?->class_name ?? '-' }}</td>
                                        <td>{{ $admission?->section?->section_name ?? '-' }}</td>
                                        <td>{{ number_format($paperFund->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No data available in table
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

    {{-- Receive Paper Fund Modal --}}
    <div
        class="modal fade"
        id="receivePaperFundModal"
        tabindex="-1"
        aria-labelledby="receivePaperFundModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="receivePaperFundModalLabel">
                        Receive Paper Fund
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="modalFamilyNo" class="form-label">Search by Family No</label>
                            <input
                                type="text"
                                class="form-control"
                                id="modalFamilyNo"
                                placeholder="Enter Family No"
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="modalStudentCode" class="form-label">Search by Student Code</label>
                            <input
                                type="text"
                                class="form-control"
                                id="modalStudentCode"
                                placeholder="Enter Student Code"
                            >
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-primary" id="modalSearchBtn">
                            Search
                        </button>
                        <button type="button" class="btn btn-secondary" id="modalResetBtn">
                            Reset
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="modalSaveFundBtn">
                        Save Fund
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const familyNoInput = document.getElementById('modalFamilyNo');
            const studentCodeInput = document.getElementById('modalStudentCode');
            const resetBtn = document.getElementById('modalResetBtn');
            const saveFundBtn = document.getElementById('modalSaveFundBtn');
            const modalElement = document.getElementById('receivePaperFundModal');

            resetBtn.addEventListener('click', function () {
                familyNoInput.value = '';
                studentCodeInput.value = '';
            });

            document.getElementById('modalSearchBtn').addEventListener('click', function () {
                // Frontend-only search for now
            });

            saveFundBtn.addEventListener('click', function () {
                alert('Fund saved successfully');
            });

            modalElement.addEventListener('hidden.bs.modal', function () {
                familyNoInput.value = '';
                studentCodeInput.value = '';
            });
        });
    </script>

</x-app-layout>
