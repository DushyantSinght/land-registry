{{-- resources/views/reports/pdf/properties.blade.php --}}
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
    td { padding: 5px 7px; border-bottom: 1px solid #e2e8f0; font-size: 8.5px; }
    tr:nth-child(even) td { background: #f8fafc; }
    .footer { margin-top: 12px; font-size: 8px; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 6px; }
</style>
</head>
<body>
<h2>🏛 Land Registry — Properties Report</h2>
<p class="subtitle">Generated: {{ now()->format('d M Y H:i') }} | Total Records: {{ $properties->count() }}</p>

<table>
    <thead>
        <tr>
            <th>Survey No.</th>
            <th>Land Type</th>
            <th>District</th>
            <th>State</th>
            <th>Area (Sqft)</th>
            <th>Market Value</th>
            <th>Govt. Value</th>
            <th>Current Owner</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($properties as $p)
        <tr>
            <td>{{ $p->survey_number }}</td>
            <td>{{ $p->land_type_label }}</td>
            <td>{{ $p->district }}</td>
            <td>{{ $p->state }}</td>
            <td>{{ number_format($p->area_sqft) }}</td>
            <td>₹{{ number_format($p->market_value) }}</td>
            <td>₹{{ number_format($p->government_value) }}</td>
            <td>{{ $p->currentOwner?->full_name ?? '—' }}</td>
            <td>{{ ucwords(str_replace('_',' ',$p->status)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">This is a computer-generated report. Land Registry System | {{ config('app.url') }}</div>
</body>
</html>
