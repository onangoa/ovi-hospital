@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Name:</div>
            <div class="info-value">{{ $labReport->user->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ is_string($labReport->date) ? \Carbon\Carbon::parse($labReport->date)->format('d M, Y') : $labReport->date->format('d M, Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Phone:</div>
            <div class="info-value">{{ $labReport->user->phone }}</div>
        </div>
        @if($labReport->doctor_id)
        <div class="info-row">
            <div class="info-label">Doctor:</div>
            <div class="info-value">{{ App\Models\User::find($labReport->doctor_id)->name ?? 'N/A' }}</div>
        </div>
        @endif
    </div>
    
    <div class="info-section">
        <h3>Report Details</h3>
        <div class="data-section">
            {!! $labReport->report !!}
        </div>
    </div>
    
    @if(isset($labReport->photo))
    <div class="info-section">
        <h3>Report Attachments</h3>
        <div class="data-section">
            @foreach (json_decode($labReport->photo) as $pic)
                @if(pathinfo($pic, PATHINFO_EXTENSION) == "pdf")
                    <p>PDF Document: {{ basename($pic) }}</p>
                @else
                    <p>Image: {{ basename($pic) }}</p>
                @endif
            @endforeach
        </div>
    </div>
    @endif
@endsection