{{-- resources/views/reports/properties.blade.php --}}
@extends('layouts.app')
@section('title', 'Properties Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">Properties Report</h5>
            <small class="text-muted">All land parcels on record</small>
        </div>
    </div>
    <a href="{{ route('reports.pdf', 'properties') }}" class="btn btn-sm btn-danger">
        <i class="bi bi-file-pdf me-1"></i>Export PDF
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <select name="land_type" class="form-select form-select-sm">
                    <option value="">All Land Types</option>
                    @foreach(['agricultural','residential','commercial','industrial','forest','government','other'] as $t)
                        <option value="{{ $t }}" {{ request('land_type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    @foreach(['available','registered','disputed','mortgaged','government_acquired'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="{{ route('reports.properties') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Properties ({{ $properties->total() }})</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:.84rem;">
            <thead class="table-light">
                <tr>
                    <th>Survey No.</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Area (Sq.ft)</th>
                    <th>Market Value</th>
                    <th>Govt. Value</th>
                    <th>Current Owner</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($properties as $p)
                <tr>
                    <td><a href="{{ route('properties.show', $p) }}" class="fw-600">{{ $p->survey_number }}</a></td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.7rem;">{{ $p->land_type_label }}</span></td>
                    <td class="small">{{ $p->district }}, {{ $p->state }}</td>
                    <td>{{ number_format($p->area_sqft) }}</td>
                    <td>₹{{ number_format($p->market_value) }}</td>
                    <td>₹{{ number_format($p->government_value) }}</td>
                    <td class="small">{{ $p->currentOwner?->full_name ?? '—' }}</td>
                    <td><span class="badge bg-{{ $p->status_badge }}">{{ ucwords(str_replace('_',' ',$p->status)) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No properties found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($properties->hasPages())
    <div class="card-footer">{{ $properties->links() }}</div>
    @endif
</div>
@endsection
