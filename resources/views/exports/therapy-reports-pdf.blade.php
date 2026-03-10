<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Therapy Reports Export</title>
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
        <h2>Therapy Reports Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Conducted by</th>
                <th>Ward</th>
                <th>Session Time</th>
                <th>Session Summary</th>
            </tr>
        </thead>
        <tbody>
            @foreach($therapyReports as $report)
                <tr>
                    <td>{{ is_string($report->date) ? \Carbon\Carbon::parse($report->date)->format('d M, Y') : $report->date->format('d M, Y') }}</td>
                    <td>
                        @if(is_null($report->patient_id))
                            <!-- Group therapy - show all participants -->
                            @if($report->participant_ids && count($report->participant_ids) > 0)
                                @foreach($report->participant_ids as $participantId)
                                    {{ \App\Models\User::find($participantId)->name ?? 'N/A' }}@if(!$loop->last), @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        @else
                            <!-- Individual therapy - show patient name -->
                            {{ $report->patient->name ?? 'N/A' }}
                        @endif
                    </td>
                    <td>{{ $report->physiotherapist->name }}</td>
                    <td>
                        @if(is_null($report->patient_id))
                            <!-- Group therapy - show ward -->
                            {{ $report->ward->name ?? 'N/A' }}
                        @else
                            <!-- Individual therapy - don't show ward -->
                            -
                        @endif
                    </td>
                    <td>{{ $report->session_time }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($report->group_session_summary ?? $report->session_summary, 200) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>