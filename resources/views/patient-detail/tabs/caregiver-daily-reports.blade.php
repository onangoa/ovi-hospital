<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Caregiver')</th>
                <th>@lang('Mood')</th>
                <th>@lang('Pain Level')</th>
                <th>@lang('Favorite Activity')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($caregiverDailyReports->count() > 0)
                @foreach($caregiverDailyReports as $report)
                    <tr>
                        <td>{{ is_string($report->date) ? \Carbon\Carbon::parse($report->date)->format('d M, Y') : $report->date->format('d M, Y') }}</td>
                        <td>{{ $report->caregiver->name ?? 'N/A' }}</td>
                        <td>{{ $report->mood ?? 'N/A' }}</td>
                        <td>{{ $report->pain_level ?? 'N/A' }}</td>
                        <td>{{ Str::limit($report->favorite_activity, 30) ?? 'N/A' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#caregiverModal{{ $report->id }}">
                                @lang('View Details')
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">@lang('No caregiver daily reports found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Modal for Caregiver Daily Report Details -->
@foreach($caregiverDailyReports as $report)
<div class="modal fade" id="caregiverModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="caregiverModalLabel{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="caregiverModalLabel{{ $report->id }}">@lang('Caregiver Daily Report Details')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>@lang('Basic Information')</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>@lang('Date'):</strong></td>
                                <td>{{ is_string($report->date) ? \Carbon\Carbon::parse($report->date)->format('d M, Y') : $report->date->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Caregiver'):</strong></td>
                                <td>{{ $report->caregiver->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Mood'):</strong></td>
                                <td>{{ $report->mood ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Pain Level'):</strong></td>
                                <td>{{ $report->pain_level ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Favorite Activity'):</strong></td>
                                <td>{{ $report->favorite_activity ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('Meals')</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>@lang('Breakfast'):</strong></td>
                                <td>{{ $report->breakfast ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Lunch'):</strong></td>
                                <td>{{ $report->lunch ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Dinner'):</strong></td>
                                <td>{{ $report->dinner ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>@lang('Additional Information')</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>@lang('Concerns'):</strong></td>
                                <td>{{ $report->concerns ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endforeach