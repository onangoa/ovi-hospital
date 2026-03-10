<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>Physiotherapist Name</th>
            <th>Session Time</th>
            <th>Session Summary</th>
            <th>Overall Observations</th>
            <th>Equipment Clean Up</th>
            <th>Additional Comments</th>
        </tr>
    </thead>
    <tbody>
        @foreach($therapyReports as $report)
            <tr>
                <td>{{ $report->date }}</td>
                <td>{{ $report->patient->name }}</td>
                <td>{{ $report->physiotherapist->name }}</td>
                <td>{{ $report->session_time }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->session_summary, 150) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->overall_observations, 150) }}</td>
                <td>{{ $report->equipment_clean_up }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->additional_comments, 150) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>