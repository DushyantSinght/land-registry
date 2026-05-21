@extends('layouts.app')
@section('title', $owner->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('owners.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">{{ $owner->full_name }}</h5>
            <small class="text-muted">{{ $owner->owner_number }} &bull; {{ $owner->owner_type_label }}</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('owners.edit', $owner) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card mb-4">
            <div class="card-body text-center p-4">
                <div style="width:80px;height:80px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:2rem;margin:0 auto 16px;">
                    {{ strtoupper(substr($owner->full_name, 0, 1)) }}
                </div>
                <h6 class="fw-700 mb-1">{{ $owner->full_name }}</h6>
                <p class="text-muted small mb-2">{{ $owner->owner_number }}</p>
                <span class="badge bg-primary">{{ $owner->owner_type_label }}</span>
                <span class="badge {{ $owner->is_active ? 'bg-success' : 'bg-secondary' }} ms-1">{{ $owner->is_active ? 'Active' : 'Inactive' }}</span>

                <hr>
                <div class="text-start">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-telephone text-muted"></i>
                        <span class="small">{{ $owner->phone }}</span>
                    </div>
                    @if($owner->email)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-envelope text-muted"></i>
                        <span class="small">{{ $owner->email }}</span>
                    </div>
                    @endif
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt text-muted"></i>
                        <span class="small">{{ $owner->address }}, {{ $owner->city }}, {{ $owner->state }} - {{ $owner->pincode }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ID Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-card-text me-2 text-primary"></i>Identity Details</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted" style="width:40%">ID Type</td><td>{{ ucwords(str_replace('_',' ',$owner->id_type)) }}</td></tr>
                    <tr><td class="text-muted">ID Number</td><td class="fw-600">{{ $owner->id_number }}</td></tr>
                    <tr><td class="text-muted">DOB</td><td>{{ $owner->date_of_birth?->format('d M Y') ?? '—' }}</td></tr>
                    @if($owner->date_of_birth)<tr><td class="text-muted">Age</td><td>{{ $owner->age }} years</td></tr>@endif
                    <tr><td class="text-muted">Nationality</td><td>{{ $owner->nationality }}</td></tr>
                </table>
                @if($owner->id_document)
                <a href="{{ asset('storage/'.$owner->id_document) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    <i class="bi bi-file-earmark me-1"></i>View ID Document
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Properties -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-map me-2 text-primary"></i>Owned Properties ({{ $owner->properties->count() }})</span>
                <a href="{{ route('properties.create') }}" class="btn btn-sm btn-outline-primary">Add Property</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Survey No.</th><th>Type</th><th>Location</th><th>Area (Sqft)</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                    @forelse($owner->properties as $p)
                        <tr>
                            <td><a href="{{ route('properties.show', $p) }}" class="fw-600">{{ $p->survey_number }}</a></td>
                            <td class="small">{{ $p->land_type_label }}</td>
                            <td class="small">{{ $p->district }}, {{ $p->state }}</td>
                            <td class="small">{{ number_format($p->area_sqft) }}</td>
                            <td><span class="badge bg-{{ $p->status_badge }}">{{ ucwords(str_replace('_',' ',$p->status)) }}</span></td>
                            <td><a href="{{ route('properties.show', $p) }}" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No properties.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Registrations -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registration History</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Reg. No.</th><th>Property</th><th>Type</th><th>Date</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    @forelse($owner->registrations as $reg)
                        <tr>
                            <td><a href="{{ route('registrations.show', $reg) }}" class="fw-500 small">{{ $reg->registration_number }}</a></td>
                            <td class="small">{{ $reg->property->survey_number }}</td>
                            <td class="small text-muted">{{ $reg->type_label }}</td>
                            <td class="small text-muted">{{ $reg->registration_date->format('d M Y') }}</td>
                            <td><span class="badge bg-{{ $reg->status_badge }}">{{ ucfirst($reg->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">No registrations.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
