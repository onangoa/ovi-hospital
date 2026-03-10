@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Name:</div>
            <div class="info-value">{{ $carePlan->patient->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ is_string($carePlan->date) ? \Carbon\Carbon::parse($carePlan->date)->format('d M, Y') : $carePlan->date->format('d M, Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $carePlan->provider->name }}</div>
        </div>
    </div>
    
    @if($carePlan->medications && count($carePlan->medications) > 0)
    <div class="info-section">
        <h3>Medications</h3>
        <div class="data-section">
            @foreach($carePlan->medications as $medication)
                @if(is_array($medication) && !empty($medication['name']))
                    <div style="background-color: white; padding: 10px; margin-bottom: 10px; border-radius: 3px; border-left: 3px solid #333;">
                        <strong>{{ $medication['name'] }}</strong>
                        @if(isset($medication['dosage'])) <br><strong>Dosage:</strong> {{ $medication['dosage'] }} @endif
                        @if(isset($medication['frequency'])) <br><strong>Frequency:</strong> {{ $medication['frequency'] }} @endif
                        @if(isset($medication['duration'])) <br><strong>Duration:</strong> {{ $medication['duration'] }} @endif
                        @if(isset($medication['special_instructions'])) <br><strong>Special Instructions:</strong> {{ $medication['special_instructions'] }} @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
    
    <div class="info-section">
        <h3>Care Plan Details</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div style="padding: 10px; border-radius: 3px;">
                <strong>Dietary Needs:</strong><br>
                {{ $carePlan->dietary_needs ?: 'None specified' }}
            </div>
            <div style="padding: 10px; border-radius: 3px;">
                <strong>Activity Restrictions:</strong><br>
                {{ $carePlan->activity_restrictions ?: 'None specified' }}
            </div>
            <div style="padding: 10px; border-radius: 3px;">
                <strong>Wound Care:</strong><br>
                {{ $carePlan->wound_care ?: 'None specified' }}
            </div>
            <div style="padding: 10px; border-radius: 3px;">
                <strong>Admission Decision:</strong><br>
                {{ $carePlan->admission_decision ?: 'Not specified' }}
            </div>
        </div>
    </div>
    
    @if($carePlan->tests_needed || $carePlan->tests_comments)
    <div class="info-section">
        <h3>Tests Required</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            @if($carePlan->tests_needed)
            <div style="padding: 10px; border-radius: 3px;">
                <strong>Tests Needed:</strong><br>
                {{ $carePlan->tests_needed }}
            </div>
            @endif
            @if($carePlan->tests_comments)
            <div style="padding: 10px; border-radius: 3px;">
                <strong>Test Comments:</strong><br>
                {{ $carePlan->tests_comments }}
            </div>
            @endif
        </div>
    </div>
    @endif
    
    @if($carePlan->additional_notes)
    <div class="info-section">
        <h3>Additional Notes</h3>
        <div class="data-section">
            {{ $carePlan->additional_notes }}
        </div>
    </div>
    @endif
@endsection