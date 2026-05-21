@extends('layouts.app')
@section('title', 'Reports & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Reports & Analytics</h5>
        <p class="text-muted mb-0 small">Land registry statistics and insights</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('reports.pdf', 'registrations') }}" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i>Registrations PDF
        </a>
        <a href="{{ route('reports.pdf', 'properties') }}" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i>Properties PDF
        </a>
    </div>
</div>

<!-- Revenue Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center border-primary">
            <div class="text-primary small fw-600 mb-1">Total Stamp Duty</div>
            <div class="fw-700 fs-4">₹{{ number_format($stats['revenue_total']->stamp ?? 0) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center border-success">
            <div class="text-success small fw-600 mb-1">Total Registration Fees</div>
            <div class="fw-700 fs-4">₹{{ number_format($stats['revenue_total']->fee ?? 0) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center border-warning">
            <div class="text-warning small fw-600 mb-1">Pending Registrations</div>
            <div class="fw-700 fs-4">{{ $stats['pending_count'] }}</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Properties by type -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-table me-2 text-primary"></i>Properties by Land Type</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Land Type</th><th>Count</th><th>Total Area (Sq.ft)</th><th>Total Market Value</th></tr>
                    </thead>
                    <tbody>
                    @foreach($stats['properties_by_type'] as $row)
                        <tr>
                            <td>{{ ucfirst($row->land_type) }}</td>
                            <td><span class="badge bg-primary">{{ $row->count }}</span></td>
                            <td>{{ number_format($row->total_area, 0) }}</td>
                            <td class="fw-500">₹{{ number_format($row->total_value, 0) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top districts -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-bar-chart me-2 text-primary"></i>Properties by District</div>
            <div class="card-body">
                <canvas id="districtChart" style="max-height:220px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Revenue Chart -->
<div class="card mb-4">
    <div class="card-header"><i class="bi bi-graph-up me-2 text-primary"></i>Monthly Registration Revenue (Last 12 Months)</div>
    <div class="card-body">
        <canvas id="revenueChart" style="max-height:250px;"></canvas>
    </div>
</div>

<!-- Navigation to detailed reports -->
<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-3">
            <div class="fw-600 mb-1"><i class="bi bi-file-earmark-text text-primary me-2"></i>Registrations Report</div>
            <p class="text-muted small mb-2">Detailed list of all registration records with status and fees.</p>
            <a href="{{ route('reports.registrations') }}" class="btn btn-sm btn-outline-primary">View Report</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="fw-600 mb-1"><i class="bi bi-map text-primary me-2"></i>Properties Report</div>
            <p class="text-muted small mb-2">All land parcels with type, area, value, and owner details.</p>
            <a href="{{ route('reports.properties') }}" class="btn btn-sm btn-outline-primary">View Report</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="fw-600 mb-1"><i class="bi bi-people text-primary me-2"></i>Owners Report</div>
            <p class="text-muted small mb-2">All registered land owners with property count details.</p>
            <a href="{{ route('reports.owners') }}" class="btn btn-sm btn-outline-primary">View Report</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// District bar chart
const dCtx = document.getElementById('districtChart').getContext('2d');
new Chart(dCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($stats['top_districts']->pluck('district')) !!},
        datasets: [{
            label: 'Properties',
            data: {!! json_encode($stats['top_districts']->pluck('count')) !!},
            backgroundColor: 'rgba(59,130,246,.7)',
            borderRadius: 4,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

// Revenue line chart
const rCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(rCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($stats['registrations_by_month']->pluck('month')) !!},
        datasets: [{
            label: 'Revenue (₹)',
            data: {!! json_encode($stats['registrations_by_month']->pluck('revenue')) !!},
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => '₹' + (v/1000).toFixed(0) + 'K' } } }
    }
});
</script>
@endpush
