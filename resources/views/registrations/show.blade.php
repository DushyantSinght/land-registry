@extends('layouts.app')
@section('title', 'Registration: ' . $registration->registration_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('registrations.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">{{ $registration->registration_number }}</h5>
            <small class="text-muted">{{ $registration->type_label }} &bull; Submitted {{ $registration->created_at->diffForHumans() }}</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        @if($registration->status === 'approved')
            <a href="{{ route('registrations.receipt', $registration) }}" class="btn btn-sm btn-success">
                <i class="bi bi-download me-1"></i>Receipt PDF
            </a>
        @endif
        @if($registration->status === 'pending')
            <a href="{{ route('registrations.edit', $registration) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            @if(auth()->user()->isRegistrar())
                <form action="{{ route('registrations.approve', $registration) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-success" onclick="return confirm('Approve this registration?')">
                        <i class="bi bi-check-circle me-1"></i>Approve
                    </button>
                </form>
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle me-1"></i>Reject
                </button>
            @endif
        @endif
    </div>
</div>

<!-- Status Banner -->
<div class="alert alert-{{ $registration->status_badge }} d-flex align-items-center mb-4">
    <i class="bi bi-{{ $registration->status === 'approved' ? 'check-circle' : ($registration->status === 'rejected' ? 'x-circle' : 'hourglass-split') }} me-2 fs-5"></i>
    <div>
        <strong>{{ ucfirst($registration->status) }}</strong>
        @if($registration->status === 'approved')
            &mdash; Approved by {{ $registration->approvedBy->name }} on {{ $registration->approved_at->format('d M Y') }}
        @elseif($registration->status === 'rejected')
            &mdash; Reason: {{ $registration->rejection_reason }}
        @else
            &mdash; Awaiting review by registrar
        @endif
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Registration Info -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registration Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">Reg. Number</td><td class="fw-600">{{ $registration->registration_number }}</td></tr>
                            <tr><td class="text-muted">Type</td><td>{{ $registration->type_label }}</td></tr>
                            <tr><td class="text-muted">Reg. Date</td><td>{{ $registration->registration_date->format('d M Y') }}</td></tr>
                            <tr><td class="text-muted">Execution Date</td><td>{{ $registration->execution_date?->format('d M Y') ?? '—' }}</td></tr>
                            <tr><td class="text-muted">Document No.</td><td>{{ $registration->document_number ?? '—' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">SRO</td><td>{{ $registration->sub_registrar_office }}</td></tr>
                            <tr><td class="text-muted">Txn Value</td><td class="fw-600">₹{{ number_format($registration->transaction_value) }}</td></tr>
                            <tr><td class="text-muted">Stamp Duty</td><td>₹{{ number_format($registration->stamp_duty) }}</td></tr>
                            <tr><td class="text-muted">Reg. Fee</td><td>₹{{ number_format($registration->registration_fee) }}</td></tr>
                            <tr><td class="text-muted">Total Fees</td><td class="fw-700 text-primary">₹{{ number_format($registration->total_fee) }}</td></tr>
                        </table>
                    </div>
                    @if($registration->remarks)
                    <div class="col-12">
                        <div class="bg-light rounded p-2 small"><strong>Remarks:</strong> {{ $registration->remarks }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-map me-2 text-primary"></i>Property Details</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:40%">Survey No.</td><td><a href="{{ route('properties.show', $registration->property) }}" class="fw-600">{{ $registration->property->survey_number }}</a></td></tr>
                            <tr><td class="text-muted">Land Type</td><td>{{ $registration->property->land_type_label }}</td></tr>
                            <tr><td class="text-muted">Area</td><td>{{ number_format($registration->property->area_sqft) }} Sq.ft</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:40%">Location</td><td>{{ $registration->property->full_location }}</td></tr>
                            <tr><td class="text-muted">Status</td><td><span class="badge bg-{{ $registration->property->status_badge }}">{{ ucwords(str_replace('_',' ',$registration->property->status)) }}</span></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Witness Info -->
        @if($registration->witness1_name || $registration->witness2_name)
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-people me-2 text-primary"></i>Witnesses</div>
            <div class="card-body">
                <div class="row g-3">
                    @if($registration->witness1_name)
                    <div class="col-md-6">
                        <div class="bg-light rounded p-3">
                            <div class="fw-600">{{ $registration->witness1_name }}</div>
                            <small class="text-muted">ID: {{ $registration->witness1_id ?? '—' }}</small>
                        </div>
                    </div>
                    @endif
                    @if($registration->witness2_name)
                    <div class="col-md-6">
                        <div class="bg-light rounded p-3">
                            <div class="fw-600">{{ $registration->witness2_name }}</div>
                            <small class="text-muted">ID: {{ $registration->witness2_id ?? '—' }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right -->
    <div class="col-lg-4">
        <!-- Owner Info -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>Owner / Applicant</div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:48px;height:48px;background:#dbeafe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#1d4ed8;">
                        {{ strtoupper(substr($registration->owner->full_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-600">{{ $registration->owner->full_name }}</div>
                        <small class="text-muted">{{ $registration->owner->owner_number }}</small>
                    </div>
                </div>
                <table class="table table-sm table-borderless mb-3">
                    <tr><td class="text-muted" style="width:35%">Phone</td><td>{{ $registration->owner->phone }}</td></tr>
                    <tr><td class="text-muted">ID No.</td><td>{{ $registration->owner->id_number }}</td></tr>
                    <tr><td class="text-muted">Type</td><td>{{ $registration->owner->owner_type_label }}</td></tr>
                </table>
                <a href="{{ route('owners.show', $registration->owner) }}" class="btn btn-sm btn-outline-primary w-100">View Profile</a>
            </div>
        </div>

        <!-- Documents -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                @foreach(['deed_document' => 'Deed Document', 'supporting_doc1' => 'Supporting Doc 1', 'supporting_doc2' => 'Supporting Doc 2'] as $field => $label)
                <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <span class="small">{{ $label }}</span>
                    @if($registration->$field)
                        <a href="{{ asset('storage/'.$registration->$field) }}" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a>
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header"><i class="bi bi-clock me-2 text-primary"></i>Timeline</div>
            <div class="card-body">
                <div class="d-flex gap-3 mb-3">
                    <div class="text-center"><div style="width:8px;height:8px;border-radius:50%;background:#3b82f6;margin:5px auto;"></div><div style="width:2px;height:30px;background:#e2e8f0;margin:0 auto;"></div></div>
                    <div><div class="fw-500 small">Submitted</div><div class="text-muted" style="font-size:.75rem;">{{ $registration->created_at->format('d M Y, h:i A') }}</div><div class="text-muted" style="font-size:.75rem;">by {{ $registration->createdBy->name }}</div></div>
                </div>
                @if($registration->approved_at)
                <div class="d-flex gap-3">
                    <div class="text-center"><div style="width:8px;height:8px;border-radius:50%;background:{{ $registration->status === 'approved' ? '#10b981' : '#ef4444' }};margin:5px auto;"></div></div>
                    <div><div class="fw-500 small">{{ ucfirst($registration->status) }}</div><div class="text-muted" style="font-size:.75rem;">{{ $registration->approved_at->format('d M Y, h:i A') }}</div><div class="text-muted" style="font-size:.75rem;">by {{ $registration->approvedBy->name }}</div></div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
@if($registration->status === 'pending' && auth()->user()->isRegistrar())
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('registrations.reject', $registration) }}" method="POST">
                @csrf @method('PATCH')
                <div class="modal-header border-0">
                    <h6 class="modal-title fw-700">Reject Registration</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-500">Rejection Reason <span class="text-danger">*</span></label>
                    <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Enter the reason for rejection…"></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Reject Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
