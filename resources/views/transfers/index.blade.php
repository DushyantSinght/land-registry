{{-- resources/views/transfers/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Transfers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Ownership Transfers</h5>
        <p class="text-muted mb-0 small">Manage land title transfer requests</p>
    </div>
    <a href="{{ route('transfers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Transfer
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="{{ route('transfers.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Transfers ({{ $transfers->total() }})</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Transfer No.</th><th>Property</th><th>From Owner</th><th>To Owner</th><th>Date</th><th>Mode</th><th>Value</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($transfers as $t)
                <tr>
                    <td><a href="{{ route('transfers.show', $t) }}" class="fw-600 text-decoration-none small">{{ $t->transfer_number }}</a></td>
                    <td class="small"><a href="{{ route('properties.show', $t->property) }}" class="text-decoration-none">{{ $t->property->survey_number }}</a></td>
                    <td class="small">{{ Str::limit($t->fromOwner->full_name, 20) }}</td>
                    <td class="small">{{ Str::limit($t->toOwner->full_name, 20) }}</td>
                    <td class="small text-muted">{{ $t->transfer_date->format('d M Y') }}</td>
                    <td class="small">{{ ucwords($t->transfer_mode) }}</td>
                    <td class="small fw-500">₹{{ number_format($t->transfer_value) }}</td>
                    <td><span class="badge bg-{{ $t->status_badge }}">{{ ucfirst($t->status) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('transfers.show', $t) }}" class="btn btn-xs btn-outline-primary" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            @if($t->status === 'pending' && auth()->user()->isRegistrar())
                                <form action="{{ route('transfers.approve', $t) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-xs btn-success" style="padding:2px 7px;font-size:.75rem;" onclick="return confirm('Approve transfer?')"><i class="bi bi-check"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No transfers found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($transfers->hasPages())
    <div class="card-footer">{{ $transfers->links() }}</div>
    @endif
</div>
@endsection
