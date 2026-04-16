<div class="col-lg-8 offset-2 col-md-12">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold text-danger">
                        Page Not Found (404)
                    </h6>
                    <p class="mb-2 text-sm mb-sm-0">
                        The requested page could not be loaded. It may have been moved,
                        deleted, or the link may be incorrect.
                    </p>
                </div>

                <div class="ms-auto d-flex">
                    <a href="../../app/adminRouter.php?pageid=<?php echo base64_encode('dashboard'); ?>"
                       class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Dashboard</strong>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body text-center">

            <img src="../../assets/img/404.png"
                 alt="404 Illustration"
                 style="max-width: 220px; opacity: 0.8;">

            <h4 class="mt-4 text-danger">Oops… Something went wrong</h4>

            <p class="text-sm">
                The system could not load the requested page.<br>
                If this continues, please contact the system administrator.
            </p>

            <?php if (isset($missingFile)): ?>
                <div class="alert alert-warning mt-3 text-start">
                    <strong>Missing File:</strong><br>
                    <code><?php echo htmlspecialchars($missingFile); ?></code>
                </div>
            <?php endif; ?>

            <a href="javascript:history.back()" class="btn btn-dark mt-3">
                Go Back
            </a>
        </div>
    </div>
</div>
