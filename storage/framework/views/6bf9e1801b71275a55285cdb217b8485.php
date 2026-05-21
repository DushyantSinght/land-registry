<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1a56db,#3b82f6)">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value"><?php echo e(number_format($stats['total_properties'])); ?></div>
                    <div class="stat-label">Total Properties</div>
                </div>
                <div class="stat-icon"><i class="bi bi-map"></i></div>
            </div>
            <div class="mt-2" style="font-size:.76rem;opacity:.8;">
                <?php echo e($stats['registered']); ?> Registered &bull; <?php echo e($stats['available']); ?> Available
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#059669,#10b981)">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value"><?php echo e(number_format($stats['total_owners'])); ?></div>
                    <div class="stat-label">Registered Owners</div>
                </div>
                <div class="stat-icon"><i class="bi bi-people"></i></div>
            </div>
            <div class="mt-2" style="font-size:.76rem;opacity:.8;">Land Holders on Record</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#d97706,#f59e0b)">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value"><?php echo e(number_format($stats['pending_registrations'])); ?></div>
                    <div class="stat-label">Pending Approvals</div>
                </div>
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
            </div>
            <div class="mt-2" style="font-size:.76rem;opacity:.8;">
                <?php echo e($stats['approved_registrations']); ?> Approved Total
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#7c3aed,#8b5cf6)">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value">₹<?php echo e(number_format(($stats['total_stamp_duty'] + $stats['total_reg_fee']) / 100000, 1)); ?>L</div>
                    <div class="stat-label">Revenue Collected</div>
                </div>
                <div class="stat-icon"><i class="bi bi-currency-rupee"></i></div>
            </div>
            <div class="mt-2" style="font-size:.76rem;opacity:.8;">Stamp Duty + Reg. Fees</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Land Type Chart -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-pie-chart me-2 text-primary"></i>Properties by Land Type</span>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="landTypeChart" style="max-height:220px;"></canvas>
            </div>
        </div>
    </div>
    <!-- Monthly Registrations Chart -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2 text-primary"></i>Monthly Registrations (Last 6 Months)
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" style="max-height:220px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Pending Registrations -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2 text-warning"></i>Pending Registrations</span>
                <a href="<?php echo e(route('registrations.index', ['status'=>'pending'])); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Reg. No</th>
                                <th>Property</th>
                                <th>Owner</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pendingRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><span class="badge bg-warning text-dark"><?php echo e($reg->registration_number); ?></span></td>
                                <td class="small"><?php echo e($reg->property->survey_number); ?></td>
                                <td class="small"><?php echo e(Str::limit($reg->owner->full_name, 20)); ?></td>
                                <td class="small text-muted"><?php echo e($reg->registration_date->format('d M Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('registrations.show', $reg)); ?>" class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:2px 8px;">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center text-muted py-3">No pending registrations</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transfers -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-arrow-left-right me-2 text-info"></i>Recent Transfers</span>
                <a href="<?php echo e(route('transfers.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ref</th>
                                <th>Property</th>
                                <th>From → To</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentTransfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><small class="text-muted"><?php echo e($t->transfer_number); ?></small></td>
                                <td class="small"><?php echo e($t->property->survey_number); ?></td>
                                <td class="small"><?php echo e(Str::limit($t->fromOwner->full_name, 12)); ?> → <?php echo e(Str::limit($t->toOwner->full_name, 12)); ?></td>
                                <td><span class="badge bg-<?php echo e($t->status_badge); ?>"><?php echo e(ucfirst($t->status)); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No transfers yet</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Land Type Doughnut
const ltCtx = document.getElementById('landTypeChart').getContext('2d');
new Chart(ltCtx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($landTypes->keys()->map(fn($k) => ucwords(str_replace('_',' ',$k)))->values()); ?>,
        datasets: [{
            data: <?php echo json_encode($landTypes->values()); ?>,
            backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#84cc16'],
            borderWidth: 2,
        }]
    },
    options: { plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }, cutout: '65%' }
});

// Monthly registrations bar
const mrCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(mrCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($monthlyRegs->keys()); ?>,
        datasets: [{
            label: 'Registrations',
            data: <?php echo json_encode($monthlyRegs->values()); ?>,
            backgroundColor: 'rgba(59,130,246,.7)',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dushyantsinghtanwar/coding/land-registry/resources/views/dashboard/index.blade.php ENDPATH**/ ?>