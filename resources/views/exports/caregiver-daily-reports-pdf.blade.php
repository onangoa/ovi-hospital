<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Caregiver Daily Reports Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
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
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $logoPath }}" alt="Company Logo" style="max-height: 60px;">
        </div>
        <h2>Caregiver Daily Reports Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Conducted by</th>
                <th>Mood</th>
                <th>Pain Level</th>
                <th>Concerns</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caregiverDailyReports as $report)
                <tr>
                    <td>{{ is_string($report->date) ? \Carbon\Carbon::parse($report->date)->format('d M, Y') : $report->date->format('d M, Y') }}</td>
                    <td>{{ $report->patient->name }}</td>
                    <td>{{ $report->caregiver->name }}</td>
                    <td>{{ $report->mood }}</td>
                    <td>{{ $report->pain_level }}</td>
                    <td>{{ $report->concerns }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>