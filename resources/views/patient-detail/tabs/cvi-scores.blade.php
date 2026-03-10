<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Score')</th>
                <th>@lang('Vitality Status')</th>
                <th>@lang('Notes')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($cviScores->count() > 0)
                @foreach($cviScores as $cviScore)
                    <tr>
                        <td>{{ is_string($cviScore->date) ? \Carbon\Carbon::parse($cviScore->date)->format('d M, Y') : $cviScore->date->format('d M, Y') }}</td>
                        <td>{{ $cviScore->score }}</td>
                        <td>
                            <span class="badge badge-{{ $cviScore->score <= 59 ? 'danger' : ($cviScore->score <= 79 ? 'warning' : ($cviScore->score <= 89 ? 'info' : 'success')) }}">
                                {{ $cviScore->vitality_score }}
                            </span>
                        </td>
                        <td>{{ Str::limit($cviScore->notes, 50) ?? 'N/A' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#cviModal{{ $cviScore->id }}">
                                @lang('View Details')
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">@lang('No CVI scores found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Modal for CVI Score Details -->
@foreach($cviScores as $cviScore)
<div class="modal fade" id="cviModal{{ $cviScore->id }}" tabindex="-1" role="dialog" aria-labelledby="cviModalLabel{{ $cviScore->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cviModalLabel{{ $cviScore->id }}">@lang('CVI Score Details')</h5>
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
                                <td>{{ is_string($cviScore->date) ? \Carbon\Carbon::parse($cviScore->date)->format('d M, Y') : $cviScore->date->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Score'):</strong></td>
                                <td>{{ $cviScore->score }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Vitality Status'):</strong></td>
                                <td>
                                    <span class="badge badge-{{ $cviScore->score <= 59 ? 'danger' : ($cviScore->score <= 79 ? 'warning' : ($cviScore->score <= 89 ? 'info' : 'success')) }}">
                                        {{ $cviScore->vitality_score }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Notes'):</strong></td>
                                <td>{{ $cviScore->notes ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('Assessment Factors')</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>@lang('Nutritional Status'):</strong></td>
                                <td>{{ $cviScore->nutritionalStatus ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Developmentally Delayed'):</strong></td>
                                <td>{{ $cviScore->developmentallyDelayed ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Chronic Conditions'):</strong></td>
                                <td>{{ $cviScore->chronicConditions ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Mental Health'):</strong></td>
                                <td>{{ $cviScore->mentalHealth ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Physical Disabilities'):</strong></td>
                                <td>{{ $cviScore->physicalDisabilities ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Communication Abilities'):</strong></td>
                                <td>{{ $cviScore->communicationAbilities ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Vaccine Status'):</strong></td>
                                <td>{{ $cviScore->vaccineStatus ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>@lang('Environmental Factors')</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>@lang('Familial Instability'):</strong></td>
                                <td>{{ $cviScore->familialInstability ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Poverty'):</strong></td>
                                <td>{{ $cviScore->poverty ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Institutionalized'):</strong></td>
                                <td>{{ $cviScore->institutionalized ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Insecure Shelter'):</strong></td>
                                <td>{{ $cviScore->insecureShelter ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Psychological Trauma'):</strong></td>
                                <td>{{ $cviScore->psychologicalTrauma ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Social Isolation'):</strong></td>
                                <td>{{ $cviScore->socialIsolation ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Discrimination'):</strong></td>
                                <td>{{ $cviScore->discrimination ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Conflict Area'):</strong></td>
                                <td>{{ $cviScore->conflictArea ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Healthcare Access'):</strong></td>
                                <td>{{ $cviScore->healthcareAccess ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Water Source'):</strong></td>
                                <td>{{ $cviScore->waterSource ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Sanitation'):</strong></td>
                                <td>{{ $cviScore->sanitation ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('School Status'):</strong></td>
                                <td>{{ $cviScore->schoolStatus ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>@lang('Disease Outbreaks'):</strong></td>
                                <td>{{ $cviScore->diseaseOutbreaks ?? 'N/A' }}</td>
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