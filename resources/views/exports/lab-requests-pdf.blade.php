<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab Requests Export</title>
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
        <h2>Lab Requests Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Request Date</th>
                <th>Patient Name</th>
                <th>Clinician Name</th>
                <th>Specimen</th>
                <th>Investigation Requested</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labRequests as $request)
                <tr>
                    <td>{{ is_string($request->request_date) ? \Carbon\Carbon::parse($request->request_date)->format('d M, Y') : $request->request_date->format('d M, Y') }}</td>
                    <td>{{ $request->patient->name }}</td>
                    <td>{{ $request->clinician->name }}</td>
                    <td>{{ $request->specimen }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($request->investigation_requested, 200) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>