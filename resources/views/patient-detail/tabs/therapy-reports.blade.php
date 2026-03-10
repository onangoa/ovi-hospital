<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Physiotherapist')</th>
                <th>@lang('Session Time')</th>
                <th>@lang('Session Summary')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($therapyReports->count() > 0)
                @foreach($therapyReports as $report)
                    <tr>
                        <td>{{
                            isset($report->date)
                                ? (is_string($report->date) ? \Carbon\Carbon::parse($report->date)->format('d M, Y') : $report->date->format('d M, Y'))
                                : (is_string($report->created_at) ? \Carbon\Carbon::parse($report->created_at)->format('d M, Y') : $report->created_at->format('d M, Y'))
                        }}</td>
                        <td>{{ $report->physiotherapist->name ?? 'N/A' }}</td>
                        <td>{{ $report->session_time ?? 'N/A' }}</td>
                        <td>{{ Str::limit($report->session_summary ?? $report->group_session_summary, 50) ?? 'N/A' }}</td>
                        <td>
                            @if($report->patient_id)
                                <a href="{{ route('individual-therapy.show', $report) }}" class="btn btn-sm btn-info">@lang('View')</a>
                            @else
                                <a href="{{ route('group-therapy.show', $report) }}" class="btn btn-sm btn-info">@lang('View')</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">@lang('No therapy reports found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>