@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('cvi.index') }}">@lang('Child Vitality Index')</a></li>
                        <li class="breadcrumb-item active">@lang('Child Vitality Index Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Child Vitality Index Info')</h3>
                    @can('cvi-update')
                        <div class="card-tools">
                            <a href="{{ route('cvi.edit', $cvi) }}" class="btn btn-primary">@lang('Edit')</a>
                            <a href="{{ route('cvi.show', $cvi) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ $cvi->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $cvi->patient->name ?? 'N/A' }}</h3>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">@lang('Date')</label>
                                        <p>{{ $cvi->date }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="score">@lang('Score')</label>
                                        <p>{{ $cvi->score }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vitality_score">@lang('Vitality Score')</label>
                                        <p>{{ $cvi->vitality_score }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">@lang('Notes')</label>
                                        <p>{{ $cvi->notes ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">

                        <div class="card-header"><h3 class="card-title">@lang('Child Vitality Index Questions')</h3>
                        </div>
                        <div class="card-body">
                            <div class="question-group">
                                <h5 class="text-primary">@lang('Health & Medical')</h5>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child is acutely malnourished, clinically underweight, or displaying symptoms of significant nutritional deficiency?')</label>
                                    <p>{{ strtoupper($cvi->nutritionalStatus) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child developmentally delayed?')</label>
                                    <p>{{ strtoupper($cvi->developmentallyDelayed) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child living with any chronic or advanced medical conditions?')</label>
                                    <p>{{ strtoupper($cvi->chronicConditions) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child facing any behavioral or mental health ailments?')</label>
                                    <p>{{ strtoupper($cvi->mentalHealth) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child experiencing physical disabilities or mobility difficulties?')</label>
                                    <p>{{ strtoupper($cvi->physicalDisabilities) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child limited in age appropriate communication abilities?')</label>
                                    <p>{{ strtoupper($cvi->communicationAbilities) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child having an incomplete or undocumented vaccine status?')</label>
                                    <p>{{ strtoupper($cvi->vaccineStatus) }}</p>
                                </div>
                            </div>

                            <div class="question-group">
                                <h5 class="text-primary">@lang('Socioeconomic & Living Conditions')</h5>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child subject to any familial instability such as maternal death, parent with mental illness, incarcerated parent or caregiver, single parent, or total orphan under informal community care?')</label>
                                    <p>{{ strtoupper($cvi->familialInstability) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child affected by food or monetary poverty?')</label>
                                    <p>{{ strtoupper($cvi->poverty) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child institutionalized in an orphanage or similar communal care facility?')</label>
                                    <p>{{ strtoupper($cvi->institutionalized) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child housed in an insecure temporary shelter and/or vulnerable to extreme weather or natural disasters?')</label>
                                    <p>{{ strtoupper($cvi->insecureShelter) }}</p>
                                </div>
                            </div>

                            <div class="question-group">
                                <h5 class="text-primary">@lang('Safety & Social Factors')</h5>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child having a history of psychological trauma such as parental death, severe injury, child marriage, FGM, suspected or known rape, or physical abuse?')</label>
                                    <p>{{ strtoupper($cvi->psychologicalTrauma) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child bed-ridden, lacking of adult supervision, or experiencing social isolation?')</label>
                                    <p>{{ strtoupper($cvi->socialIsolation) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child facing any gender, ethnic, religious, medical, or cultural discrimination?')</label>
                                    <p>{{ strtoupper($cvi->discrimination) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child residing in an area of active war, oppression, or conflict?')</label>
                                    <p>{{ strtoupper($cvi->conflictArea) }}</p>
                                </div>
                            </div>

                            <div class="question-group">
                                <h5 class="text-primary">@lang('Environmental & Education')</h5>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child lacking access to healthcare either by restraints of proximity or finance?')</label>
                                    <p>{{ strtoupper($cvi->healthcareAccess) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child dependent on an untreated or insufficient water source?')</label>
                                    <p>{{ strtoupper($cvi->waterSource) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child living without a sanitary toilet or essential hygiene access?')</label>
                                    <p>{{ strtoupper($cvi->sanitation) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child inactive or unenrolled in school?')</label>
                                    <p>{{ strtoupper($cvi->schoolStatus) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Is the child situated in an area of active disease outbreaks affecting region/community?')</label>
                                    <p>{{ strtoupper($cvi->diseaseOutbreaks) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
@endsection
