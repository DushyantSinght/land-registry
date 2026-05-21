@extends('layouts.app')
@section('title', 'Add Land Owner')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('owners.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">Add Land Owner</h5>
        <small class="text-muted">Register a new land holder in the system</small>
    </div>
</div>

<form action="{{ route('owners.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <!-- Personal / Entity Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>Owner Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Full Name / Entity Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Owner Type <span class="text-danger">*</span></label>
                        <select name="owner_type" class="form-select @error('owner_type') is-invalid @enderror" required>
                            <option value="">— Select —</option>
                            <option value="individual" {{ old('owner_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="company" {{ old('owner_type') == 'company' ? 'selected' : '' }}>Company / Firm</option>
                            <option value="government" {{ old('owner_type') == 'government' ? 'selected' : '' }}>Government Body</option>
                        </select>
                        @error('owner_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">ID Type <span class="text-danger">*</span></label>
                        <select name="id_type" class="form-select" required>
                            <option value="national_id" {{ old('id_type','national_id') == 'national_id' ? 'selected' : '' }}>Aadhaar / National ID</option>
                            <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                            <option value="company_reg" {{ old('id_type') == 'company_reg' ? 'selected' : '' }}>Company Registration</option>
                            <option value="pan" {{ old('id_type') == 'pan' ? 'selected' : '' }}>PAN Card</option>
                            <option value="voter_id" {{ old('id_type') == 'voter_id' ? 'selected' : '' }}>Voter ID</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">ID Number <span class="text-danger">*</span></label>
                        <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror" value="{{ old('id_number') }}" required>
                        @error('id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Nationality <span class="text-danger">*</span></label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Indian') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Address -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-geo-alt me-2 text-primary"></i>Address</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-500">Street Address <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address') }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', 'Punjab') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" maxlength="10" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="col-lg-4">
        <!-- Photo -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-camera me-2 text-primary"></i>Photo & ID Document</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Owner Photo</label>
                    <input type="file" name="photo" class="form-control form-control-sm" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">JPEG/PNG, max 2MB</small>
                </div>
                <div>
                    <label class="form-label fw-500">ID Document</label>
                    <input type="file" name="id_document" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">PDF/Image, max 5MB</small>
                </div>
            </div>
        </div>

        <!-- Help -->
        <div class="card mb-4 bg-light border-0">
            <div class="card-body">
                <h6 class="fw-600 mb-2"><i class="bi bi-info-circle text-primary me-1"></i>Notes</h6>
                <ul class="small text-muted mb-0 ps-3">
                    <li>Owner number is auto-generated</li>
                    <li>ID number must be unique in the system</li>
                    <li>All required fields marked with <span class="text-danger">*</span></li>
                </ul>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-check me-2"></i>Register Owner
            </button>
            <a href="{{ route('owners.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection
