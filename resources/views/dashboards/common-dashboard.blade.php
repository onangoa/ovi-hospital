@extends('layouts.layout')

@section('one_page_css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css') }}">
@endsection
@section('one_page_js')
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>@lang('Dashboard')</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">@lang('Dashboard')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body p-0">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            "use strict";
            function ini_events(ele) {
                ele.each(function () {
                    var eventObject = {
                        title: $.trim($(this).text())
                    }
                    $(this).data('eventObject', eventObject)
                    $(this).draggable({
                        zIndex        : 1070,
                        revert        : true,
                        revertDuration: 0
                    })
                })
            }
            ini_events($('#external-events div.external-event'))
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;
            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                events: [
                    @if (isset($patientAppointment) && !empty($patientAppointment))
                        @foreach($patientAppointment as $appointment)
                            @php
                                $appointmentDate = $appointment->appointment_date;
                                $startTime = $appointment->start_time;
                                $endTime = $appointment->end_time;

                                $start = $appointmentDate."T".$startTime;
                                $end = $appointmentDate."T".$endTime;
                                
                                // Check if appointment is for a patient or ward
                                if ($appointment->patient) {
                                    $pName = $appointment->patient->name;
                                    $title = 'Patient: ' . $pName;
                                } elseif ($appointment->ward) {
                                    $pName = $appointment->ward->name;
                                    $title = 'Ward: ' . $pName;
                                } else {
                                    $title = 'Unknown Appointment';
                                }
                            @endphp
                            {
                                title : '{{ $title }}',
                                start : '{{ $start }}',
                                end : '{{ $end }}',
                            },
                        @endforeach
                    @endif

                    @if (isset($appointments) && !empty($appointments))
                        @foreach($appointments as $appointment)
                            @php
                                $appointmentDate = $appointment->appointment_date;
                                $startTime = $appointment->start_time;
                                $endTime = $appointment->end_time;

                                $start = $appointmentDate."T".$startTime;
                                $end = $appointmentDate."T".$endTime;
                                
                                // Check if appointment is for a patient or ward
                                if ($appointment->patient) {
                                    $pName = $appointment->patient->name;
                                    $title = 'Patient: ' . $pName;
                                } elseif ($appointment->ward) {
                                    $pName = $appointment->ward->name;
                                    $title = 'Ward: ' . $pName;
                                } else {
                                    $title = 'Unknown Appointment';
                                }
                                
                                // Add doctor name if available
                                if ($appointment->doctor) {
                                    $title .= ' (Dr. ' . $appointment->doctor->name . ')';
                                }
                            @endphp
                            {
                                title : '{{ $title }}',
                                start : '{{ $start }}',
                                end : '{{ $end }}',
                            },
                        @endforeach
                    @endif

                    @if (isset($receptionistAppointments) && !empty($receptionistAppointments))
                        @foreach($receptionistAppointments as $appointment)
                            @php
                                $appointmentDate = $appointment->appointment_date;
                                $startTime = $appointment->start_time;
                                $endTime = $appointment->end_time;

                                $start = $appointmentDate."T".$startTime;
                                $end = $appointmentDate."T".$endTime;
                                
                                // Check if appointment is for a patient or ward
                                if ($appointment->patient) {
                                    $pName = $appointment->patient->name;
                                    $title = 'Patient: ' . $pName;
                                } elseif ($appointment->ward) {
                                    $pName = $appointment->ward->name;
                                    $title = 'Ward: ' . $pName;
                                } else {
                                    $title = 'Unknown Appointment';
                                }
                                
                                // Add doctor name if available
                                if ($appointment->doctor) {
                                    $title .= ' have appointment with Dr. ' . $appointment->doctor->name;
                                }
                            @endphp
                            {
                                title : '{{ $title }}',
                                start : '{{ $start }}',
                                end : '{{ $end }}',
                            },
                        @endforeach
                    @endif

                    @if (isset($doctorAssignments) && !empty($doctorAssignments))
                        @foreach($doctorAssignments as $assignment)
                            @php
                                // Use appointment_date if available, otherwise use appointment_date
                                $appointmentDate = $assignment->appointment_date ?: $assignment->appointment_date;
                                $startTime = $assignment->start_time;
                                $endTime = $assignment->end_time;

                                $start = $appointmentDate."T".$startTime;
                                $end = $appointmentDate."T".$endTime;
                                
                                // Determine assignment type and title
                                if ($assignment->patient) {
                                    $pName = $assignment->patient->name;
                                    $title = 'Patient: ' . $pName;
                                } elseif ($assignment->ward) {
                                    $pName = $assignment->ward->name;
                                    $title = 'Ward: ' . $pName;
                                } else {
                                    $title = 'Assignment';
                                }
                                
                                // Add doctor name if available
                                if ($assignment->doctor) {
                                    $title .= ' (Dr. ' . $assignment->doctor->name . ')';
                                }
                                
                                // Add status if available
                                if ($assignment->status) {
                                    $title .= ' - Status: ' . ucfirst($assignment->status);
                                }
                                
                                // Set color based on status
                                $color = '#007bff'; // Default blue
                                if ($assignment->status === 'completed') {
                                    $color = '#28a745'; // Green
                                } elseif ($assignment->status === 'in_progress') {
                                    $color = '#ffc107'; // Yellow
                                } elseif ($assignment->status === 'cancelled') {
                                    $color = '#dc3545'; // Red
                                }
                            @endphp
                            {
                                title : '{{ $title }}',
                                start : '{{ $start }}',
                                end : '{{ $end }}',
                                color : '{{ $color }}',
                            },
                        @endforeach
                    @endif
                ],
                editable  : true,
                droppable : true,
            });
            calendar.render();
        });
    </script>
@endsection
