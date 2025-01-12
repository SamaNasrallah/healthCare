<?php $__env->startSection('mainContent'); ?>
    <style>
        .status-label {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            color: #fff;
            text-transform: capitalize;
        }

        /* الحالات المختلفة */
        .status-label.pending {
            background-color: #ffc107; /* لون أصفر */
        }

        .status-label.confirmed {
            background-color: #4dd0fa;
        }
        .status-label.cancelled {
            background-color: #dc3545; /* لون أحمر */
        }
        .status-label.completed {
            background-color: #3ec055;
        }


    </style>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(\Illuminate\Support\Facades\Auth::user()->first_name); ?> <?php echo e(\Illuminate\Support\Facades\Auth::user()->last_name); ?></span>
                    <img class="img-profile rounded-circle"
                         src="<?php echo e(asset('img/undraw_profile.svg')); ?>">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?php echo e(route('patient.profile')); ?>">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
<div class="container">

    <h1>Your Appointments</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Doctor</th>
            <th>Specialization</th>
            <th>Appointment Time</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($appointment->doctor->first_name); ?> <?php echo e($appointment->doctor->last_name); ?></td>
                <td><?php echo e($appointment->doctor->specialization); ?></td>
                <td><?php echo e($appointment->appointment_date); ?></td>
                <td>
                    <span class="status-label <?php echo e(strtolower($appointment->status)); ?>">
                    <?php echo e(ucfirst($appointment->status)); ?>

                    </span>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('patient.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\healthCare-1\resources\views/patient/showAppointments.blade.php ENDPATH**/ ?>