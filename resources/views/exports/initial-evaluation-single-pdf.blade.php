@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Name:</div>
            <div class="info-value">{{ $initialEvaluation->patient->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ is_string($initialEvaluation->date) ? \Carbon\Carbon::parse($initialEvaluation->date)->format('d M, Y') : $initialEvaluation->date->format('d M, Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $initialEvaluation->provider_name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Reason for seeking treatment:</div>
            <div class="info-value">{{ $initialEvaluation->reason_for_treatment ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Summary of social background:</div>
            <div class="info-value">{{ $initialEvaluation->social_background ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Clinical Status Evaluation</h3>
        
        <h4>Vital Signs</h4>
        <div class="data-section">
            @if($initialEvaluation->vital_signs && is_array($initialEvaluation->vital_signs))
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                    @if($initialEvaluation->vital_signs['temperature'])
                        <div><strong>Temperature (°C):</strong> {{ $initialEvaluation->vital_signs['temperature'] }}</div>
                    @endif
                    @if($initialEvaluation->vital_signs['pulse_rate'])
                        <div><strong>Pulse Rate (bpm):</strong> {{ $initialEvaluation->vital_signs['pulse_rate'] }}</div>
                    @endif
                    @if($initialEvaluation->vital_signs['respiratory_rate'])
                        <div><strong>Respiratory Rate:</strong> {{ $initialEvaluation->vital_signs['respiratory_rate'] }}</div>
                    @endif
                    @if($initialEvaluation->vital_signs['oxygen_saturation'])
                        <div><strong>SpO2 (%):</strong> {{ $initialEvaluation->vital_signs['oxygen_saturation'] }}</div>
                    @endif
                    @if($initialEvaluation->vital_signs['systolic_bp'])
                        <div><strong>Systolic BP (mmHg):</strong> {{ $initialEvaluation->vital_signs['systolic_bp'] }}</div>
                    @endif
                    @if($initialEvaluation->vital_signs['diastolic_bp'])
                        <div><strong>Diastolic BP (mmHg):</strong> {{ $initialEvaluation->vital_signs['diastolic_bp'] }}</div>
                    @endif
                    @if($initialEvaluation->vital_signs['hb'])
                        <div><strong>Hb (g/dL):</strong> {{ $initialEvaluation->vital_signs['hb'] }}</div>
                    @endif
                    @if($initialEvaluation->vital_signs['rbs'])
                        <div><strong>RBS (mg/dL):</strong> {{ $initialEvaluation->vital_signs['rbs'] }}</div>
                    @endif
                </div>
            @endif
        </div>
        
        <h4>General Examination</h4>
        <div class="data-section">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div><strong>Skin Color/Condition:</strong> {{ $initialEvaluation->skin_condition ?? 'N/A' }}</div>
                <div><strong>Edema:</strong> 
                    @if($initialEvaluation->edema == 'present')
                        Present
                    @elseif($initialEvaluation->edema == 'absent')
                        Absent
                    @else
                        N/A
                    @endif
                </div>
                <div><strong>Nutritional Status:</strong> 
                    @if($initialEvaluation->nutritional_status == 'adequate')
                        Adequate
                    @elseif($initialEvaluation->nutritional_status == 'malnourished')
                        Malnourished
                    @else
                        N/A
                    @endif
                </div>
                <div><strong>Signs of Pain:</strong> {{ $initialEvaluation->pain_signs ?? 'N/A' }}</div>
                <div><strong>Hydration Status:</strong> 
                    @if($initialEvaluation->hydration == 'adequate')
                        Adequate
                    @elseif($initialEvaluation->hydration == 'mild')
                        Mild dehydration
                    @elseif($initialEvaluation->hydration == 'severe')
                        Severe dehydration
                    @else
                        N/A
                    @endif
                </div>
                <div><strong>Pain Level (Scale 0-10):</strong> {{ $initialEvaluation->pain_level ?? 'N/A' }}</div>
                <div><strong>Location of Pain:</strong> {{ $initialEvaluation->pain_location ?? 'N/A' }}</div>
                <div><strong>Mobility:</strong> 
                    @if($initialEvaluation->mobility == 'independent')
                        Independent
                    @elseif($initialEvaluation->mobility == 'partial')
                        Partial assistance required
                    @elseif($initialEvaluation->mobility == 'fully_dependent')
                        Fully dependent
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>
        
        <h4>Systemic Assessment</h4>
        <div class="data-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>System</th>
                        <th>Status</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Respiratory</td>
                        <td>
                            @if($initialEvaluation->respiratory == 'normal')
                                Normal
                            @elseif($initialEvaluation->respiratory == 'abnormal')
                                Abnormal
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->respiratory_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Cardiovascular</td>
                        <td>
                            @if($initialEvaluation->cardiovascular == 'normal')
                                Normal
                            @elseif($initialEvaluation->cardiovascular == 'abnormal')
                                Abnormal
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->cardiovascular_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Neurological</td>
                        <td>
                            @if($initialEvaluation->neurological == 'normal')
                                Normal
                            @elseif($initialEvaluation->neurological == 'abnormal')
                                Abnormal
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->neurological_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Gastrointestinal</td>
                        <td>
                            @if($initialEvaluation->gastrointestinal == 'normal')
                                Normal
                            @elseif($initialEvaluation->gastrointestinal == 'abnormal')
                                Abnormal
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->gastrointestinal_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Musculoskeletal</td>
                        <td>
                            @if($initialEvaluation->musculoskeletal == 'normal')
                                Normal
                            @elseif($initialEvaluation->musculoskeletal == 'abnormal')
                                Abnormal
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->musculoskeletal_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Skin/Wounds</td>
                        <td>
                            @if($initialEvaluation->skin == 'normal')
                                Normal
                            @elseif($initialEvaluation->skin == 'abnormal')
                                Abnormal
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->skin_comments ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <h4>Ongoing Medical History and Needs</h4>
        <div class="data-section">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div><strong>Primary Diagnosis:</strong> {{ $initialEvaluation->primary_diagnosis ?? 'N/A' }}</div>
                <div><strong>Secondary Diagnosis:</strong> {{ $initialEvaluation->secondary_diagnosis ?? 'N/A' }}</div>
                <div><strong>Known Chronic Conditions:</strong> {{ $initialEvaluation->chronic_conditions ?? 'N/A' }}</div>
                <div><strong>Current Medications:</strong> {{ $initialEvaluation->current_medications ?? 'N/A' }}</div>
                <div><strong>Allergies:</strong> {{ $initialEvaluation->allergies ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Daily Living and Therapy Needs</h3>
        
        <h4>Activities of Daily Living (ADLs)</h4>
        <div class="data-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Level of Assistance</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bathing</td>
                        <td>
                            @if($initialEvaluation->bathing == 'none')
                                None
                            @elseif($initialEvaluation->bathing == 'partial')
                                Partial
                            @elseif($initialEvaluation->bathing == 'full')
                                Full
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->bathing_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Dressing</td>
                        <td>
                            @if($initialEvaluation->dressing == 'none')
                                None
                            @elseif($initialEvaluation->dressing == 'partial')
                                Partial
                            @elseif($initialEvaluation->dressing == 'full')
                                Full
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->dressing_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Eating</td>
                        <td>
                            @if($initialEvaluation->eating == 'none')
                                None
                            @elseif($initialEvaluation->eating == 'partial')
                                Partial
                            @elseif($initialEvaluation->eating == 'full')
                                Full
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->eating_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Mobility/Transfers</td>
                        <td>
                            @if($initialEvaluation->mobility_transfers == 'none')
                                None
                            @elseif($initialEvaluation->mobility_transfers == 'partial')
                                Partial
                            @elseif($initialEvaluation->mobility_transfers == 'full')
                                Full
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->mobility_transfers_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Toileting</td>
                        <td>
                            @if($initialEvaluation->toileting == 'none')
                                None
                            @elseif($initialEvaluation->toileting == 'partial')
                                Partial
                            @elseif($initialEvaluation->toileting == 'full')
                                Full
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->toileting_comments ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <h4>Therapies Needed</h4>
        <div class="data-section">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div><strong>Physical Therapy:</strong> 
                    @if($initialEvaluation->physical_therapy)
                        Yes
                    @else
                        No
                    @endif
                </div>
                <div><strong>Psychiatric/Trauma Support:</strong> 
                    @if($initialEvaluation->psychiatric_support)
                        Yes
                    @else
                        No
                    @endif
                </div>
                <div><strong>Virtual Reality Therapy / Play Therapy:</strong> 
                    @if($initialEvaluation->virtual_therapy)
                        Yes
                    @else
                        No
                    @endif
                </div>
                <div><strong>Other Therapy:</strong> 
                    @if($initialEvaluation->other_therapy)
                        Yes
                    @else
                        No
                    @endif
                </div>
            </div>
            @if($initialEvaluation->other_therapy_comments)
                <div style="margin-top: 10px;"><strong>Other Therapy Comments:</strong> {{ $initialEvaluation->other_therapy_comments }}</div>
            @endif
        </div>
    </div>
    
    <div class="info-section">
        <h3>Social and Emotional Well-Being</h3>
        <div class="data-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Observation</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Emotional State</td>
                        <td>
                            @if($initialEvaluation->emotional_state == 'stable')
                                Stable
                            @elseif($initialEvaluation->emotional_state == 'unstable')
                                Unstable
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->emotional_state_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Engagement in Activities</td>
                        <td>
                            @if($initialEvaluation->engagement == 'high')
                                High
                            @elseif($initialEvaluation->engagement == 'moderate')
                                Moderate
                            @elseif($initialEvaluation->engagement == 'low')
                                Low
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->engagement_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Interaction with Peers</td>
                        <td>
                            @if($initialEvaluation->peer_interaction == 'positive')
                                Positive
                            @elseif($initialEvaluation->peer_interaction == 'neutral')
                                Neutral
                            @elseif($initialEvaluation->peer_interaction == 'negative')
                                Negative
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $initialEvaluation->peer_interaction_comments ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection