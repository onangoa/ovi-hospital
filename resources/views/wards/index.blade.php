@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('ward-create')
                        <h3><a href="{{ route('wards.create') }}" class="btn btn-outline btn-info">+ @lang('Add Ward')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Ward List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">@lang('Ward List')</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Ward Name')</th>
                                <th>@lang('Capacity')</th>
                                <th>@lang('Status')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wards as $ward)
                                <tr>
                                    <td>{{ $ward->name }}</td>
                                    <td>{{ $ward->capacity }}</td>
                                    <td>
                                        @if($ward->status == 'active')
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('wards.show', $ward) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('ward-update')
                                                <a href="{{ route('wards.edit', $ward) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('patient-detail-read')
                                                <a href="{{ route('wards.show', ['ward' => $ward, 'assign_patient' => 1]) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Assign Patients')"><i class="fa fa-user-plus"></i></a>
                                            @endcan
                                            @can('ward-delete')
                                                <a href="#" data-href="{{ route('wards.destroy', $ward) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $wards->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
