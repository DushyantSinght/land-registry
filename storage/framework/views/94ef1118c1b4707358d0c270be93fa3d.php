<?php $__env->startSection('title', 'Transfers'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Ownership Transfers</h5>
        <p class="text-muted mb-0 small">Manage land title transfer requests</p>
    </div>
    <a href="<?php echo e(route('transfers.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Transfer
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="<?php echo e(route('transfers.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Transfers (<?php echo e($transfers->total()); ?>)</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Transfer No.</th><th>Property</th><th>From Owner</th><th>To Owner</th><th>Date</th><th>Mode</th><th>Value</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><a href="<?php echo e(route('transfers.show', $t)); ?>" class="fw-600 text-decoration-none small"><?php echo e($t->transfer_number); ?></a></td>
                    <td class="small"><a href="<?php echo e(route('properties.show', $t->property)); ?>" class="text-decoration-none"><?php echo e($t->property->survey_number); ?></a></td>
                    <td class="small"><?php echo e(Str::limit($t->fromOwner->full_name, 20)); ?></td>
                    <td class="small"><?php echo e(Str::limit($t->toOwner->full_name, 20)); ?></td>
                    <td class="small text-muted"><?php echo e($t->transfer_date->format('d M Y')); ?></td>
                    <td class="small"><?php echo e(ucwords($t->transfer_mode)); ?></td>
                    <td class="small fw-500">₹<?php echo e(number_format($t->transfer_value)); ?></td>
                    <td><span class="badge bg-<?php echo e($t->status_badge); ?>"><?php echo e(ucfirst($t->status)); ?></span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?php echo e(route('transfers.show', $t)); ?>" class="btn btn-xs btn-outline-primary" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            <?php if($t->status === 'pending' && auth()->user()->isRegistrar()): ?>
                                <form action="<?php echo e(route('transfers.approve', $t)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button class="btn btn-xs btn-success" style="padding:2px 7px;font-size:.75rem;" onclick="return confirm('Approve transfer?')"><i class="bi bi-check"></i></button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center text-muted py-4">No transfers found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($transfers->hasPages()): ?>
    <div class="card-footer"><?php echo e($transfers->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/transfers/index.blade.php ENDPATH**/ ?>