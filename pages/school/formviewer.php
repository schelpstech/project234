<?php
include './inc/header.php';
include './inc/nav.php';
include './inc/navbar.php';
?>


<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="px-5 py-4 container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mx-2 mb-3 d-md-flex align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h5 class="mb-0 font-weight-bold">School code:
                            <?php echo $utility->escape($_SESSION['active'] ?? '') ?>
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
                './forms/corporate.php',
                './forms/availableClasses.php',
                './forms/contact.php',
                './forms/approval.php',
                './forms/facilities.php',
                './forms/add_personnel.php',
                './forms/editPersonnel.php',
                './forms/personnelDocs.php',
                './forms/post_vacancy.php',
                './report/activityLog.php',
                './forms/ticket.php',
                './report/myTickets.php',
                './forms/conversation.php',
                './forms/accesscode.php',
                './forms/userprofile.php',
                './forms/academicReport.php',
                './forms/modifyAcademicReport.php',
                './forms/enrolment.php',
                './forms/rebate.php',
                './forms/jesusTime.php',
                './forms/editJTreport.php',
                './forms/editEnrolment.php',
                './forms/billgenerator.php',
                './report/transaction.php',
                './forms/uploadpayment.php',
            ];
            $includeFile = $_SESSION['include'] ?? '';

            if (in_array($includeFile, $allowedIncludes, true) && file_exists($includeFile)) {
                include $includeFile;
            } else {
                error_log('Blocked invalid school include: ' . (string) $includeFile);
                $utility->notifier('danger', 'The requested page is not available.');
                $model->redirect('../../app/router.php?pageid=' . base64_encode('school_dashboard'));
            }
            ?>
        </div>
        <?php
        include './inc/footer.php';
        ?>
