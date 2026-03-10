@extends('exports.base-single-pdf')

@php
    $title = 'Patient - ' . ($patientDetail->name ?? '');
@endphp

@section('content')
    <div class="patient-info">
        
        <div class="patient-details">
            <div class="info-section">
                <h3>Personal Information</h3>
                <div class="info-row">
                    <div class="info-label">Full Name:</div>
                    <div class="info-value">{{ $patientDetail->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $patientDetail->email ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $patientDetail->phone ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value">{{ $patientDetail->address ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Gender:</div>
                    <div class="info-value">{{ ucfirst($patientDetail->gender ?: 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Blood Group:</div>
                    <div class="info-value">{{ $patientDetail->blood_group ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date of Birth:</div>
                    <div class="info-value">{{ $patientDetail->date_of_birth ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Age:</div>
                    <div class="info-value">{{ $patientDetail->age ?: 'N/A' }}</div>
                </div>
            </div>
            
            <div class="info-section">
                <h3>Physical Information</h3>
                <div class="info-row">
                    <div class="info-label">Weight (kg):</div>
                    <div class="info-value">{{ $patientDetail->weight ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Height (cm):</div>
                    <div class="info-value">{{ $patientDetail->height ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ward Assigned:</div>
                    <div class="info-value">{{ $patientDetail->wards->first()->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        @if($patientDetail->status == 1)
                            <span class="status-active">Active</span>
                        @else
                            <span class="status-inactive">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($patientDetail->guardian_name || $patientDetail->guardian_phone || $patientDetail->guardian_email || $patientDetail->guardian_address)
    <div class="guardian-section">
        <h3>Parent/Guardian Details</h3>
        <div class="info-row">
            <div class="info-label">Name:</div>
            <div class="info-value">{{ $patientDetail->guardian_name ?: 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Phone:</div>
            <div class="info-value">{{ $patientDetail->guardian_phone ?: 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $patientDetail->guardian_email ?: 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Relation:</div>
            <div class="info-value">{{ $patientDetail->guardian_relation ?: 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Address:</div>
            <div class="info-value">{{ $patientDetail->guardian_address ?: 'N/A' }}</div>
        </div>
    </div>
    @endif
    
    @if($patientDetail->carePreferences)
    <div class="care-preferences">
        <h3>Care Preferences</h3>
        @if($patientDetail->carePreferences->likes)
        <div class="info-row">
            <div class="info-label">Likes:</div>
            <div class="info-value">{{ $patientDetail->carePreferences->likes }}</div>
        </div>
        @endif
        @if($patientDetail->carePreferences->dislikes)
        <div class="info-row">
            <div class="info-label">Dislikes:</div>
            <div class="info-value">{{ $patientDetail->carePreferences->dislikes }}</div>
        </div>
        @endif
        @if($patientDetail->carePreferences->care_preferences)
        <div class="info-row">
            <div class="info-label">Care Preferences:</div>
            <div class="info-value">{{ $patientDetail->carePreferences->care_preferences }}</div>
        </div>
        @endif
        @if($patientDetail->carePreferences->info)
        <div class="info-row">
            <div class="info-label">Additional Info:</div>
            <div class="info-value">{{ $patientDetail->carePreferences->info }}</div>
        </div>
        @endif
    </div>
    @endif
    
@endsection