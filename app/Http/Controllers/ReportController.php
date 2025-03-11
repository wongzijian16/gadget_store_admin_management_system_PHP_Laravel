<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ReportController extends Controller {

    public function displayAdminLoginReport(Request $request) {
        try {
            // Validate the incoming year and month from the request
            $request->validate([
                'year' => 'required|integer',
                'month' => 'required|integer|min:1|max:12',
            ]);

            $year = $request->year;
            $month = $request->month;

            // Fetch unique days admin logged in for the specified month and year
            $attendanceRecords = Log::join('users', 'logs.userId', '=', 'users.userId')
            ->where('logs.userType', 'admin')
            ->whereYear('logs.created_at', $year)
            ->whereMonth('logs.created_at', $month)
            ->select('users.username', 'logs.userId', DB::raw('COUNT(DISTINCT DATE(logs.created_at)) as attendance_count'))
            ->groupBy('logs.userId', 'users.username')
            ->get();

            return response()->json([
                        'year' => $year,
                        'month' => $month,
                        'attendance' => $attendanceRecords,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching attendance report: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching the report.'], 500);
        }
    }

}
