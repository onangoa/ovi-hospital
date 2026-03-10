<table>
    <thead>
        <tr>
            <th>Report Date</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Report</th>
        </tr>
    </thead>
    <tbody>
        @foreach($labReports as $labReport)
            <tr>
                <td>{{ $labReport->date }}</td>
                <td>{{ $labReport->user->name }}</td>
                <td>{{ $labReport->user->age ?? '-' }}</td>
                <td>{{ $labReport->user->gender ?? '-' }}</td>
                <td>{{ $labReport->user->address ?? '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit(strip_tags($labReport->report), 200) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>