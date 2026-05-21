<?php $__env->startSection('title', 'Properties'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Land Properties</h5>
        <p class="text-muted mb-0 small">Manage all registered land parcels</p>
    </div>
    <a href="<?php echo e(route('properties.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Property
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search survey no., district…" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <select name="district" class="form-select form-select-sm">
                    <option value="">All Districts</option>
                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d); ?>" <?php echo e(request('district') == $d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="land_type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <?php $__currentLoopData = $landTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t); ?>" <?php echo e(request('land_type') == $t ? 'selected' : ''); ?>><?php echo e(ucfirst($t)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(request('status') == $s ? 'selected' : ''); ?>><?php echo e(ucwords(str_replace('_',' ',$s))); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Filter</button>
                <a href="<?php echo e(route('properties.index')); ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Properties (<?php echo e($properties->total()); ?>)</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Survey No.</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Area (Sq.ft)</th>
                    <th>Market Value</th>
                    <th>Current Owner</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('properties.show', $p)); ?>" class="fw-600 text-decoration-none"><?php echo e($p->survey_number); ?></a>
                        <?php if($p->plot_number): ?><br><small class="text-muted">Plot: <?php echo e($p->plot_number); ?></small><?php endif; ?>
                    </td>
                    <td>
                        <div><?php echo e($p->district); ?></div>
                        <small class="text-muted"><?php echo e($p->taluka); ?>, <?php echo e($p->state); ?></small>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?php echo e($p->land_type_label); ?></span></td>
                    <td><?php echo e(number_format($p->area_sqft, 0)); ?></td>
                    <td>₹<?php echo e(number_format($p->market_value, 0)); ?></td>
                    <td>
                        <?php if($p->currentOwner): ?>
                            <a href="<?php echo e(route('owners.show', $p->currentOwner)); ?>" class="text-decoration-none small">
                                <?php echo e(Str::limit($p->currentOwner->full_name, 22)); ?>

                            </a>
                        <?php else: ?>
                            <span class="text-muted small">—</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-<?php echo e($p->status_badge); ?>"><?php echo e(ucwords(str_replace('_',' ',$p->status))); ?></span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?php echo e(route('properties.show', $p)); ?>" class="btn btn-xs btn-outline-primary" title="View" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('properties.edit', $p)); ?>" class="btn btn-xs btn-outline-secondary" title="Edit" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-pencil"></i></a>
                            <a href="<?php echo e(route('properties.certificate', $p)); ?>" class="btn btn-xs btn-outline-success" title="Certificate" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-file-pdf"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">No properties found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($properties->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($properties->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/properties/index.blade.php ENDPATH**/ ?>