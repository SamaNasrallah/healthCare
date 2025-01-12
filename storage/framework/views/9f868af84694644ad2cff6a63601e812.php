<?php $__env->startSection('mainContent'); ?>

    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <!-- User Info Dropdown -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(\Illuminate\Support\Facades\Auth::user()->first_name); ?> <?php echo e(\Illuminate\Support\Facades\Auth::user()->last_name); ?></span>
                    <img class="img-profile rounded-circle"
                         src="<?php echo e(asset('img/undraw_profile.svg')); ?>">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="userDropdown">

                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div class="container my-5">
        <h1 class="text-center mb-4">Invoices Management</h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Issued At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($invoice->id); ?></td>
                    <td><?php echo e($invoice->patient->first_name); ?> <?php echo e($invoice->patient->last_name); ?></td>
                    <td>$<?php echo e($invoice->amount); ?></td>
                    <td>
                        <span class="badge badge-<?php echo e($invoice->status === 'paid' ? 'success' : 'warning'); ?>">
                            <?php echo e($invoice->status); ?>

                        </span>
                    </td>
                    <td><?php echo e($invoice->issued_at ? $invoice->issued_at : 'N/A'); ?></td>
                    <td>
                        <!-- Toggle Status -->
                        <?php if($invoice->status === 'paid'): ?>

                        <?php else: ?>
                            <form action="<?php echo e(route('admin.invoices.toggleStatus', $invoice->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-toggle-on"></i> Mark Paid
                                </button>
                            </form>
                        <?php endif; ?>


                        <!-- Delete -->
                        <form action="<?php echo e(route('admin.invoices.destroy', $invoice)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/admin/invoices/index.blade.php ENDPATH**/ ?>