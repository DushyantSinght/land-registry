@extends('layouts.app')
@section('title', $owner->full_name . ' — Properties')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('owners.show', $owner) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">{{ $owner->full_name }} — Properties</h5>
        <small class="text-muted">{{ $owner->owner_number }}</small>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-map me-2 text-primary"></i>Owned Properties ({{ $properties->total() }})</span>
        <a href="{{ route('properties.create') }}" class="btn btn-sm btn-outline-primary">Add Property</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Survey No.</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Area (Sq.ft)</th>
                    <th>Market Value</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($properties as $p)
                <tr>
                    <td><a href="{{ route('properties.show', $p) }}" class="fw-600 text-decoration-none">{{ $p->survey_number }}</a></td>
                    <td><span class="badge bg-light text-dark border">{{ $p->land_type_label }}</span></td>
                    <td class="small">{{ $p->district }}, {{ $p->state }}</td>
                    <td class="small">{{ number_format($p->area_sqft) }}</td>
                    <td class="small fw-500">₹{{ number_format($p->market_value) }}</td>
                    <td><span class="badge bg-{{ $p->status_badge }}">{{ ucwords(str_replace('_',' ',$p->status)) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('properties.show', $p) }}" class="btn btn-xs btn-outline-primary" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('properties.certificate', $p) }}" class="btn btn-xs btn-outline-success" style="padding:2px 7px;font-size:.75rem;" title="Download Certificate"><i class="bi bi-file-pdf"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No properties found for this owner.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($properties->hasPages())
    <div class="card-footer">{{ $properties->links() }}</div>
    @endif
</div>
@endsection
