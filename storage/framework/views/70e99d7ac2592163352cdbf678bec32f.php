<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">User Management</h5>
        <p class="text-muted mb-0 small">Manage system users and their roles</p>
    </div>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add User
    </a>
</div>

<div class="card">
    <div class="card-header">System Users (<?php echo e($users->total()); ?>)</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;background:#e0e7ff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#3730a3;font-size:.8rem;">
                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                            </div>
                            <span class="fw-600"><?php echo e($user->name); ?></span>
                            <?php if($user->id === auth()->id()): ?> <span class="badge bg-secondary">You</span> <?php endif; ?>
                        </div>
                    </td>
                    <td class="small"><?php echo e($user->email); ?></td>
                    <td class="small"><?php echo e($user->phone ?? '—'); ?></td>
                    <td>
                        <span class="badge <?php echo e($user->role === 'admin' ? 'bg-danger' : ($user->role === 'registrar' ? 'bg-primary' : 'bg-secondary')); ?>">
                            <?php echo e($user->role_label); ?>

                        </span>
                    </td>
                    <td><span class="badge <?php echo e($user->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($user->is_active ? 'Active' : 'Inactive'); ?></span></td>
                    <td class="small text-muted"><?php echo e($user->created_at->format('d M Y')); ?></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-xs btn-outline-primary" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-pencil"></i></a>
                            <?php if($user->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('Delete this user?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-xs btn-outline-danger" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-trash"></i></button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
    <div class="card-footer"><?php echo e($users->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/users/index.blade.php ENDPATH**/ ?>