<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Provider')</th>
                <th>@lang('Examination Type')</th>
                <th>@lang('Reason for Investigation')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($radiologyRequests->count() > 0)
                @foreach($radiologyRequests as $request)
                    <tr>
                        <td>{{ $request->created_at->format('d M, Y') }}</td>
                        <td>{{ $request->provider->name ?? 'N/A' }}</td>
                        <td>
                            @if($request->examination_type)
                                {{ is_array($request->examination_type) ? implode(', ', $request->examination_type) : $request->examination_type }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ Str::limit($request->reason_for_investigation, 50) ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('radiology-requests.show', $request) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">@lang('No radiology requests found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>