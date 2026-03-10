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
                        <li class="breadcrumb-item active">@lang('Edit Drug Order')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Edit Drug Order')</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('drug-orders.update', $drugOrder) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ordered_by_id">@lang('Conducted By')</label>
                                    <select name="ordered_by_id" id="ordered_by_id" class="form-control @error('ordered_by_id') is-invalid @enderror">
                                        <option value="">@lang('Select User')</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if($drugOrder->ordered_by_id == $user->id) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('ordered_by_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">@lang('Date')</label>
                                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d', strtotime($drugOrder->date))) }}" readonly>

                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Items')</label>
                                    <table class="table table-bordered" id="items_table">
                                        <thead>
                                            <tr>
                                                <th>@lang('Name of drug ordered')</th>
                                                <th>@lang('Dosage')</th>
                                                <th>@lang('Quantity Required')</th>
                                                <th>@lang('Amount of each drug ordered')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drugOrder->items as $key => $item)
                                                <tr>
                                                    <td><input type="text" name="items[{{ $key }}][name]" class="form-control" value="{{ $item['name'] }}" /></td>
                                                    <td><input type="text" name="items[{{ $key }}][dosage]" class="form-control" value="{{ $item['dosage'] }}" /></td>
                                                    <td><input type="number" name="items[{{ $key }}][quantity]" class="form-control item-quantity" value="{{ $item['quantity'] }}" /></td>
                                                    <td><input type="number" name="items[{{ $key }}][amount]" class="form-control item-amount" value="{{ $item['amount'] }}" /></td>
                                                    <td><button type="button" class="btn btn-danger remove-tr">-</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" id="add_row" class="btn btn-primary">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_quantity">@lang('Total Quantity')</label>
                                    <input type="number" name="total_quantity" id="total_quantity" class="form-control @error('total_quantity') is-invalid @enderror" value="{{ old('total_quantity', $drugOrder->total_quantity) }}" readonly>
                                    @error('total_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_amount">@lang('Total Amount')</label>
                                    <input type="number" name="total_amount" id="total_amount" class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount', $drugOrder->total_amount) }}" readonly>
                                    @error('total_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                <a href="{{ route('drug-orders.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer')
    <script src="{{ asset('assets/js/custom/drug-order.js') }}"></script>
@endpush

