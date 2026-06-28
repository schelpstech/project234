<?php
include './inc/header.php';
include './inc/nav.php';
include './inc/navbar.php';
?>


<main class="main-content position-relative border-radius-lg ">
    <div class="px-5 py-4 container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mx-2 mb-3 d-md-flex align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h5 class="mb-0 font-weight-bold">Admin:
                            <?php echo $utility->escape($_SESSION['activeAdmin'] ?? '') ?>
                        </h5>

                    </div>
                    <button type="button"
                        class="mb-0 mb-2 btn btn-sm btn-white btn-icon d-flex align-items-center ms-md-auto mb-sm-0 me-2">
                        <span class="btn-inner--icon">
                            <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                <span class="visually-hidden">New</span>
                            </span>
                        </span>
                        <span class="btn-inner--text">Session: 
                            <?php echo $utility->escape($currentTerm['termVariable'] ?? 'No Active Term') ?>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-0"><br>
        <div class="col-lg-12 col-md-12 ">
            <?php
            $allowedIncludes = [
                './forms/userprofile.php',
                './forms/uploadpayment.php',
                './forms/ticket.php',
                './forms/schoolProfile/facilities.php',
                './forms/schoolProfile/corporate.php',
                './forms/schoolProfile/contact.php',
                './forms/schoolProfile/approval.php',
                './forms/post_vacancy.php',
                './forms/personnelDocs.php',
                './forms/managesession.php',
                './forms/enrolment.php',
                './forms/conversation.php',
                './forms/billgenerator.php',
                './forms/accesscode.php',
                './report/dashboard.php',
                './report/activityLog.php',
                './report/myTickets.php',
                './report/profile/profile.php',
                './report/profile/createSchool.php',
                './report/profile/complianceMailer.php',
                './report/profile/complianceStatus.php',
                './report/profile/availableClasses.php',
                './report/personnel/personnelReport.php',
                './report/personnel/personnelList.php',
                './report/personnel/personnelInfo.php',
                './report/invoice/termlyInvoice.php',
                './report/invoice/invoiceDetails.php',
                './report/invoice/financeProfile.php',
                './report/invoice/transactionManager.php',
                './report/invoice/paymentReceipt.php',
                './report/academic/academicReportManager.php',
                './report/Enrolment/enrolmentRecord.php',
                './report/Enrolment/enrolmentList.php',
                './report/Enrolment/enrolmentbyTerm.php',
                './report/rebate/rebateview.php',
                './report/rebate/rebatelog.php',
                './report/conference/reg_report.php',
            ];
            $includeFile = $_SESSION['include'] ?? '';

            if (in_array($includeFile, $allowedIncludes, true) && file_exists($includeFile)) {
                include $includeFile;
            } else {
                error_log('Blocked invalid admin include: ' . (string) $includeFile);
                $utility->notifier('danger', 'The requested page is not available.');
                $model->redirect('../../app/adminRouter.php?pageid=' . base64_encode('dashboard'));
            }
            ?>
        </div>
        <?php
        include './inc/footer.php';
        ?>
