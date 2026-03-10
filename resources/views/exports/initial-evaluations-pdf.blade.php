<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Initial Evaluations Export</title>
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
        .vital-signs {
            font-size: 10px;
        }
        .vital-signs th, .vital-signs td {
            padding: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $logoPath }}" alt="Company Logo" style="max-height: 60px;">
        </div>
        <h2>Initial Evaluations Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient</th>
                <th>Conducted by</th>
                <th>Reason for treatment</th>
                <th>Pain Signs</th>
                <th>Pain Location</th>
                <th>Pain Level</th>
                <!-- <th>Vital Signs</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($evaluations as $evaluation)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($evaluation->date)->format('d M, Y') }}</td>
                    <td>{{ $evaluation->patient->name ?? 'N/A' }}</td>
                    <td>{{ $evaluation->provider_name ?? 'N/A' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($evaluation->reason_for_treatment ?? '', 100) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($evaluation->pain_signs ?? '', 100) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($evaluation->pain_location ?? '', 100) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($evaluation->pain_level ?? '', 100) }}</td>
                    <!-- <td>
                        @if($evaluation->vital_signs)
                            @php
                                $vitalSigns = is_array($evaluation->vital_signs) ? $evaluation->vital_signs : json_decode($evaluation->vital_signs, true);
                            @endphp
                            <table class="vital-signs">
                                <thead>
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(is_array($vitalSigns))
                                        @foreach($vitalSigns as $key => $value)
                                            <tr>
                                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @else
                            No vital signs
                        @endif
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>