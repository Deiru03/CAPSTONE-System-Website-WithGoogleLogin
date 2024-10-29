<!DOCTYPE html>
<html>
<head>
    <title>Faculty Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 5px;
            background-color: #f9f9f9;
            font-size: 11px;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            background-color: #fff;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 2px solid #ddd;
            padding: 3px;
            text-align: left;
            font-size: 11px;
            height: 15px; /* Added fixed height for rows */
            line-height: 15px; /* Added to vertically center content */
        }
        th {
            background-color: #4c63af;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        footer {
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Faculty Report</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Program</th>
                <th>Position</th>
                <th>Managed By</th>
                <th>Checklist<br>Status</th>
                <th>Last Clearance<br>Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faculty as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->department->name ?? 'N/A' }}</td>
                    <td>{{ $member->program_name ?? 'N/A' }}</td>
                    <td>{{ $member->position ?? 'N/A' }}</td>
                    <td>{{ $member->managingAdmins->pluck('name')->join(', ') ?? 'N/A' }}</td>
                    <td style="color: {{ $member->clearances_status == 'complete' ? '#22c55e' : ($member->clearances_status == 'pending' ? '#ef4444' : '#000') }}">
                        {{ $member->clearances_status == 'complete' ? 'Accomplished' : ($member->clearances_status == 'pending' ? 'Not Complete' : $member->clearances_status) }}
                    </td>
                    <td>{{ $member->last_clearance_update ? $member->last_clearance_update->format('F j, Y H:i:s') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <footer>
        <p>Generated on {{ now()->format('F j, Y H:i:s') }}</p>
        by {{ Auth::user()->name }}
    </footer>
</body>
</html>