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

    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Patient Details</h2>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo e($doctor->first_name); ?> <?php echo e($doctor->last_name); ?></p>
                <p><strong>Email:</strong> <?php echo e($doctor->email); ?></p>
                <p><strong>Phone:</strong> <?php echo e($doctor->phone_number); ?></p>
                <p><strong>Specialization:</strong> <?php echo e($doctor->specialization); ?></p>
                <p><strong>License_number:</strong> <?php echo e($doctor->license_number); ?></p>
                <p><strong>Experience_years:</strong> <?php echo e($doctor->experience_years); ?></p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/doctor/profile.blade.php ENDPATH**/ ?>