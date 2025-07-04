<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter data for dropdowns
        $allVehicles = \App\Models\Vehicle::orderBy('name')->get();
        $allUsers = \App\Models\User::orderBy('name')->get();
        $allRegions = \App\Models\Region::orderBy('name')->get();
        $statusList = ['draft','pending','approved','rejected','onuse','finish'];

        // Get filter values
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $vehicleId = $request->vehicle_id;
        $status = $request->status;
        $userId = $request->user_id;
        $regionId = $request->region_id;

        // Build booking query with filters
        $bookingQuery = \App\Models\Booking::query();
        if ($startDate) {
            $bookingQuery->whereDate('start_datetime', '>=', $startDate);
        }
        if ($endDate) {
            $bookingQuery->whereDate('end_datetime', '<=', $endDate);
        }
        if ($vehicleId) {
            $bookingQuery->where('vehicle_id', $vehicleId);
        }
        if ($status) {
            $bookingQuery->where('status', $status);
        }
        if ($userId) {
            $bookingQuery->where('user_id', $userId);
        }
        if ($regionId) {
            $bookingQuery->whereHas('vehicle', function($q) use ($regionId) {
                $q->where('region_id', $regionId);
            });
        }

        // Top 10 Vehicle Usage (filtered)
        $vehicleUsage = \App\Models\Vehicle::withCount(['bookings as bookings_count' => function($q) use ($startDate, $endDate, $status, $userId, $regionId) {
            if ($startDate) $q->whereDate('start_datetime', '>=', $startDate);
            if ($endDate) $q->whereDate('end_datetime', '<=', $endDate);
            if ($status) $q->where('status', $status);
            if ($userId) $q->where('user_id', $userId);
            if ($regionId) $q->whereHas('vehicle', function($q2) use ($regionId) { $q2->where('region_id', $regionId); });
        }])
        ->orderByDesc('bookings_count')
        ->take(10)
        ->get();

        // Bookings per day (filtered, last 14 days or filtered range)
        $bookingsPerDayQuery = clone $bookingQuery;
        if (!$startDate && !$endDate) {
            $bookingsPerDayQuery->where('start_datetime', '>=', now()->subDays(13)->startOfDay());
        }
        $bookingsPerDay = $bookingsPerDayQuery
            ->selectRaw('DATE(start_datetime) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('pages.dashboard.index', compact(
            'vehicleUsage', 'bookingsPerDay',
            'allVehicles', 'allUsers', 'allRegions', 'statusList'
        ));
    }
} 