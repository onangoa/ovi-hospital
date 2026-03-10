@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('drug-orders-create')
                        <h3><a href="{{ route('drug-orders.create') }}" class="btn btn-outline btn-info">+ Add Drug Order</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Drug Order List</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Drug Order List</h3>
                    <div class="card-tools">
                        @can('drug-orders-create')
                            <!-- <a class="btn btn-primary" target="_blank" href="{{ route('drug-orders.index') }}?export=1"><i class="fas fa-cloud-download-alt"></i> Export</a> -->
                            <a class="btn btn-danger" target="_blank" href="{{ route('drug-orders.index') }}?export_pdf=1"><i class="fas fa-file-pdf"></i> PDF Export</a>
                        @endcan
                        <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i> Filter</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if(request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Conducted by</label>
                                            <input type="text" name="ordered_by_id" class="form-control" value="{{ request()->ordered_by_id }}" placeholder="Conducted By">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" name="date" class="form-control" value="{{ request()->date }}" placeholder="Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('drug-orders.index') }}" class="btn btn-secondary">Clear</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>Conducted By</th>
                                <th>Date</th>
                                <th>Total Quantity</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drugOrders as $drugOrder)
                                <tr>
                                    <td>{{ $drugOrder->orderedBy->name }}</td>
                                    <td>{{ $drugOrder->date->format('d-m-Y') }}</td>
                                    <td>{{ $drugOrder->total_quantity }}</td>
                                    <td>{{ number_format($drugOrder->total_amount, 2) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('drug-orders.show', $drugOrder->id) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="View"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('drug-orders-update')
                                                <a href="{{ route('drug-orders.edit', $drugOrder->id) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="Edit"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('drug-orders-delete')
                                                <a href="#" data-href="{{ route('drug-orders.destroy', $drugOrder->id) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $drugOrders->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
