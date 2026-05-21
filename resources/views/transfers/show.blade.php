@extends('layouts.app')
@section('title', 'Transfer: ' . $transfer->transfer_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('transfers.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">{{ $transfer->transfer_number }}</h5>
            <small class="text-muted">Property Transfer Request</small>
        </div>
    </div>
    @if($transfer->status === 'pending' && auth()->user()->isRegistrar())
    <div class="d-flex gap-2">
        <form action="{{ route('transfers.approve', $transfer) }}" method="POST">
            @csrf @method('PATCH')
            <button class="btn btn-sm btn-success" onclick="return confirm('Approve this transfer? The ownership will be updated.')">
                <i class="bi bi-check-circle me-1"></i>Approve
            </button>
        </form>
        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
            <i class="bi bi-x-circle me-1"></i>Reject
        </button>
    </div>
    @endif
</div>

<div class="alert alert-{{ $transfer->status_badge }}">
    <i class="bi bi-{{ $transfer->status === 'approved' ? 'check-circle' : ($transfer->status === 'rejected' ? 'x-circle' : 'hourglass-split') }} me-2"></i>
    <strong>{{ ucfirst($transfer->status) }}</strong>
    @if($transfer->approved_at) &mdash; by {{ $transfer->approvedBy->name }} on {{ $transfer->approved_at->format('d M Y') }} @endif
    @if($transfer->remarks) &mdash; {{ $transfer->remarks }} @endif
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transfer Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:40%">Transfer No.</td><td class="fw-600">{{ $transfer->transfer_number }}</td></tr>
                            <tr><td class="text-muted">Property</td><td><a href="{{ route('properties.show', $transfer->property) }}">{{ $transfer->property->survey_number }}</a></td></tr>
                            <tr><td class="text-muted">Transfer Date</td><td>{{ $transfer->transfer_date->format('d M Y') }}</td></tr>
                            <tr><td class="text-muted">Transfer Mode</td><td>{{ ucwords($transfer->transfer_mode) }}</td></tr>
                            <tr><td class="text-muted">Transfer Value</td><td class="fw-600">₹{{ number_format($transfer->transfer_value) }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3 mb-2">
                            <div class="text-muted small mb-1">FROM</div>
                            <div class="fw-600">{{ $transfer->fromOwner->full_name }}</div>
                            <small class="text-muted">{{ $transfer->fromOwner->owner_number }}</small>
                        </div>
                        <div class="text-center"><i class="bi bi-arrow-down text-muted"></i></div>
                        <div class="border border-success rounded p-3 mt-2">
                            <div class="text-muted small mb-1">TO</div>
                            <div class="fw-600 text-success">{{ $transfer->toOwner->full_name }}</div>
                            <small class="text-muted">{{ $transfer->toOwner->owner_number }}</small>
                        </div>
                    </div>
                    @if($transfer->reason)
                    <div class="col-12">
                        <div class="bg-light rounded p-2 small"><strong>Reason:</strong> {{ $transfer->reason }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                @if($transfer->transfer_deed)
                    <a href="{{ asset('storage/'.$transfer->transfer_deed) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-file-pdf me-1"></i>View Transfer Deed
                    </a>
                @else
                    <p class="text-muted small mb-0">No deed uploaded.</p>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header"><i class="bi bi-clock me-2 text-primary"></i>Submitted By</div>
            <div class="card-body">
                <div class="fw-600">{{ $transfer->createdBy->name }}</div>
                <small class="text-muted">{{ $transfer->created_at->format('d M Y, h:i A') }}</small>
            </div>
        </div>
    </div>
</div>

@if($transfer->status === 'pending' && auth()->user()->isRegistrar())
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('transfers.reject', $transfer) }}" method="POST">
                @csrf @method('PATCH')
                <div class="modal-header"><h6 class="modal-title fw-700">Reject Transfer</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <textarea name="remarks" class="form-control" rows="3" required placeholder="Reason for rejection…"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
