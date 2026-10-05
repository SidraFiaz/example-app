<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>{{ \App\Support\BrowserTitle::make('Fee Challan') }}</title>

    <style>

        @page {
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111;
            margin: 0;
            padding: 0;
        }

        /* =====================================================
           MAIN PAGE
        ====================================================== */

        .challan {
            border: 1.5px solid #222;
            padding: 18px;
            min-height: 700px;
        }


        /* =====================================================
           SCHOOL HEADER
        ====================================================== */

        .header {
            width: 100%;
            border-bottom: 1.5px solid #222;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .school-name {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .school-tagline {
            text-align: center;
            font-size: 10px;
            color: #555;
        }

        .challan-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 8px;
        }


        /* =====================================================
           SCHOOL INFORMATION
        ====================================================== */

        .school-info {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .school-info td {
            padding: 2px 0;
            font-size: 10px;
        }

        .right {
            text-align: right;
        }


        /* =====================================================
           CHALLAN INFORMATION
        ====================================================== */

        .challan-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .challan-info td {
            padding: 4px 0;
            font-size: 10px;
        }


        /* =====================================================
           STUDENT INFORMATION AREA
        ====================================================== */

        .student-area {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .photo-cell {
            width: 95px;
            height: 95px;
            border: 1px solid #444;
            text-align: center;
            vertical-align: middle;
        }

        .photo-placeholder {
            font-size: 9px;
            color: #777;
        }

        .details-cell {
            padding-left: 15px;
            vertical-align: top;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 6px 3px;
            border-bottom: 1px solid #777;
        }

        .detail-label {
            font-weight: bold;
            width: 85px;
        }


        /* =====================================================
           FEE TABLE
        ====================================================== */

        .fee-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .fee-table th {
            background: #eeeeee;
            border: 1px solid #555;
            padding: 7px;
            text-align: left;
            font-weight: bold;
        }

        .fee-table td {
            border: 1px solid #555;
            padding: 7px;
        }

        .fee-number {
            width: 7%;
        }

        .fee-month {
            width: 13%;
        }

        .fee-year {
            width: 15%;
        }

        .fee-amount {
            width: 20%;
            text-align: right !important;
        }

        .total-row td {
            font-weight: bold;
        }


        /* =====================================================
           PAYMENT STATUS
        ====================================================== */

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }

        .payment-table td {
            border: 1px solid #555;
            padding: 7px;
        }

        .payment-label {
            width: 30%;
            background: #eeeeee;
            font-weight: bold;
        }


        /* =====================================================
           SIGNATURES
        ====================================================== */

        .signature-area {
            width: 100%;
            margin-top: 45px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-box {
            width: 50%;
            text-align: center;
        }

        .signature-line {
            width: 75%;
            margin: 0 auto;
            border-top: 1px solid #222;
            padding-top: 5px;
            font-size: 9px;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .footer {
            margin-top: 45px;
            border-top: 4px solid #d0d0d0;
            padding-top: 7px;
            text-align: center;
            font-size: 9px;
            color: #555;
        }

    </style>
</head>


<body>

<div class="challan">


    {{-- =====================================================
         SCHOOL HEADER
    ====================================================== --}}

    <div class="header">

        <div class="school-name">
            KNOWLEDGE HORIZON SCHOOL
        </div>

        <div class="school-tagline">
            Excellence in Education
        </div>

        <table class="school-info">

            <tr>

                <td>
                    <strong>Branch Name:</strong>
                    Main Campus
                </td>

                <td class="right">
                    <strong>Report:</strong>
                    Fee Challan Receipt
                </td>

            </tr>

            <tr>

                <td>
                    <strong>Address:</strong>
                    School Campus
                </td>

                <td class="right">
                    <strong>Contact:</strong>
                    __________
                </td>

            </tr>

        </table>

        <div class="challan-title">
            FEE CHALLAN RECEIPT
        </div>

    </div>


    {{-- =====================================================
         CHALLAN NUMBER / DATE
    ====================================================== --}}

    <table class="challan-info">

        <tr>

            <td>

                <strong>Challan No:</strong>

                FC-{{ str_pad(
                    $fee_collection->id,
                    5,
                    '0',
                    STR_PAD_LEFT
                ) }}

            </td>


            <td class="right">

                <strong>Date:</strong>

                @if($fee_collection->payment_date)

                    {{ \Carbon\Carbon::parse(
                        $fee_collection->payment_date
                    )->format('d-m-Y') }}

                @else

                    __________

                @endif

            </td>

        </tr>

    </table>


    {{-- =====================================================
         STUDENT INFORMATION
    ====================================================== --}}

    <table class="student-area">

        <tr>


            {{-- STUDENT PHOTO --}}

            <td class="photo-cell">

                <div class="photo-placeholder">
                    STUDENT PHOTO
                </div>

            </td>


            {{-- STUDENT DETAILS --}}

            <td class="details-cell">

                <table class="details-table">


                    {{-- ROLL NUMBER --}}

                    <tr>

                        <td class="detail-label">
                            Roll No
                        </td>

                        <td>
                            {{ $fee_collection->student->roll_no ?? '________' }}
                        </td>

                    </tr>


                    {{-- STUDENT NAME --}}

                    <tr>

                        <td class="detail-label">
                            Student's Name
                        </td>

                        <td>
                            {{ $fee_collection->student->name ?? '________' }}
                        </td>

                    </tr>


                    {{-- FATHER NAME --}}

                    <tr>

                        <td class="detail-label">
                            Father Name
                        </td>

                        <td>
                            {{ $fee_collection->student->father_name ?? '________' }}
                        </td>

                    </tr>


                    {{-- CLASS / SECTION --}}

                    <tr>

                        <td class="detail-label">
                            Class
                        </td>

                        <td>
                            {{ optional(
                                $fee_collection->student->studentClass
                            )->class_name ?? '________' }}
                        </td>

                        <td class="detail-label">
                            Section
                        </td>

                        <td>
                            {{ optional(
                                $fee_collection->student->section
                            )->section_name ?? '________' }}
                        </td>

                    </tr>


                    {{-- RECEIVED AMOUNT --}}

                    <tr>

                        <td class="detail-label">
                            Received Amount
                        </td>

                        <td colspan="3">

                            Rs.
                            {{ number_format(
                                $totalAmount
                            ) }}

                        </td>

                    </tr>


                </table>

            </td>

        </tr>

    </table>


    {{-- =====================================================
         FEE DETAILS
    ====================================================== --}}

    <table class="fee-table">

        <thead>

            <tr>

                <th class="fee-number">
                    #
                </th>

                <th>
                    Fee Type
                </th>

                <th class="fee-month">
                    Month
                </th>

                <th class="fee-year">
                    Year
                </th>

                <th class="fee-amount">
                    Amount
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($fees as $index => $fee)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $fee->feeType->fee_name ?? 'Fee' }}
                    </td>

                    <td>
                        {{ $fee->month }}
                    </td>

                    <td>
                        {{ $fee->year }}
                    </td>

                    <td class="fee-amount">

                        Rs.
                        {{ number_format(
                            $fee->amount
                        ) }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" style="text-align:center;">
                        No fee records found.
                    </td>

                </tr>

            @endforelse


            {{-- TOTAL --}}

            <tr class="total-row">

                <td colspan="4" class="right">
                    Total Amount
                </td>

                <td class="fee-amount">

                    Rs.
                    {{ number_format(
                        $totalAmount
                    ) }}

                </td>

            </tr>

        </tbody>

    </table>


    {{-- =====================================================
         PAYMENT STATUS
    ====================================================== --}}

    <table class="payment-table">

        <tr>

            <td class="payment-label">
                Payment Status
            </td>

            <td>
                {{ ucfirst(
                    $fee_collection->status ?? 'Pending'
                ) }}
            </td>

        </tr>


        <tr>

            <td class="payment-label">
                Remarks
            </td>

            <td>
                {{ $fee_collection->remarks ?? 'N/A' }}
            </td>

        </tr>

    </table>


    {{-- =====================================================
         SIGNATURES
    ====================================================== --}}

    <div class="signature-area">

        <table class="signature-table">

            <tr>

                <td class="signature-box">

                    <div class="signature-line">
                        Parent / Guardian Signature
                    </div>

                </td>


                <td class="signature-box">

                    <div class="signature-line">
                        Signature and Stamp
                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer">

        This is a computer-generated fee challan receipt.

    </div>


</div>

</body>
</html>