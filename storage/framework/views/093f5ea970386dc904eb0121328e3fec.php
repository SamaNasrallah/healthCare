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
        <h1 class="text-center mb-4">Doctors Management</h1>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Add Doctor Button -->
        <div class="text-right mb-4">
            <a href="<?php echo e(route('admin.doctors.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Create New Doctor Account
            </a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Specialization</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">License Number</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=0; ?>
            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $i++;?>
                <tr>
                    <th scope="row"><?php echo e($i); ?></th>
                    <td><?php echo e($doctor->first_name); ?> <?php echo e($doctor->last_name); ?></td>
                    <td><?php echo e($doctor->specialization); ?></td>
                    <td><?php echo e($doctor->email); ?></td>
                    <td><?php echo e($doctor->phone_number ?? 'N/A'); ?></td>
                    <td><?php echo e($doctor->license_number); ?></td>
                    <td>
                        <?php if($doctor->user->is_active): ?>
                            <span class="badge badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Show "Activate" button only if the doctor is inactive -->
                        <?php if(!$doctor->user->is_active): ?>
                            <form action="<?php echo e(route('admin.doctors.toggleStatus', $doctor)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button type="submit" class="btn btn-sm btn-success"
                                        onclick="return confirm('Are you sure you want to activate this account?')">
                                    <i class="fas fa-toggle-on"></i> Activate
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Edit button -->
                        <a href="<?php echo e(route('admin.doctors.edit', $doctor)); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Delete button -->
                        <form action="<?php echo e(route('admin.doctors.destroy', $doctor)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/admin/doctors/index.blade.php ENDPATH**/ ?>