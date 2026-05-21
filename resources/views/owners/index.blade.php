@extends('layouts.app')
@section('title', 'Land Owners')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Land Owners</h5>
        <p class="text-muted mb-0 small">All registered land holders</p>
    </div>
    <a href="{{ route('owners.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add Owner
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name, ID number, owner number, phone…" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="individual" {{ request('type') === 'individual' ? 'selected' : '' }}>Individual</option>
                    <option value="company" {{ request('type') === 'company' ? 'selected' : '' }}>Company / Firm</option>
                    <option value="government" {{ request('type') === 'government' ? 'selected' : '' }}>Government</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="{{ route('owners.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Owners ({{ $owners->total() }})</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Owner</th>
                    <th>Type</th>
                    <th>ID Number</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Properties</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($owners as $owner)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:36px;height:36px;background:#dbeafe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#1d4ed8;font-size:.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($owner->full_name, 0, 1)) }}
                            </div>
                            <div>
                                <a href="{{ route('owners.show', $owner) }}" class="fw-600 text-decoration-none d-block">{{ $owner->full_name }}</a>
                                <small class="text-muted">{{ $owner->owner_number }}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $owner->owner_type_label }}</span></td>
                    <td class="small text-muted">{{ $owner->id_number }}</td>
                    <td class="small">
                        {{ $owner->phone }}
                        @if($owner->email)<br><span class="text-muted">{{ $owner->email }}</span>@endif
                    </td>
                    <td class="small">{{ $owner->city }}, {{ $owner->state }}</td>
                    <td>
                        <a href="{{ route('owners.properties', $owner) }}" class="badge bg-primary text-decoration-none">
                            {{ $owner->properties_count ?? $owner->properties->count() }} props
                        </a>
                    </td>
                    <td>
                        <span class="badge {{ $owner->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $owner->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('owners.show', $owner) }}" class="btn btn-xs btn-outline-primary" title="View" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('owners.edit', $owner) }}" class="btn btn-xs btn-outline-secondary" title="Edit" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-pencil"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No owners found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($owners->hasPages())
    <div class="card-footer">{{ $owners->links() }}</div>
    @endif
</div>
@endsection
