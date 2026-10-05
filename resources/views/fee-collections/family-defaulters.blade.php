<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>{{ \App\Support\BrowserTitle::make('Family Defaulter Report') }}</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 25px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111;
            margin: 0;
            padding: 0;
        }

        /* ---------------------------------------------------------
           HEADER
        --------------------------------------------------------- */

        .header {
            width: 100%;
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .school-name {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .tagline {
            text-align: center;
            font-size: 15px;
            color: #555;
            margin-bottom: 14px;
        }

        .report-info {
            width: 100%;
            border: none;
            margin: 0;
        }

        .report-info td {
            border: none;
            padding: 3px 0;
            font-size: 11px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
        }

        /* ---------------------------------------------------------
           REPORT TITLE
        --------------------------------------------------------- */

        .report-heading {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            background: #eeeeee;
            border: 1px solid #222;
            padding: 8px;
            margin-top: 12px;
        }

        /* ---------------------------------------------------------
           MAIN TABLE
        --------------------------------------------------------- */

        .family-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .family-table th {
            border: 1px solid #222;
            background: #eeeeee;
            text-align: center;
            font-weight: bold;
            padding: 8px 5px;
            vertical-align: middle;
        }

        .family-table td {
            border: 1px solid #222;
            padding: 7px 6px;
            vertical-align: middle;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .student-info {
            line-height: 1.6;
        }

        .student-row {
            margin-bottom: 2px;
        }

        .student-number {
            font-weight: bold;
        }

        .contact {
            text-align: center;
            line-height: 1.6;
        }

        .balance {
            text-align: right;
            font-weight: bold;
        }

        .total-row td {
            background: #eeeeee;
            font-weight: bold;
        }

        /* ---------------------------------------------------------
           FOOTER
        --------------------------------------------------------- */

        .footer {
            width: 100%;
            margin-top: 15px;
            font-size: 9px;
        }

        .footer-left {
            text-align: left;
        }

        .footer-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- =========================================================
         SCHOOL HEADER
    ========================================================== -->

    <div class="header">

        <div class="school-name">
            KNOWLEDGE HORIZON SCHOOL
        </div>

        <div class="tagline">
            Excellence in Education
        </div>

        <table class="report-info">

            <tr>

                <td style="width: 12%;">
                    <span class="label">Branch Name:</span>
                </td>

                <td style="width: 38%;">
                    Main Campus
                </td>

                <td style="width: 12%;">
                    <span class="label">Report:</span>
                </td>

                <td style="width: 38%;">
                    Family Defaulter Report
                </td>

            </tr>

            <tr>

                <td>
                    <span class="label">Address:</span>
                </td>

                <td>
                    School Campus
                </td>

                <td>
                    <span class="label">Date:</span>
                </td>

                <td>
                    {{ date('d-m-Y') }}
                </td>

            </tr>

        </table>

    </div>


    <!-- =========================================================
         REPORT HEADING
    ========================================================== -->

    <div class="report-heading">
        Family Defaulters
    </div>


    <!-- =========================================================
         FAMILY DEFAULTER TABLE
    ========================================================== -->

    <table class="family-table">

        <thead>

            <tr>

                <th style="width: 5%;">
                    #
                </th>

                <th style="width: 10%;">
                    Family #
                </th>

                <th style="width: 11%;">
                    Total<br>
                    Students
                </th>

                <th style="width: 43%;">
                    Student Info
                </th>

                <th style="width: 16%;">
                    Father Contact
                </th>

                <th style="width: 15%;">
                    Defaulter<br>
                    Balance
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($families as $index => $family)

                <tr>

                    <!-- # -->

                    <td class="center">
                        {{ $index + 1 }}
                    </td>


                    <!-- FAMILY # -->

                    <td class="center">
                        {{ $family['family_no'] ?: '-' }}
                    </td>


                    <!-- TOTAL STUDENTS -->

                    <td class="center">
                        {{ $family['total_students'] }}
                    </td>


                    <!-- STUDENT INFO -->

                    <td>

                        <div class="student-info">

                            @foreach($family['student_info'] as $studentIndex => $student)

                                <div class="student-row">

                                    <span class="student-number">
                                        {{ $studentIndex + 1 }}.
                                    </span>

                                    {{ $student['name'] }}

                                    @if(!empty($student['student_code']))
                                        ({{ $student['student_code'] }})
                                    @endif

                                </div>

                            @endforeach

                        </div>

                    </td>


                    <!-- FATHER CONTACT -->

                    <td class="contact">

                        @if(!empty($family['father_contacts']))

                            @foreach($family['father_contacts'] as $contact)

                                <div>
                                    {{ $contact }}
                                </div>

                            @endforeach

                        @else

                            -

                        @endif

                    </td>


                    <!-- DEFAULTER BALANCE -->

                    <td class="balance">

                        {{ number_format(
                            (float) $family['defaulter_balance'],
                            0
                        ) }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="center"
                        style="padding: 20px;"
                    >
                        No family defaulters found.
                    </td>

                </tr>

            @endforelse

        </tbody>


        <!-- =====================================================
             TOTAL
        ====================================================== -->

        @if($families->count() > 0)

            <tfoot>

                <tr class="total-row">

                    <td
                        colspan="2"
                        class="right"
                    >
                        TOTAL
                    </td>

                    <td class="center">
                        {{ $families->sum('total_students') }}
                    </td>

                    <td colspan="2">
                    </td>

                    <td class="balance">

                        {{ number_format(
                            $families->sum('defaulter_balance'),
                            0
                        ) }}

                    </td>

                </tr>

            </tfoot>

        @endif

    </table>


    <!-- =========================================================
         FOOTER
    ========================================================== -->

    <div class="footer">

        <table style="width:100%; border:none;">

            <tr>

                <td
                    class="footer-left"
                    style="border:none;"
                >
                    Family Defaulter Report
                </td>

                <td
                    class="footer-right"
                    style="border:none;"
                >
                    Generated on {{ date('d-m-Y') }}
                </td>

            </tr>

        </table>

    </div>

</body>
</html>