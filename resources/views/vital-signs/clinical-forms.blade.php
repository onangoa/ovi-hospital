@extends('layouts.layout')

@section('title', __('Clinical Forms Configuration'))

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Clinical Forms Configuration') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vital-signs.index') }}">{{ __('Vital Signs Configuration') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Clinical Forms') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Clinical Forms Management') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('vital-signs.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to Vital Signs') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Form Name') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Vital Signs Count') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($clinicalForms as $form)
                                            <tr>
                                                <td>
                                                    <strong>{{ $form->form_display_name }}</strong>
                                                    <br>
                                                    <small class="text-muted"><code>{{ $form->form_name }}</code></small>
                                                </td>
                                                <td>{{ $form->description ?? '-' }}</td>
                                                <td>
                                                    @if($form->is_active)
                                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $form->vitalSigns->count() }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('vital-signs.configure-form', $form) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-cog"></i> {{ __('Configure') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">{{ __('No clinical forms found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection