<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Therapist Signature')</th>
                <th>@lang('Session Time')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($therapyReports as $report)
                <tr>
                    <td>{{ $report->date }}</td>
                    <td>{{ $report->physiotherapist_signature }}</td>
                    <td>{{ $report->session_time }}</td>
                    <td>
                        <a href="{{ route('therapy-reports.show', $report) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        @if ($report->session_summary)
                            <a href="{{ route('individual-therapy.edit', $report) }}" class="btn btn-sm btn-warning">@lang('Edit Individual')</a>
                        @else
                            <a href="{{ route('group-therapy.edit', $report) }}" class="btn btn-sm btn-warning">@lang('Edit Group')</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No therapy reports found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
