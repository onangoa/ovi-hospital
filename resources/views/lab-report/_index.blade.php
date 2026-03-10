<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Patient')</th>
                <th>@lang('Age')</th>
                <th>@lang('Gender')</th>
                <th>@lang('Address')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($labReports as $report)
                <tr>
                    <td>{{ $report->date }}</td>
                    <td>{{ $report->user->name }}</td>
                    <td>{{ $report->user->age ?? '-' }}</td>
                    <td>{{ $report->user->gender ?? '-' }}</td>
                    <td>{{ $report->user->address ?? '-' }}</td>
                    <td>
                        <a href="{{ route('lab-reports.show', $report) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('lab-reports.edit', $report) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">@lang('No lab reports found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
