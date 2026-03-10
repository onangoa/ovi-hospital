<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Patient')</th>
                <th>Conducted by</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evaluations as $evaluation)
                <tr>
                    <td>{{ $evaluation->date }}</td>
                    <td>{{ $evaluation->patient->name }}</td>
                    <td>{{ $evaluation->provider ? $evaluation->provider->name : $evaluation->provider_name }}</td>
                    <td>
                        <a href="{{ route('initial-evaluations.show', $evaluation) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('initial-evaluations.edit', $evaluation) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No evaluations found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
