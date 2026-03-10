<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Description')</th>
                <th>@lang('Capacity')</th>
                <th>@lang('Assigned At')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($wards as $ward)
                <tr>
                    <td>{{ $ward->name }}</td>
                    <td>{{ $ward->description }}</td>
                    <td>{{ $ward->capacity }}</td>
                    <td>{{ $ward->pivot->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('Not assigned to any wards.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
