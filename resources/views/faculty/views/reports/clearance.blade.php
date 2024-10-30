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
        .form-group {
            margin: 20px 0;
            display: flex;
            align-items: center;
        }
        .label {
            color: #666;
            margin-bottom: 5px;
        }
        .value-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 300px;
            margin-left: 10px;
        }
        .bullet-points {
            margin: 20px 0;
            color: #666;
        }
        .bullet-points li {
            margin: 5px 0;
            list-style-type: none;
        }
        .bullet-points li:before {
            content: "•";
            margin-right: 10px;
        }
        .status-box {
            margin: 20px 0;
        }
        .checkbox-group {
            margin: 10px 0;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            padding-top: 5px;
            color: #666;
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
        <div class="form-group">
            <span class="label">NAME OF FACULTY:</span>
            <span class="value-line">{{ $user->name }}</span>
        </div>
    
        <div class="form-group">
            <span class="label">DEPARTMENT/COLLEGE:</span>
            <span class="value-line">{{ $user->department->name ?? 'N/A' }}</span>
        </div>
    
        <div class="bullet-points">
            <li>PERMANENT/TEMPORARY</li>
            <li>PART-TIME W/ 12 UNITS LOAD AND ABOVE</li>
            <li>PART-TIME W/ 9 UNITS LOAD AND ABOVE</li>
        </div>
        <p class="status">
            <span class="label">STATUS:</span>
            <br>
            <input type="checkbox" {{ $user->clearances_status === 'complete' ? 'checked' : '' }}> ACCOMPLISHED
            <br>
            <input type="checkbox" {{ $user->clearances_status === 'pending' ? 'checked' : '' }}> NOT ACCOMPLISH
        </p>
        <p class="footer">
            <span class="label">DATE:</span> ______________________
            <br>
            <br>
            <span class="label">IQA OFFICER SIGNATURE:</span> ______________________
        </p>
    </div>
</body>
</html>