@extends('layouts.app')
@section('title', 'New Registration')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('registrations.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">New Land Registration</h5>
        <small class="text-muted">Submit a new deed registration request</small>
    </div>
</div>

<form action="{{ route('registrations.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <!-- Property & Owner -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-link me-2 text-primary"></i>Property & Owner</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Property <span class="text-danger">*</span></label>
                        <select name="property_id" class="form-select @error('property_id') is-invalid @enderror" required>
                            <option value="">— Select Property —</option>
                            @foreach($properties as $p)
                                <option value="{{ $p->id }}" {{ (old('property_id', request('property_id')) == $p->id) ? 'selected' : '' }}>
                                    {{ $p->survey_number }} — {{ $p->district }}
                                </option>
                            @endforeach
                        </select>
                        @error('property_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Owner (Applicant) <span class="text-danger">*</span></label>
                        <select name="owner_id" class="form-select @error('owner_id') is-invalid @enderror" required>
                            <option value="">— Select Owner —</option>
                            @foreach($owners as $o)
                                <option value="{{ $o->id }}" {{ old('owner_id') == $o->id ? 'selected' : '' }}>
                                    {{ $o->full_name }} ({{ $o->owner_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('owner_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registration Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Registration Type <span class="text-danger">*</span></label>
                        <select name="registration_type" class="form-select @error('registration_type') is-invalid @enderror" required>
                            <option value="">— Select Type —</option>
                            @foreach(['first_registration','sale_deed','gift_deed','will_deed','partition_deed','lease_deed','mortgage_deed'] as $t)
                                <option value="{{ $t }}" {{ old('registration_type') == $t ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$t)) }}</option>
                            @endforeach
                        </select>
                        @error('registration_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Sub-Registrar Office <span class="text-danger">*</span></label>
                        <input type="text" name="sub_registrar_office" class="form-control @error('sub_registrar_office') is-invalid @enderror" value="{{ old('sub_registrar_office') }}" required>
                        @error('sub_registrar_office')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Registration Date <span class="text-danger">*</span></label>
                        <input type="date" name="registration_date" class="form-control @error('registration_date') is-invalid @enderror" value="{{ old('registration_date', date('Y-m-d')) }}" required>
                        @error('registration_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Execution Date</label>
                        <input type="date" name="execution_date" class="form-control" value="{{ old('execution_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Document Number</label>
                        <input type="text" name="document_number" class="form-control" value="{{ old('document_number') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-currency-rupee me-2 text-primary"></i>Financial Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transaction Value (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="transaction_value" id="transaction_value" class="form-control" value="{{ old('transaction_value', 0) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Stamp Duty (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="stamp_duty" id="stamp_duty" class="form-control" value="{{ old('stamp_duty', 0) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Registration Fee (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="registration_fee" id="registration_fee" class="form-control" value="{{ old('registration_fee', 0) }}" min="0" step="0.01" required>
                    </div>
                    <div class="col-12">
                        <div class="bg-primary bg-opacity-10 rounded p-3 d-flex justify-content-between align-items-center">
                            <span class="fw-600 text-primary">Total Payable Fees</span>
                            <span class="fw-700 fs-5 text-primary" id="total_fee">₹0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Witness Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-people me-2 text-primary"></i>Witness Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 1 Name</label>
                        <input type="text" name="witness1_name" class="form-control" value="{{ old('witness1_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 1 ID</label>
                        <input type="text" name="witness1_id" class="form-control" value="{{ old('witness1_id') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 2 Name</label>
                        <input type="text" name="witness2_name" class="form-control" value="{{ old('witness2_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 2 ID</label>
                        <input type="text" name="witness2_id" class="form-control" value="{{ old('witness2_id') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="col-lg-4">
        <!-- Remarks -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-chat-left-text me-2 text-primary"></i>Remarks</div>
            <div class="card-body">
                <textarea name="remarks" class="form-control" rows="4" placeholder="Additional remarks…">{{ old('remarks') }}</textarea>
            </div>
        </div>

        <!-- Document Uploads -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Upload Documents</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Deed Document (PDF)</label>
                    <input type="file" name="deed_document" class="form-control form-control-sm" accept=".pdf">
                    <small class="text-muted">Max 10MB</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-500">Supporting Document 1</label>
                    <input type="file" name="supporting_doc1" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-500">Supporting Document 2</label>
                    <input type="file" name="supporting_doc2" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-2"></i>Submit Registration
            </button>
            <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
    document.getElementById('total_fee').textContent = '₹' + (stamp + fee).toLocaleString('en-IN');
}
// Auto-calculate stamp duty (approx 4% of transaction value)
document.getElementById('transaction_value').addEventListener('input', function () {
    const val = parseFloat(this.value) || 0;
    document.getElementById('stamp_duty').value = (val * 0.04).toFixed(2);
    document.getElementById('registration_fee').value = (val * 0.01).toFixed(2);
    updateTotal();
});
document.getElementById('stamp_duty').addEventListener('input', updateTotal);
document.getElementById('registration_fee').addEventListener('input', updateTotal);
</script>
@endpush
