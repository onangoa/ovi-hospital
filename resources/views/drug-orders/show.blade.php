@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><a href="{{ route('drug-orders.index') }}" class="btn btn-outline btn-info">
                        <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('drug-orders.index') }}">@lang('Drug Order List')</a></li>
                        <li class="breadcrumb-item active">@lang('Show Drug Order')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Show Drug Order')</h4>
                    <div class="card-tools">
                        <a href="{{ route('drug-orders.show', $drugOrder) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Conducted By')</label>
                                <p>{{ $drugOrder->orderedBy->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Date')</label>
                                <p>{{ date($companySettings->date_format, strtotime($drugOrder->date)) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Items')</label>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('Name of drug ordered')</th>
                                            <th>@lang('Dosage')</th>
                                            <th>@lang('Quantity Required')</th>
                                            <th>@lang('Amount of each drug ordered')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($drugOrder->items as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ $item['dosage'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>{{ $item['amount'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Total Quantity')</label>
                                <p>{{ $drugOrder->total_quantity }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Total Amount')</label>
                                <p>{{ $drugOrder->total_amount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
