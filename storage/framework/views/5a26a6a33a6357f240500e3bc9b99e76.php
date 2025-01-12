

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

    <div class="container">
        <h1 class="mb-4">Patients</h1>

        <form method="GET" action="<?php echo e(route('doctor.patients.index')); ?>" class="d-flex mb-4">
            <input type="text" class="form-control me-2" name="search" placeholder="Search patients..." value="<?php echo e(request('search')); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- عرض المرضى الجدد -->
        <h3 class="mb-3">Recent Patients</h3>
        <?php if($recentPatients->isEmpty()): ?>
            <p>No recent patients found.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $recentPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></td>
                            <td><?php echo e($patient->email); ?></td>
                            <td><?php echo e($patient->phone_number); ?></td>
                            <td>
                                <a href="<?php echo e(route('doctor.patients.show', $patient->id)); ?>" class="btn btn-success btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($recentPatients->links()); ?>

        <?php endif; ?>

        <!-- عرض المرضى القدامى -->
        <h3 class="mb-3">Follow up Patients</h3>
        <?php if($oldPatients->isEmpty()): ?>
            <p>No Follow up  patients found.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $oldPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></td>
                            <td><?php echo e($patient->email); ?></td>
                            <td><?php echo e($patient->phone_number); ?></td>
                            <td>
                                <a href="<?php echo e(route('doctor.patients.show', $patient->id)); ?>" class="btn btn-success btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($oldPatients->links()); ?>

        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\healthCare-1\resources\views/doctor/patients/index.blade.php ENDPATH**/ ?>