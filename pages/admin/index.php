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
                        <h5 class="mb-0 font-weight-bold">Admin Profile:
                            <?php echo $_SESSION['activeAdmin'] ?>
                        </h5>
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
        if ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "userProfile") {
            $pageName = "Admin Profile";
            $pageDescription = "Update profile information";
            $include = include "./forms/userprofile.php";
        } elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "activity_log") {
            $pageName = "Activity Log";
            $pageDescription = "See information about all the activities that you have done on the portal";
            $include = include "./report/activityLog.php";
        } 
        //Support Tickets
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ticketLog") {
            $pageName = "Support Ticket Log";
            $pageDescription = "See all inquiries and complain ticket request of schools on the portal";
            $include = include "./report/myTickets.php";
        }
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "conversation") {
            $pageName = "Support Ticket Log";
            $pageDescription = "See all inquiries and complain ticket request of schools on the portal";
            $_SESSION['ticketid'] = $_GET['ticketid'];
            $include = include "./forms/conversation.php";
        }

        //Corporate Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Corporate") {
            $pageName = "School Corporate Details";
            $pageDescription = "View and Validate Corporate Details of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./forms/corporate.php";
        }

        //Contact Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Contact") {
            $pageName = "School Contact Details";
            $pageDescription = "View and Validate  Contact Details of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./forms/contact.php";
        }
        //Available Class Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Classes") {
            $pageName = "School Contact Details";
            $pageDescription = "View and Validate  Contact Details of Selected School";
            $_SESSION['schCode'] = $_GET['schCode'];
            $include = include "./report/availableClasses.php";
        }


        else {
            $pageName = "Admin Dashboard";
            $pageDescription = "CRSM Admin portal";
            $include = include "./report/dashboard.php";
        }
        ?>
        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <?php echo "School Code :: ". $_SESSION['schCode'] ?? "" ?>
                    </h6>
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