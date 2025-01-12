<?php $__env->startSection('mainContent'); ?>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- دائرة ملونة تشير إلى وجود إشعارات جديدة -->
                    <?php if($unreadNotifications > 0): ?>
                        <span class="badge badge-danger badge-counter"><?php echo e($unreadNotifications); ?></span>
                    <?php endif; ?>
                </a>
                <!-- Dropdown - Notifications -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="notificationsDropdown">
                    <h6 class="dropdown-header">
                        Notifications Center
                    </h6>
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('admin.notifications')); ?>">
                            <div class="mr-3">
                                <div class="icon-circle <?php echo e($notification->read_at ? 'bg-secondary' : 'bg-primary'); ?>">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <span class="<?php echo e($notification->read_at ? '' : 'font-weight-bold'); ?>"><?php echo e($notification->data['message']); ?></span>
                            </div>
                            <?php if(is_null($notification->read_at)): ?>
                                <form method="GET" action="<?php echo e(route('admin.notifications.read', $notification->id)); ?>" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-link text-primary">Make as read</button>
                                </form>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <a class="dropdown-item text-center small text-gray-500" href="<?php echo e(route('admin.notifications')); ?>">Show All Notifications</a>
                </div>
            </li>


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
    <div class="container-fluid">
        <?php if(session('status')): ?>
            <div class="alert alert-success">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Welcome to the Admin Dashboard</h1>

        <!-- Content Row -->
        <div class="row">

            <!-- Total Patients Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Patients</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalPatients); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Invoices Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Invoices</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalInvoices); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Appointments Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Doctors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalDoctors); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Notifications Summary Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Unread Notifications</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo e($unreadNotifications); ?>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Content Row (Recent Activity) -->
            <div class="row">
                <!-- Recent Activities Card -->
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <!-- Notifications -->
                                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <strong>Notification:</strong> <?php echo e($notification->data['message']); ?>

                                        <span class="text-muted">(<?php echo e($notification->created_at->format('d-m-Y H:i')); ?>)</span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <!-- Recent Patients -->
                                <?php $__currentLoopData = $recentPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <strong>New Patient:</strong> <?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?>

                                        <span class="text-muted">(<?php echo e($patient->created_at->format('d-m-Y')); ?>)</span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <!-- Recent Invoices -->
                                <?php $__currentLoopData = $recentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <strong>Invoice:</strong> Invoice #<?php echo e($invoice->id); ?> - $<?php echo e($invoice->total); ?>

                                        <span class="text-muted">(<?php echo e($invoice->created_at->format('d-m-Y')); ?>)</span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/admin/index.blade.php ENDPATH**/ ?>