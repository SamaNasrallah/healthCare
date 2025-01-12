<?php $__env->startSection('mainContent'); ?>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(\Illuminate\Support\Facades\Auth::user()->first_name); ?> <?php echo e(\Illuminate\Support\Facades\Auth::user()->last_name); ?></span>
                    <img class="img-profile rounded-circle" src="<?php echo e(asset('img/undraw_profile.svg')); ?>">
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

    <div class="container mt-5">
        <?php if($invoice): ?> <!-- Check if invoice exists -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Invoice and Prescription Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Invoice ID -->
                    <div class="col-md-6 mb-3">
                        <p><strong>Invoice ID:</strong> <span class="font-weight-bold"><?php echo e($invoice->id); ?></span></p>
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6 mb-3">
                        <p><strong>Amount:</strong> <span class="font-weight-bold text-success">$<?php echo e($invoice->amount); ?></span></p>
                    </div>

                    <!-- Issued At -->
                    <div class="col-md-6 mb-3">
                        <p><strong>Issued At:</strong> <span class="font-weight-bold"><?php echo e($invoice->issued_at); ?></span></p>
                    </div>

                    <!-- Prescription Date -->
                    <?php if($diagnosis->diagnosis): ?>
                        <div class="col-md-6 mb-3">
                            <p><strong>Prescription Date:</strong> <span class="font-weight-bold"><?php echo e($diagnosis->created_at); ?></span></p>
                        </div>

                        <!-- Dosage -->
                        <div class="col-md-6 mb-3">
                            <p><strong>Dosage:</strong> <span class="font-weight-bold"><?php echo e($diagnosis->diagnosis); ?></span></p>
                        </div>

                        <!-- Prescription -->
                        <div class="col-md-6 mb-3">
                            <p><strong>Prescription:</strong> <span class="font-weight-bold"><?php echo e($diagnosis->prescription); ?></span></p>
                        </div>
                    <?php else: ?>
                        <div class="col-md-12 mb-3">
                            <p class="text-danger font-weight-bold">No associated prescription found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Button -->
            <div class="col-md-6 mb-3">
                <button id="payNowBtn" class="btn btn-success btn-lg shadow-sm" data-invoice-id="<?php echo e($invoice->id); ?>" <?php if($invoice->status == 'paid'): ?> style="display: none;" <?php endif; ?>>
                    Pay Now
                </button>

                <?php if($invoice->status == 'paid' ): ?>
                    <span id="paidStatus" style="font-size: 18px; font-weight: bold; color: white; background-color: #28a745; padding: 10px 20px; border-radius: 30px; text-align: center; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); text-transform: uppercase; letter-spacing: 1px; display: inline-block;">
                            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>Paid
                        </span>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
            <!-- If no invoice exists, display a message -->
            <div class="alert alert-warning" role="alert">
                <strong>No invoices found!</strong> You don't have any invoices at the moment.
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var payNowBtn = document.getElementById('payNowBtn');

            if (payNowBtn) {
                payNowBtn.addEventListener('click', function() {
                    var invoiceId = this.getAttribute('data-invoice-id');

                    // Send an AJAX request to update the invoice status
                    fetch('/invoices/' + invoiceId + '/toggle-status', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({}),
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);

                            // If invoice status was successfully updated
                            if (data.message === 'Invoice marked as Paid successfully!') {
                                // Hide the "Pay Now" button
                                document.getElementById('payNowBtn').style.display = 'none';
                                // Display the "Paid" status
                                document.getElementById('paidStatus').style.display = 'inline-block';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('patient.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/patient/invoice/show.blade.php ENDPATH**/ ?>