<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Attending Clinician')</th>
                <th>@lang('Main Complaints')</th>
                <th>@lang('Condition')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($wardRoundNotes->count() > 0)
                @foreach($wardRoundNotes as $note)
                    <tr>
                        <td>{{ is_string($note->date) ? \Carbon\Carbon::parse($note->date)->format('d M, Y') : $note->date->format('d M, Y') }}</td>
                        <td>{{ $note->attendingClinician->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($note->main_complaints, 50) ?? 'N/A' }}</td>
                        <td>
                            @if($note->condition)
                                <span class="badge badge-{{ $note->condition == 'stable' ? 'success' : ($note->condition == 'improving' ? 'info' : 'warning') }}">
                                    {{ ucfirst($note->condition) }}
                                </span>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('ward-round-notes.show', $note) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">@lang('No ward round notes found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>