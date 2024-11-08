<!DOCTYPE html>
<html>
<head>
    <title>Admin Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        header img {
            height: 80px;
        }
        header h1 {
            text-align: center;
            flex-grow: 1;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('OMSCLogo.png') }}" alt="OMSC Logo" style="width: 100px;">
        <h1>Admin Report</h1>
    </header>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Checklist<br>Status</th>
                <th>Checked By</th>
                <th>Last Clearance<br>Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td style="color: {{ $user->clearances_status == 'complete' ? '#22c55e' : ($user->clearances_status == 'pending' ? '#ef4444' : '') }}">
                        {{ $user->clearances_status == 'complete' ? 'Accomplished' : ($user->clearances_status == 'pending' ? 'Not Complied' : $user->clearances_status) }}
                    </td>
                    <td>
                        @if($user->managingAdmins->isNotEmpty())
                            {{ $user->managingAdmins->pluck('name')->join(', ') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $user->last_clearance_update ? $user->last_clearance_update->format('F j, Y H:i:s') : 'N/A' }}</td>
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