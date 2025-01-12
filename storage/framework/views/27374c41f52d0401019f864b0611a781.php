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
    <div class="container my-4">
        <?php if(session('status')): ?>
            <div class="alert alert-success">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <h1>Backup Options</h1>

        <p>Choose the type of backup you want to create:</p>

        <!-- Form to backup patient data -->
        <form action="<?php echo e(route('admin.backup.patientData')); ?>" method="POST" class="mb-4">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-warning">Backup Patient Data</button>
        </form>
            <!-- Form to backup patient data -->
            <form action="<?php echo e(route('admin.backup.patientDataEncrypt')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-info">Backup Patient Data (Encrypted)</button>
            </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\healthCare-1\resources\views/admin/backup/index.blade.php ENDPATH**/ ?>