<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clearance Report</title>
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
            margin-top: 10px;
            /* height: 80vh; */
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
            white-space: pre-wrap;
            /* margin-top: 2px; */
            /* margin-bottom: 2px; */
            font-size: 15px;
            /* height: 5px; */
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            /* height: 5px; */
        }
        tr {
            page-break-inside: avoid;
        }
        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 9px;
        }
        .note {
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 15px;
            text-decoration: italic;
            text-align: center;
        }
        .reference {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: -40px;
            margin-bottom: 10px;
            width: 100%;
            white-space: nowrap;
        }
        .reference span {
            font-size: 8px;
            font-weight: normal;
            flex: 1;
        }
        .reference .left {
            text-align: left;
            margin-left: 0px;
        }
        .reference .center {
            text-align: center;
            margin-left: 180px;
        }
        .reference .right {
            text-align: right;
            margin-left: 210px;
        }
    </style>
    <div class="reference">
        <span class="left">Reference No.: OMSC-Form-IQA-03-D</span>
        <span class="center">Effective Date: MM-DD-YYYY</span>
        <span class="right">Revision No. XX</span>
    </div>
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
    <div class="details">
        <p>Name of the Faculty&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $clearance->faculty_name ?? '____________________________' }}</p>
        <p>College/Department&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $clearance->department ?? '____________________________' }}</p>
        <p>Date Submitted&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $clearance->date_submitted ?? '____________________________' }}</p>
        <p>Checked by&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $clearance->checked_by ?? '____________________________' }}</p>
        <br>
        <br>
        <h2 style="text-align: center; font-size: 18px; font-weight: bold">{{ $clearance->document_name }}</h2>
        <div class="subtitle" style="text-align: center; font-weight: bold; font-size: 16px; margin-top: -6px; margin-right: 50px; margin-left: 50px; text-decoration: underline;">({{ $clearance->description }})</div>
        <div class="note" style="margin-top: 15px; margin-bottom: 15px; font-size: 15px; text-decoration: italic; text-align: center;">Note: All documents should be printed/photocopied in LONG COUPON BOND.</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>List of Documents</th>
                <th>Complied</th>
                <th>Not Complied</th>
                <th>Not Applicable</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($clearance->requirements as $requirement)
            <tr>
                <td style="padding-left: 22px; text-indent: -20px;"> {{ $loop->iteration }}. {{ $requirement->requirement }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <span><strong>As of: </strong> {{ now()->format('F j, Y - H:i:s') }}</span>
        <span>|<strong> by:</strong> {{ Auth::user()->name }}</span>
    </div>
</body>
</html>