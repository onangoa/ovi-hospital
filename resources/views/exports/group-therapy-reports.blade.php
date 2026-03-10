<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Participants</th>
            <th>Physiotherapist Name</th>
            <th>Ward</th>
            <th>Session Time</th>
            <th>Group Session Summary</th>
            <th>Overall Observations</th>
            <th>Equipment Clean Up</th>
            <th>Additional Comments</th>
        </tr>
    </thead>
    <tbody>
        @foreach($therapyReports as $report)
            <tr>
                <td>{{ $report->date }}</td>
                <td>
                    @if($report->participant_ids && count($report->participant_ids) > 0)
                        @foreach($report->participant_ids as $participantId)
                            {{ \App\Models\User::find($participantId)->name ?? 'N/A' }}@if(!$loop->last), @endif
                        @endforeach
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $report->physiotherapist->name }}</td>
                <td>{{ $report->ward->name ?? 'N/A' }}</td>
                <td>{{ $report->session_time }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->group_session_summary, 150) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->overall_observations, 150) }}</td>
                <td>{{ $report->equipment_clean_up }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->additional_comments, 150) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>