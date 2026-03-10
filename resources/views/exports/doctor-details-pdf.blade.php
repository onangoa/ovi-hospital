<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Doctor Details Export</title>
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
        <h2>Doctor Details Report</h2>
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
                <th>Specialist</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctorDetails as $doctor)
                <tr>
                    <td>{{ $doctor->user->name }}</td>
                    <td>{{ $doctor->user->email }}</td>
                    <td>{{ $doctor->user->phone }}</td>
                    <td>{{ $doctor->user->gender }}</td>
                    <td>{{ $doctor->user->blood_group }}</td>
                    <td>{{ $doctor->user->address }}</td>
                    <td>{{ $doctor->specialist }}</td>
                    <td>{{ $doctor->designation }}</td>
                    <td>{{ $doctor->hospitalDepartment->name ?? 'N/A' }}</td>
                    <td>{{ $doctor->user->status ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>