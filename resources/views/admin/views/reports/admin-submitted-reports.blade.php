<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 5px;
            font-size: 12px;
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
    <div class="header">
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
    <h1 style="text-align: center; font-size: 18px; font-weight: bold;">Submitted Actions History Reports</h1>
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
                    <td>{{ $report->created_at->format('M d, Y h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <span style="font-size: 11px;"><strong>As of:</strong> {{ now()->format('M d, Y h:i A') }}</span>
    <span style="font-size: 11px;"><strong> | By:</strong> {{ Auth::user()->name }} - {{ Auth::user()->campus_id ? Auth::user()->user_type : 'Super Admin' }}</span>
</body>
</html>