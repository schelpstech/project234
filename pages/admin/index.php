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
                        <h4><?php echo $_SESSION['pageName'] ?? "" ?></h4>
                    </div>
                    <button type="button"
                        class="mb-0 mb-2 btn btn-sm btn-white btn-icon d-flex align-items-center ms-md-auto mb-sm-0 me-2">
                        <span class="btn-inner--icon">
                            <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                <span class="visually-hidden">New</span>
                            </span>
                        </span>
                        <span class="btn-inner--text">Session: <?php echo $currentTerm['termVariable'] ?? "No Active Term"; ?></span>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-0">

        <?php

        $pageId = isset($_GET['pageid']) ? base64_decode($_GET['pageid']) : 'dashboard';

        switch ($pageId) {
            //=== School Profile ===//
            case 'schoolProfile':
                $include = include "./report/profile/profile.php";
                break;
            case 'schoolCreate':
                $include = include "./report/profile/createSchool.php";
                break;

            //=== Personnel ===//
            case 'personnelProfile':
                $include = include "./report/personnel/personnelReport.php";
                break;
            case 'schPersonnelList':
                $include = include "./report/personnel/personnelList.php";
                break;
            case 'personnelInfoPage':
                $include = include "./report/personnel/personnelInfo.php";
                break;

            //=== Enrolment ===//
            case 'enrolmentTable':
                $include = include "./report/Enrolment/enrolmentList.php";
                break;
            case 'enrolmentbyTerm':
                $pageName = "School Enrolment Record";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Termly Enrolment Record for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "The terms for which Selected School has created enrolment records";
                $_SESSION['schCode'] = $_GET['schCode'] ?? '';
                $include = include "./report/enrolmentbyTerm.php";
                break;
            case 'schEnrolmentDetails':
                $pageName = "School Invoice Details - Enrolment Record";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Termly Enrolment Record for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "View and Validate Invoices of Selected School";
                $_SESSION['termRef'] = $_GET['termRef'] ?? '';
                $include = include "./report/enrolmentRecord.php";
                break;

            //=== Rebate ===//
            case 'rebateManager':
                $include = include "./report/rebate/rebatelog.php";
                break;
            case 'rebateDetails':
                $pageName = "School Rebate Application Details";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Rebate Application Details for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "View and Validate Rebate Application of Selected School";
                $_SESSION['rebateRef'] = $_GET['rebateRef'] ?? '';
                $include = include "./forms/rebateDetails.php";
                break;

            //=== Invoice ===//
            case 'financeProfile':
                $include = include "./report/invoice/financeProfile.php";
                break;
            case 'schInvoicePage':
                $pageName = "School Invoice Details";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Invoices for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "View and Validate Invoices of Selected School";
                $_SESSION['schCode'] = $_GET['schCode'] ?? '';
                $include = include "./report/transaction.php";
                break;
            case 'termlyRemittanceInvoice':
                $include = include "./report/invoice/termlyInvoice.php";
                break;

            //=== User & Logs ===//
            case 'userProfile':
                $include = include "./forms/userprofile.php";
                break;
            case 'activity_log':
                $include = include "./report/activityLog.php";
                break;
            case 'ticketLog':
                $include = include "./report/myTickets.php";
                break;
            case 'conversation':
                $include = include "./forms/conversation.php";
                break;

            //=== School Profile Details ===//
            case 'Corporate':
                $include = include "./forms/schoolProfile/corporate.php";
                break;
            case 'Contact':
                $include = include "./forms/schoolProfile/contact.php";
                break;
            case 'Classes':
                $include = include "./report/schoolProfile/availableClasses.php";
                break;
            case 'Approval':
                $include = include "./forms/schoolProfile/approval.php";
                break;
            case 'Facility':
                $include = include "./forms/schoolProfile/facilities.php";
                break;

            //=== Session Management ===//
            case 'ResetPassword':
                $include = include "./forms/accesscode.php";
                break;
            case 'managesession':
                $pageName = "Academic Session Manager";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Create, Activate and Deactivate Terms and Session</h6>';
                $pageDescription = "Manage Academic Session and Terms";
                $include = include "./forms/managesession.php";
                break;

            //=== Conference ===//
            case 'conferenceReport':
                $include = include "./report/conference/reg_report.php";
                break;

            //=== Default ===//
            default:
                $include = include "./report/dashboard.php";
                break;
        }
        ?>


        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <?php echo $_SESSION['pageDescription'] ?? "" ?>
            </div>
        </div>
        <?php
        $include;
        include './inc/footer.php';
        ?>