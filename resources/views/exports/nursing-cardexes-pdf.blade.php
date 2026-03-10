<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nursing Cardex Export</title>
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
        <h2>Nursing Cardex Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient</th>
                <th>Conducted by</th>
                <th>Vital Signs</th>
                <th>Brief Report</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nursingCardexes as $cardex)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($cardex->date)->format('d M, Y') }}</td>
                    <td>{{ $cardex->patient->name ?? 'N/A' }}</td>
                    <td>{{ $cardex->nurse_on_duty_name ?? 'N/A' }}</td>
                    
                    <td>
                        @if($cardex->vital_signs)
                            @php
                                $vitalSigns = is_array($cardex->vital_signs) ? $cardex->vital_signs : json_decode($cardex->vital_signs, true);
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
                    </td>
                    <td>{{ $cardex->brief_report }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>