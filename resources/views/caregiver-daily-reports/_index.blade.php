<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Patient')</th>
                <th>@lang('Caregiver')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->date }}</td>
                    <td>{{ $report->patient->name }}</td>
                    <td>{{ $report->caregiver->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('caregiver-daily-reports.show', $report) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('caregiver-daily-reports.edit', $report) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No caregiver reports found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
