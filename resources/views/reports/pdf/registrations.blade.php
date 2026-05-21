{{-- resources/views/reports/pdf/registrations.blade.php --}}
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1a1a1a; }
    h2 { font-size: 14px; color: #1a56db; margin: 0 0 4px; }
    p.subtitle { font-size: 9px; color: #64748b; margin: 0 0 12px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #1a56db; color: white; padding: 5px 7px; text-align: left; font-size: 8px; }
    td { padding: 5px 7px; border-bottom: 1px solid #e2e8f0; }
    tr:nth-child(even) td { background: #f8fafc; }
    .badge-approved { background: #d1fae5; color: #065f46; padding: 1px 5px; border-radius: 3px; }
    .badge-pending  { background: #fef3c7; color: #92400e; padding: 1px 5px; border-radius: 3px; }
    .badge-rejected { background: #fee2e2; color: #991b1b; padding: 1px 5px; border-radius: 3px; }
    .footer { margin-top: 12px; font-size: 8px; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 6px; }
</style>
</head>
<body>
<h2>🏛 Land Registry — Registrations Report</h2>
<p class="subtitle">Generated: {{ now()->format('d M Y H:i') }} | Total Records: {{ $registrations->count() }}</p>

<table>
    <thead>
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
    @foreach($registrations as $reg)
        <tr>
            <td>{{ $reg->registration_number }}</td>
            <td>{{ $reg->property->survey_number }}</td>
            <td>{{ $reg->owner->full_name }}</td>
            <td>{{ $reg->type_label }}</td>
            <td>{{ $reg->registration_date->format('d/m/Y') }}</td>
            <td>₹{{ number_format($reg->transaction_value) }}</td>
            <td>₹{{ number_format($reg->stamp_duty) }}</td>
            <td>₹{{ number_format($reg->registration_fee) }}</td>
            <td><span class="badge-{{ $reg->status }}">{{ ucfirst($reg->status) }}</span></td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">This is a computer-generated report. Land Registry System | {{ config('app.url') }}</div>
</body>
</html>
