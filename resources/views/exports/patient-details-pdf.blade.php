<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Details Export</title>
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
        <h2>Patient Details Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Blood Group</th>
                <th>Address</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Date of Birth</th>
                <th>Guardian Name</th>
                <th>Guardian Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patientDetails as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->blood_group }}</td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->weight ?? 'N/A' }}</td>
                    <td>{{ $patient->height ?? 'N/A' }}</td>
                    <td>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d M, Y') : 'N/A' }}</td>
                    <td>{{ $patient->guardian_name ?? 'N/A' }}</td>
                    <td>{{ $patient->guardian_phone ?? 'N/A' }}</td>
                    <td>{{ $patient->status ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>