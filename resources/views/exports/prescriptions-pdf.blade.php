<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescriptions Export</title>
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
        .items-table {
            margin-top: 10px;
            font-size: 10px;
        }
        .items-table th, .items-table td {
            padding: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $logoPath }}" alt="Company Logo" style="max-height: 60px;">
        </div>
        <h2>Prescriptions Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Chief Complaint</th>
                <th>Medicines</th>
                <th>Diagnosis</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d M, Y') }}</td>
                    <td>{{ $prescription->user->name ?? 'N/A' }}</td>
                    <td>{{ $prescription->doctor->name ?? 'N/A' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($prescription->chief_complaint, 100) }}</td>
                    <td>
                        @if($prescription->medicine_info)
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Type</th>
                                        <th>Instruction</th>
                                        <th>Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(json_decode($prescription->medicine_info, true) as $medicine)
                                        <tr>
                                            <td>{{ $medicine['medicine_name'] ?? '' }}</td>
                                            <td>{{ $medicine['medicine_type'] ?? '' }}</td>
                                            <td>{{ $medicine['instruction'] ?? '' }}</td>
                                            <td>{{ $medicine['day'] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            No medicines
                        @endif
                    </td>
                    <td>
                        @if($prescription->diagnosis_info)
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>Diagnosis</th>
                                        <th>Instruction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(json_decode($prescription->diagnosis_info, true) as $diagnosis)
                                        <tr>
                                            <td>{{ $diagnosis['diagnosis'] ?? '' }}</td>
                                            <td>{{ $diagnosis['diagnosis_instruction'] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            No diagnosis
                        @endif
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($prescription->note, 100) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>