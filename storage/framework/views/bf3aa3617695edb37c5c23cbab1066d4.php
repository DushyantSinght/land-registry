<?php $__env->startSection('title', 'Property: ' . $property->survey_number); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?php echo e(route('properties.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h5 class="fw-700 mb-0"><?php echo e($property->survey_number); ?></h5>
            <small class="text-muted"><?php echo e($property->full_location); ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('properties.certificate', $property)); ?>" class="btn btn-sm btn-success">
            <i class="bi bi-file-pdf me-1"></i>Certificate
        </a>
        <a href="<?php echo e(route('properties.edit', $property)); ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <form action="<?php echo e(route('properties.destroy', $property)); ?>" method="POST" onsubmit="return confirm('Delete this property?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- Left: Details -->
    <div class="col-lg-8">
        <!-- Info Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="text-muted small mb-1">Area</div>
                    <div class="fw-700 fs-5"><?php echo e(number_format($property->area_sqft, 0)); ?></div>
                    <div class="text-muted" style="font-size:.75rem;">Sq. Feet</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="text-muted small mb-1">Market Value</div>
                    <div class="fw-700 fs-5">₹<?php echo e(number_format($property->market_value, 0)); ?></div>
                    <div class="text-muted" style="font-size:.75rem;">As of <?php echo e($property->valuation_year); ?></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="text-muted small mb-1">Status</div>
                    <div class="fw-700 fs-5">
                        <span class="badge bg-<?php echo e($property->status_badge); ?> fs-6"><?php echo e(ucwords(str_replace('_',' ',$property->status))); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-info-circle me-2 text-primary"></i>Property Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">Survey Number</td><td class="fw-500"><?php echo e($property->survey_number); ?></td></tr>
                            <tr><td class="text-muted">Plot Number</td><td><?php echo e($property->plot_number ?? '—'); ?></td></tr>
                            <tr><td class="text-muted">Khasra No.</td><td><?php echo e($property->khasra_number ?? '—'); ?></td></tr>
                            <tr><td class="text-muted">Land Type</td><td><?php echo e($property->land_type_label); ?></td></tr>
                            <tr><td class="text-muted">Land Use</td><td><?php echo e(ucwords(str_replace('_',' ',$property->land_use))); ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:45%">Village</td><td><?php echo e($property->village ?? '—'); ?></td></tr>
                            <tr><td class="text-muted">Taluka</td><td><?php echo e($property->taluka); ?></td></tr>
                            <tr><td class="text-muted">District</td><td><?php echo e($property->district); ?></td></tr>
                            <tr><td class="text-muted">State</td><td><?php echo e($property->state); ?></td></tr>
                            <tr><td class="text-muted">Pincode</td><td><?php echo e($property->pincode); ?></td></tr>
                        </table>
                    </div>
                    <?php if($property->address_description): ?>
                    <div class="col-12">
                        <div class="bg-light rounded p-2 small text-muted"><?php echo e($property->address_description); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Dimensions & Valuation -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-rulers me-2 text-primary"></i>Dimensions & Valuation</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-3 text-center border-end">
                        <div class="text-muted small">Sq. Feet</div>
                        <div class="fw-600"><?php echo e(number_format($property->area_sqft, 2)); ?></div>
                    </div>
                    <div class="col-md-3 text-center border-end">
                        <div class="text-muted small">Sq. Meters</div>
                        <div class="fw-600"><?php echo e(number_format($property->area_sqm, 2)); ?></div>
                    </div>
                    <div class="col-md-3 text-center border-end">
                        <div class="text-muted small">Market Value</div>
                        <div class="fw-600">₹<?php echo e(number_format($property->market_value)); ?></div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="text-muted small">Govt. Value</div>
                        <div class="fw-600">₹<?php echo e(number_format($property->government_value)); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registrations -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registrations</span>
                <a href="<?php echo e(route('registrations.create')); ?>?property_id=<?php echo e($property->id); ?>" class="btn btn-sm btn-outline-primary">New Registration</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Reg. No</th><th>Type</th><th>Date</th><th>Owner</th><th>Value</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $property->registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e(route('registrations.show', $reg)); ?>" class="fw-500"><?php echo e($reg->registration_number); ?></a></td>
                            <td class="small"><?php echo e($reg->type_label); ?></td>
                            <td class="small text-muted"><?php echo e($reg->registration_date->format('d M Y')); ?></td>
                            <td class="small"><?php echo e($reg->owner->full_name); ?></td>
                            <td class="small">₹<?php echo e(number_format($reg->transaction_value)); ?></td>
                            <td><span class="badge bg-<?php echo e($reg->status_badge); ?>"><?php echo e(ucfirst($reg->status)); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center text-muted py-3">No registrations yet.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transfers -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transfer History</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Transfer No</th><th>From</th><th>To</th><th>Date</th><th>Mode</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $property->transfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><small><?php echo e($t->transfer_number); ?></small></td>
                            <td class="small"><?php echo e(Str::limit($t->fromOwner->full_name, 20)); ?></td>
                            <td class="small"><?php echo e(Str::limit($t->toOwner->full_name, 20)); ?></td>
                            <td class="small text-muted"><?php echo e($t->transfer_date->format('d M Y')); ?></td>
                            <td class="small"><?php echo e(ucwords($t->transfer_mode)); ?></td>
                            <td><span class="badge bg-<?php echo e($t->status_badge); ?>"><?php echo e(ucfirst($t->status)); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center text-muted py-3">No transfers.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Owner & Documents -->
    <div class="col-lg-4">
        <!-- Current Owner -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person-check me-2 text-primary"></i>Current Owner</div>
            <div class="card-body">
                <?php if($property->currentOwner): ?>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:48px;height:48px;background:#e0e7ff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#3730a3;font-size:1.2rem;">
                            <?php echo e(strtoupper(substr($property->currentOwner->full_name, 0, 1))); ?>

                        </div>
                        <div>
                            <div class="fw-600"><?php echo e($property->currentOwner->full_name); ?></div>
                            <small class="text-muted"><?php echo e($property->currentOwner->owner_number); ?></small>
                        </div>
                    </div>
                    <table class="table table-sm table-borderless mb-3">
                        <tr><td class="text-muted" style="width:40%">Type</td><td><?php echo e($property->currentOwner->owner_type_label); ?></td></tr>
                        <tr><td class="text-muted">Phone</td><td><?php echo e($property->currentOwner->phone); ?></td></tr>
                        <tr><td class="text-muted">ID</td><td><?php echo e($property->currentOwner->id_number); ?></td></tr>
                    </table>
                    <a href="<?php echo e(route('owners.show', $property->currentOwner)); ?>" class="btn btn-sm btn-outline-primary w-100">View Owner Profile</a>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-person-x fs-2"></i>
                        <p class="mt-2 mb-0">No owner assigned</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Documents -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        <span class="small">Site Plan</span>
                    </div>
                    <?php if($property->site_plan_url): ?>
                        <a href="<?php echo e($property->site_plan_url); ?>" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a>
                    <?php else: ?>
                        <span class="text-muted small">Not uploaded</span>
                    <?php endif; ?>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-text text-primary"></i>
                        <span class="small">Survey Document</span>
                    </div>
                    <?php if($property->survey_document): ?>
                        <a href="<?php echo e(asset('storage/'.$property->survey_document)); ?>" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a>
                    <?php else: ?>
                        <span class="text-muted small">Not uploaded</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Disputes -->
        <?php if($property->has_disputes): ?>
        <div class="card mb-4 border-danger">
            <div class="card-header text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Dispute Notice</div>
            <div class="card-body">
                <p class="small mb-0"><?php echo e($property->dispute_notes ?? 'This property has active disputes.'); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Meta -->
        <div class="card">
            <div class="card-header"><i class="bi bi-clock me-2 text-primary"></i>Record Info</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted">Created By</td><td class="small"><?php echo e($property->createdBy->name); ?></td></tr>
                    <tr><td class="text-muted">Created At</td><td class="small"><?php echo e($property->created_at->format('d M Y')); ?></td></tr>
                    <tr><td class="text-muted">Last Updated</td><td class="small"><?php echo e($property->updated_at->format('d M Y')); ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/properties/show.blade.php ENDPATH**/ ?>