<?php $__env->startSection('title', 'Owners Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0">Owners Report</h5>
            <small class="text-muted">All registered land holders</small>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Owners (<?php echo e($owners->total()); ?>)</div>
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
            <?php $__empty_1 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-600 text-muted"><?php echo e($owner->owner_number); ?></td>
                    <td><a href="<?php echo e(route('owners.show', $owner)); ?>" class="fw-600 text-decoration-none"><?php echo e($owner->full_name); ?></a></td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.7rem;"><?php echo e($owner->owner_type_label); ?></span></td>
                    <td class="text-muted"><?php echo e($owner->id_number); ?></td>
                    <td><?php echo e($owner->phone); ?></td>
                    <td><?php echo e($owner->city); ?>, <?php echo e($owner->state); ?></td>
                    <td>
                        <span class="badge bg-primary"><?php echo e($owner->properties_count); ?></span>
                    </td>
                    <td><span class="badge <?php echo e($owner->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($owner->is_active ? 'Active' : 'Inactive'); ?></span></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">No owners found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($owners->hasPages()): ?>
    <div class="card-footer"><?php echo e($owners->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/reports/owners.blade.php ENDPATH**/ ?>