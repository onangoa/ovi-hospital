<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Shift::with('users');
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->inactive();
            }
        }
        
        // Search by name if provided
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $shifts = $query->orderBy('name')->paginate(20);
        
        return view('shifts.index', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        Shift::create([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_active' => $request->has('is_active') ? true : false,
            'description' => $request->description,
        ]);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        return view('shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $shift = Shift::findOrFail($id);
        $shift->update([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_active' => $request->has('is_active') ? true : false,
            'description' => $request->description,
        ]);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);

        // Check if shift can be deleted
        if (!$shift->canBeDeleted()) {
            return redirect()->route('shifts.index')
                ->with('error', $shift->getCannotDeleteReason());
        }

        $shift->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'Shift deleted successfully.');
    }

    /**
     * Format duration in minutes to hours and minutes format
     *
     * @param  int  $minutes
     * @return string
     */
    private function formatDuration($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        if ($hours > 0 && $mins > 0) {
            return $hours . 'h ' . $mins . 'm';
        } elseif ($hours > 0) {
            return $hours . 'h';
        } else {
            return $mins . 'm';
        }
    }

    /**
     * Show attendance analysis for a specific shift.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attendance(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);
        
        // Get all users assigned to this shift via pivot table (for accurate counts)
        $allUsersQuery = User::whereHas('shifts', function($query) use ($id) {
            $query->where('shifts.id', $id);
        });
        $allUsers = $allUsersQuery->get();
        
        // Filter by date if provided
        $date = $request->has('date') && $request->date
            ? $request->date
            : now()->format('Y-m-d');
        
        // Get paginated users for display
        $query = User::whereHas('shifts', function($query) use ($id) {
            $query->where('shifts.id', $id);
        });
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status) {
            // We'll need to calculate attendance status first to filter
            // For now, get all users and filter after calculation
        }
        
        $users = $query->paginate(20);
        
        // Get all attendance records for the specified date and all users in this shift
        $allAttendances = \App\Models\HkAttendance::whereDate('date_time', $date)
            ->whereIn('employee_no_string', $allUsers->pluck('external_id')->filter())
            ->orderBy('date_time')
            ->get();
        
        // Group attendance records by employee_no_string
        $attendancesByEmployee = $allAttendances->groupBy('employee_no_string');
        
        // Process attendance data for each user (using all users for accurate counts)
        $userAttendanceData = [];
        $presentCount = 0;
        $lateCount = 0;
        $absentCount = 0;
        
        foreach ($allUsers as $user) {
            $employeeAttendances = $attendancesByEmployee->get($user->external_id, collect());
            
            if ($employeeAttendances->isEmpty()) {
                // User has no attendance records
                $userAttendanceData[$user->id] = [
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 'absent',
                    'late_by' => null,
                    'overtime' => null,
                ];
                $absentCount++;
            } else {
                // Get first record as check-in
                $checkIn = $employeeAttendances->first();
                $checkOut = null;
                $checkOutTime = null;
                
                // Only set check-out if there are multiple attendance records
                if ($employeeAttendances->count() > 1) {
                    $checkOut = $employeeAttendances->last();
                    $checkOutTime = \Carbon\Carbon::parse($checkOut->date_time);
                }
                
                // Parse attendance times with full datetime
                $checkInTime = \Carbon\Carbon::parse($checkIn->date_time);
                
                // Create shift times on the attendance date
                $shiftStartTime = \Carbon\Carbon::parse($date . ' ' . $shift->start_time->format('H:i:s'));
                $shiftEndTime = \Carbon\Carbon::parse($date . ' ' . $shift->end_time->format('H:i:s'));
                
                // Handle shifts that span midnight (end time is before start time)
                if ($shiftEndTime->lt($shiftStartTime)) {
                    $shiftEndTime->addDay();
                }
                
                $status = 'on_time';
                $lateBy = null;
                $overtime = null;
                
                // Check if late (more than 15 minutes after shift start)
                if ($checkInTime->gt($shiftStartTime->copy()->addMinutes(15))) {
                    $status = 'late';
                    $lateMinutes = $shiftStartTime->copy()->addMinutes(15)->diffInMinutes($checkInTime);
                    $lateBy = $this->formatDuration($lateMinutes);
                    $lateCount++;
                } else {
                    $presentCount++;
                }
                
                // Check for overtime (only if check-out time exists)
                if ($checkOutTime && $checkOutTime->gt($shiftEndTime)) {
                    $overtimeMinutes = $shiftEndTime->diffInMinutes($checkOutTime);
                    $overtime = $this->formatDuration($overtimeMinutes);
                    if ($status === 'on_time') {
                        $status = 'overtime';
                    }
                }
                
                $userAttendanceData[$user->id] = [
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                    'late_by' => $lateBy,
                    'overtime' => $overtime,
                ];
            }
        }
        
        // Apply status filter to paginated users if provided
        if ($request->has('status') && $request->status) {
            $filteredUsers = collect();
            foreach ($users as $user) {
                $attendanceData = $userAttendanceData[$user->id] ?? null;
                if ($attendanceData && $attendanceData['status'] === $request->status) {
                    $filteredUsers->push($user);
                }
            }
            // Create a new paginator with filtered users
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                $filteredUsers,
                $users->total(),
                $users->perPage(),
                $users->currentPage(),
                ['path' => \Illuminate\Support\Facades\Request::url(), 'query' => $request->query()]
            );
        }
        
        return view('shifts.attendance', compact('shift', 'users', 'userAttendanceData', 'presentCount', 'lateCount', 'absentCount'));
    }
}
