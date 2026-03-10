<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>Nurse on Duty</th>
            <th>Brief Report</th>
            <th>Duty End Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($nursingCardexes as $cardex)
            <tr>
                <td>{{ $cardex->date }}</td>
                <td>{{ $cardex->patient->name }}</td>
                <td>{{ $cardex->nurseOnDuty->name ?? $cardex->nurse_on_duty_name }}</td>
                <td>{{ \Illuminate\Support\Str::limit($cardex->brief_report, 200) }}</td>
                <td>{{ $cardex->duty_end_time }}</td>
            </tr>
        @endforeach
    </tbody>
</table>