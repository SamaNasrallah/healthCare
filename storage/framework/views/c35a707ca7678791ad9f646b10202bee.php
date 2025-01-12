

<?php $__env->startSection('mainContent'); ?>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <!-- User Info Dropdown -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php echo e(\Illuminate\Support\Facades\Auth::user()->first_name); ?> <?php echo e(\Illuminate\Support\Facades\Auth::user()->last_name); ?>

                    <br>
                    <small class="text-muted"><?php echo e(\Illuminate\Support\Facades\Auth::user()->doctor->specialization); ?></small> <!-- التخصص -->
                </span>
                    <img class="img-profile rounded-circle" src="<?php echo e(asset('img/undraw_profile.svg')); ?>">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?php echo e(route('doctor.profile')); ?>">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
    <div class="container py-4">
        <h1>Diagnoses & Prescriptions</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Patient</th>
                <th>Diagnosis</th>
                <th>Prescription</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $diagnoses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diagnosis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($diagnosis->patient->first_name); ?> <?php echo e($diagnosis->patient->last_name); ?></td>
                    <td><?php echo e(Str::limit($diagnosis->diagnosis, 50)); ?></td>
                    <td><?php echo e(Str::limit($diagnosis->prescription, 50)); ?></td>
                    <td>
                        <a href="<?php echo e(route('doctor.diagnosis.show', $diagnosis->id)); ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">No diagnoses found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php echo e($diagnoses->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/doctor/diagnosis/index.blade.php ENDPATH**/ ?>