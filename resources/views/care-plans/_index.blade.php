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
            @forelse($carePlans as $plan)
                <tr>
                    <td>{{ $plan->date }}</td>
                    <td>{{ $plan->patient->name }}</td>
                    <td>{{ $plan->provider ? $plan->provider->name : $plan->provider_signature }}</td>
                    <td>
                        <a href="{{ route('care-plans.show', $plan) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('care-plans.edit', $plan) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No care plans found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
