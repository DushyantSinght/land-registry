<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Property;
use App\Models\Registration;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_properties'    => Property::count(),
            'registered'          => Property::where('status', 'registered')->count(),
            'available'           => Property::where('status', 'available')->count(),
            'disputed'            => Property::where('has_disputes', true)->count(),
            'total_owners'        => Owner::count(),
            'pending_registrations' => Registration::pending()->count(),
            'approved_registrations' => Registration::approved()->count(),
            'total_transfers'     => Transfer::count(),
        ];

        // Revenue stats
        $revenue = Registration::approved()
            ->selectRaw('SUM(stamp_duty) as total_stamp, SUM(registration_fee) as total_reg_fee')
            ->first();

        $stats['total_stamp_duty']   = $revenue->total_stamp ?? 0;
        $stats['total_reg_fee']      = $revenue->total_reg_fee ?? 0;

        // Land type breakdown
        $landTypes = Property::select('land_type', DB::raw('count(*) as count'))
            ->groupBy('land_type')
            ->pluck('count', 'land_type');

        // Monthly registrations (last 6 months)
        $monthlyRegs = Registration::selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, DATE_FORMAT(created_at, '%Y-%m') as month_sort, count(*) as count")
    ->where('created_at', '>=', now()->subMonths(6))
    ->groupBy('month', 'month_sort')
    ->orderBy('month_sort')
    ->pluck('count', 'month');

        // Recent activities
        $recentRegistrations = Registration::with(['property', 'owner'])
            ->latest()->limit(5)->get();

        $recentTransfers = Transfer::with(['property', 'fromOwner', 'toOwner'])
            ->latest()->limit(5)->get();

        $pendingRegistrations = Registration::with(['property', 'owner'])
            ->pending()->latest()->limit(10)->get();

        return view('dashboard.index', compact(
            'stats', 'landTypes', 'monthlyRegs',
            'recentRegistrations', 'recentTransfers', 'pendingRegistrations'
        ));
    }
}
