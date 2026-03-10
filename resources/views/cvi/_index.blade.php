<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Score')</th>
                <th>@lang('Vitality Score')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cvis as $cvi)
                <tr>
                    <td>{{ $cvi->date }}</td>
                    <td>{{ $cvi->score }}</td>
                    <td>{{ $cvi->vitality_score }}</td>
                    <td>

                        <a href="{{ route('cvi.show', $cvi) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('cvi.edit', $cvi) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No CVI records found.')</td>
                </tr>

            @endforelse
        </tbody>
    </table>
</div>
