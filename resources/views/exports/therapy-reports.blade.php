<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Physiotherapist Name</th>
            <th>Patient Name</th>
            <th>Session Time</th>
            <th>Session Summary</th>
            <th>Participants</th>
            <th>Group Session Summary</th>
            <th>Overall Observations</th>
            <th>Equipment Clean Up</th>
            <th>Additional Comments</th>
            <th>Ward</th>
        </tr>
    </thead>
    <tbody>
        @foreach($therapyReports as $report)
            <tr>
                <td>{{ $report->date }}</td>
                <td>{{ $report->physiotherapist->name }}</td>
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
                <td>{{ $report->session_time }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->session_summary, 150) }}</td>
                <td>
                    @if($report->participant_ids)
                        @php
                            $participants = json_decode($report->participant_ids, true);
                            if($participants && count($participants) > 0) {
                                foreach($participants as $participantId) {
                                    $participant = \App\Models\User::find($participantId);
                                    if($participant) {
                                        echo $participant->name . "\n";
                                    }
                                }
                            }
                        @endphp
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($report->group_session_summary, 150) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->overall_observations, 150) }}</td>
                <td>{{ $report->equipment_clean_up }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->additional_comments, 150) }}</td>
                <td>
                    @if(is_null($report->patient_id))
                        <!-- Group therapy - show ward -->
                        {{ $report->ward->name ?? 'N/A' }}
                    @else
                        <!-- Individual therapy - don't show ward -->
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>