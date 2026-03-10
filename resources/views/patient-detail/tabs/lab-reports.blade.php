<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Doctor')</th>
                <th>@lang('Report Type')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($labReports->count() > 0)
                @foreach($labReports as $report)
                    <tr>
                        <td>{{ is_string($report->date) ? \Carbon\Carbon::parse($report->date)->format('d M, Y') : $report->date->format('d M, Y') }}</td>
                        <td>{{ App\Models\User::find($report->doctor_id)->name ?? 'N/A' }}</td>
                        <td>{{ $report->labReportTemplate->name ?? 'N/A' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#labReportModal{{ $report->id }}">
                                @lang('View Details')
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">@lang('No lab reports found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Modal for Lab Report Details -->
@foreach($labReports as $report)
<div class="modal fade" id="labReportModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="labReportModalLabel{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labReportModalLabel{{ $report->id }}">@lang('Lab Report Details')</h5>
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
                                <td><strong>@lang('Doctor'):</strong></td>
                                <td>{{ App\Models\User::find($report->doctor_id)->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Report Type'):</strong></td>
                                <td>{{ $report->labReportTemplate->name ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('Report Image')</h6>
                        @if($report->photo)
                            <img src="{{ asset($report->photo) }}" class="img-fluid" alt="Lab Report">
                        @else
                            <p>@lang('No image available')</p>
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>@lang('Report Content')</h6>
                        <div class="card">
                            <div class="card-body">
                                {!! $report->report !!}
                            </div>
                        </div>
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