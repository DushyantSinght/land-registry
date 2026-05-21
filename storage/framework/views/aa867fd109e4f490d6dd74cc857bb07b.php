<?php $__env->startSection('title', $owner->full_name); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?php echo e(route('owners.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0"><?php echo e($owner->full_name); ?></h5>
            <small class="text-muted"><?php echo e($owner->owner_number); ?> &bull; <?php echo e($owner->owner_type_label); ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('owners.edit', $owner)); ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card mb-4">
            <div class="card-body text-center p-4">
                <div style="width:80px;height:80px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:2rem;margin:0 auto 16px;">
                    <?php echo e(strtoupper(substr($owner->full_name, 0, 1))); ?>

                </div>
                <h6 class="fw-700 mb-1"><?php echo e($owner->full_name); ?></h6>
                <p class="text-muted small mb-2"><?php echo e($owner->owner_number); ?></p>
                <span class="badge bg-primary"><?php echo e($owner->owner_type_label); ?></span>
                <span class="badge <?php echo e($owner->is_active ? 'bg-success' : 'bg-secondary'); ?> ms-1"><?php echo e($owner->is_active ? 'Active' : 'Inactive'); ?></span>

                <hr>
                <div class="text-start">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-telephone text-muted"></i>
                        <span class="small"><?php echo e($owner->phone); ?></span>
                    </div>
                    <?php if($owner->email): ?>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-envelope text-muted"></i>
                        <span class="small"><?php echo e($owner->email); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt text-muted"></i>
                        <span class="small"><?php echo e($owner->address); ?>, <?php echo e($owner->city); ?>, <?php echo e($owner->state); ?> - <?php echo e($owner->pincode); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ID Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-card-text me-2 text-primary"></i>Identity Details</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted" style="width:40%">ID Type</td><td><?php echo e(ucwords(str_replace('_',' ',$owner->id_type))); ?></td></tr>
                    <tr><td class="text-muted">ID Number</td><td class="fw-600"><?php echo e($owner->id_number); ?></td></tr>
                    <tr><td class="text-muted">DOB</td><td><?php echo e($owner->date_of_birth?->format('d M Y') ?? '—'); ?></td></tr>
                    <?php if($owner->date_of_birth): ?><tr><td class="text-muted">Age</td><td><?php echo e($owner->age); ?> years</td></tr><?php endif; ?>
                    <tr><td class="text-muted">Nationality</td><td><?php echo e($owner->nationality); ?></td></tr>
                </table>
                <?php if($owner->id_document): ?>
                <a href="<?php echo e(asset('storage/'.$owner->id_document)); ?>" target="_blank" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    <i class="bi bi-file-earmark me-1"></i>View ID Document
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Properties -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-map me-2 text-primary"></i>Owned Properties (<?php echo e($owner->properties->count()); ?>)</span>
                <a href="<?php echo e(route('properties.create')); ?>" class="btn btn-sm btn-outline-primary">Add Property</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Survey No.</th><th>Type</th><th>Location</th><th>Area (Sqft)</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $owner->properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e(route('properties.show', $p)); ?>" class="fw-600"><?php echo e($p->survey_number); ?></a></td>
                            <td class="small"><?php echo e($p->land_type_label); ?></td>
                            <td class="small"><?php echo e($p->district); ?>, <?php echo e($p->state); ?></td>
                            <td class="small"><?php echo e(number_format($p->area_sqft)); ?></td>
                            <td><span class="badge bg-<?php echo e($p->status_badge); ?>"><?php echo e(ucwords(str_replace('_',' ',$p->status))); ?></span></td>
                            <td><a href="<?php echo e(route('properties.show', $p)); ?>" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center text-muted py-3">No properties.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Registrations -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registration History</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Reg. No.</th><th>Property</th><th>Type</th><th>Date</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $owner->registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e(route('registrations.show', $reg)); ?>" class="fw-500 small"><?php echo e($reg->registration_number); ?></a></td>
                            <td class="small"><?php echo e($reg->property->survey_number); ?></td>
                            <td class="small text-muted"><?php echo e($reg->type_label); ?></td>
                            <td class="small text-muted"><?php echo e($reg->registration_date->format('d M Y')); ?></td>
                            <td><span class="badge bg-<?php echo e($reg->status_badge); ?>"><?php echo e(ucfirst($reg->status)); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">No registrations.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/owners/show.blade.php ENDPATH**/ ?>