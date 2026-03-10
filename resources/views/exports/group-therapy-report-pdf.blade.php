@extends('exports.base-single-pdf')

@section('content')
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
            <div class="info-label">Ward:</div>
            <div class="info-value">{{ $therapyReport->ward->name ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Group Therapy Session</h3>
        <div class="info-row">
            <div class="info-label">Participants:</div>
            <div class="info-value">
                @if($therapyReport->participant_ids && count($therapyReport->participant_ids) > 0)
                    @foreach($therapyReport->participant_ids as $participantId)
                        {{ \App\Models\User::find($participantId)->name ?? 'N/A' }}@if(!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        <div style="padding: 10px;  border-radius: 4px;">
            <p><strong>Session Summary:</strong></p>
            {{ $therapyReport->group_session_summary ?? 'N/A' }}
        </div>
    </div>
    
    <div class="info-section">
        <h3>End-of-Day Notes & Clean-Up</h3>
        <div style="padding: 10px;  border-radius: 4px;">
            <div class="info-row">
                <div class="info-label">Overall Observations:</div>
                <div class="info-value">{{ $therapyReport->overall_observations ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Equipment/Room Clean-Up:</div>
                <div class="info-value">{{ $therapyReport->equipment_clean_up ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Additional Comments:</div>
                <div class="info-value">{{ $therapyReport->additional_comments ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
@endsection