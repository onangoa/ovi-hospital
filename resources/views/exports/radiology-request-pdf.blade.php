@extends('exports.base-single-pdf')

@php
    $title = 'Radiology Request - ' . $radiologyRequest->patient->name;
@endphp

@section('content')
    
    <div class="request-info">
        
        <div class="request-details">
            <div class="info-section">
                <h3>Patient Information</h3>
                <div class="info-row">
                    <div class="info-label">Patient Name:</div>
                    <div class="info-value">{{ $radiologyRequest->patient->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Blood Group:</div>
                    <div class="info-value">{{ $radiologyRequest->patient->blood_group }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Conducted by:</div>
                    <div class="info-value">
                        @if($radiologyRequest->provider_id)
                            {{ App\Models\User::find($radiologyRequest->provider_id)->name ?? 'User ID: ' . $radiologyRequest->provider_id . ' (Not Found)' }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Request Date:</div>
                    <div class="info-value">{{ $radiologyRequest->created_at->format('d M, Y') }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Examination Requested</h3>
        <div style="padding: 10px;  border-radius: 4px;">
            {{ implode(', ', $radiologyRequest->examination_type ?? []) }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Examination Details</h3>
        <div style="padding: 10px;  border-radius: 4px;">
            <p><strong>Body organs to be imaged:</strong></p>
            {{ $radiologyRequest->examination_details }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Relevant Clinical Information</h3>
        <div style="padding: 10px;  border-radius: 4px;">
            {{ $radiologyRequest->relevant_clinical_information }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Reason for Radiological Investigation</h3>
        <div style="padding: 10px;  border-radius: 4px;">
            {{ $radiologyRequest->reason_for_investigation }}
        </div>
    </div>
@endsection