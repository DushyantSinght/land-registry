{{-- resources/views/transfers/create.blade.php --}}
@extends('layouts.app')
@section('title', 'New Transfer')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('transfers.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">New Ownership Transfer</h5>
        <small class="text-muted">Transfer property ownership to another party</small>
    </div>
</div>

<form action="{{ route('transfers.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transfer Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-500">Property <span class="text-danger">*</span></label>
                        <select name="property_id" class="form-select @error('property_id') is-invalid @enderror" required id="property_select">
                            <option value="">— Select Registered Property —</option>
                            @foreach($properties as $p)
                                <option value="{{ $p->id }}" data-owner="{{ $p->current_owner_id }}" {{ old('property_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->survey_number }} — {{ $p->district }} (Owner: {{ $p->currentOwner?->full_name ?? 'None' }})
                                </option>
                            @endforeach
                        </select>
                        @error('property_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Transferring From <span class="text-danger">*</span></label>
                        <select name="from_owner_id" class="form-select @error('from_owner_id') is-invalid @enderror" required>
                            <option value="">— Select Current Owner —</option>
                            @foreach($owners as $o)
                                <option value="{{ $o->id }}" {{ old('from_owner_id') == $o->id ? 'selected' : '' }}>
                                    {{ $o->full_name }} ({{ $o->owner_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('from_owner_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Transferring To <span class="text-danger">*</span></label>
                        <select name="to_owner_id" class="form-select @error('to_owner_id') is-invalid @enderror" required>
                            <option value="">— Select New Owner —</option>
                            @foreach($owners as $o)
                                <option value="{{ $o->id }}" {{ old('to_owner_id') == $o->id ? 'selected' : '' }}>
                                    {{ $o->full_name }} ({{ $o->owner_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('to_owner_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transfer Date <span class="text-danger">*</span></label>
                        <input type="date" name="transfer_date" class="form-control" value="{{ old('transfer_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transfer Mode <span class="text-danger">*</span></label>
                        <select name="transfer_mode" class="form-select" required>
                            <option value="">— Select —</option>
                            @foreach(['Sale' => 'sale', 'Gift' => 'gift', 'Inheritance' => 'inheritance', 'Court Order' => 'court_order', 'Exchange' => 'exchange'] as $label => $val)
                                <option value="{{ $val }}" {{ old('transfer_mode') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transfer Value (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="transfer_value" class="form-control" value="{{ old('transfer_value', 0) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-500">Reason / Notes</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Reason for transfer…">{{ old('reason') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Transfer Deed</div>
            <div class="card-body">
                <input type="file" name="transfer_deed" class="form-control form-control-sm" accept=".pdf">
                <small class="text-muted">PDF only, max 10MB</small>
            </div>
        </div>
        <div class="alert alert-info small">
            <i class="bi bi-info-circle me-1"></i>
            Transfer will be <strong>pending</strong> until approved by a Registrar. On approval, the property ownership will be updated automatically.
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-send me-2"></i>Submit Transfer</button>
            <a href="{{ route('transfers.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection
