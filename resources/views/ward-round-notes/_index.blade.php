<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Conducted by')</th>
                <th>@lang('Condition')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($wardRoundNotes as $note)
                <tr>
                    <td>{{ $note->date }}</td>
                    <td>{{ $note->attending_clinician }}</td>
                    <td>{{ $note->condition }}</td>
                    <td>
                        <a href="{{ route('ward-round-notes.show', $note) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('ward-round-notes.edit', $note) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">@lang('No ward round notes found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
