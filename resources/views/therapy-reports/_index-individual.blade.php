<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Physiotherapist</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($therapyReports as $report)
            <tr>
                <td>{{ \Carbon\Carbon::parse($report->date)->format('d-m-Y') }}</td>
                <td>{{ $report->patient->name ?? 'N/A' }}</td>
                <td>{{ $report->physiotherapist->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('individual-therapy.show', $report->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('individual-therapy.edit', $report->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
