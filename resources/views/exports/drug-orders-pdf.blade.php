<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Drug Orders Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .items-table {
            margin-top: 10px;
            font-size: 10px;
        }
        .items-table th, .items-table td {
            padding: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $logoPath }}" alt="Company Logo" style="max-height: 60px;">
        </div>
        <h2>Drug Orders Report</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Ordered By</th>
                <th>Total Quantity</th>
                <th>Total Amount</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            @if(count($drugOrders) > 0)
                @foreach($drugOrders as $order)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d M, Y') }}</td>
                        <td>{{ $order->orderedBy->name ?? 'N/A' }}</td>
                        <td>{{ $order->total_quantity }}</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @if($order->items)
                                <table class="items-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Dosage</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(is_array($order->items) ? $order->items : json_decode($order->items, true) as $item)
                                            <tr>
                                                <td>{{ $item['name'] ?? '' }}</td>
                                                <td>{{ $item['dosage'] ?? '' }}</td>
                                                <td>{{ $item['quantity'] ?? '' }}</td>
                                                <td>${{ number_format($item['amount'] ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                No items
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" style="text-align: center;">No drug orders found</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>