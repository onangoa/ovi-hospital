<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Ordered By</th>
            <th>Items</th>
            <th>Total Quantity</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($drugOrders as $order)
            <tr>
                <td>{{ $order->date }}</td>
                <td>{{ $order->orderedBy->name }}</td>
                <td>
                    @if($order->items)
                        @php
                            $items = json_decode($order->items, true);
                            if($items && count($items) > 0) {
                                foreach($items as $item) {
                                    echo $item['name'] . ' - Qty: ' . $item['quantity'] . ' - Price: ' . $item['price'] . "\n";
                                }
                            }
                        @endphp
                    @endif
                </td>
                <td>{{ $order->total_quantity }}</td>
                <td>{{ $order->total_amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>