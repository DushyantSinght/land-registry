@extends('layouts.app')
@section('title', 'Property: ' . $property->survey_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">{{ $property->survey_number }}</h5>
            <small class="text-muted">{{ $property->full_location }}</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('properties.certificate', $property) }}" class="btn btn-sm btn-success">
            <i class="bi bi-file-pdf me-1"></i>Certificate
        </a>
        <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Delete this property?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- Left: Details -->
    <div class="col-lg-8">
        <!-- Info Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="text-muted small mb-1">Area</div>
                    <div class="fw-700 fs-5">{{ number_format($property->area_sqft, 0) }}</div>
                    <div class="text-muted" style="font-size:.75rem;">Sq. Feet</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="text-muted small mb-1">Market Value</div>
                    <div class="fw-700 fs-5">₹{{ number_format($property->market_value, 0) }}</div>
                    <div class="text-muted" style="font-size:.75rem;">As of {{ $property->valuation_year }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="text-muted small mb-1">Status</div>
                    <div class="fw-700 fs-5">
                        <span class="badge bg-{{ $property->status_badge }} fs-6">{{ ucwords(str_replace('_',' ',$property->status)) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-info-circle me-2 text-primary"></i>Property Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">Survey Number</td><td class="fw-500">{{ $property->survey_number }}</td></tr>
                            <tr><td class="text-muted">Plot Number</td><td>{{ $property->plot_number ?? '—' }}</td></tr>
                            <tr><td class="text-muted">Khasra No.</td><td>{{ $property->khasra_number ?? '—' }}</td></tr>
                            <tr><td class="text-muted">Land Type</td><td>{{ $property->land_type_label }}</td></tr>
                            <tr><td class="text-muted">Land Use</td><td>{{ ucwords(str_replace('_',' ',$property->land_use)) }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">Village</td><td>{{ $property->village ?? '—' }}</td></tr>
                            <tr><td class="text-muted">Taluka</td><td>{{ $property->taluka }}</td></tr>
                            <tr><td class="text-muted">District</td><td>{{ $property->district }}</td></tr>
                            <tr><td class="text-muted">State</td><td>{{ $property->state }}</td></tr>
                            <tr><td class="text-muted">Pincode</td><td>{{ $property->pincode }}</td></tr>
                        </table>
                    </div>
                    @if($property->address_description)
                    <div class="col-12">
                        <div class="bg-light rounded p-2 small text-muted">{{ $property->address_description }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Dimensions & Valuation -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-rulers me-2 text-primary"></i>Dimensions & Valuation</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-3 text-center border-end">
                        <div class="text-muted small">Sq. Feet</div>
                        <div class="fw-600">{{ number_format($property->area_sqft, 2) }}</div>
                    </div>
                    <div class="col-md-3 text-center border-end">
                        <div class="text-muted small">Sq. Meters</div>
                        <div class="fw-600">{{ number_format($property->area_sqm, 2) }}</div>
                    </div>
                    <div class="col-md-3 text-center border-end">
                        <div class="text-muted small">Market Value</div>
                        <div class="fw-600">₹{{ number_format($property->market_value) }}</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="text-muted small">Govt. Value</div>
                        <div class="fw-600">₹{{ number_format($property->government_value) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registrations -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registrations</span>
                <a href="{{ route('registrations.create') }}?property_id={{ $property->id }}" class="btn btn-sm btn-outline-primary">New Registration</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Reg. No</th><th>Type</th><th>Date</th><th>Owner</th><th>Value</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    @forelse($property->registrations as $reg)
                        <tr>
                            <td><a href="{{ route('registrations.show', $reg) }}" class="fw-500">{{ $reg->registration_number }}</a></td>
                            <td class="small">{{ $reg->type_label }}</td>
                            <td class="small text-muted">{{ $reg->registration_date->format('d M Y') }}</td>
                            <td class="small">{{ $reg->owner->full_name }}</td>
                            <td class="small">₹{{ number_format($reg->transaction_value) }}</td>
                            <td><span class="badge bg-{{ $reg->status_badge }}">{{ ucfirst($reg->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No registrations yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transfers -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transfer History</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Transfer No</th><th>From</th><th>To</th><th>Date</th><th>Mode</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    @forelse($property->transfers as $t)
                        <tr>
                            <td><small>{{ $t->transfer_number }}</small></td>
                            <td class="small">{{ Str::limit($t->fromOwner->full_name, 20) }}</td>
                            <td class="small">{{ Str::limit($t->toOwner->full_name, 20) }}</td>
                            <td class="small text-muted">{{ $t->transfer_date->format('d M Y') }}</td>
                            <td class="small">{{ ucwords($t->transfer_mode) }}</td>
                            <td><span class="badge bg-{{ $t->status_badge }}">{{ ucfirst($t->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No transfers.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Owner & Documents -->
    <div class="col-lg-4">
        <!-- Current Owner -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person-check me-2 text-primary"></i>Current Owner</div>
            <div class="card-body">
                @if($property->currentOwner)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:48px;height:48px;background:#e0e7ff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#3730a3;font-size:1.2rem;">
                            {{ strtoupper(substr($property->currentOwner->full_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-600">{{ $property->currentOwner->full_name }}</div>
                            <small class="text-muted">{{ $property->currentOwner->owner_number }}</small>
                        </div>
                    </div>
                    <table class="table table-sm table-borderless mb-3">
                        <tr><td class="text-muted" style="width:40%">Type</td><td>{{ $property->currentOwner->owner_type_label }}</td></tr>
                        <tr><td class="text-muted">Phone</td><td>{{ $property->currentOwner->phone }}</td></tr>
                        <tr><td class="text-muted">ID</td><td>{{ $property->currentOwner->id_number }}</td></tr>
                    </table>
                    <a href="{{ route('owners.show', $property->currentOwner) }}" class="btn btn-sm btn-outline-primary w-100">View Owner Profile</a>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-person-x fs-2"></i>
                        <p class="mt-2 mb-0">No owner assigned</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Documents -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        <span class="small">Site Plan</span>
                    </div>
                    @if($property->site_plan_url)
                        <a href="{{ $property->site_plan_url }}" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a>
                    @else
                        <span class="text-muted small">Not uploaded</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-text text-primary"></i>
                        <span class="small">Survey Document</span>
                    </div>
                    @if($property->survey_document)
                        <a href="{{ asset('storage/'.$property->survey_document) }}" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a>
                    @else
                        <span class="text-muted small">Not uploaded</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Disputes -->
        @if($property->has_disputes)
        <div class="card mb-4 border-danger">
            <div class="card-header text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Dispute Notice</div>
            <div class="card-body">
                <p class="small mb-0">{{ $property->dispute_notes ?? 'This property has active disputes.' }}</p>
            </div>
        </div>
        @endif

        <!-- Meta -->
        <div class="card">
            <div class="card-header"><i class="bi bi-clock me-2 text-primary"></i>Record Info</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted">Created By</td><td class="small">{{ $property->createdBy->name }}</td></tr>
                    <tr><td class="text-muted">Created At</td><td class="small">{{ $property->created_at->format('d M Y') }}</td></tr>
                    <tr><td class="text-muted">Last Updated</td><td class="small">{{ $property->updated_at->format('d M Y') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
