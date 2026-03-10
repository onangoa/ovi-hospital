@extends('layouts.layout')

@section('title', __('Edit Vital Sign'))

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Edit Vital Sign') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vital-signs.index') }}">{{ __('Vital Signs Configuration') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit Vital Sign') }}</li>
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
                            <h3 class="card-title">{{ __('Edit Vital Sign') }}: {{ $vitalSign->display_name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vital-signs.update', $vitalSign) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field_name">{{ __('Field Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('field_name') is-invalid @enderror" 
                                                   id="field_name" name="field_name" value="{{ old('field_name', $vitalSign->field_name) }}" 
                                                   placeholder="{{ __('e.g., temperature') }}" required>
                                            @error('field_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">{{ __('Unique identifier for field (no spaces, use underscores)') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="display_name">{{ __('Display Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                                   id="display_name" name="display_name" value="{{ old('display_name', $vitalSign->display_name) }}" 
                                                   placeholder="{{ __('e.g., Temperature') }}" required>
                                            @error('display_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">{{ __('User-friendly name that will be displayed') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field_type">{{ __('Field Type') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('field_type') is-invalid @enderror" 
                                                    id="field_type" name="field_type" required>
                                                <option value="">{{ __('Select Type') }}</option>
                                                <option value="text" {{ old('field_type', $vitalSign->field_type) == 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                                                <option value="number" {{ old('field_type', $vitalSign->field_type) == 'number' ? 'selected' : '' }}>{{ __('Number') }}</option>
                                                <option value="select" {{ old('field_type', $vitalSign->field_type) == 'select' ? 'selected' : '' }}>{{ __('Select/Dropdown') }}</option>
                                            </select>
                                            @error('field_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category">{{ __('Category') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                                   id="category" name="category" value="{{ old('category', $vitalSign->category) }}" 
                                                   placeholder="{{ __('e.g., general, pediatric, laboratory') }}" required>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="unit">{{ __('Unit') }}</label>
                                            <input type="text" class="form-control @error('unit') is-invalid @enderror" 
                                                   id="unit" name="unit" value="{{ old('unit', $vitalSign->unit) }}" 
                                                   placeholder="{{ __('e.g., °C, bpm, mmHg') }}">
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="fieldOptionsRow" style="display: none;">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="field_options">{{ __('Field Options') }}</label>
                                            <textarea class="form-control @error('field_options') is-invalid @enderror" 
                                                      id="field_options" name="field_options" rows="3" 
                                                      placeholder="{{ __('Enter options as key:value pairs, one per line') }}">{{ old('field_options', $vitalSign->field_options ? implode("\n", array_map(function($k, $v) { return "$k:$v"; }, array_keys($vitalSign->field_options), $vitalSign->field_options)) : '') }}</textarea>
                                            <small class="form-text text-muted">{{ __('For select fields, enter options as: value:label (one per line)') }}</small>
                                            @error('field_options')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 ml-2">
                                        <div class="form-group">
                                            <label for="display_order">{{ __('Display Order') }}</label>
                                            <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                                                   id="display_order" name="display_order" value="{{ old('display_order', $vitalSign->display_order) }}" min="0">
                                            @error('display_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="is_required" value="1"
                                                       {{ old('is_required', $vitalSign->is_required) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ __('Required Field') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                                       {{ old('is_active', $vitalSign->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ __('Active') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                    <a href="{{ route('vital-signs.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection

@push('footer')
<script>
$(document).ready(function() {
    function toggleFieldOptions() {
        var fieldType = $('#field_type').val();
        console.log('Field type changed to:', fieldType); // Debug log
        if (fieldType === 'select') {
            $('#fieldOptionsRow').show();
            console.log('Showing field options row'); // Debug log
        } else {
            $('#fieldOptionsRow').hide();
            console.log('Hiding field options row'); // Debug log
        }
    }

    // Initialize on page load
    toggleFieldOptions();
    
    // Handle change event
    $('#field_type').on('change', function() {
        toggleFieldOptions();
    });
});
</script>
@endpush