@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Cardex Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $nursingCardex->patient->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ $nursingCardex->date->format('d-m-Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $nursingCardex->nurse_on_duty_name }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Vital Signs</h3>
        <div class="data-section">
            <div style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Temperature:</strong> {{ $nursingCardex->vital_signs['temperature'] ?? 'N/A' }} °C
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Blood Pressure:</strong> {{ $nursingCardex->vital_signs['systolic_bp'] ?? 'N/A' }}/{{ $nursingCardex->vital_signs['diastolic_bp'] ?? 'N/A' }} mmHg
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Pulse Rate:</strong> {{ $nursingCardex->vital_signs['pulse_rate'] ?? 'N/A' }} bpm
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Respiratory Rate:</strong> {{ $nursingCardex->vital_signs['respiratory_rate'] ?? 'N/A' }} /min
                </div>
            </div>
            <div style="display: flex; flex-wrap: wrap;">
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Oxygen Saturation:</strong> {{ $nursingCardex->vital_signs['oxygen_saturation'] ?? 'N/A' }} %
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Hb:</strong> {{ $nursingCardex->vital_signs['hb'] ?? 'N/A' }} g/dL
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>RBS:</strong> {{ $nursingCardex->vital_signs['rbs'] ?? 'N/A' }} mg/dL
                </div>
            </div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Brief Report</h3>
        <div class="data-section">
            {{ $nursingCardex->brief_report }}
        </div>
    </div>
@endsection