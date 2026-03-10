@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Name:</div>
            <div class="info-value">{{ $labRequest->patient->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Age:</div>
            <div class="info-value">{{ $labRequest->age }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Sex:</div>
            <div class="info-value">{{ $labRequest->sex }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Resident:</div>
            <div class="info-value">{{ $labRequest->resident }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Request Information</h3>
        <div class="info-row">
            <div class="info-label">Request Date:</div>
            <div class="info-value">{{ is_string($labRequest->request_date) ? \Carbon\Carbon::parse($labRequest->request_date)->format('d M, Y') : $labRequest->request_date->format('d M, Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $labRequest->clinician->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Report To:</div>
            <div class="info-value">{{ $labRequest->report_to ?: 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Specimen Type:</div>
            <div class="info-value">{{ $labRequest->specimen_type ?: 'Not specified' }}</div>
        </div>
    </div>
    
    @if($labRequest->collection_datetime)
    <div class="info-section">
        <h3>Specimen Collection</h3>
        <div class="info-row">
            <div class="info-label">Collection Date & Time:</div>
            <div class="info-value">{{ is_string($labRequest->collection_datetime) ? \Carbon\Carbon::parse($labRequest->collection_datetime)->format('d M, Y H:i') : $labRequest->collection_datetime->format('d M, Y H:i') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Specimen No:</div>
            <div class="info-value">{{ $labRequest->specimen_no ?: 'Not assigned' }}</div>
        </div>
    </div>
    @endif
    
    <div class="info-section">
        <h3>Laboratory Destinations</h3>
        <div class="data-section">
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @if($labRequest->blood_bank) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">Blood Bank</div> @endif
                @if($labRequest->histology) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">Histology</div> @endif
                @if($labRequest->serology) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">Serology</div> @endif
                @if($labRequest->haematology) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">Haematology</div> @endif
                @if($labRequest->bacteriology) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">Bacteriology</div> @endif
                @if($labRequest->parasitology) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">Parasitology</div> @endif
                @if($labRequest->biochemistry) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">Biochemistry</div> @endif
                @if($labRequest->other_destination) <div style="padding: 8px 12px;  border-radius: 3px; font-size: 11px;">{{ $labRequest->other_destination }}</div> @endif
            </div>
        </div>
    </div>
    
    @if($labRequest->vital_signs && is_array($labRequest->vital_signs))
    <div class="info-section">
        <h3>Vital Signs</h3>
        <div class="data-section">
            @foreach($labRequest->vital_signs as $key => $value)
                @if($value)
                    <div style="display: inline-block; margin: 5px; padding: 5px 10px; background-color: white; border: 1px solid #ddd; border-radius: 3px;">
                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
    
    @if($labRequest->investigation_requested)
    <div class="info-section">
        <h3>Investigation Requested</h3>
        <div class="data-section">
            {{ $labRequest->investigation_requested }}
        </div>
    </div>
    @endif
    
    @if($labRequest->differential_diagnosis)
    <div class="info-section">
        <h3>Differential Diagnosis</h3>
        <div class="data-section">
            {{ $labRequest->differential_diagnosis }}
        </div>
    </div>
    @endif
@endsection