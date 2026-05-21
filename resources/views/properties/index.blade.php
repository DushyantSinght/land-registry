@extends('layouts.app')
@section('title', 'Properties')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Land Properties</h5>
        <p class="text-muted mb-0 small">Manage all registered land parcels</p>
    </div>
    <a href="{{ route('properties.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Property
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search survey no., district…" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="district" class="form-select form-select-sm">
                    <option value="">All Districts</option>
                    @foreach($districts as $d)
                        <option value="{{ $d }}" {{ request('district') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="land_type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    @foreach($landTypes as $t)
                        <option value="{{ $t }}" {{ request('land_type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Properties ({{ $properties->total() }})</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Survey No.</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Area (Sq.ft)</th>
                    <th>Market Value</th>
                    <th>Current Owner</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($properties as $p)
                <tr>
                    <td>
                        <a href="{{ route('properties.show', $p) }}" class="fw-600 text-decoration-none">{{ $p->survey_number }}</a>
                        @if($p->plot_number)<br><small class="text-muted">Plot: {{ $p->plot_number }}</small>@endif
                    </td>
                    <td>
                        <div>{{ $p->district }}</div>
                        <small class="text-muted">{{ $p->taluka }}, {{ $p->state }}</small>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $p->land_type_label }}</span></td>
                    <td>{{ number_format($p->area_sqft, 0) }}</td>
                    <td>₹{{ number_format($p->market_value, 0) }}</td>
                    <td>
                        @if($p->currentOwner)
                            <a href="{{ route('owners.show', $p->currentOwner) }}" class="text-decoration-none small">
                                {{ Str::limit($p->currentOwner->full_name, 22) }}
                            </a>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td><span class="badge bg-{{ $p->status_badge }}">{{ ucwords(str_replace('_',' ',$p->status)) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('properties.show', $p) }}" class="btn btn-xs btn-outline-primary" title="View" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('properties.edit', $p) }}" class="btn btn-xs btn-outline-secondary" title="Edit" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-pencil"></i></a>
                            <a href="{{ route('properties.certificate', $p) }}" class="btn btn-xs btn-outline-success" title="Certificate" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-file-pdf"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No properties found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($properties->hasPages())
    <div class="card-footer">
        {{ $properties->links() }}
    </div>
    @endif
</div>
@endsection
