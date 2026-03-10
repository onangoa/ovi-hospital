<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weekly Wellness Checks Export</title>
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
        <h2>Weekly Wellness Checks Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Conducted By</th>
                <th>Mood</th>
                <th>Engagement</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($weeklyWellnessChecks as $check)
                <tr>
                    <td>{{ is_string($check->date) ? \Carbon\Carbon::parse($check->date)->format('d M, Y') : $check->date->format('d M, Y') }}</td>
                    <td>{{ $check->patient->name }}</td>
                    <td>{{ $check->conductedBy->name }}</td>
                    <td>{{ $check->mood }}</td>
                    <td>{{ $check->engagement }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($check->notes, 200) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>