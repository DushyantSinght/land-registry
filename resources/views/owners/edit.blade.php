@extends('layouts.app')
@section('title', 'Edit Owner: ' . $owner->full_name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('owners.show', $owner) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">Edit Owner: {{ $owner->full_name }}</h5>
        <small class="text-muted">{{ $owner->owner_number }}</small>
    </div>
</div>

<form action="{{ route('owners.update', $owner) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>Owner Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name', $owner->full_name) }}" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $owner->phone) }}" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $owner->email) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Nationality</label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $owner->nationality) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control"
                               value="{{ old('date_of_birth', $owner->date_of_birth?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Account Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ $owner->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-geo-alt me-2 text-primary"></i>Address</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-500">Street Address <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                  rows="2" required>{{ old('address', $owner->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $owner->city) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $owner->state) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $owner->pincode) }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Read-only info -->
        <div class="card mb-4 bg-light border-0">
            <div class="card-body">
                <h6 class="fw-600 mb-3"><i class="bi bi-shield-lock text-primary me-1"></i>Non-Editable Fields</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted small">Owner No.</td><td class="small fw-600">{{ $owner->owner_number }}</td></tr>
                    <tr><td class="text-muted small">ID Type</td><td class="small">{{ ucwords(str_replace('_',' ',$owner->id_type)) }}</td></tr>
                    <tr><td class="text-muted small">ID Number</td><td class="small fw-600">{{ $owner->id_number }}</td></tr>
                    <tr><td class="text-muted small">Owner Type</td><td class="small">{{ $owner->owner_type_label }}</td></tr>
                </table>
                <small class="text-muted d-block mt-2">To change ID or type, contact system admin.</small>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-camera me-2 text-primary"></i>Update Documents</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Owner Photo</label>
                    @if($owner->photo)
                        <img src="{{ asset('storage/'.$owner->photo) }}" class="d-block mb-2 rounded" style="width:60px;height:60px;object-fit:cover;" alt="Current photo">
                    @endif
                    <input type="file" name="photo" class="form-control form-control-sm" accept=".jpg,.jpeg,.png">
                </div>
                <div>
                    <label class="form-label fw-500">ID Document</label>
                    @if($owner->id_document)
                        <a href="{{ asset('storage/'.$owner->id_document) }}" target="_blank" class="d-block small text-primary mb-1">Current document</a>
                    @endif
                    <input type="file" name="id_document" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Update Owner
            </button>
            <a href="{{ route('owners.show', $owner) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection
