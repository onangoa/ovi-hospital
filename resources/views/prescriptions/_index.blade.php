<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Doctor')</th>
                <th>@lang('Patient')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->prescription_date }}</td>
                    <td>{{ $prescription->doctor->name }}</td>
                    <td>{{ $prescription->user->name }}</td>
                    <td>
                        <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('prescriptions.edit', $prescription) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No prescriptions found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
