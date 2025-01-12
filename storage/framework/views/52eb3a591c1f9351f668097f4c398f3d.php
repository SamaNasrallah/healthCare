<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Health Care - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Custom styles for this template-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>" rel="stylesheet">
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(route('patient.dashboard')); ?>">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Health Care</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="<?php echo e(route('patient.dashboard')); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Patient Features
        </div>

        <!-- Nav Item - Appointments -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('patient.showAppointments')); ?>">
                <i class="fas fa-fw fa-calendar-check"></i>
                <span>Appointments</span>
            </a>
        </li>

        <!-- Nav Item - Doctors -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('patient.doctors')); ?>">
                <i class="fas fa-fw fa-user-md"></i>
                <span>Doctors</span>
            </a>
        </li>

        <!-- Nav Item - Upload Documents -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('patient.uploadDocuments')); ?>">
                <i class="fas fa-fw fa-upload"></i>
                <span>Upload Documents</span>
            </a>
        </li>

        <!-- Nav Item - Medical Records -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('patient.showMedicalRecords')); ?>">
                <i class="fas fa-fw fa-file-medical-alt"></i>
                <span>Medical Records</span>
            </a>
        </li>

        <!-- Nav Item - Notifications -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('patient.notifications')); ?>">
                <i class="fas fa-fw fa-bell"></i>
                <span>Notifications</span>
            </a>
        </li>

        <!-- Nav Item - Notifications -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('patient.invoice.show')); ?>">
                <i class="fas fa-fw fa-bell"></i>
                <span>Invoices</span>
            </a>
        </li>

        <!-- Nav Item - Profile -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('patient.profile')); ?>">
                <i class="fas fa-fw fa-user"></i>
                <span>Profile</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        <!-- Nav Item - Logout -->
        <li class="nav-item">
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <?php echo $__env->yieldContent('mainContent'); ?>
        </div>


        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                <!-- نموذج مخفي لتسجيل الخروج -->
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>

                <!-- زر لتفعيل تسجيل الخروج -->
                <button class="btn btn-primary" type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript-->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="https://cdn.jsdelivr.net/npm/jquery.easing@3.0.1/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo e(asset('js/sb-admin-2.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/patient/app.blade.php ENDPATH**/ ?>