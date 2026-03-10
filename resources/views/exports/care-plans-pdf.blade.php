<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Care Plans Export</title>
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
        <h2>Care Plans Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Provider Name</th>
                <th>Medications</th>
                <th>Dietary Needs</th>
                <th>Activity Restrictions</th>
                <th>Wound Care</th>
                <th>Admission Decision</th>
                <th>Tests Needed</th>
                <th>Tests Comments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carePlans as $carePlan)
                <tr>
                    <td>{{ is_string($carePlan->date) ? \Carbon\Carbon::parse($carePlan->date)->format('d M, Y') : $carePlan->date->format('d M, Y') }}</td>
                    <td>{{ $carePlan->patient->name }}</td>
                    <td>{{ $carePlan->provider->name }}</td>
                    <td>
                        @if($carePlan->medications)
                            @php
                                $medications = $carePlan->medications;
                                if($medications && count($medications) > 0) {
                                    foreach($medications as $medication) {
                                        if(is_array($medication)) {
                                            echo ($medication['name'] ?? '') .
                                                 (isset($medication['dosage']) ? ' - ' . $medication['dosage'] : '') .
                                                 (isset($medication['frequency']) ? ' - ' . $medication['frequency'] : '') .
                                                 (isset($medication['duration']) ? ' - ' . $medication['duration'] : '') . "\n";
                                        } else {
                                            echo $medication . "\n";
                                        }
                                    }
                                }
                            @endphp
                        @endif
                    </td>
                    <td>{{ $carePlan->dietary_needs }}</td>
                    <td>{{ $carePlan->activity_restrictions }}</td>
                    <td>{{ $carePlan->wound_care }}</td>
                    <td>{{ $carePlan->admission_decision }}</td>
                    <td>{{ $carePlan->tests_needed }}</td>
                    <td>{{ $carePlan->tests_comments }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>