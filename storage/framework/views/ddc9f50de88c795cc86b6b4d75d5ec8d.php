<?php $__env->startSection('title', 'Add New Property'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?php echo e(route('properties.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">Add New Property</h5>
        <small class="text-muted">Register a new land parcel in the system</small>
    </div>
</div>

<form action="<?php echo e(route('properties.store')); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>

<div class="row g-4">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Land Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-map me-2 text-primary"></i>Land Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Land Type <span class="text-danger">*</span></label>
                        <select name="land_type" class="form-select <?php $__errorArgs = ['land_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Select type</option>
                            <?php $__currentLoopData = ['agricultural','residential','commercial','industrial','forest','government','other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t); ?>" <?php echo e(old('land_type') == $t ? 'selected' : ''); ?>><?php echo e(ucfirst($t)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['land_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Land Use <span class="text-danger">*</span></label>
                        <select name="land_use" class="form-select <?php $__errorArgs = ['land_use'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Select use</option>
                            <?php $__currentLoopData = ['vacant'=>'Vacant','built_up'=>'Built Up','semi_built'=>'Semi Built']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($v); ?>" <?php echo e(old('land_use') == $v ? 'selected' : ''); ?>><?php echo e($l); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['land_use'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Plot Number</label>
                        <input type="text" name="plot_number" class="form-control" value="<?php echo e(old('plot_number')); ?>" placeholder="Optional">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Khasra Number</label>
                        <input type="text" name="khasra_number" class="form-control" value="<?php echo e(old('khasra_number')); ?>" placeholder="Optional">
                    </div>
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-geo-alt me-2 text-primary"></i>Location</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Village / Area</label>
                        <input type="text" name="village" class="form-control" value="<?php echo e(old('village')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Taluka <span class="text-danger">*</span></label>
                        <input type="text" name="taluka" class="form-control <?php $__errorArgs = ['taluka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('taluka')); ?>" required>
                        <?php $__errorArgs = ['taluka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">District <span class="text-danger">*</span></label>
                        <input type="text" name="district" class="form-control <?php $__errorArgs = ['district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('district')); ?>" required>
                        <?php $__errorArgs = ['district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" value="<?php echo e(old('state', 'Punjab')); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" class="form-control" value="<?php echo e(old('pincode')); ?>" maxlength="10" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-500">Address Description</label>
                        <textarea name="address_description" class="form-control" rows="2"><?php echo e(old('address_description')); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dimensions -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-rulers me-2 text-primary"></i>Dimensions</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Area (Sq.ft) <span class="text-danger">*</span></label>
                        <input type="number" name="area_sqft" class="form-control <?php $__errorArgs = ['area_sqft'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('area_sqft')); ?>" step="0.01" min="1" required>
                        <?php $__errorArgs = ['area_sqft'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Area (Acres)</label>
                        <input type="number" name="area_acres" class="form-control" value="<?php echo e(old('area_acres')); ?>" step="0.0001">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-500">Length (ft)</label>
                        <input type="number" name="length_ft" class="form-control" value="<?php echo e(old('length_ft')); ?>" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-500">Width (ft)</label>
                        <input type="number" name="width_ft" class="form-control" value="<?php echo e(old('width_ft')); ?>" step="0.01">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Valuation -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-currency-rupee me-2 text-primary"></i>Valuation</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Market Value (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="market_value" class="form-control <?php $__errorArgs = ['market_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('market_value', 0)); ?>" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-500">Government Value (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="government_value" class="form-control" value="<?php echo e(old('government_value', 0)); ?>" min="0" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-500">Valuation Year</label>
                    <input type="number" name="valuation_year" class="form-control" value="<?php echo e(old('valuation_year', date('Y'))); ?>" min="2000" max="<?php echo e(date('Y')); ?>">
                </div>
            </div>
        </div>

        <!-- Ownership -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person-check me-2 text-primary"></i>Ownership & Status</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Current Owner</label>
                    <select name="current_owner_id" class="form-select">
                        <option value="">— No Owner —</option>
                        <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($o->id); ?>" <?php echo e(old('current_owner_id') == $o->id ? 'selected' : ''); ?>>
                                <?php echo e($o->full_name); ?> (<?php echo e($o->owner_number); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-500">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <?php $__currentLoopData = ['available','registered','disputed','mortgaged','government_acquired']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e(old('status','available') == $s ? 'selected' : ''); ?>><?php echo e(ucwords(str_replace('_',' ',$s))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" name="has_disputes" class="form-check-input" id="has_disputes" value="1" <?php echo e(old('has_disputes') ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="has_disputes">Has Disputes</label>
                </div>
                <textarea name="dispute_notes" class="form-control form-control-sm" rows="2" placeholder="Dispute details (optional)"><?php echo e(old('dispute_notes')); ?></textarea>
            </div>
        </div>

        <!-- Documents -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Documents</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Site Plan</label>
                    <input type="file" name="site_plan" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">PDF/Image, max 5MB</small>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-500">Survey Document</label>
                    <input type="file" name="survey_document" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">PDF/Image, max 5MB</small>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Save Property
            </button>
            <a href="<?php echo e(route('properties.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/properties/create.blade.php ENDPATH**/ ?>