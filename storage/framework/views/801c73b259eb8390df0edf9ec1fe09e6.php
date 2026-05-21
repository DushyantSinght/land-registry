<?php $__env->startSection('title', 'New Transfer'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?php echo e(route('transfers.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">New Ownership Transfer</h5>
        <small class="text-muted">Transfer property ownership to another party</small>
    </div>
</div>

<form action="<?php echo e(route('transfers.store')); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transfer Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-500">Property <span class="text-danger">*</span></label>
                        <select name="property_id" class="form-select <?php $__errorArgs = ['property_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required id="property_select">
                            <option value="">— Select Registered Property —</option>
                            <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>" data-owner="<?php echo e($p->current_owner_id); ?>" <?php echo e(old('property_id') == $p->id ? 'selected' : ''); ?>>
                                    <?php echo e($p->survey_number); ?> — <?php echo e($p->district); ?> (Owner: <?php echo e($p->currentOwner?->full_name ?? 'None'); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['property_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Transferring From <span class="text-danger">*</span></label>
                        <select name="from_owner_id" class="form-select <?php $__errorArgs = ['from_owner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Select Current Owner —</option>
                            <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($o->id); ?>" <?php echo e(old('from_owner_id') == $o->id ? 'selected' : ''); ?>>
                                    <?php echo e($o->full_name); ?> (<?php echo e($o->owner_number); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['from_owner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Transferring To <span class="text-danger">*</span></label>
                        <select name="to_owner_id" class="form-select <?php $__errorArgs = ['to_owner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Select New Owner —</option>
                            <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($o->id); ?>" <?php echo e(old('to_owner_id') == $o->id ? 'selected' : ''); ?>>
                                    <?php echo e($o->full_name); ?> (<?php echo e($o->owner_number); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['to_owner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transfer Date <span class="text-danger">*</span></label>
                        <input type="date" name="transfer_date" class="form-control" value="<?php echo e(old('transfer_date', date('Y-m-d'))); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transfer Mode <span class="text-danger">*</span></label>
                        <select name="transfer_mode" class="form-select" required>
                            <option value="">— Select —</option>
                            <?php $__currentLoopData = ['Sale' => 'sale', 'Gift' => 'gift', 'Inheritance' => 'inheritance', 'Court Order' => 'court_order', 'Exchange' => 'exchange']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(old('transfer_mode') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transfer Value (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="transfer_value" class="form-control" value="<?php echo e(old('transfer_value', 0)); ?>" min="0" step="0.01" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-500">Reason / Notes</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Reason for transfer…"><?php echo e(old('reason')); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Transfer Deed</div>
            <div class="card-body">
                <input type="file" name="transfer_deed" class="form-control form-control-sm" accept=".pdf">
                <small class="text-muted">PDF only, max 10MB</small>
            </div>
        </div>
        <div class="alert alert-info small">
            <i class="bi bi-info-circle me-1"></i>
            Transfer will be <strong>pending</strong> until approved by a Registrar. On approval, the property ownership will be updated automatically.
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-send me-2"></i>Submit Transfer</button>
            <a href="<?php echo e(route('transfers.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/transfers/create.blade.php ENDPATH**/ ?>