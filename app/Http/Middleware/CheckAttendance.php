<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAttendance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Only check for authenticated users
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Skip check for Super Admin
        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        // Only check for POST, PUT, PATCH, DELETE requests (form submissions)
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $next($request);
        }

        // Check if user has attendance for today
        $hasAttendance = \App\Models\HkAttendance::hasAttendanceForDay($user->external_id);

        if (!$hasAttendance) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have attendance recorded for today. Please contact your administrator.'
                ], 403);
            }

            return redirect()->back()
                ->with('error', 'You do not have attendance recorded for today. Please contact your administrator.')
                ->withInput();
        }

        return $next($request);
    }
}
