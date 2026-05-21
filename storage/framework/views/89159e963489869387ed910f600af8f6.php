<?php $__env->startSection('title', 'Transfer: ' . $transfer->transfer_number); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?php echo e(route('transfers.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0"><?php echo e($transfer->transfer_number); ?></h5>
            <small class="text-muted">Property Transfer Request</small>
        </div>
    </div>
    <?php if($transfer->status === 'pending' && auth()->user()->isRegistrar()): ?>
    <div class="d-flex gap-2">
        <form action="<?php echo e(route('transfers.approve', $transfer)); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <button class="btn btn-sm btn-success" onclick="return confirm('Approve this transfer? The ownership will be updated.')">
                <i class="bi bi-check-circle me-1"></i>Approve
            </button>
        </form>
        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
            <i class="bi bi-x-circle me-1"></i>Reject
        </button>
    </div>
    <?php endif; ?>
</div>

<div class="alert alert-<?php echo e($transfer->status_badge); ?>">
    <i class="bi bi-<?php echo e($transfer->status === 'approved' ? 'check-circle' : ($transfer->status === 'rejected' ? 'x-circle' : 'hourglass-split')); ?> me-2"></i>
    <strong><?php echo e(ucfirst($transfer->status)); ?></strong>
    <?php if($transfer->approved_at): ?> &mdash; by <?php echo e($transfer->approvedBy->name); ?> on <?php echo e($transfer->approved_at->format('d M Y')); ?> <?php endif; ?>
    <?php if($transfer->remarks): ?> &mdash; <?php echo e($transfer->remarks); ?> <?php endif; ?>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transfer Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:40%">Transfer No.</td><td class="fw-600"><?php echo e($transfer->transfer_number); ?></td></tr>
                            <tr><td class="text-muted">Property</td><td><a href="<?php echo e(route('properties.show', $transfer->property)); ?>"><?php echo e($transfer->property->survey_number); ?></a></td></tr>
                            <tr><td class="text-muted">Transfer Date</td><td><?php echo e($transfer->transfer_date->format('d M Y')); ?></td></tr>
                            <tr><td class="text-muted">Transfer Mode</td><td><?php echo e(ucwords($transfer->transfer_mode)); ?></td></tr>
                            <tr><td class="text-muted">Transfer Value</td><td class="fw-600">₹<?php echo e(number_format($transfer->transfer_value)); ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3 mb-2">
                            <div class="text-muted small mb-1">FROM</div>
                            <div class="fw-600"><?php echo e($transfer->fromOwner->full_name); ?></div>
                            <small class="text-muted"><?php echo e($transfer->fromOwner->owner_number); ?></small>
                        </div>
                        <div class="text-center"><i class="bi bi-arrow-down text-muted"></i></div>
                        <div class="border border-success rounded p-3 mt-2">
                            <div class="text-muted small mb-1">TO</div>
                            <div class="fw-600 text-success"><?php echo e($transfer->toOwner->full_name); ?></div>
                            <small class="text-muted"><?php echo e($transfer->toOwner->owner_number); ?></small>
                        </div>
                    </div>
                    <?php if($transfer->reason): ?>
                    <div class="col-12">
                        <div class="bg-light rounded p-2 small"><strong>Reason:</strong> <?php echo e($transfer->reason); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                <?php if($transfer->transfer_deed): ?>
                    <a href="<?php echo e(asset('storage/'.$transfer->transfer_deed)); ?>" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-file-pdf me-1"></i>View Transfer Deed
                    </a>
                <?php else: ?>
                    <p class="text-muted small mb-0">No deed uploaded.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><i class="bi bi-clock me-2 text-primary"></i>Submitted By</div>
            <div class="card-body">
                <div class="fw-600"><?php echo e($transfer->createdBy->name); ?></div>
                <small class="text-muted"><?php echo e($transfer->created_at->format('d M Y, h:i A')); ?></small>
            </div>
        </div>
    </div>
</div>

<?php if($transfer->status === 'pending' && auth()->user()->isRegistrar()): ?>
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('transfers.reject', $transfer)); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <div class="modal-header"><h6 class="modal-title fw-700">Reject Transfer</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <textarea name="remarks" class="form-control" rows="3" required placeholder="Reason for rejection…"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/transfers/show.blade.php ENDPATH**/ ?>