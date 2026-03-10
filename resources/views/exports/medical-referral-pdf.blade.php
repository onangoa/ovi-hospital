@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Referral Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $medicalReferral->patient->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $medicalReferral->referringDoctor->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Referral Date:</div>
            <div class="info-value">{{ $medicalReferral->created_at->format('d M, Y') }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Reason for Referral</h3>
        <div class="data-section">
            {{ $medicalReferral->reason_for_referral }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Chief Complaint</h3>
        <div class="data-section">
            {{ $medicalReferral->chief_complaint }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Patient Brief History</h3>
        <div class="data-section">
            {{ $medicalReferral->patient_brief_history }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Vital Signs</h3>
        <div class="data-section">
            <div style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Temperature:</strong> {{ $medicalReferral->vital_signs['temperature'] ?? 'N/A' }} °C
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Blood Pressure:</strong> {{ $medicalReferral->vital_signs['systolic_bp'] ?? 'N/A' }}/{{ $medicalReferral->vital_signs['diastolic_bp'] ?? 'N/A' }} mmHg
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Pulse Rate:</strong> {{ $medicalReferral->vital_signs['pulse_rate'] ?? 'N/A' }} bpm
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Respiratory Rate:</strong> {{ $medicalReferral->vital_signs['respiratory_rate'] ?? 'N/A' }} /min
                </div>
            </div>
            <div style="display: flex; flex-wrap: wrap;">
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Oxygen Saturation:</strong> {{ $medicalReferral->vital_signs['oxygen_saturation'] ?? 'N/A' }} %
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Hb:</strong> {{ $medicalReferral->vital_signs['hb'] ?? 'N/A' }} g/dL
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>RBS:</strong> {{ $medicalReferral->vital_signs['rbs'] ?? 'N/A' }} mg/dL
                </div>
            </div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Lab Investigation Done Before Referral</h3>
        <div class="data-section">
            {{ $medicalReferral->lab_investigation_done }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Treatment Done Before Referral</h3>
        <div class="data-section">
            {{ $medicalReferral->treatment_done }}
        </div>
    </div>
@endsection