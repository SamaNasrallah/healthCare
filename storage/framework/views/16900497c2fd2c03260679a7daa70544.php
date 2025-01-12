<?php $__env->startSection('mainContent'); ?>
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
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div class="container mt-4">

        <h2>Notifications</h2>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="notification mb-4 p-4 border rounded shadow-sm bg-light">
                <div class="d-flex justify-content-between">
                    <!-- محتويات الإشعار على اليسار -->
                    <div>
                        <p class="font-weight-bold"><?php echo e($notification->data['message']); ?></p>
                        <small class="text-muted d-block mb-2">Created at: <?php echo e($notification->created_at->format('Y-m-d H:i:s')); ?></small>
                        <?php if(array_key_exists('url', $notification->data)): ?>
                            <p><a href="<?php echo e($notification->data['url']); ?>">View Details</a></p>
                        <?php endif; ?>

                    </div>

                    <!-- حالة الإشعار وزر "Mark as Read" على اليمين -->
                    <div class="text-right">
                        <?php if($notification->read_at): ?>
                            <span class="badge badge-success mr-2">Read</span> <!-- إشعار مقروء -->
                        <?php else: ?>
                            <span class="badge badge-warning mr-2">Unread</span> <!-- إشعار غير مقروء -->
                        <?php endif; ?>

                        <!-- زر "Mark as Read" في نفس السطر -->
                        <?php if(is_null($notification->read_at)): ?>
                            <a href="<?php echo e(route('admin.notifications.read', $notification->id)); ?>" class="btn btn-primary btn-sm">Mark as Read</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\healthCare-1\resources\views/admin/notifications.blade.php ENDPATH**/ ?>