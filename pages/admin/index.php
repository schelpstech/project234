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
                    <?php echo $_SESSION['pageName'] ?? "" ?>
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
            $include = include "./report/profile.php";
        } 


//Personnel Pages Starts
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "personnelProfile") {
            $include = include "./report/personnel/personnelReport.php";
        } 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schPersonnelList") {
            $include = include "./report/personnel/personnelList.php";
        } 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "personnelInfoPage") {
            $include = include "./report/personnel/personnelInfo.php";
        } 
//Personnel Pages Ends

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "financeProfile") {
            $include = include "./report/financeProfile.php";
        } elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateManager") {
            $include = include "./report/rebatelog.php";
        } elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentTable") {
            $include = include "./report/enrolmentList.php";
        } elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "userProfile") {
            $include = include "./forms/userprofile.php";
        } elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "activity_log") {
            $include = include "./report/activityLog.php";
        }
        //Support Tickets
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ticketLog") {
            $include = include "./report/myTickets.php";
        } elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "conversation") {
            $include = include "./forms/conversation.php";
        }

        //Corporate Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Corporate") {
            $include = include "./forms/corporate.php";
        }

        //Contact Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Contact") {
            $include = include "./forms/contact.php";
        }
        //Available Class Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Classes") {
            $include = include "./report/availableClasses.php";
        }
        //Approval  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Approval") {
            $include = include "./forms/approval.php";
        }
        //Facility  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Facility") {
            $include = include "./forms/facilities.php";
        }
        //Reset School Password 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ResetPassword") {
            $include = include "./forms/accesscode.php";
        }
        //School Invoice  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schInvoicePage") {
            $include = include "./report/transaction.php";
        }


        //View School  Enrolment Term 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentbyTerm") {
            $include = include "./report/enrolmentbyTerm.php";
        }
        //School Termly Enrolment  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schEnrolmentDetails") {
            $include = include "./report/enrolmentRecord.php";
        }
        //School Rebate Application  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateDetails") {
            $include = include "./forms/rebateDetails.php";
        } else {
            $include = include "./report/dashboard.php";
        }
        ?>


        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <?php echo $_SESSION['identifier'] ?? "" ?>
                    <p class="text-sm">
                        <?php echo $_SESSION['pageDescription'] ?? "" ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
        $include ;
        include './inc/footer.php';
        ?>