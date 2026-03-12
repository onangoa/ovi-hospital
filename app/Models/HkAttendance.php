<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HkAttendance
 * @package App
 * @category model
 */
class HkAttendance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'port_no',
        'protocol',
        'date_time',
        'event_type',
        'event_state',
        'event_description',
        'device_name',
        'major_event_type',
        'sub_event_type',
        'card_type',
        'card_reader_no',
        'door_no',
        'employee_no_string',
        'serial_no',
        'user_type',
        'attendance_status',
        'status_value',
        'pictures_number',
        'pure_pwd_verify_enable',
        'raw_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_time' => 'datetime',
        'raw_data' => 'array',
        'pure_pwd_verify_enable' => 'boolean',
    ];

    /**
     * Scope to filter by employee number
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $employeeNo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByEmployee($query, $employeeNo)
    {
        return $query->where('employee_no_string', $employeeNo);
    }

    /**
     * Scope to filter by date range
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_time', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by device name
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $deviceName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDevice($query, $deviceName)
    {
        return $query->where('device_name', $deviceName);
    }

    /**
     * Get event type description
     *
     * @return string
     */
    public function getEventDescriptionAttribute()
    {
        $eventTypes = [
            22 => 'Door Opened',
            38 => 'Card Authentication',
            39 => 'Fingerprint Authentication',
            40 => 'Face Authentication',
            41 => 'Password Authentication',
        ];

        return $eventTypes[$this->sub_event_type] ?? 'Unknown Event';
    }
}
