@extends('exports.base-single-pdf')

@php
    $title = 'Drug Order';
@endphp

@section('content')
    <style>
        
        .order-details {
            flex: 1;
        }
        
        .drug-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .drug-table th, .drug-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .drug-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
    </style>
    
    <div class="order-info">
        
        <div class="order-details">
            <div class="info-section">
                <h3>Basic Information</h3>
                <div class="info-row">
                    <div class="info-label">Patient Name:</div>
                    <div class="info-value">{{ $drugOrder->user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Order Date:</div>
                    <div class="info-value">{{ optional($drugOrder->date)->format('Y-m-d') ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Conducted By:</div>
                    <div class="info-value">{{ $drugOrder->orderedBy->name ?? 'N/A' }}</div>
                </div>
            </div>
            
            
            <div class="info-section">
                <h3>Drugs Ordered</h3>
                <div class="drug-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Drug Name</th>
                                <th>Dosage</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drugOrder->items as $item)
                                <tr>
                                    <td>{{ $item['name'] ?? 'N/A' }}</td>
                                    <td>{{ $item['dosage'] ?? 'N/A' }}</td>
                                    <td>{{ $item['quantity'] ?? 'N/A' }}</td>
                                    <td>{{ $item['amount'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
    
@endsection