@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>@lang('Edit Ward')</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('wards.index') }}">@lang('Ward List')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Ward')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Edit Ward')</h3>
                </div>
                <div class="card-body">
                    <form class="form-material" method="POST" action="{{ route('wards.update', $ward) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">@lang('Ward Name') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $ward->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description', $ward->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="capacity">@lang('Capacity')</label>
                            <input type="number" class="form-control" name="capacity" value="{{ old('capacity', $ward->capacity) }}" min="0">
                            @error('capacity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">@lang('Status') <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="active" {{ old('status', $ward->status) == 'active' ? 'selected' : '' }}>@lang('Active')</option>
                                <option value="inactive" {{ old('status', $ward->status) == 'inactive' ? 'selected' : '' }}>@lang('Inactive')</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                            <a href="{{ route('wards.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

