<?php $__env->startSection('title', 'Land Owners'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Land Owners</h5>
        <p class="text-muted mb-0 small">All registered land holders</p>
    </div>
    <a href="<?php echo e(route('owners.create')); ?>" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add Owner
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name, ID number, owner number, phone…" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="individual" <?php echo e(request('type') === 'individual' ? 'selected' : ''); ?>>Individual</option>
                    <option value="company" <?php echo e(request('type') === 'company' ? 'selected' : ''); ?>>Company / Firm</option>
                    <option value="government" <?php echo e(request('type') === 'government' ? 'selected' : ''); ?>>Government</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="<?php echo e(route('owners.index')); ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Owners (<?php echo e($owners->total()); ?>)</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Owner</th>
                    <th>Type</th>
                    <th>ID Number</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Properties</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:36px;height:36px;background:#dbeafe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#1d4ed8;font-size:.85rem;flex-shrink:0;">
                                <?php echo e(strtoupper(substr($owner->full_name, 0, 1))); ?>

                            </div>
                            <div>
                                <a href="<?php echo e(route('owners.show', $owner)); ?>" class="fw-600 text-decoration-none d-block"><?php echo e($owner->full_name); ?></a>
                                <small class="text-muted"><?php echo e($owner->owner_number); ?></small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?php echo e($owner->owner_type_label); ?></span></td>
                    <td class="small text-muted"><?php echo e($owner->id_number); ?></td>
                    <td class="small">
                        <?php echo e($owner->phone); ?>

                        <?php if($owner->email): ?><br><span class="text-muted"><?php echo e($owner->email); ?></span><?php endif; ?>
                    </td>
                    <td class="small"><?php echo e($owner->city); ?>, <?php echo e($owner->state); ?></td>
                    <td>
                        <a href="<?php echo e(route('owners.properties', $owner)); ?>" class="badge bg-primary text-decoration-none">
                            <?php echo e($owner->properties_count ?? $owner->properties->count()); ?> props
                        </a>
                    </td>
                    <td>
                        <span class="badge <?php echo e($owner->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                            <?php echo e($owner->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?php echo e(route('owners.show', $owner)); ?>" class="btn btn-xs btn-outline-primary" title="View" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('owners.edit', $owner)); ?>" class="btn btn-xs btn-outline-secondary" title="Edit" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-pencil"></i></a>
                        </div>
                    </td>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/owners/index.blade.php ENDPATH**/ ?>