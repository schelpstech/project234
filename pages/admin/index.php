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
                        
                    </div>
                    <button type="button"
                        class="mb-0 mb-2 btn btn-sm btn-white btn-icon d-flex align-items-center ms-md-auto mb-sm-0 me-2">
                        <span class="btn-inner--icon">
                            <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                <span class="visually-hidden">New</span>
                            </span>
                        </span>
                        <span class="btn-inner--text">Session: 2022/2023</span>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-0">

        <?php

        if ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schoolProfile") {
            $pageName = "School Profile";
            $pageDescription = "School Profile information";
            $include = include "./report/profile.php";
        }
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "personnelProfile") {
            $pageName = "School Personnel Profile";
            $pageDescription = "School Personnel Profile information";
            $include = include "./report/personnelReport.php";
        }
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "financeProfile") {
            $pageName = "School Invoice List";
            $pageDescription = "School Finance Portal";
            $include = include "./report/financeProfile.php";
        }
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateManager") {
            $pageName = "School Rebate Application";
            $pageDescription = "School Finance Portal";
            $include = include "./report/rebatelog.php";
        }
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentTable") {
            $pageName = "School Enrolment Records";
            $pageDescription = "School Finance Portal";
            $include = include "./report/enrolmentList.php";
        }
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "userProfile") {
            $pageName = "Admin Profile";
            $pageDescription = "Update profile information";
            $include = include "./forms/userprofile.php";
        } elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "activity_log") {
            $pageName = "Activity Log";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "See information about all the activities that you have done on the portal";
            $include = include "./report/activityLog.php";
        } 
        //Support Tickets
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ticketLog") {
            $pageName = "Support Ticket Log";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "See all inquiries and complain ticket request of schools on the portal";
            $include = include "./report/myTickets.php";
        }
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "conversation") {
            $pageName = "Support Ticket Log";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "See all inquiries and complain ticket request of schools on the portal";
            $_SESSION['ticketid'] = $_GET['ticketid'];
            $include = include "./forms/conversation.php";
        }

        //Corporate Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Corporate") {
            $pageName = "School Corporate Details";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "View and Validate Corporate Details of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./forms/corporate.php";
        }

        //Contact Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Contact") {
            $pageName = "School Contact Details";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "View and Validate  Contact Details of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./forms/contact.php";
        }
        //Available Class Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Classes") {
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageName = "School Contact Details";
            $pageDescription = "View and Validate  Contact Details of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./report/availableClasses.php";
        }
        //Approval  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Approval") {
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageName = "School Contact Details";
            $pageDescription = "View and Validate  Approval Details of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./forms/approval.php";
        }
        //Facility  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Facility") {
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageName = "School Facility Details";
            $pageDescription = "View and Validate  Facility Available in the Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./forms/facilities.php";
        }
            //Reset School Password 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ResetPassword") {
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on Resetting School Portal Access Password</h6>';
            $pageName = "School Password Reset";
            $pageDescription = "Reset Password in the Selected School";
            $include = include "./forms/accesscode.php";
        }
                //School Invoice  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schInvoicePage") {
            $pageName = "School Invoice Details";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Invoices for School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "View and Validate  Invoices of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./report/transaction.php";
        }
                //View School  Enrolment Term 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentbyTerm") {
            $pageName = "School Enrolment Record";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Termly Enrolment Record for School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "The terms for which Selected School has created enrolment records";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./report/enrolmentbyTerm.php";
        }
                //School Termly Enrolment  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schEnrolmentDetails") {
            $pageName = "School Invoice Details - Enrolment Record";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Termly Enrolment Record for School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "View and Validate  Invoices of Selected School";
            $_SESSION['termRef'] = $_GET['termRef'];
            $include = include "./report/enrolmentRecord.php";
        }
                //School Rebate Application  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateDetails") {
            $pageName = "School Rebate Application  Details";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            Rebate Application  Details for School with Code :: '. $_SESSION['schCode'] ?? "".'
                            </h6>';
            $pageDescription = "View and Validate  Rebate Application  of Selected School";
            $_SESSION['rebateRef'] = $_GET['rebateRef'];
            $include = include "./forms/rebateDetails.php";
        }
        else {
            $pageName = "Admin Dashboard";
            $identifier = '<h6 class="font-weight-semibold text-lg mb-0">
                            signed in as :: '. $_SESSION['activeAdmin'] ?? "".'
                            </h6>';
            $pageDescription = "CRSM Admin portal";
            $include = include "./report/dashboard.php";
        }
        ?>
        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <?php echo $identifier ?? "" ?>
                    <p class="text-sm">
                        <?php echo $pageDescription ?? "" ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
        $include;
        include './inc/footer.php';
        ?>