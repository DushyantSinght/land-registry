@extends('layouts.app')
@section('title', 'Add New Property')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">Add New Property</h5>
        <small class="text-muted">Register a new land parcel in the system</small>
    </div>
</div>

<form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row g-4">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Land Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-map me-2 text-primary"></i>Land Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Land Type <span class="text-danger">*</span></label>
                        <select name="land_type" class="form-select @error('land_type') is-invalid @enderror" required>
                            <option value="">Select type</option>
                            @foreach(['agricultural','residential','commercial','industrial','forest','government','other'] as $t)
                                <option value="{{ $t }}" {{ old('land_type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                        @error('land_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Land Use <span class="text-danger">*</span></label>
                        <select name="land_use" class="form-select @error('land_use') is-invalid @enderror" required>
                            <option value="">Select use</option>
                            @foreach(['vacant'=>'Vacant','built_up'=>'Built Up','semi_built'=>'Semi Built'] as $v => $l)
                                <option value="{{ $v }}" {{ old('land_use') == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                        @error('land_use')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Plot Number</label>
                        <input type="text" name="plot_number" class="form-control" value="{{ old('plot_number') }}" placeholder="Optional">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Khasra Number</label>
                        <input type="text" name="khasra_number" class="form-control" value="{{ old('khasra_number') }}" placeholder="Optional">
                    </div>
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-geo-alt me-2 text-primary"></i>Location</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Village / Area</label>
                        <input type="text" name="village" class="form-control" value="{{ old('village') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Taluka <span class="text-danger">*</span></label>
                        <input type="text" name="taluka" class="form-control @error('taluka') is-invalid @enderror" value="{{ old('taluka') }}" required>
                        @error('taluka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">District <span class="text-danger">*</span></label>
                        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}" required>
                        @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', 'Punjab') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" maxlength="10" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-500">Address Description</label>
                        <textarea name="address_description" class="form-control" rows="2">{{ old('address_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dimensions -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-rulers me-2 text-primary"></i>Dimensions</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Area (Sq.ft) <span class="text-danger">*</span></label>
                        <input type="number" name="area_sqft" class="form-control @error('area_sqft') is-invalid @enderror" value="{{ old('area_sqft') }}" step="0.01" min="1" required>
                        @error('area_sqft')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Area (Acres)</label>
                        <input type="number" name="area_acres" class="form-control" value="{{ old('area_acres') }}" step="0.0001">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-500">Length (ft)</label>
                        <input type="number" name="length_ft" class="form-control" value="{{ old('length_ft') }}" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-500">Width (ft)</label>
                        <input type="number" name="width_ft" class="form-control" value="{{ old('width_ft') }}" step="0.01">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Valuation -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-currency-rupee me-2 text-primary"></i>Valuation</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Market Value (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="market_value" class="form-control @error('market_value') is-invalid @enderror" value="{{ old('market_value', 0) }}" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-500">Government Value (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="government_value" class="form-control" value="{{ old('government_value', 0) }}" min="0" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-500">Valuation Year</label>
                    <input type="number" name="valuation_year" class="form-control" value="{{ old('valuation_year', date('Y')) }}" min="2000" max="{{ date('Y') }}">
                </div>
            </div>
        </div>

        <!-- Ownership -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person-check me-2 text-primary"></i>Ownership & Status</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Current Owner</label>
                    <select name="current_owner_id" class="form-select">
                        <option value="">— No Owner —</option>
                        @foreach($owners as $o)
                            <option value="{{ $o->id }}" {{ old('current_owner_id') == $o->id ? 'selected' : '' }}>
                                {{ $o->full_name }} ({{ $o->owner_number }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-500">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['available','registered','disputed','mortgaged','government_acquired'] as $s)
                            <option value="{{ $s }}" {{ old('status','available') == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" name="has_disputes" class="form-check-input" id="has_disputes" value="1" {{ old('has_disputes') ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_disputes">Has Disputes</label>
                </div>
                <textarea name="dispute_notes" class="form-control form-control-sm" rows="2" placeholder="Dispute details (optional)">{{ old('dispute_notes') }}</textarea>
            </div>
        </div>

        <!-- Documents -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Site Plan</label>
                    <input type="file" name="site_plan" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">PDF/Image, max 5MB</small>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-500">Survey Document</label>
                    <input type="file" name="survey_document" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">PDF/Image, max 5MB</small>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Save Property
            </button>
            <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection
