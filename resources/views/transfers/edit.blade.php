@extends('layouts.app')
@section('title', 'Edit Transfer: ' . $transfer->transfer_number)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('transfers.show', $transfer) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">Edit Transfer: {{ $transfer->transfer_number }}</h5>
        <small class="text-muted">Only pending transfers can be edited</small>
    </div>
</div>

<form action="{{ route('transfers.update', $transfer) }}" method="POST">
@csrf @method('PUT')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transfer Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Property</label>
                        <input type="text" class="form-control bg-light" value="{{ $transfer->property->survey_number }} — {{ $transfer->property->district }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">From Owner</label>
                        <input type="text" class="form-control bg-light" value="{{ $transfer->fromOwner->full_name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">To Owner</label>
                        <input type="text" class="form-control bg-light" value="{{ $transfer->toOwner->full_name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Transfer Date <span class="text-danger">*</span></label>
                        <input type="date" name="transfer_date" class="form-control"
                               value="{{ old('transfer_date', $transfer->transfer_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Transfer Mode <span class="text-danger">*</span></label>
                        <select name="transfer_mode" class="form-select" required>
                            @foreach(['sale','gift','inheritance','court_order','exchange'] as $mode)
                                <option value="{{ $mode }}" {{ $transfer->transfer_mode == $mode ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_',' ',$mode)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Transfer Value (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="transfer_value" class="form-control"
                               value="{{ old('transfer_value', $transfer->transfer_value) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-500">Reason / Notes</label>
                        <textarea name="reason" class="form-control" rows="3">{{ old('reason', $transfer->reason) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4 bg-warning bg-opacity-10 border-warning">
            <div class="card-body">
                <h6 class="fw-600 text-warning mb-2"><i class="bi bi-exclamation-triangle me-1"></i>Edit Notice</h6>
                <p class="small text-muted mb-0">Only <strong>pending</strong> transfers can be edited. Property and ownership details cannot be changed here.</p>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Update Transfer
            </button>
            <a href="{{ route('transfers.show', $transfer) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection
