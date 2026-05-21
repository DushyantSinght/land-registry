<?php $__env->startSection('title', 'Registrations'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Land Registrations</h5>
        <p class="text-muted mb-0 small">Manage property registration deeds</p>
    </div>
    <a href="<?php echo e(route('registrations.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Registration
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search reg. no., property, owner…" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(request('status') == $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t); ?>" <?php echo e(request('type') == $t ? 'selected' : ''); ?>><?php echo e(ucwords(str_replace('_',' ',$t))); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e(request('date_from')); ?>" placeholder="From date">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control form-control-sm" value="<?php echo e(request('date_to')); ?>" placeholder="To date">
            </div>
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">Go</button>
                <a href="<?php echo e(route('registrations.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Registrations (<?php echo e($registrations->total()); ?>)</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Reg. Number</th>
                    <th>Property</th>
                    <th>Owner</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Transaction Value</th>
                    <th>Total Fees</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('registrations.show', $reg)); ?>" class="fw-600 text-decoration-none"><?php echo e($reg->registration_number); ?></a>
                    </td>
                    <td class="small">
                        <a href="<?php echo e(route('properties.show', $reg->property)); ?>" class="text-decoration-none"><?php echo e($reg->property->survey_number); ?></a>
                        <br><span class="text-muted"><?php echo e(Str::limit($reg->property->district . ', ' . $reg->property->state, 25)); ?></span>
                    </td>
                    <td class="small">
                        <a href="<?php echo e(route('owners.show', $reg->owner)); ?>" class="text-decoration-none"><?php echo e(Str::limit($reg->owner->full_name, 22)); ?></a>
                    </td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.72rem;"><?php echo e($reg->type_label); ?></span></td>
                    <td class="small text-muted"><?php echo e($reg->registration_date->format('d M Y')); ?></td>
                    <td class="small fw-500">₹<?php echo e(number_format($reg->transaction_value)); ?></td>
                    <td class="small">₹<?php echo e(number_format($reg->total_fee)); ?></td>
                    <td><span class="badge bg-<?php echo e($reg->status_badge); ?>"><?php echo e(ucfirst($reg->status)); ?></span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?php echo e(route('registrations.show', $reg)); ?>" class="btn btn-xs btn-outline-primary" title="View" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-eye"></i></a>
                            <?php if($reg->status === 'approved'): ?>
                                <a href="<?php echo e(route('registrations.receipt', $reg)); ?>" class="btn btn-xs btn-outline-success" title="Download Receipt" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-download"></i></a>
                            <?php endif; ?>
                            <?php if($reg->status === 'pending' && auth()->user()->isRegistrar()): ?>
                                <form action="<?php echo e(route('registrations.approve', $reg)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button class="btn btn-xs btn-success" title="Approve" style="padding:2px 7px;font-size:.75rem;" onclick="return confirm('Approve this registration?')"><i class="bi bi-check"></i></button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center text-muted py-4">No registrations found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($registrations->hasPages()): ?>
    <div class="card-footer"><?php echo e($registrations->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/registrations/index.blade.php ENDPATH**/ ?>