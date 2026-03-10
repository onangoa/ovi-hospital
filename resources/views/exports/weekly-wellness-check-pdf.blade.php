@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->patient->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ optional($weeklyWellnessCheck->date)->format('Y-m-d') ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted By:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->conductedBy->name ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Physical Health</h3>
        <div class="info-row">
            <div class="info-label">Vital Signs:</div>
            <div class="info-value">
                @if(is_array($weeklyWellnessCheck->vital_signs))
                    @foreach($weeklyWellnessCheck->vital_signs as $key => $value)
                        {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}<br>
                    @endforeach
                @else
                    {{ $weeklyWellnessCheck->vital_signs ?? 'N/A' }}
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Meals:</div>
            <div class="info-value">
                @if($weeklyWellnessCheck->full_meals)
                    Full meals
                @elseif($weeklyWellnessCheck->partial_meals)
                    Partial meals
                @elseif($weeklyWellnessCheck->minimal_meals)
                    Minimal meals
                @else
                    N/A
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Skin and Wounds:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->skin_wounds ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Mobility:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->mobility ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Mobility Notes:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->mobility_notes ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Sleep:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->sleep ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Emotional and Behavioral Signs</h3>
        <div class="info-row">
            <div class="info-label">Mood:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->mood ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Engagement:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->engagement ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Behavior Changes:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->behavior_changes ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Social Interaction</h3>
        <div class="info-row">
            <div class="info-label">With Caregivers:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->with_caregivers ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">With Peers:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->with_peers ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Communication:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->communication ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Pain and Comfort</h3>
        <div class="info-row">
            <div class="info-label">Pain Indicators:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->pain_indicators ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Comfort:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->comfort ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Medical and Environmental Review</h3>
        <div class="info-row">
            <div class="info-label">Medication:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->medication ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Signs of Illness:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->signs_of_illness ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Hydration:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->hydration ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Environment:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->environment ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Notes and Follow-Up</h3>
        <div class="info-row">
            <div class="info-label">Progress:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->progress ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Next Steps:</div>
            <div class="info-value">{{ $weeklyWellnessCheck->next_steps ?? 'N/A' }}</div>
        </div>
    </div>
@endsection