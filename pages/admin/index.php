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
                        <span class="btn-inner--text">Session: 2022/2023</span>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-0">

        <?php

        if ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schoolProfile") {
            $include = include "./report/profile/profile.php";
        } 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schoolCreate") {
            $include = include "./report/profile/createSchool.php";
        }

//***Personnel Pages Starts
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "personnelProfile") {
            $include = include "./report/personnel/personnelReport.php";
        } 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schPersonnelList") {
            $include = include "./report/personnel/personnelList.php";
        } 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "personnelInfoPage") {
            $include = include "./report/personnel/personnelInfo.php";
        } 
//***Personnel Pages Ends


//**** Enrolment Starts
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentTable") {
            $include = include "./report/Enrolment/enrolmentList.php";
        }
        //View School  Enrolment Term 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentbyTerm") {
            $include = include "./report/Enrolment/enrolmentbyTerm.php";
        }
        //School Termly Enrolment  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schEnrolmentDetails") {
            $include = include "./report/Enrolment/enrolmentRecord.php";
        }
//**** Enrolment Ends


//**** Rebate Starts

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateManager") {
            $include = include "./report/rebate/rebatelog.php";
        } 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateDetails") {
            $include = include "./report/rebate/rebateview.php";
        }
//**** Rebate Ends


//******Invoice Manager Starts

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "financeProfile") {
            $include = include "./report/invoice/financeProfile.php";
        } 

        //School Created Invoice  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schInvoicePage") {
            $include = include "./report/invoice/invoiceDetails.php";
        }

        //School Termly remittance Invoice  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "termlyRemittanceInvoice") {
            $include = include "./report/invoice/termlyInvoice.php";
        }
        
//******Invoice Manager Ends

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "userProfile") {
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


//******* School Profile Starts */
        //Corporate Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Corporate") {
            $include = include "./forms/schoolProfile/corporate.php";
        }

        //Contact Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Contact") {
            $include = include "./forms/schoolProfile/contact.php";
        }
        //Available Class Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Classes") {
            $include = include "./report/schoolProfile/availableClasses.php";
        }
        //Approval  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Approval") {
            $include = include "./forms/schoolProfile/approval.php";
        }
        //Facility  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Facility") {
            $include = include "./forms/schoolProfile/facilities.php";
        }

//******* School Profile Ends */


        //Reset School Password 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ResetPassword") {
            $include = include "./forms/accesscode.php";
        }
        
        else {
            $include = include "./report/dashboard.php";
        }
        ?>


        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                    <?php echo $_SESSION['pageDescription'] ?? "" ?>
            </div>
        </div>
        <?php
        $include ;
        include './inc/footer.php';
        ?>