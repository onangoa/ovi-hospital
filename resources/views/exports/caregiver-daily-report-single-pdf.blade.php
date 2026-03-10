@extends('exports.base-single-pdf')

@php
    $title = 'Caregiver Daily Report - ' . $caregiverDailyReport->patient->name;
@endphp

@section('content')
    <div class="info-section">
        <h3>Patient & Caregiver Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $caregiverDailyReport->patient->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $caregiverDailyReport->caregiver->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ is_string($caregiverDailyReport->date) ? \Carbon\Carbon::parse($caregiverDailyReport->date)->format('d M, Y') : $caregiverDailyReport->date->format('d M, Y') }}</div>
        </div>
    </div>
    
    @if($caregiverDailyReport->mood)
    <div class="info-section">
        <h3>Patient Mood Assessment</h3>
        <div class="info-row">
            <div class="info-label">Mood:</div>
            <div class="info-value">
                {{ $caregiverDailyReport->mood }}
                
            </div>
        </div>
    </div>
    @endif
    
    <div class="info-section">
        <h3>Activity & Health</h3>
        <div class="info-row">
            <div class="info-label">Favorite Activity:</div>
            <div class="info-value">{{ $caregiverDailyReport->favorite_activity ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Pain Level:</div>
            <div class="info-value">{{ $caregiverDailyReport->pain_level ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Concerns:</div>
            <div class="info-value">{{ $caregiverDailyReport->concerns ?? 'N/A' }}</div>
        </div>
    </div>
@endsection