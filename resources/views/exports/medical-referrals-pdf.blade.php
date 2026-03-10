<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medical Referrals Export</title>
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
        <h2>Medical Referrals Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Referring Doctor</th>
                <th>Reason for Referral</th>
                <th>Chief Complaint</th>
                <th>Patient Brief History</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicalReferrals as $referral)
                <tr>
                    <td>{{ $referral->patient->name }}</td>
                    <td>{{ $referral->referringDoctor->name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($referral->reason_for_referral, 200) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($referral->chief_complaint, 200) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($referral->patient_brief_history, 200) }}</td>
                    <td>{{ \Carbon\Carbon::parse($referral->date)->format('d M, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>