<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Participants</th>
                <th>Ward</th>
                <th>Physiotherapist</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($therapyReports as $report)
            <tr>
                <td>{{ $report->date->format('Y-m-d') }}</td>
                <td>
                    @if($report->participant_ids && count($report->participant_ids) > 0)
                        @foreach($report->participant_ids as $participantId)
                            {{ App\Models\User::find($participantId)->name ?? 'N/A' }}@if(!$loop->last), @endif
                        @endforeach
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $report->ward->name ?? 'N/A' }}</td>
                <td>{{ $report->physiotherapist->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('group-therapy.show', $report->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('group-therapy.edit', $report->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('therapy-reports.destroy', $report->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $therapyReports->links() }}
