<table>
    <thead>
        <tr>
            <th>Request Date</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Resident</th>
            <th>Specimen</th>
            <th>Blood Bank</th>
            <th>Histology</th>
            <th>Serology</th>
            <th>Haematology</th>
            <th>Bacteriology</th>
            <th>Parasitology</th>
            <th>Biochemistry</th>
            <th>Other Destination</th>
            <th>Investigation Requested</th>
            <th>Differential Diagnosis</th>
            <th>Clinician Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach($labRequests as $labRequest)
            <tr>
                <td>{{ $labRequest->request_date }}</td>
                <td>{{ $labRequest->patient->name }}</td>
                <td>{{ $labRequest->age }}</td>
                <td>{{ $labRequest->sex }}</td>
                <td>{{ $labRequest->resident }}</td>
                <td>{{ $labRequest->specimen }}</td>
                <td>{{ $labRequest->blood_bank ? 'Yes' : 'No' }}</td>
                <td>{{ $labRequest->histology ? 'Yes' : 'No' }}</td>
                <td>{{ $labRequest->serology ? 'Yes' : 'No' }}</td>
                <td>{{ $labRequest->haematology ? 'Yes' : 'No' }}</td>
                <td>{{ $labRequest->bacteriology ? 'Yes' : 'No' }}</td>
                <td>{{ $labRequest->parasitology ? 'Yes' : 'No' }}</td>
                <td>{{ $labRequest->biochemistry ? 'Yes' : 'No' }}</td>
                <td>{{ $labRequest->other_destination }}</td>
                <td>{{ \Illuminate\Support\Str::limit($labRequest->investigation_requested, 200) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($labRequest->differential_diagnosis, 200) }}</td>
                <td>{{ $labRequest->clinician_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>