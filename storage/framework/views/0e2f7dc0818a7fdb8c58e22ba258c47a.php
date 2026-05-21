
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a1a; margin: 0; padding: 0; }
    .header { background: #1a56db; color: white; padding: 20px 30px; }
    .header h2 { margin: 0 0 4px; font-size: 18px; }
    .header p { margin: 0; font-size: 11px; opacity: .85; }
    .body { padding: 20px 30px; }
    .receipt-meta { display: flex; justify-content: space-between; background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 4px; margin-bottom: 16px; }
    table.details { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    table.details td { padding: 7px 10px; border: 1px solid #e2e8f0; font-size: 11px; }
    table.details td.label { background: #f8fafc; font-weight: bold; color: #64748b; width: 35%; }
    .section-title { color: #1a56db; font-weight: bold; font-size: 12px; padding: 8px 0 4px; border-bottom: 2px solid #1a56db; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
    .fee-box { background: #1a56db; color: white; padding: 14px; border-radius: 4px; margin-top: 16px; }
    .fee-row { display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 11px; }
    .fee-total { border-top: 1px solid rgba(255,255,255,.4); padding-top: 8px; margin-top: 8px; font-size: 14px; font-weight: bold; }
    .status-badge { background: #10b981; color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; }
    .footer { margin-top: 30px; padding-top: 16px; border-top: 2px solid #e2e8f0; font-size: 10px; color: #94a3b8; text-align: center; }
</style>
</head>
<body>
<div class="header">
    <h2>🏛 Land Registry System — Payment Receipt</h2>
    <p>Government Land Registration Portal | Official Receipt</p>
</div>

<div class="body">
    <div class="receipt-meta">
        <div><strong>Receipt No:</strong> <?php echo e($registration->registration_number); ?></div>
        <div><strong>Date:</strong> <?php echo e($registration->registration_date->format('d M Y')); ?></div>
        <div><span class="status-badge">APPROVED</span></div>
    </div>

    <div class="section-title">Registration Details</div>
    <table class="details">
        <tr><td class="label">Reg. Number</td><td><?php echo e($registration->registration_number); ?></td><td class="label">Type</td><td><?php echo e($registration->type_label); ?></td></tr>
        <tr><td class="label">Reg. Date</td><td><?php echo e($registration->registration_date->format('d M Y')); ?></td><td class="label">Sub-Registrar Office</td><td><?php echo e($registration->sub_registrar_office); ?></td></tr>
        <?php if($registration->document_number): ?>
        <tr><td class="label">Document No.</td><td colspan="3"><?php echo e($registration->document_number); ?></td></tr>
        <?php endif; ?>
    </table>

    <div class="section-title">Property Details</div>
    <table class="details">
        <tr><td class="label">Survey Number</td><td><?php echo e($registration->property->survey_number); ?></td><td class="label">Land Type</td><td><?php echo e($registration->property->land_type_label); ?></td></tr>
        <tr><td class="label">Area</td><td><?php echo e(number_format($registration->property->area_sqft)); ?> Sq.ft</td><td class="label">Location</td><td><?php echo e($registration->property->full_location); ?></td></tr>
        <tr><td class="label">Transaction Value</td><td colspan="3"><strong>₹<?php echo e(number_format($registration->transaction_value)); ?></strong></td></tr>
    </table>

    <div class="section-title">Owner Details</div>
    <table class="details">
        <tr><td class="label">Owner Name</td><td><?php echo e($registration->owner->full_name); ?></td><td class="label">Owner No.</td><td><?php echo e($registration->owner->owner_number); ?></td></tr>
        <tr><td class="label">ID Number</td><td><?php echo e($registration->owner->id_number); ?></td><td class="label">Phone</td><td><?php echo e($registration->owner->phone); ?></td></tr>
        <tr><td class="label">Address</td><td colspan="3"><?php echo e($registration->owner->address); ?>, <?php echo e($registration->owner->city); ?>, <?php echo e($registration->owner->state); ?></td></tr>
    </table>

    <div class="fee-box">
        <div class="fee-row"><span>Stamp Duty</span><span>₹<?php echo e(number_format($registration->stamp_duty, 2)); ?></span></div>
        <div class="fee-row"><span>Registration Fee</span><span>₹<?php echo e(number_format($registration->registration_fee, 2)); ?></span></div>
        <div class="fee-row fee-total"><span>TOTAL PAID</span><span>₹<?php echo e(number_format($registration->total_fee, 2)); ?></span></div>
    </div>

    <p style="margin-top:16px;font-size:11px;">Approved by: <strong><?php echo e($registration->approvedBy->name); ?></strong> on <?php echo e($registration->approved_at->format('d M Y')); ?></p>

    <div class="footer">
        This is a computer-generated receipt and does not require a physical signature.<br>
        For queries, contact the Sub-Registrar Office. | Generated: <?php echo e(now()->format('d M Y H:i:s')); ?>

    </div>
</div>
</body>
</html>
<?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/registrations/receipt-pdf.blade.php ENDPATH**/ ?>