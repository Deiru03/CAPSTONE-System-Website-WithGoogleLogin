<!DOCTYPE html>
<html>
<head>
    <title>Clearance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .content {
            margin: 20px 0;
            border: 1px solid #000;
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .content .label {
            display: inline-block;
            width: 200px;
            font-weight: bold;
        }
        .status {
            margin-top: 20px;
        }
        .status p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/OMSCLogo.png') }}" alt="Left Logo">
        <h1>OCCIDENTAL MINDORO STATE COLLEGE</h1>
        <img src="{{ asset('images/OMSCLogo.png') }}" alt="Right Logo">
    </div>
    <div class="content">
        <p><span class="label">NAME OF FACULTY:</span> {{ $user->name }}</p>
        <p><span class="label">DEPARTMENT/COLLEGE:</span> {{ $user->department->name ?? 'N/A' }}</p>
        <p class="status">
            <span class="label">STATUS:</span>
            <br>
            <input type="checkbox" {{ $user->clearances_status == 'complete' ? 'checked' : '' }}> ACCOMPLISHED
            <br>
            <input type="checkbox" {{ $user->clearances_status == 'pending' ? 'checked' : '' }}> NOT ACCOMPLISH
        </p>
        <p class="footer">
            <span class="label">DATE:</span> ______________________
            <br>
            <span class="label">IQA OFFICER SIGNATURE:</span> ______________________
        </p>
    </div>
</body>
</html>