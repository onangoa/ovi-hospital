@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Basic Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $wardRoundNote->patient->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ optional($wardRoundNote->date)->format('Y-m-d') ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $wardRoundNote->attendingClinician->name ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Vital Signs</h3>
        <div class="data-section">
            <div style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Temperature (°C):</strong> {{ $wardRoundNote->vital_signs['temperature'] ?? 'N/A' }}
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Pulse Rate (bpm):</strong> {{ $wardRoundNote->vital_signs['pulse_rate'] ?? 'N/A' }}
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Respiratory Rate:</strong> {{ $wardRoundNote->vital_signs['respiratory_rate'] ?? 'N/A' }}
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>SpO2 (%):</strong> {{ $wardRoundNote->vital_signs['oxygen_saturation'] ?? 'N/A' }}
                </div>
            </div>
            <div style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Systolic BP (mmHg):</strong> {{ $wardRoundNote->vital_signs['systolic_bp'] ?? 'N/A' }}
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Diastolic BP (mmHg):</strong> {{ $wardRoundNote->vital_signs['diastolic_bp'] ?? 'N/A' }}
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>Hb (g/dL):</strong> {{ $wardRoundNote->vital_signs['hb'] ?? 'N/A' }}
                </div>
                <div style="flex: 0 0 25%; padding: 5px;">
                    <strong>RBS (mg/dL):</strong> {{ $wardRoundNote->vital_signs['rbs'] ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Assessment Details</h3>
        <div class="info-row">
            <div class="info-label">Main Complaints:</div>
            <div class="info-value">{{ $wardRoundNote->main_complaints ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Examination Findings:</div>
            <div class="info-value">{{ $wardRoundNote->examination_findings ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Systemic Assessment</h3>
        <div class="data-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>System</th>
                        <th>Status</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Respiratory</td>
                        <td>{{ ucfirst($wardRoundNote->respiratory_status ?? 'N/A') }}</td>
                        <td>{{ $wardRoundNote->respiratory_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Cardiovascular</td>
                        <td>{{ ucfirst($wardRoundNote->cardiovascular_status ?? 'N/A') }}</td>
                        <td>{{ $wardRoundNote->cardiovascular_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Neurological</td>
                        <td>{{ ucfirst($wardRoundNote->neurological_status ?? 'N/A') }}</td>
                        <td>{{ $wardRoundNote->neurological_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Gastrointestinal</td>
                        <td>{{ ucfirst($wardRoundNote->gastrointestinal_status ?? 'N/A') }}</td>
                        <td>{{ $wardRoundNote->gastrointestinal_comments ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Skin/Wounds</td>
                        <td>{{ ucfirst($wardRoundNote->skin_status ?? 'N/A') }}</td>
                        <td>{{ $wardRoundNote->skin_comments ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Plan and Updates</h3>
        <div class="info-row">
            <div class="info-label">Medications/Changes:</div>
            <div class="info-value">{{ $wardRoundNote->medications_changes ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Procedures/Interventions:</div>
            <div class="info-value">{{ $wardRoundNote->procedures_interventions ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Pending Tests:</div>
            <div class="info-value">{{ $wardRoundNote->pending_tests ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Progress and Next Steps</h3>
        <div class="info-row">
            <div class="info-label">Condition:</div>
            <div class="info-value">{{ ucfirst($wardRoundNote->condition ?? 'N/A') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Next Steps:</div>
            <div class="info-value">{{ $wardRoundNote->next_steps ?? 'N/A' }}</div>
        </div>
    </div>
@endsection