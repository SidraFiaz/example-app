<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ \App\Support\BrowserTitle::make('Deleted Students') }}</title>

    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #333;
        }

        .container {
            width: 100%;
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        .breadcrumb {
            margin-top: 8px;
            margin-bottom: 15px;
        }

        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12);
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #707070;
            color: white;
            text-align: left;
            padding: 16px 10px;
        }

        td {
            padding: 14px 10px;
            border: 1px solid #ddd;
            background: white;
        }

        .restore-btn {
            background: #4077e5;
            color: white;
            border: none;
            padding: 11px 40px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .restore-btn:hover {
            background: #2864d4;
        }

        .empty {
            text-align: center;
            padding: 25px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Student List</h1>

    <div class="breadcrumb">
        <a href="{{ route('admission.index') }}">Home</a>
        &nbsp; / &nbsp;
        <span>Deleted</span>
    </div>

    <div class="card">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <table>

            <thead>
                <tr>
                    <th>Student Code</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($admissions as $admission)

                    <tr>

                        <td>
                            {{ $admission->id }}
                        </td>

                        <td>
                            {{ $admission->student_name }}
                        </td>

                        <td>
                            {{ $admission->studentClass->class_name ?? '--' }}
                        </td>

                        <td>
                            {{ $admission->section->section_name ?? '--' }}
                        </td>

                        <td>

                            <form
                                action="{{ route('admission.restore', $admission->id) }}"
                                method="POST"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="restore-btn"
                                >
                                    Restore
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="empty">
                            No deleted students found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>
</html>