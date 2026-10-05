<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>{{ \App\Support\BrowserTitle::make('Fee Warning Notice') }}</title>

    <style>
        @page {
            margin: 30px 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
        }

        .school-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .school-name {
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .report-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }

        .line {
            border-bottom: 1px solid #222;
            margin: 10px 0 12px 0;
        }

        .student-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .student-info td {
            padding: 7px 4px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 13%;
        }

        .value {
            width: 37%;
        }

        .fee-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .fee-table th,
        .fee-table td {
            border: 1px solid #555;
            padding: 8px;
        }

        .fee-table th {
            text-align: left;
            font-weight: bold;
        }

        .amount {
            text-align: right;
            font-weight: bold;
        }

        .notice {
            margin-top: 20px;
            line-height: 1.6;
        }

        .signature {
            margin-top: 100px;
            text-align: right;
            font-weight: bold;
        }

        .footer-line {
            border-bottom: 1px solid #222;
            margin-top: 170px;
        }
    </style>
</head>

<body>

<div class="page">

    {{-- SCHOOL NAME --}}
    <div class="school-header">

        <div class="school-name">
            Knowledge Heights Academy
        </div>

        <div class="report-title">
            FEE WARNING NOTICE
        </div>

    </div>

    <div class="line"></div>


    {{-- STUDENT INFORMATION --}}
    <table class="student-info">

        <tr>
            <td class="label">
                Roll No:
            </td>

            <td class="value">
                {{ $student->id ?? 'N/A' }}
            </td>

            <td class="label">
                Issue Date:
            </td>

            <td class="value">
                {{ now()->format('d-m-Y') }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Name:
            </td>

            <td class="value">
                {{ $student->name ?? 'N/A' }}
            </td>

            <td class="label">
                Class/Section:
            </td>

            <td class="value">
                {{ $student->studentClass->class_name ?? 'N/A' }}
                /
                {{ $student->section->section_name ?? 'N/A' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Father Name:
            </td>

            <td class="value">
                {{ $student->father_name ?? 'N/A' }}
            </td>

            <td class="label">
                Mobile #:
            </td>

            <td class="value">
                N/A
            </td>
        </tr>

    </table>


    {{-- FEE INFORMATION --}}
    <table class="fee-table">

        <thead>
            <tr>
                <th style="width: 25%;">
                    Fee Information
                </th>

                <th>
                    Balance
                </th>

                <th class="amount">
                    Total Amount: {{ number_format($totalAmount ?? 0) }}/-
                </th>
            </tr>
        </thead>

        <tbody>

            @forelse($fees as $fee)

                <tr>

                    <td>
                        {{ $fee->feeType->fee_name ?? 'Fee' }}
                    </td>

                    <td>
                        {{ $fee->month ?? '' }}-{{ $fee->year ?? '' }}
                    </td>

                    <td class="amount">
                        {{ number_format($fee->amount ?? 0) }}/-
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="3">
                        No outstanding fee record found.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- NOTICE --}}
    <div class="notice">

        <strong>Notice:</strong>

        Please deposit fee balance within one day of notice
        otherwise student will not be allowed to sit in class
        and will be expelled.

    </div>


    {{-- SIGNATURE --}}
    <div class="signature">
        Authorized Signature
    </div>


    <div class="footer-line"></div>

</div>

</body>
</html>