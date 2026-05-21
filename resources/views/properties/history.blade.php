@extends('layouts.app')
@section('title', 'History: ' . $property->survey_number)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">Ownership History — {{ $property->survey_number }}</h5>
        <small class="text-muted">{{ $property->full_location }}</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-clock-history me-2 text-primary"></i>Ownership Timeline</div>
            <div class="card-body p-0">
                @forelse($history as $record)
                <div class="d-flex gap-4 p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="text-center" style="min-width: 60px;">
                        <div style="width:40px;height:40px;border-radius:50%;
                            background:{{ match($record->event_type) {
                                'registration' => '#dbeafe',
                                'transfer' => '#d1fae5',
                                'mortgage' => '#fef3c7',
                                default => '#f1f5f9'
                            } }};
                            display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="bi bi-{{ match($record->event_type) {
                                'registration' => 'file-earmark-text',
                                'transfer' => 'arrow-left-right',
                                'mortgage' => 'bank',
                                default => 'circle'
                            } }}" style="color:{{ match($record->event_type) {
                                'registration' => '#3b82f6',
                                'transfer' => '#10b981',
                                'mortgage' => '#f59e0b',
                                default => '#64748b'
                            } }};"></i>
                        </div>
                        @if(!$loop->last)
                        <div style="width:2px;height:40px;background:#e2e8f0;margin:4px auto;"></div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="fw-600">{{ ucfirst($record->event_type) }}</span>
                                <span class="text-muted small ms-2">{{ $record->from_date->format('d M Y') }}</span>
                                @if($record->to_date)
                                    <span class="text-muted small"> → {{ $record->to_date->format('d M Y') }}</span>
                                @endif
                            </div>
                            <span class="badge bg-{{ match($record->event_type) {
                                'registration' => 'primary',
                                'transfer' => 'success',
                                'mortgage' => 'warning',
                                default => 'secondary'
                            } }}">{{ ucfirst($record->event_type) }}</span>
                        </div>
                        <div class="mt-1">
                            <span class="small fw-500">Owner: </span>
                            <a href="{{ route('owners.show', $record->owner) }}" class="small text-decoration-none">
                                {{ $record->owner->full_name }}
                            </a>
                            <span class="text-muted small">({{ $record->owner->owner_number }})</span>
                        </div>
                        @if($record->notes)
                        <div class="mt-1 text-muted small">{{ $record->notes }}</div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-clock-history fs-1 d-block mb-2 opacity-25"></i>
                    No history records found.
                </div>
                @endforelse
            </div>
            @if($history->hasPages())
            <div class="card-footer">{{ $history->links() }}</div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-info-circle me-2 text-primary"></i>Property Summary</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted" style="width:45%">Survey No.</td><td class="fw-600">{{ $property->survey_number }}</td></tr>
                    <tr><td class="text-muted">Land Type</td><td>{{ $property->land_type_label }}</td></tr>
                    <tr><td class="text-muted">Area</td><td>{{ number_format($property->area_sqft) }} Sq.ft</td></tr>
                    <tr><td class="text-muted">District</td><td>{{ $property->district }}</td></tr>
                    <tr><td class="text-muted">Current Status</td><td><span class="badge bg-{{ $property->status_badge }}">{{ ucwords(str_replace('_',' ',$property->status)) }}</span></td></tr>
                    @if($property->currentOwner)
                    <tr><td class="text-muted">Current Owner</td><td><a href="{{ route('owners.show', $property->currentOwner) }}" class="small">{{ $property->currentOwner->full_name }}</a></td></tr>
                    @endif
                    <tr><td class="text-muted">Total Events</td><td class="fw-600">{{ $history->total() }}</td></tr>
                </table>
            </div>
        </div>

        <a href="{{ route('properties.show', $property) }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-arrow-left me-2"></i>Back to Property
        </a>
    </div>
</div>
@endsection
