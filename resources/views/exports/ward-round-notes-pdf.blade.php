<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ward Round Notes Export</title>
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
        <h2>Ward Round Notes Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Conducted by</th>
                <th>Main Complaints</th>
                <th>Examination Findings</th>
                <!-- <th>Respiratory Status</th>
                <th>Cardiovascular Status</th>
                <th>Neurological Status</th>
                <th>Gastrointestinal Status</th>
                <th>Skin Status</th>
                <th>Medications Changes</th>
                <th>Procedures Interventions</th>
                <th>Pending Tests</th> -->
                <th>Condition</th>
                <!-- <th>Next Steps</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($wardRoundNotes as $note)
                <tr>
                    <td>{{ is_string($note->date) ? \Carbon\Carbon::parse($note->date)->format('d M, Y') : $note->date->format('d M, Y') }}</td>
                    <td>{{ $note->patient->name }}</td>
                    <td>{{ $note->attendingClinician->name ?? $note->clinician_name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($note->main_complaints, 100) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($note->examination_findings, 100) }}</td>
                    <!-- <td>{{ $note->respiratory_status }}</td>
                    <td>{{ $note->cardiovascular_status }}</td>
                    <td>{{ $note->neurological_status }}</td>
                    <td>{{ $note->gastrointestinal_status }}</td>
                    <td>{{ $note->skin_status }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($note->medications_changes, 100) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($note->procedures_interventions, 100) }}</td>
                    <td>{{ $note->pending_tests }}</td> -->
                    <td>{{ $note->condition }}</td>
                    <!-- <td>{{ \Illuminate\Support\Str::limit($note->next_steps, 100) }}</td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>