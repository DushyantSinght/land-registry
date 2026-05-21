@extends('layouts.app')
@section('title', 'Edit Registration: ' . $registration->registration_number)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('registrations.show', $registration) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">Edit Registration: {{ $registration->registration_number }}</h5>
        <small class="text-muted">Only pending registrations can be edited</small>
    </div>
</div>

<form action="{{ route('registrations.update', $registration) }}" method="POST">
@csrf @method('PUT')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registration Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Read-only: Property & Owner -->
                    <div class="col-md-6">
                        <label class="form-label fw-500">Property</label>
                        <input type="text" class="form-control bg-light" value="{{ $registration->property->survey_number }} — {{ $registration->property->district }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Owner</label>
                        <input type="text" class="form-control bg-light" value="{{ $registration->owner->full_name }} ({{ $registration->owner->owner_number }})" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-500">Registration Type <span class="text-danger">*</span></label>
                        <select name="registration_type" class="form-select" required>
                            @foreach(['first_registration','sale_deed','gift_deed','will_deed','partition_deed','lease_deed','mortgage_deed'] as $t)
                                <option value="{{ $t }}" {{ $registration->registration_type == $t ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_',' ',$t)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Sub-Registrar Office <span class="text-danger">*</span></label>
                        <input type="text" name="sub_registrar_office" class="form-control"
                               value="{{ old('sub_registrar_office', $registration->sub_registrar_office) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Registration Date <span class="text-danger">*</span></label>
                        <input type="date" name="registration_date" class="form-control"
                               value="{{ old('registration_date', $registration->registration_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Execution Date</label>
                        <input type="date" name="execution_date" class="form-control"
                               value="{{ old('execution_date', $registration->execution_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Document Number</label>
                        <input type="text" name="document_number" class="form-control"
                               value="{{ old('document_number', $registration->document_number) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-currency-rupee me-2 text-primary"></i>Financial Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transaction Value (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="transaction_value" id="transaction_value" class="form-control"
                               value="{{ old('transaction_value', $registration->transaction_value) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Stamp Duty (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="stamp_duty" id="stamp_duty" class="form-control"
                               value="{{ old('stamp_duty', $registration->stamp_duty) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Registration Fee (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="registration_fee" id="registration_fee" class="form-control"
                               value="{{ old('registration_fee', $registration->registration_fee) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-12">
                        <div class="bg-primary bg-opacity-10 rounded p-3 d-flex justify-content-between align-items-center">
                            <span class="fw-600 text-primary">Total Fees</span>
                            <span class="fw-700 fs-5 text-primary" id="total_fee">
                                ₹{{ number_format($registration->stamp_duty + $registration->registration_fee, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-chat-left-text me-2 text-primary"></i>Remarks</div>
            <div class="card-body">
                <textarea name="remarks" class="form-control" rows="3">{{ old('remarks', $registration->remarks) }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4 bg-warning bg-opacity-10 border-warning">
            <div class="card-body">
                <h6 class="fw-600 text-warning mb-2"><i class="bi bi-exclamation-triangle me-1"></i>Edit Notice</h6>
                <p class="small text-muted mb-0">
                    Only <strong>pending</strong> registrations can be edited. Once approved or rejected, changes are locked.
                </p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Registration Info</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted small">Reg. No.</td><td class="small fw-600">{{ $registration->registration_number }}</td></tr>
                    <tr><td class="text-muted small">Status</td><td><span class="badge bg-warning text-dark">Pending</span></td></tr>
                    <tr><td class="text-muted small">Submitted</td><td class="small">{{ $registration->created_at->format('d M Y') }}</td></tr>
                </table>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Update Registration
            </button>
            <a href="{{ route('registrations.show', $registration) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
function updateTotal() {
    const stamp = parseFloat(document.getElementById('stamp_duty').value) || 0;
    const fee   = parseFloat(document.getElementById('registration_fee').value) || 0;
    document.getElementById('total_fee').textContent = '₹' + (stamp + fee).toLocaleString('en-IN', {minimumFractionDigits: 2});
}
document.getElementById('stamp_duty').addEventListener('input', updateTotal);
document.getElementById('registration_fee').addEventListener('input', updateTotal);
document.getElementById('transaction_value').addEventListener('input', function () {
    const val = parseFloat(this.value) || 0;
    document.getElementById('stamp_duty').value = (val * 0.04).toFixed(2);
    document.getElementById('registration_fee').value = (val * 0.01).toFixed(2);
    updateTotal();
});
</script>
@endpush
