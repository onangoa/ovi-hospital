<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Request Date')</th>
                <th>@lang('Clinician')</th>
                <th>@lang('Specimen')</th>
                <th>@lang('Investigation Requested')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($labRequests->count() > 0)
                @foreach($labRequests as $request)
                    <tr>
                        <td>{{ is_string($request->request_date) ? \Carbon\Carbon::parse($request->request_date)->format('d M, Y') : $request->request_date->format('d M, Y') }}</td>
                        <td>{{ $request->clinician->name ?? 'N/A' }}</td>
                        <td>{{ $request->specimen ?? 'N/A' }}</td>
                        <td>{{ Str::limit($request->investigation_requested, 50) ?? 'N/A' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#labRequestModal{{ $request->id }}">
                                @lang('View Details')
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">@lang('No lab requests found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Modal for Lab Request Details -->
@foreach($labRequests as $request)
<div class="modal fade" id="labRequestModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="labRequestModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labRequestModalLabel{{ $request->id }}">@lang('Lab Request Details')</h5>
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
                                <td><strong>@lang('Request Date'):</strong></td>
                                <td>{{ is_string($request->request_date) ? \Carbon\Carbon::parse($request->request_date)->format('d M, Y') : $request->request_date->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Clinician'):</strong></td>
                                <td>{{ $request->clinician->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Age'):</strong></td>
                                <td>{{ $request->age ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Sex'):</strong></td>
                                <td>{{ $request->sex ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Resident'):</strong></td>
                                <td>{{ $request->resident ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Specimen'):</strong></td>
                                <td>{{ $request->specimen ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('Test Categories')</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>@lang('Blood Bank'):</strong></td>
                                <td>{{ $request->blood_bank ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Histology'):</strong></td>
                                <td>{{ $request->histology ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Serology'):</strong></td>
                                <td>{{ $request->serology ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Haematology'):</strong></td>
                                <td>{{ $request->haematology ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Bacteriology'):</strong></td>
                                <td>{{ $request->bacteriology ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Parasitology'):</strong></td>
                                <td>{{ $request->parasitology ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Biochemistry'):</strong></td>
                                <td>{{ $request->biochemistry ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Other Destination'):</strong></td>
                                <td>{{ $request->other_destination ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>@lang('Clinical Information')</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>@lang('Investigation Requested'):</strong></td>
                                <td>{{ $request->investigation_requested ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Differential Diagnosis'):</strong></td>
                                <td>{{ $request->differential_diagnosis ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($request->vital_signs)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>@lang('Vital Signs')</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Temperature:</strong> {{ $request->vital_signs['temperature'] ?? 'N/A' }} °C
                                </div>
                                <div class="col-md-3">
                                    <strong>Blood Pressure:</strong> {{ $request->vital_signs['systolic_bp'] ?? 'N/A' }}/{{ $request->vital_signs['diastolic_bp'] ?? 'N/A' }} mmHg
                                </div>
                                <div class="col-md-3">
                                    <strong>Pulse Rate:</strong> {{ $request->vital_signs['pulse_rate'] ?? 'N/A' }} bpm
                                </div>
                                <div class="col-md-3">
                                    <strong>Respiratory Rate:</strong> {{ $request->vital_signs['respiratory_rate'] ?? 'N/A' }} /min
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endforeach