@extends('exports.base-single-pdf')

@php
    $title = 'Doctor - ' . ($doctorDetail->user->name ?? '');
@endphp

@section('content')
    
    <div class="doctor-info">
        
        <div class="doctor-details">
            <div class="info-section">
                <h3>Personal Information</h3>
                <div class="info-row">
                    <div class="info-label">Full Name:</div>
                    <div class="info-value">{{ $doctorDetail->user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $doctorDetail->user->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $doctorDetail->user->phone ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value">{{ $doctorDetail->user->address ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Gender:</div>
                    <div class="info-value">{{ ucfirst($doctorDetail->user->gender ?: 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Blood Group:</div>
                    <div class="info-value">{{ $doctorDetail->user->blood_group ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date of Birth:</div>
                    <div class="info-value">{{ $doctorDetail->user->date_of_birth ?: 'N/A' }}</div>
                </div>
            </div>
            
            <div class="info-section">
                <h3>Professional Information</h3>
                <div class="info-row">
                    <div class="info-label">Specialist:</div>
                    <div class="info-value">{{ $doctorDetail->specialist ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Designation:</div>
                    <div class="info-value">{{ $doctorDetail->designation ?: 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Department:</div>
                    <div class="info-value">{{ $doctorDetail->hospitalDepartment->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        @if($doctorDetail->user->status == 1)
                            <span class="status-active">Active</span>
                        @else
                            <span class="status-inactive">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($doctorDetail->biography)
            <div class="info-section">
                <h3>Biography</h3>
                <div style="padding: 10px;  border-radius: 4px;">
                    {!! $doctorDetail->biography !!}
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection