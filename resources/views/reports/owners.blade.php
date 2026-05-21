{{-- resources/views/reports/owners.blade.php --}}
@extends('layouts.app')
@section('title', 'Owners Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">Owners Report</h5>
            <small class="text-muted">All registered land holders</small>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Owners ({{ $owners->total() }})</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:.84rem;">
            <thead class="table-light">
                <tr>
                    <th>Owner No.</th>
                    <th>Full Name</th>
                    <th>Type</th>
                    <th>ID Number</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Properties</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($owners as $owner)
                <tr>
                    <td class="fw-600 text-muted">{{ $owner->owner_number }}</td>
                    <td><a href="{{ route('owners.show', $owner) }}" class="fw-600 text-decoration-none">{{ $owner->full_name }}</a></td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.7rem;">{{ $owner->owner_type_label }}</span></td>
                    <td class="text-muted">{{ $owner->id_number }}</td>
                    <td>{{ $owner->phone }}</td>
                    <td>{{ $owner->city }}, {{ $owner->state }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $owner->properties_count }}</span>
                    </td>
                    <td><span class="badge {{ $owner->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $owner->is_active ? 'Active' : 'Inactive' }}</span></td>
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
