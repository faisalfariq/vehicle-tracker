<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Example: Get total bookings per vehicle (top 10)
        $vehicleUsage = Vehicle::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(10)
            ->get();

        // Example: Get bookings per day for the last 14 days
        $bookingsPerDay = Booking::selectRaw('DATE(start_datetime) as date, COUNT(*) as total')
            ->where('start_datetime', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('pages.dashboard.index', compact('vehicleUsage', 'bookingsPerDay'));
    }
} 