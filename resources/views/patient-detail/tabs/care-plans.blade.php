<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Provider')</th>
                <th>@lang('Medications')</th>
                <th>@lang('Dietary Needs')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($carePlans->count() > 0)
                @foreach($carePlans as $plan)
                    <tr>
                        <td>{{ is_string($plan->date) ? \Carbon\Carbon::parse($plan->date)->format('d M, Y') : $plan->date->format('d M, Y') }}</td>
                        <td>{{ $plan->provider->name ?? 'N/A' }}</td>
                        <td>
                            @if($plan->medications && is_array($plan->medications))
                                @foreach($plan->medications as $medication)
                                    @if(isset($medication['name']))
                                        <span class="badge badge-info">{{ $medication['name'] }}</span>
                                    @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ Str::limit($plan->dietary_needs, 30) ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('care-plans.show', $plan) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">@lang('No care plans found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>