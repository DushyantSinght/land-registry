@extends('layouts.app')
@section('title', 'Registrations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Land Registrations</h5>
        <p class="text-muted mb-0 small">Manage property registration deeds</p>
    </div>
    <a href="{{ route('registrations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Registration
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search reg. no., property, owner…" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    @foreach($types as $t)
                        <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$t)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From date">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To date">
            </div>
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Go</button>
                <a href="{{ route('registrations.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Registrations ({{ $registrations->total() }})</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Reg. Number</th>
                    <th>Property</th>
                    <th>Owner</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Transaction Value</th>
                    <th>Total Fees</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($registrations as $reg)
                <tr>
                    <td>
                        <a href="{{ route('registrations.show', $reg) }}" class="fw-600 text-decoration-none">{{ $reg->registration_number }}</a>
                    </td>
                    <td class="small">
                        <a href="{{ route('properties.show', $reg->property) }}" class="text-decoration-none">{{ $reg->property->survey_number }}</a>
                        <br><span class="text-muted">{{ Str::limit($reg->property->district . ', ' . $reg->property->state, 25) }}</span>
                    </td>
                    <td class="small">
                        <a href="{{ route('owners.show', $reg->owner) }}" class="text-decoration-none">{{ Str::limit($reg->owner->full_name, 22) }}</a>
                    </td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.72rem;">{{ $reg->type_label }}</span></td>
                    <td class="small text-muted">{{ $reg->registration_date->format('d M Y') }}</td>
                    <td class="small fw-500">₹{{ number_format($reg->transaction_value) }}</td>
                    <td class="small">₹{{ number_format($reg->total_fee) }}</td>
                    <td><span class="badge bg-{{ $reg->status_badge }}">{{ ucfirst($reg->status) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('registrations.show', $reg) }}" class="btn btn-xs btn-outline-primary" title="View" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            @if($reg->status === 'approved')
                                <a href="{{ route('registrations.receipt', $reg) }}" class="btn btn-xs btn-outline-success" title="Download Receipt" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-download"></i></a>
                            @endif
                            @if($reg->status === 'pending' && auth()->user()->isRegistrar())
                                <form action="{{ route('registrations.approve', $reg) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-xs btn-success" title="Approve" style="padding:2px 7px;font-size:.75rem;" onclick="return confirm('Approve this registration?')"><i class="bi bi-check"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No registrations found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($registrations->hasPages())
    <div class="card-footer">{{ $registrations->links() }}</div>
    @endif
</div>
@endsection
