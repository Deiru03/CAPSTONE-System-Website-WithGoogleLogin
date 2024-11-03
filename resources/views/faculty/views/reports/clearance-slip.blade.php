<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Clearance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }
        .header img {
            width: 100px;
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
        }
        .header h1 {
            color: rgb(49, 49, 49);
            font-size: 28px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin: 0;
            letter-spacing: 1px;
        }
        .content {
            margin: 20px 0;
            background: white;
            border: none;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin: 20px 0;
            display: flex;
            align-items: center;
        }
        .label {
            color: #1e3a8a;
            font-weight: 600;
            min-width: 200px;
        }
        .value-line {
            border-bottom: 2px solid #3b82f6;
            display: inline-block;
            min-width: 300px;
            margin-left: 10px;
            padding-bottom: 5px;
            color: #1f2937;
        }
        .bullet-points {
            margin: 20px 0;
            color: #4b5563;
        }
        .bullet-points li {
            margin: 10px 0;
            list-style-type: none;
            padding-left: 20px;
            position: relative;
        }
        .bullet-points li:before {
            content: "•";
            color: #3b82f6;
            font-size: 20px;
            position: absolute;
            left: 0;
        }
        .status {
            margin-top: 30px;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 8px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #1e3a8a;
        }
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <img src="data:image/png;base64,{{ $image }}" alt="OMSC Logo"/>
            <h1>OCCIDENTAL MINDORO STATE COLLEGE</h1>
        </div>
    </div>
    <div class="content">
        <div class="form-group">
            <span class="label">NAME OF FACULTY:</span>
            <span class="value-line">{{ $user->name }}</span>
        </div>
    
        <div class="form-group">
            <span class="label">DEPARTMENT/COLLEGE:</span>
            <span class="value-line">{{ ($user->department->name ?? 'N/A') . ' - ' . ($user->program_name ?? 'N/A') }}</span>
        </div>
    
        <div class="bullet-points">
            <li>{!! $user->position === 'Permanent' || $user->position === 'Temporary' ? '<strong style="background-color: yellow;">PERMANENT/TEMPORARY</strong>' : 'PERMANENT/TEMPORARY' !!}</li>
            <li>{!! $user->position === 'Part-Timer' && $user->units >= 12 ? '<strong style="background-color: yellow;">PART-TIME W/ 12 UNITS LOAD AND ABOVE</strong>' : 'PART-TIME W/ 12 UNITS LOAD AND ABOVE' !!}</li>
            <li>{!! $user->position === 'Part-Timer' && $user->units >= 9 && $user->units < 12 ? '<strong style="background-color: yellow;">PART-TIME W/ 9 UNITS LOAD AND ABOVE</strong>' : 'PART-TIME W/ 9 UNITS LOAD AND ABOVE' !!}</li>
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