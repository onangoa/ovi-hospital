<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Radiology Requests Export</title>
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
        <h2>Radiology Requests Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Provider Name</th>
                <th>Examination Type</th>
                <th>Examination Details</th>
                <th>Relevant Clinical Information</th>
                <th>Reason for Investigation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($radiologyRequests as $request)
                <tr>
                    <td>{{ $request->patient->name }}</td>
                    <td>{{ $request->provider->name }}</td>
                    <td>
                        @if($request->examination_type)
                            @php
                                $examTypes = $request->examination_type;
                                if($examTypes && count($examTypes) > 0) {
                                    foreach($examTypes as $type) {
                                        if(is_array($type)) {
                                            echo (isset($type['name']) ? $type['name'] : json_encode($type)) . "\n";
                                        } else {
                                            echo $type . "\n";
                                        }
                                    }
                                }
                            @endphp
                        @endif
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($request->examination_details, 200) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($request->relevant_clinical_information, 200) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($request->reason_for_investigation, 200) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>