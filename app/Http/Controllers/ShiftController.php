<?php

namespace App\Http\Controllers;

use App\Models\Shift;
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
        $query = Shift::query();
        
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
        $shift->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'Shift deleted successfully.');
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
        
        // Get users assigned to this shift
        $query = User::where('shift_id', $id);
        
        // Filter by date if provided
        $date = $request->has('date') && $request->date 
            ? $request->date 
            : now()->format('Y-m-d');
        
        $users = $query->paginate(20);
        
        // Get attendance records for the specified date
        $attendances = \App\Models\HkAttendance::whereDate('date_time', $date)
            ->whereIn('employee_no_string', $users->pluck('external_id')->filter())
            ->get()
            ->keyBy('employee_no_string');
        
        // Calculate statistics
        $presentCount = 0;
        $lateCount = 0;
        $absentCount = 0;
        
        foreach ($users as $user) {
            $attendance = $attendances->get($user->external_id);
            
            if (!$attendance) {
                $absentCount++;
            } else {
                $presentCount++;
                $shiftStartTime = \Carbon\Carbon::parse($shift->start_time);
                $checkIn = \Carbon\Carbon::parse($attendance->date_time);
                
                // Check if late (more than 15 minutes after shift start)
                if ($checkIn->gt($shiftStartTime->addMinutes(15))) {
                    $lateCount++;
                }
            }
        }
        
        return view('shifts.attendance', compact('shift', 'users', 'attendances', 'presentCount', 'lateCount', 'absentCount'));
    }
}
