<table>
    <thead>
        <tr>
            <th>Patient Name</th>
            <th>Provider Name</th>
            <th>Examination Type</th>
            <th>Examination Details</th>
            <th>Relevant Clinical Information</th>
            <th>Reason for Investigation</th>
        </tr>
    </thead>
    <tbody>
        @foreach($radiologyRequests as $request)
            <tr>
                <td>{{ $request->patient->name }}</td>
                <td>{{ $request->provider->name }}</td>
                <td>
                    @if($request->examination_type)
                        @php
                            $examTypes = $request->examination_type;
                            if($examTypes && count($examTypes) > 0) {
                                foreach($examTypes as $type) {
                                    if(is_array($type)) {
                                        echo (isset($type['name']) ? $type['name'] : json_encode($type)) . "\n";
                                    } else {
                                        echo $type . "\n";
                                    }
                                }
                            }
                        @endphp
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($request->examination_details, 200) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($request->relevant_clinical_information, 200) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($request->reason_for_investigation, 200) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>