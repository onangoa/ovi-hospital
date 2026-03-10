@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('doctor-details.index') }}">@lang('Doctor')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Doctor Info')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Doctor Info')</h3>
                <div class="card-tools">
                    <a href="{{ route('doctor-details.show', $doctorDetail) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                    </a>
                    @can('doctor-detail-update')
                        <a href="{{ route('doctor-details.edit', $doctorDetail) }}" class="btn btn-primary">@lang('Edit')</a>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ $doctorDetail->user->photo_url }}" alt="" />
                        <h3 class="profile-username text-center">{{ $doctorDetail->user->name }}</h3>
                        <p class="text-muted text-center">{{ $doctorDetail->specialist }}</p>
                    </div>

                    <div class="col-md-9">
                        {{-- Row 1 --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">@lang('Name')</label>
                                    <p>{{ $doctorDetail->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">@lang('Email')</label>
                                    <p>{{ $doctorDetail->user->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">@lang('Phone')</label>
                                    <p>{{ $doctorDetail->user->phone }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Row 2 --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">@lang('Address')</label>
                                    <p>{{ $doctorDetail->user->address }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="specialist">@lang('Specialist')</label>
                                    <p>{{ $doctorDetail->specialist }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="designation">@lang('Designation')</label>
                                    <p>{{ $doctorDetail->designation }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Row 3 --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">@lang('Gender')</label>
                                    <p>{{ ucfirst($doctorDetail->user->gender) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="blood_group">@lang('Blood Group')</label>
                                    <p>{{ $doctorDetail->user->blood_group }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_of_birth">@lang('Date of Birth')</label>
                                    <p>{{ $doctorDetail->user->date_of_birth }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Row 4 --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="gender">@lang('Biography')</label>
                                    <p>{!! $doctorDetail->biography !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hospital_department_id">@lang('Department')</label>
                                    <p>{{ $doctorDetail->hospitalDepartment->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">@lang('Status')</label>
                                    <p>
                                        @if($doctorDetail->user->status == 1)
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </p>
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
