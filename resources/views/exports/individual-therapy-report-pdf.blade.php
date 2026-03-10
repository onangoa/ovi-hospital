@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $therapyReport->patient->name ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Session Details</h3>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($therapyReport->date)->format('d-m-Y') ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $therapyReport->physiotherapist->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Session Time:</div>
            <div class="info-value">{{ $therapyReport->session_time ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Individual Therapy Session</h3>
        <div class="data-section">
            {{ $therapyReport->session_summary ?? 'N/A' }}
        </div>
    </div>
@endsection