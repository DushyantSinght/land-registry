{{-- resources/views/reports/registrations.blade.php --}}
@extends('layouts.app')
@section('title', 'Registrations Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">Registrations Report</h5>
            <small class="text-muted">All registration records</small>
        </div>
    </div>
    <a href="{{ route('reports.pdf', 'registrations') }}" class="btn btn-sm btn-danger">
        <i class="bi bi-file-pdf me-1"></i>Export PDF
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="year" class="form-select form-select-sm">
                    <option value="">All Years</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="{{ route('reports.registrations') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Registrations ({{ $registrations->total() }})</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:.84rem;">
            <thead class="table-light">
                <tr>
                    <th>Reg. No.</th>
                    <th>Property</th>
                    <th>Owner</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Txn. Value</th>
                    <th>Stamp Duty</th>
                    <th>Reg. Fee</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($registrations as $reg)
                <tr>
                    <td><a href="{{ route('registrations.show', $reg) }}" class="fw-600 small">{{ $reg->registration_number }}</a></td>
                    <td>{{ $reg->property->survey_number }}</td>
                    <td>{{ Str::limit($reg->owner->full_name, 22) }}</td>
                    <td class="text-muted">{{ $reg->type_label }}</td>
                    <td class="text-muted">{{ $reg->registration_date->format('d M Y') }}</td>
                    <td>₹{{ number_format($reg->transaction_value) }}</td>
                    <td>₹{{ number_format($reg->stamp_duty) }}</td>
                    <td>₹{{ number_format($reg->registration_fee) }}</td>
                    <td><span class="badge bg-{{ $reg->status_badge }}">{{ ucfirst($reg->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No records found.</td></tr>
            @endforelse
            </tbody>
            @if($registrations->count())
            <tfoot class="table-light fw-600">
                <tr>
                    <td colspan="5" class="text-end">Totals (this page):</td>
                    <td>₹{{ number_format($registrations->sum('transaction_value')) }}</td>
                    <td>₹{{ number_format($registrations->sum('stamp_duty')) }}</td>
                    <td>₹{{ number_format($registrations->sum('registration_fee')) }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
    @if($registrations->hasPages())
    <div class="card-footer">{{ $registrations->links() }}</div>
    @endif
</div>
@endsection
