<?php $__env->startSection('title', 'Registration: ' . $registration->registration_number); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?php echo e(route('registrations.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0"><?php echo e($registration->registration_number); ?></h5>
            <small class="text-muted"><?php echo e($registration->type_label); ?> &bull; Submitted <?php echo e($registration->created_at->diffForHumans()); ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <?php if($registration->status === 'approved'): ?>
            <a href="<?php echo e(route('registrations.receipt', $registration)); ?>" class="btn btn-sm btn-success">
                <i class="bi bi-download me-1"></i>Receipt PDF
            </a>
        <?php endif; ?>
        <?php if($registration->status === 'pending'): ?>
            <a href="<?php echo e(route('registrations.edit', $registration)); ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <?php if(auth()->user()->isRegistrar()): ?>
                <form action="<?php echo e(route('registrations.approve', $registration)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button class="btn btn-sm btn-success" onclick="return confirm('Approve this registration?')">
                        <i class="bi bi-check-circle me-1"></i>Approve
                    </button>
                </form>
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle me-1"></i>Reject
                </button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Status Banner -->
<div class="alert alert-<?php echo e($registration->status_badge); ?> d-flex align-items-center mb-4">
    <i class="bi bi-<?php echo e($registration->status === 'approved' ? 'check-circle' : ($registration->status === 'rejected' ? 'x-circle' : 'hourglass-split')); ?> me-2 fs-5"></i>
    <div>
        <strong><?php echo e(ucfirst($registration->status)); ?></strong>
        <?php if($registration->status === 'approved'): ?>
            &mdash; Approved by <?php echo e($registration->approvedBy->name); ?> on <?php echo e($registration->approved_at->format('d M Y')); ?>

        <?php elseif($registration->status === 'rejected'): ?>
            &mdash; Reason: <?php echo e($registration->rejection_reason); ?>

        <?php else: ?>
            &mdash; Awaiting review by registrar
        <?php endif; ?>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Registration Info -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registration Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">Reg. Number</td><td class="fw-600"><?php echo e($registration->registration_number); ?></td></tr>
                            <tr><td class="text-muted">Type</td><td><?php echo e($registration->type_label); ?></td></tr>
                            <tr><td class="text-muted">Reg. Date</td><td><?php echo e($registration->registration_date->format('d M Y')); ?></td></tr>
                            <tr><td class="text-muted">Execution Date</td><td><?php echo e($registration->execution_date?->format('d M Y') ?? '—'); ?></td></tr>
                            <tr><td class="text-muted">Document No.</td><td><?php echo e($registration->document_number ?? '—'); ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">SRO</td><td><?php echo e($registration->sub_registrar_office); ?></td></tr>
                            <tr><td class="text-muted">Txn Value</td><td class="fw-600">₹<?php echo e(number_format($registration->transaction_value)); ?></td></tr>
                            <tr><td class="text-muted">Stamp Duty</td><td>₹<?php echo e(number_format($registration->stamp_duty)); ?></td></tr>
                            <tr><td class="text-muted">Reg. Fee</td><td>₹<?php echo e(number_format($registration->registration_fee)); ?></td></tr>
                            <tr><td class="text-muted">Total Fees</td><td class="fw-700 text-primary">₹<?php echo e(number_format($registration->total_fee)); ?></td></tr>
                        </table>
                    </div>
                    <?php if($registration->remarks): ?>
                    <div class="col-12">
                        <div class="bg-light rounded p-2 small"><strong>Remarks:</strong> <?php echo e($registration->remarks); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-map me-2 text-primary"></i>Property Details</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:40%">Survey No.</td><td><a href="<?php echo e(route('properties.show', $registration->property)); ?>" class="fw-600"><?php echo e($registration->property->survey_number); ?></a></td></tr>
                            <tr><td class="text-muted">Land Type</td><td><?php echo e($registration->property->land_type_label); ?></td></tr>
                            <tr><td class="text-muted">Area</td><td><?php echo e(number_format($registration->property->area_sqft)); ?> Sq.ft</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:40%">Location</td><td><?php echo e($registration->property->full_location); ?></td></tr>
                            <tr><td class="text-muted">Status</td><td><span class="badge bg-<?php echo e($registration->property->status_badge); ?>"><?php echo e(ucwords(str_replace('_',' ',$registration->property->status))); ?></span></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Witness Info -->
        <?php if($registration->witness1_name || $registration->witness2_name): ?>
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-people me-2 text-primary"></i>Witnesses</div>
            <div class="card-body">
                <div class="row g-3">
                    <?php if($registration->witness1_name): ?>
                    <div class="col-md-6">
                        <div class="bg-light rounded p-3">
                            <div class="fw-600"><?php echo e($registration->witness1_name); ?></div>
                            <small class="text-muted">ID: <?php echo e($registration->witness1_id ?? '—'); ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($registration->witness2_name): ?>
                    <div class="col-md-6">
                        <div class="bg-light rounded p-3">
                            <div class="fw-600"><?php echo e($registration->witness2_name); ?></div>
                            <small class="text-muted">ID: <?php echo e($registration->witness2_id ?? '—'); ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right -->
    <div class="col-lg-4">
        <!-- Owner Info -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>Owner / Applicant</div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:48px;height:48px;background:#dbeafe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#1d4ed8;">
                        <?php echo e(strtoupper(substr($registration->owner->full_name, 0, 1))); ?>

                    </div>
                    <div>
                        <div class="fw-600"><?php echo e($registration->owner->full_name); ?></div>
                        <small class="text-muted"><?php echo e($registration->owner->owner_number); ?></small>
                    </div>
                </div>
                <table class="table table-sm table-borderless mb-3">
                    <tr><td class="text-muted" style="width:35%">Phone</td><td><?php echo e($registration->owner->phone); ?></td></tr>
                    <tr><td class="text-muted">ID No.</td><td><?php echo e($registration->owner->id_number); ?></td></tr>
                    <tr><td class="text-muted">Type</td><td><?php echo e($registration->owner->owner_type_label); ?></td></tr>
                </table>
                <a href="<?php echo e(route('owners.show', $registration->owner)); ?>" class="btn btn-sm btn-outline-primary w-100">View Profile</a>
            </div>
        </div>

        <!-- Documents -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                <?php $__currentLoopData = ['deed_document' => 'Deed Document', 'supporting_doc1' => 'Supporting Doc 1', 'supporting_doc2' => 'Supporting Doc 2']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between align-items-center py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
                    <span class="small"><?php echo e($label); ?></span>
                    <?php if($registration->$field): ?>
                        <a href="<?php echo e(asset('storage/'.$registration->$field)); ?>" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a>
                    <?php else: ?>
                        <span class="text-muted small">—</span>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header"><i class="bi bi-clock me-2 text-primary"></i>Timeline</div>
            <div class="card-body">
                <div class="d-flex gap-3 mb-3">
                    <div class="text-center"><div style="width:8px;height:8px;border-radius:50%;background:#3b82f6;margin:5px auto;"></div><div style="width:2px;height:30px;background:#e2e8f0;margin:0 auto;"></div></div>
                    <div><div class="fw-500 small">Submitted</div><div class="text-muted" style="font-size:.75rem;"><?php echo e($registration->created_at->format('d M Y, h:i A')); ?></div><div class="text-muted" style="font-size:.75rem;">by <?php echo e($registration->createdBy->name); ?></div></div>
                </div>
                <?php if($registration->approved_at): ?>
                <div class="d-flex gap-3">
                    <div class="text-center"><div style="width:8px;height:8px;border-radius:50%;background:<?php echo e($registration->status === 'approved' ? '#10b981' : '#ef4444'); ?>;margin:5px auto;"></div></div>
                    <div><div class="fw-500 small"><?php echo e(ucfirst($registration->status)); ?></div><div class="text-muted" style="font-size:.75rem;"><?php echo e($registration->approved_at->format('d M Y, h:i A')); ?></div><div class="text-muted" style="font-size:.75rem;">by <?php echo e($registration->approvedBy->name); ?></div></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<?php if($registration->status === 'pending' && auth()->user()->isRegistrar()): ?>
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('registrations.reject', $registration)); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <div class="modal-header border-0">
                    <h6 class="modal-title fw-700">Reject Registration</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-500">Rejection Reason <span class="text-danger">*</span></label>
                    <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Enter the reason for rejection…"></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Reject Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/registrations/show.blade.php ENDPATH**/ ?>