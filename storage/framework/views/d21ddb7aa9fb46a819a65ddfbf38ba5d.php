

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
        <h2>Appointments</h2>
        <style>
            .status-label {
                padding: 5px 10px;
                border-radius: 5px;
                font-weight: bold;
                color: #fff;
                text-transform: capitalize;
            }

            /* الحالات المختلفة */
            .pending {
                background-color: #ffc107;
            }

            .confirmed {
                background-color: #4dd0fa;
            }

            .cancelled {
                background-color: #dc3545;
            }
            .completed{
                background-color: #3ec055;
            }
        </style>
        <!-- عرض المواعيد في جدول -->
        <table class="table">
            <thead>
            <tr>
                <th>Patient</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?></td>
                    <td><?php echo e($appointment->appointment_date); ?></td>

                    <!-- عرض حالة الموعد -->
                    <td>
                        <?php if($appointment->status == 'pending'): ?>
                            <span class="status-label pending">Pending</span>
                        <?php elseif($appointment->status == 'confirmed'): ?>
                            <span class="status-label confirmed">Confirmed</span>
                        <?php elseif($appointment->status == 'cancelled'): ?>
                            <span class="status-label cancelled">Cancelled</span>
                        <?php elseif($appointment->status == 'completed'): ?>
                            <span class="status-label completed">Completed</span>
                        <?php endif; ?>
                    </td>

                    <!-- عرض الأزرار بناءً على حالة الموعد -->
                    <td>
                        <?php if($appointment->status == 'pending'): ?>
                            <a href="<?php echo e(route('doctor.appointments.confirm', $appointment->id)); ?>" class="btn btn-success">Confirm</a>
                            <a href="<?php echo e(route('doctor.appointments.cancel', $appointment->id)); ?>" class="btn btn-danger">Cancel</a>
                        <?php elseif($appointment->status == 'confirmed'): ?>
                            <a href="<?php echo e(route('doctor.patients.show', $appointment->patient_id)); ?>" class="btn btn-info">View Patient Profile</a>
                            <a href="<?php echo e(route('doctor.diagnoses.create', $appointment->patient_id)); ?>" class="btn btn-primary">Create Diagnosis & Prescription</a>
                        <?php elseif($appointment->status == 'cancelled'): ?>
                            <span class="text-muted">Cancelled</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\healthCare-1\resources\views/doctor/appointments/index.blade.php ENDPATH**/ ?>