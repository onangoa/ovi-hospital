<?php

namespace App\Http\Controllers;

use App\Models\HkAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = HkAttendance::with('user');
        
        // Filter by employee number if provided
        if ($request->has('employee_no') && $request->employee_no) {
            $query->byEmployee($request->employee_no);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->start_date) {
            $endDate = $request->has('end_date') && $request->end_date 
                ? $request->end_date 
                : $request->start_date;
            $query->byDateRange($request->start_date, $endDate);
        }
        
        // Filter by device name if provided
        if ($request->has('device_name') && $request->device_name) {
            $query->byDevice($request->device_name);
        }
        
        // Filter by event type if provided
        if ($request->has('event_type') && $request->event_type) {
            $query->where('sub_event_type', $request->event_type);
        }
        
        $attendances = $query->orderBy('date_time', 'desc')
                            ->paginate(20);
        
        // Get unique device names for filter dropdown
        $deviceNames = HkAttendance::distinct()
                            ->whereNotNull('device_name')
                            ->pluck('device_name')
                            ->sort()
                            ->values();
        
        // Get unique employee numbers for filter dropdown
        $employeeNumbers = HkAttendance::distinct()
                            ->whereNotNull('employee_no_string')
                            ->pluck('employee_no_string')
                            ->sort()
                            ->values();
        
        // Event types for filter dropdown
        $eventTypes = [
            22 => 'Door Opened',
            38 => 'Fingerprint Authentication',
            39 => 'Card Authentication',
            40 => 'Face Authentication',
            41 => 'Password Authentication',
        ];
        
        return view('attendance.index', compact('attendances', 'deviceNames', 'employeeNumbers', 'eventTypes'));
    }
}
