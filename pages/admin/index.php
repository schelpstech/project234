<?php
include './inc/header.php';
include './inc/nav.php';
include './inc/navbar.php';


$pageId = isset($_GET['pageid']) ? base64_decode($_GET['pageid']) : 'dashboard';

?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="px-5 py-4 container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mx-2 mb-3 d-md-flex align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h4><?php echo $_SESSION['pageName'] ?? ""; ?></h4>
                    </div>
                    <button type="button"
                        class="mb-0 mb-2 btn btn-sm btn-white btn-icon d-flex align-items-center ms-md-auto mb-sm-0 me-2">
                        <span class="btn-inner--icon">
                            <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                <span class="visually-hidden">New</span>
                            </span>
                        </span>
                        <span class="btn-inner--text">
                            Session: <?php echo $currentTerm['termVariable'] ?? "No Active Term"; ?>
                        </span>
                    </button>
                </div>
            </div>
        <hr class="my-0">

        <?php

        // Default view file
        $viewFile = "./report/dashboard.php";

        switch ($pageId) {

            //=== School Profile ===//
            case 'schoolProfile':
                $viewFile = "./report/profile/profile.php";
                break;

            case 'schoolCreate':
                $viewFile = "./report/profile/createSchool.php";
                break;

            //=== Personnel ===//
            case 'personnelProfile':
                $viewFile = "./report/personnel/personnelReport.php";
                break;

            case 'schPersonnelList':
                $viewFile = "./report/personnel/personnelList.php";
                break;

            case 'personnelInfoPage':
                $viewFile = "./report/personnel/personnelInfo.php";
                break;

            //=== Enrolment ===//
            case 'enrolmentTable':
                $viewFile = "./report/Enrolment/enrolmentList.php";
                break;

            case 'enrolmentbyTerm':
                $pageName = "School Enrolment Record";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Termly Enrolment Record for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "The terms for which Selected School has created enrolment records";
                $_SESSION['schCode'] = $_GET['schCode'] ?? '';
                $viewFile = "./report/Enrolment/enrolmentbyTerm.php";
                break;

            case 'schEnrolmentDetails':
                $pageName = "School Invoice Details - Enrolment Record";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Termly Enrolment Record for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "View and Validate Invoices of Selected School";
                $_SESSION['termRef'] = $_GET['termRef'] ?? '';
                $_SESSION['schCode'] = $_GET['schoolcode'] ?? '';
                $viewFile = "./report/Enrolment/enrolmentRecord.php";
                break;

            //=== Rebate ===//
            case 'rebateManager':
                $viewFile = "./report/rebate/rebatelog.php";
                break;

            case 'rebateDetails':
                $pageName = "School Rebate Application Details";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Rebate Application Details for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "View and Validate Rebate Application of Selected School";
                $_SESSION['rebateRef'] = $_GET['rebateRef'] ?? '';
                $viewFile = "./report/rebate/rebateview.php";
                break;

            //=== Invoice ===//
            case 'financeProfile':
                $viewFile = "./report/invoice/financeProfile.php";
                break;

            case 'schInvoicePage':
                $pageName = "School Invoice Details";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Invoices for School with Code :: ' . ($_SESSION['schCode'] ?? "") . '</h6>';
                $pageDescription = "View and Validate Invoices of Selected School";
                $_SESSION['schCode'] = $_GET['schCode'] ?? '';
                $viewFile = "./report/invoice/invoiceDetails.php";
                break;

            case 'termlyRemittanceInvoice':
                $viewFile = "./report/invoice/termlyInvoice.php";
                break;

            //=== User & Logs ===//
            case 'userProfile':
                $viewFile = "./forms/userprofile.php";
                break;

            case 'activity_log':
                $viewFile = "./report/activityLog.php";
                break;

            case 'ticketLog':
                $viewFile = "./report/myTickets.php";
                break;

            case 'conversation':
                $viewFile = "./forms/conversation.php";
                break;

            //=== School Profile Details ===//
            case 'Corporate':
                $viewFile = "./forms/schoolProfile/corporate.php";
                break;

            case 'Contact':
                $viewFile = "./forms/schoolProfile/contact.php";
                break;

            case 'Classes':
                $viewFile = "./report/profile/availableClasses.php";
                break;

            case 'Approval':
                $viewFile = "./forms/schoolProfile/approval.php";
                break;

            case 'Facility':
                $viewFile = "./forms/schoolProfile/facilities.php";
                break;

            //=== Session Management ===//
            case 'ResetPassword':
                $viewFile = "./forms/accesscode.php";
                break;

            case 'managesession':
                $pageName = "Academic Session Manager";
                $identifier = '<h6 class="font-weight-semibold text-lg mb-0">Create, Activate and Deactivate Terms and Session</h6>';
                $pageDescription = "Manage Academic Session and Terms";
                $viewFile = "./forms/managesession.php";
                break;

            //=== Conference ===//
            case 'conferenceReport':
                $viewFile = "./report/conference/reg_report.php";
                break;

            //=== Default ===//
            default:
                $viewFile = "./report/dashboard.php";
                break;
        }

        // === Safe include with 404 handling, but still in global scope ===
        if (file_exists($viewFile)) {
            $include = include $viewFile;   // if you still want $include for debugging
        } else {
            error_log("Missing include file: " . $viewFile);
            $missingFile = $viewFile;
            include "./error/404.php";
        }
        ?>

        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <?php echo $_SESSION['pageDescription'] ?? ""; ?>
            </div>
        </div>

        <?php include './inc/footer.php'; ?>
    </div>
</main>
