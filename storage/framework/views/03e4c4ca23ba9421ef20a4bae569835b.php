<?php $__env->startSection('title', 'New Registration'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?php echo e(route('registrations.index')); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="fw-700 mb-0">New Land Registration</h5>
        <small class="text-muted">Submit a new deed registration request</small>
    </div>
</div>

<form action="<?php echo e(route('registrations.store')); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<div class="row g-4">
    <div class="col-lg-8">
        <!-- Property & Owner -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-link me-2 text-primary"></i>Property & Owner</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Property <span class="text-danger">*</span></label>
                        <select name="property_id" class="form-select <?php $__errorArgs = ['property_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Select Property —</option>
                            <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>" <?php echo e((old('property_id', request('property_id')) == $p->id) ? 'selected' : ''); ?>>
                                    <?php echo e($p->survey_number); ?> — <?php echo e($p->district); ?>

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
                        <label class="form-label fw-500">Owner (Applicant) <span class="text-danger">*</span></label>
                        <select name="owner_id" class="form-select <?php $__errorArgs = ['owner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Select Owner —</option>
                            <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($o->id); ?>" <?php echo e(old('owner_id') == $o->id ? 'selected' : ''); ?>>
                                    <?php echo e($o->full_name); ?> (<?php echo e($o->owner_number); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['owner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Registration Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Registration Type <span class="text-danger">*</span></label>
                        <select name="registration_type" class="form-select <?php $__errorArgs = ['registration_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Select Type —</option>
                            <?php $__currentLoopData = ['first_registration','sale_deed','gift_deed','will_deed','partition_deed','lease_deed','mortgage_deed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t); ?>" <?php echo e(old('registration_type') == $t ? 'selected' : ''); ?>><?php echo e(ucwords(str_replace('_',' ',$t))); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['registration_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Sub-Registrar Office <span class="text-danger">*</span></label>
                        <input type="text" name="sub_registrar_office" class="form-control <?php $__errorArgs = ['sub_registrar_office'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('sub_registrar_office')); ?>" required>
                        <?php $__errorArgs = ['sub_registrar_office'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Registration Date <span class="text-danger">*</span></label>
                        <input type="date" name="registration_date" class="form-control <?php $__errorArgs = ['registration_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('registration_date', date('Y-m-d'))); ?>" required>
                        <?php $__errorArgs = ['registration_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Execution Date</label>
                        <input type="date" name="execution_date" class="form-control" value="<?php echo e(old('execution_date')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Document Number</label>
                        <input type="text" name="document_number" class="form-control" value="<?php echo e(old('document_number')); ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-currency-rupee me-2 text-primary"></i>Financial Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-500">Transaction Value (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="transaction_value" id="transaction_value" class="form-control" value="<?php echo e(old('transaction_value', 0)); ?>" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Stamp Duty (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="stamp_duty" id="stamp_duty" class="form-control" value="<?php echo e(old('stamp_duty', 0)); ?>" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500">Registration Fee (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="registration_fee" id="registration_fee" class="form-control" value="<?php echo e(old('registration_fee', 0)); ?>" min="0" step="0.01" required>
                    </div>
                    <div class="col-12">
                        <div class="bg-primary bg-opacity-10 rounded p-3 d-flex justify-content-between align-items-center">
                            <span class="fw-600 text-primary">Total Payable Fees</span>
                            <span class="fw-700 fs-5 text-primary" id="total_fee">₹0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Witness Details -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-people me-2 text-primary"></i>Witness Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 1 Name</label>
                        <input type="text" name="witness1_name" class="form-control" value="<?php echo e(old('witness1_name')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 1 ID</label>
                        <input type="text" name="witness1_id" class="form-control" value="<?php echo e(old('witness1_id')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 2 Name</label>
                        <input type="text" name="witness2_name" class="form-control" value="<?php echo e(old('witness2_name')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Witness 2 ID</label>
                        <input type="text" name="witness2_id" class="form-control" value="<?php echo e(old('witness2_id')); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="col-lg-4">
        <!-- Remarks -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-chat-left-text me-2 text-primary"></i>Remarks</div>
            <div class="card-body">
                <textarea name="remarks" class="form-control" rows="4" placeholder="Additional remarks…"><?php echo e(old('remarks')); ?></textarea>
            </div>
        </div>

        <!-- Document Uploads -->
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-paperclip me-2 text-primary"></i>Upload Documents</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-500">Deed Document (PDF)</label>
                    <input type="file" name="deed_document" class="form-control form-control-sm" accept=".pdf">
                    <small class="text-muted">Max 10MB</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-500">Supporting Document 1</label>
                    <input type="file" name="supporting_doc1" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-500">Supporting Document 2</label>
                    <input type="file" name="supporting_doc2" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-2"></i>Submit Registration
            </button>
            <a href="<?php echo e(route('registrations.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function updateTotal() {
    const stamp = parseFloat(document.getElementById('stamp_duty').value) || 0;
    const fee   = parseFloat(document.getElementById('registration_fee').value) || 0;
    document.getElementById('total_fee').textContent = '₹' + (stamp + fee).toLocaleString('en-IN');
}
// Auto-calculate stamp duty (approx 4% of transaction value)
document.getElementById('transaction_value').addEventListener('input', function () {
    const val = parseFloat(this.value) || 0;
    document.getElementById('stamp_duty').value = (val * 0.04).toFixed(2);
    document.getElementById('registration_fee').value = (val * 0.01).toFixed(2);
    updateTotal();
});
document.getElementById('stamp_duty').addEventListener('input', updateTotal);
document.getElementById('registration_fee').addEventListener('input', updateTotal);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/registrations/create.blade.php ENDPATH**/ ?>