<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Conducted By')</th>
                <th>@lang('Patient')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($weeklyWellnessChecks as $check)
                <tr>
                    <td>{{ optional($check->date)->format('Y-m-d') }}</td>
                    <td>{{ $check->conductedBy->name ?? 'N/A' }}</td>

                    <td>{{ $check->patient->name }}</td>
                    <td>
                        <a href="{{ route('weekly-wellness-checks.show', $check) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('weekly-wellness-checks.edit', $check) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No wellness checks found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
