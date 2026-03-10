@extends('exports.base-single-pdf')

@php
    $title = 'Child Vitality Index Report - ' . ($cvi->patient->name ?? 'Unknown Patient');
@endphp

@section('content')
    <div class="info-section">
        <h3>Patient Information</h3>
        <div class="info-row">
            <div class="info-label">Patient Name:</div>
            <div class="info-value">{{ $cvi->patient->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value">{{ is_string($cvi->date) ? \Carbon\Carbon::parse($cvi->date)->format('d M, Y') : $cvi->date->format('d M, Y') }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>CVI Score Information</h3>
        <div class="info-row">
            <div class="info-label">CVI Score:</div>
            <div class="info-value">{{ $cvi->score ?? 'N/A' }} - {{ $cvi->vitality_score ?? 'N/A' }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Health Factors</h3>
        <div class="question-item">
            <div class="question-label">Is the child acutely malnourished, clinically underweight, or displaying symptoms of significant nutritional deficiency?</div>
            <div class="info-value">{{ strtoupper($cvi->nutritionalStatus ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child developmentally delayed?</div>
            <div class="info-value">{{ strtoupper($cvi->developmentallyDelayed ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child living with any chronic or advanced medical conditions?</div>
            <div class="info-value">{{ strtoupper($cvi->chronicConditions ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child facing any behavioral or mental health ailments?</div>
            <div class="info-value">{{ strtoupper($cvi->mentalHealth ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child experiencing physical disabilities or mobility difficulties?</div>
            <div class="info-value">{{ strtoupper($cvi->physicalDisabilities ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child limited in age appropriate communication abilities?</div>
            <div class="info-value">{{ strtoupper($cvi->communicationAbilities ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child having an incomplete or undocumented vaccine status?</div>
            <div class="info-value">{{ strtoupper($cvi->vaccineStatus ?? 'N/A') }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Social Factors</h3>
        <div class="question-item">
            <div class="question-label">Is the child subject to any familial instability such as maternal death, parent with mental illness, incarcerated parent or caregiver, single parent, or total orphan under informal community care?</div>
            <div class="info-value">{{ strtoupper($cvi->familialInstability ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child affected by food or monetary poverty?</div>
            <div class="info-value">{{ strtoupper($cvi->poverty ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child institutionalized in an orphanage or similar communal care facility?</div>
            <div class="info-value">{{ strtoupper($cvi->institutionalized ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child housed in an insecure temporary shelter and/or vulnerable to extreme weather or natural disasters?</div>
            <div class="info-value">{{ strtoupper($cvi->insecureShelter ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child having a history of psychological trauma such as parental death, severe injury, child marriage, FGM, suspected or known rape, or physical abuse?</div>
            <div class="info-value">{{ strtoupper($cvi->psychologicalTrauma ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child bed-ridden, lacking of adult supervision, or experiencing social isolation?</div>
            <div class="info-value">{{ strtoupper($cvi->socialIsolation ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child facing any gender, ethnic, religious, medical, or cultural discrimination?</div>
            <div class="info-value">{{ strtoupper($cvi->discrimination ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child residing in an area of active war, oppression, or conflict?</div>
            <div class="info-value">{{ strtoupper($cvi->conflictArea ?? 'N/A') }}</div>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Environmental Factors</h3>
        <div class="question-item">
            <div class="question-label">Is the child lacking access to healthcare either by restraints of proximity or finance?</div>
            <div class="info-value">{{ strtoupper($cvi->healthcareAccess ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child dependent on an untreated or insufficient water source?</div>
            <div class="info-value">{{ strtoupper($cvi->waterSource ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child living without a sanitary toilet or essential hygiene access?</div>
            <div class="info-value">{{ strtoupper($cvi->sanitation ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child inactive or unenrolled in school?</div>
            <div class="info-value">{{ strtoupper($cvi->schoolStatus ?? 'N/A') }}</div>
        </div>
        <div class="question-item">
            <div class="question-label">Is the child situated in an area of active disease outbreaks affecting region/community?</div>
            <div class="info-value">{{ strtoupper($cvi->diseaseOutbreaks ?? 'N/A') }}</div>
        </div>
    </div>
    
    @if($cvi->notes)
    <div class="info-section">
        <h3>Additional Notes</h3>
        <div class="data-section">
            {{ $cvi->notes }}
        </div>
    </div>
    @endif
@endsection