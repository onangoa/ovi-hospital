<table>
    <thead>
        <tr>
            <th>Doctor Name</th>
            <th>Patient Name</th>
            <th>Prescription Date</th>
            <th>Chief Complaint</th>
            <th>Medicines</th>
            <th>Diagnosis</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prescriptions as $prescription)
            <tr>
                <td>{{ $prescription->doctor->name }}</td>
                <td>{{ $prescription->user->name }}</td>
                <td>{{ $prescription->prescription_date }}</td>
                <td>{{ $prescription->chief_complaint }}</td>
                <td>
                    @if($prescription->medicine_info)
                        @php
                            $medicines = json_decode($prescription->medicine_info, true);
                            if($medicines && count($medicines) > 0) {
                                foreach($medicines as $medicine) {
                                    echo $medicine['medicine_name'] . ' - ' . $medicine['instruction'] . ' (' . $medicine['day'] . ')' . "\n";
                                }
                            }
                        @endphp
                    @endif
                </td>
                <td>
                    @if($prescription->diagnosis_info)
                        @php
                            $diagnosis = json_decode($prescription->diagnosis_info, true);
                            if($diagnosis && count($diagnosis) > 0) {
                                foreach($diagnosis as $diag) {
                                    echo $diag['diagnosis'] . ' - ' . $diag['diagnosis_instruction'] . "\n";
                                }
                            }
                        @endphp
                    @endif
                </td>
                <td>{{ $prescription->note }}</td>
            </tr>
        @endforeach
    </tbody>
</table>