<!DOCTYPE html>
<html>
<head>
    <title>Faculty Generated Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 5px;
            background-color: #ffffff;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }
        .header img {
            position: absolute;
            top: 0;
            width: 100px;
        }
        .header img.left {
            width: 130px;
            left: 0;
        }
        .header img.right {
            margin-top: 15px;
            width: 100px;
            right: 0;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 15px;
            font-family: 'Times New Roman', serif;
            font-weight: bold;
            text-align: center;
        }
        .header h3 {
            margin: 1px 0;
            font-size: 15px;
            font-weight: normal;
        }
        .header h4 {
            margin: 1px 0;
            font-size: 13px;
            font-weight: normal;
        }
        .header p {
            margin: 1px 0;
            font-size: 11px;
        }
        .details, .requirements {
            margin-bottom: 10px;
        }
        .details h2 {
            font-size: 18px;
            margin: 5px 0;
        }
        .details p {
            margin: 7px 0;
            display: flex;
            align-items: center;
            font-size: 15px;
            font-weight: normal;
            margin-left: 120px;
        }
        .details p::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid black;
            margin-left: 5px;
        }
        .details p span {
            flex-shrink: 0;
            margin-right: 5px;
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
            text-align: center;
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
    <div class="header" style="margin-bottom: 10px; font-family: 'Times New Roman', serif;">
        <img src="data:image/png;base64,{{ $omscLogo }}" alt="OMSC Logo" class="left"/>
        <img src="data:image/png;base64,{{ $iqaLogo }}" alt="IQA Logo" class="right"/>
        <h4>Republic of the Philippines</h4>
        <h1>OCCIDENTAL MINDORO STATE COLLEGE</h1>
        <h4>Labangan, San Jose, Occidental Mindoro</h4>
        <h4>Website: www.omsc.edu.ph | Email: omsc_9747@yahoo.com</h4>
        <h4>Tele/Fax: (043) 457-0225</h4>
        <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 0px; margin-top: 15px;"  >Institutional Quality Assurance Office</h2>
        <hr style="border: 3px solid rgb(22, 22, 22);">
    </div>
    <h1 style="text-align: center; font-size: 18px; font-weight: bold;">Faculty Generated Report</h1>
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
                        {{ $member->clearances_status == 'complete' ? 'Accomplished' : ($member->clearances_status == 'pending' ? 'Not Complied' : $member->clearances_status) }}
                    </td>
                    <td>{{ $member->last_clearance_update ? $member->last_clearance_update->format('F j, Y H:i:s') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <footer>
        <span style="font-size: 11px;"><strong>As of:</strong> {{ now()->format('M d, Y h:i A') }}</span>
        <span style="font-size: 11px;"><strong> | By:</strong> {{ Auth::user()->name }} - {{ Auth::user()->campus_id ? Auth::user()->user_type : 'Super Admin' }}</span>    
    </footer>
</body>
</html>