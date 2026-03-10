<?php

namespace App\Mail;

use App\Models\DoctorAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAppointment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * new appointment.
     *
     * @var App\Models\DoctorAssignment
     */
    protected $patientAppointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DoctorAssignment $doctorAssignment)
    {
        $this->patientAppointment = $doctorAssignment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment booked successfully')
            ->markdown('emails.appointments.newappointment', [
                'patientAppointment' => $this->patientAppointment
            ]);
    }
}
