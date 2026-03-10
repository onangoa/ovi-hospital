@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $prescription->user->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Conducted by:</div>
            <div class="info-value">{{ $prescription->doctor->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Weight (kg):</div>
            <div class="info-value">{{ $prescription->user->weight ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Height (feet):</div>
            <div class="info-value">{{ $prescription->user->height ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Chief Complaint</h3>
        <div class="data-section">
            {{ $prescription->chief_complaint ?? 'N/A' }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>Medicines</h3>
        <div class="data-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Medicine Type</th>
                        <th>Instruction</th>
                        <th>Days</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(json_decode($prescription->medicine_info) as $medicineInfo)
                        <tr>
                            <td>{{ $medicineInfo->medicine_name }}</td>
                            <td>{{ $medicineInfo->medicine_type }}</td>
                            <td>{{ $medicineInfo->instruction }}</td>
                            <td>{{ $medicineInfo->day }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Diagnosis</h3>
        <div class="data-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Diagnosis</th>
                        <th>Instruction</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(json_decode($prescription->diagnosis_info) as $diagnosisInfo)
                        <tr>
                            <td>{{ $diagnosisInfo->diagnosis }}</td>
                            <td>{{ $diagnosisInfo->diagnosis_instruction }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Note</h3>
        <div class="data-section">
            {{ $prescription->note ?? 'N/A' }}
        </div>
    </div>
@endsection