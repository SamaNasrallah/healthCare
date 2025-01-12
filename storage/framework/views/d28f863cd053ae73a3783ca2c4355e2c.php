

<?php $__env->startSection('mainContent'); ?>
    <style>
        /* تصميم النافذة المنبثقة */
        /* تصميم النافذة المنبثقة */
        .popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ccd6ff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        .popup-content {
            display: flex;
            flex-direction: column;
        }

        .popup h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .popup p {
            margin: 5px 0;
        }

        .popup-close {
            align-self: flex-start;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            color: #3a0101;
        }

        .popup-close:hover {
            color: #c9302c;
        }



    </style>
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
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('patient.notifications')); ?>">
                            <div class="mr-3">
                                <div class="icon-circle <?php echo e($notification->read_at ? 'bg-secondary' : 'bg-primary'); ?>">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <span class="<?php echo e($notification->read_at ? '' : 'font-weight-bold'); ?>"><?php echo e($notification->data['message']); ?></span>
                            </div>
                            <?php if(is_null($notification->read_at)): ?>
                                <form method="GET" action="<?php echo e(route('patient.notifications.read', $notification->id)); ?>" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-link text-primary">Make as read</button>
                                </form>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <a class="dropdown-item text-center small text-gray-500" href="<?php echo e(route('patient.notifications')); ?>">Show All Notifications</a>
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
    <div class="container-fluid">
        <!-- Topbar -->


        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h1 class="h3 mb-4 text-gray-800">Welcome, <?php echo e(\Illuminate\Support\Facades\Auth::user()->first_name); ?>!</h1>
                        <p class="lead">You are logged in as a patient.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patient's Statistics Section -->





        <!-- Row for Patient's Actions -->
        <div class="row">
            <!-- Upload Document Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Upload Medical Documents</h5>
                        <p class="card-text">Upload medical reports or images for review or consultation.</p>
                        <a href="<?php echo e(route('patient.uploadDocuments')); ?>" class="btn btn-primary">Upload Documents</a>
                    </div>
                </div>
            </div>

            <!-- View Medical Records Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">View Medical Records</h5>
                        <p class="card-text">Access your past medical records and reports for review.</p>
                        <a href="<?php echo e(route('patient.showMedicalRecords')); ?>" class="btn btn-warning">View Medical Records</a>
                    </div>
                </div>
            </div>

            <!-- View Doctors Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">View Doctors</h5>
                        <p class="card-text">Choose a doctor based on your condition and availability.</p>
                        <a href="<?php echo e(route('patient.doctors')); ?>" class="btn btn-info">View Doctors</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow h-100 py-2" style="background-color: #ffffff;">
                    <div class="card-body">
                        <h5 class="card-title">Reminder</h5>
                        <p class="card-text">
                            Don't forget to check your upcoming appointments regularly to stay on track with your health plan.
                        </p>
                        <a href="<?php echo e(route('patient.showAppointments')); ?>" class="btn btn-primary btn-sm mt-2">View Appointments</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- نافذة منبثقة للإعلان (في الجانب الأيمن السفلي) -->
        <div id="popup" class="popup" style="display:none;">
            <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">×</span>
                <h4 id="popup-title"></h4>
                <p id="popup-content"></p>
            </div>
        </div>

    </div>
    <script>
        // إرسال الإعلان إلى JavaScript من خلال Blade
        var advertisement = <?php echo json_encode($advertisement, 15, 512) ?>;
    </script>

    <!-- HTML لجعل الـ popup يظهر -->
    <script>
        window.onload = function() {
            setInterval(function() {
                if (advertisement) {
                    var title = advertisement.title;
                    var content = advertisement.content;
                    showPopup(title, content);
                }
            }, 5000); // عرض الإعلان كل 5 ثوانٍ (يمكنك تغيير هذه الفترة)
        };

        function showPopup(title, content) {
            const popup = document.createElement('div');
            popup.classList.add('popup');
            popup.innerHTML = `
            <div class="popup-content">
                <h3>${title}</h3>
                <p>${content}</p>
                <span class="popup-close" onclick="closePopup(this)">x</span>
            </div>
        `;
            document.body.appendChild(popup);
        }

        function closePopup(button) {
            const popup = button.closest('.popup');
            popup.remove();
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('patient.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/patient/index.blade.php ENDPATH**/ ?>