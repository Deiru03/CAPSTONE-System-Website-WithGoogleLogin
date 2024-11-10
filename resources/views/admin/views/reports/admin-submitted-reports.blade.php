<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body { 
            font-family: 'Times New Roman', serif;
            font-size: 11px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 2px;
        }
        th { 
            background-color: #f2f2f2;
        }
        h1 {
            font-size: 14px;
        }
        p {
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h1>Submitted Reports</h1>
    <table>
        <thead>
            <tr>
                <th>Admin</th>
                <th>User</th>
                <th>Title</th>
                <th>Transaction Type</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->admin->name ?? 'N/A' }}</td>
                    <td>{{ $report->user->name ?? 'N/A' }}</td>
                    <td>{{ $report->title }}</td>
                    <td>{{ $report->transaction_type }}</td>
                    <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <span><strong>As of:</strong> {{ now()->format('M d, Y H:i') }}</span>
    <span><strong> | By:</strong> {{ Auth::user()->name }} - {{ Auth::user()->campus_id ? Auth::user()->user_type : 'Super Admin' }}</span>
</body>
</html>