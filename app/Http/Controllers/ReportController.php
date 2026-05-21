<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Property;
use App\Models\Registration;
use App\Models\Transfer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'properties_by_type'   => Property::select('land_type', DB::raw('count(*) as count, sum(area_sqft) as total_area, sum(market_value) as total_value'))
                ->groupBy('land_type')->get(),
            'registrations_by_month' => Registration::selectRaw("DATE_FORMAT(registration_date,'%Y-%m') as month, count(*) as count, sum(stamp_duty + registration_fee) as revenue")
                ->where('status','approved')
                ->groupBy('month')->orderBy('month')->limit(12)->get(),
            'top_districts'        => Property::select('district', DB::raw('count(*) as count'))
                ->groupBy('district')->orderByDesc('count')->limit(10)->get(),
            'revenue_total'        => Registration::approved()->selectRaw('sum(stamp_duty) as stamp, sum(registration_fee) as fee')->first(),
            'pending_count'        => Registration::pending()->count(),
            'transfers_this_year'  => Transfer::whereYear('transfer_date', now()->year)->count(),
        ];

        return view('reports.index', compact('stats'));
    }

    public function registrations(Request $request)
    {
        $registrations = Registration::with(['property', 'owner'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->year, fn($q) => $q->whereYear('registration_date', $request->year))
            ->latest()->paginate(25);

        return view('reports.registrations', compact('registrations'));
    }

    public function properties(Request $request)
    {
        $properties = Property::with('currentOwner')
            ->when($request->land_type, fn($q) => $q->where('land_type', $request->land_type))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->paginate(25);

        return view('reports.properties', compact('properties'));
    }

    public function owners()
    {
        $owners = Owner::withCount('properties')->paginate(25);
        return view('reports.owners', compact('owners'));
    }

    public function pdf(Request $request, string $type)
    {
        $view = match($type) {
            'registrations' => ['view' => 'reports.pdf.registrations', 'data' => ['registrations' => Registration::with(['property','owner'])->approved()->latest()->get()]],
            'properties'    => ['view' => 'reports.pdf.properties', 'data' => ['properties' => Property::with('currentOwner')->get()]],
            default         => abort(404),
        };

        $pdf = Pdf::loadView($view['view'], $view['data'])->setPaper('A4', 'landscape');
        return $pdf->download("{$type}-report-" . date('Y-m-d') . ".pdf");
    }
}
