<?php
include '../model/query.php';


if ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schoolProfile") {
    $_SESSION['pageName'] = "School Profile";
    $_SESSION['pageDescription']  = "School Profile information";
    $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
} 

//******** Personnel Starts
            //Personnel Reports
            elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "personnelProfile") {
                $_SESSION['pageName'] = "School Personnel Report";
                $_SESSION['pageDescription']  = "School Personnel Profile information";
                $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
            } 


            //Personnel List of a Selected School
            elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) === "schPersonnelList") {
                $_SESSION['schCode'] = $_GET['schCode'];
                $_SESSION['pageName'] = "School Personnel List";
                $_SESSION['pageDescription']  = "School Personnel Profile information";
                $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
            } 


            //Personnel Information Page 

            elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) === "personnelInfoPage") {
                $_SESSION['personnelRef'] = $_GET['personnelRef'];
                $_SESSION['pageName'] = "School Personnel Information Page";
                $_SESSION['pageDescription']  = "View all the information about the selected staff in a CRSM School with School Code : ".$_SESSION['schCode'];
                $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
            } 
//********Personnel Ends */





elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "userProfile") {
    $_SESSION['pageName'] = "Admin Profile";
    $_SESSION['pageDescription']  = "Update profile information";
    $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
} elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "activity_log") {
    $_SESSION['pageName'] = "Activity Log";
    $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                    Working on School with Code :: ' . $_SESSION['schCode'] ?? "" . '
                    </h6>';
    $_SESSION['pageDescription']  = "See information about all the activities that you have done on the portal";
    $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
}

//******Support Ticket Starts */

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ticketLog") {
            $_SESSION['pageName'] = "Support Ticket Log";
            $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: ' . $_SESSION['schCode'] ?? "" . '
                            </h6>';
            $_SESSION['pageDescription']  = "See all inquiries and complain ticket request of schools on the portal";
            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        } 



        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "conversation") {
            $_SESSION['ticketid'] = $_GET['ticketid'];
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['pageName'] = "Support Ticket ::".$_GET['ticketid'];
            $_SESSION['pageDescription']  = 'Working on inquiries and complain ticket request of  School with Code :: ' . $_SESSION['schCode'] ?? "";
            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }
//******Support Ticket Ends */

//******Compliance Records Starts */

        //Corporate Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Corporate") {
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['pageName'] = "School Corporate Details";
            $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: ' . $_SESSION['schCode'] ?? "" . '
                            </h6>';
            $_SESSION['pageDescription']  = "View and Validate Corporate Details of Selected School";

            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }

        //Contact Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Contact") {
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['pageName'] = "School Contact Details";
            $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: ' . $_SESSION['schCode'] ?? "" . '
                            </h6>';
            $_SESSION['pageDescription']  = "View and Validate  Contact Details of Selected School";

            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }
        //Available Class Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Classes") {
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: ' . $_SESSION['schCode'] ?? "" . '
                            </h6>';
            $_SESSION['pageName'] = "School Contact Details";
            $_SESSION['pageDescription']  = "View and Validate  Contact Details of Selected School";

            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }
        //Approval  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Approval") {
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: ' . $_SESSION['schCode'] ?? "" . '
                            </h6>';
            $_SESSION['pageName'] = "School Contact Details";
            $_SESSION['pageDescription']  = "View and Validate  Approval Details of Selected School";
        
            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }
        //Facility  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "Facility") {
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                            Working on School with Code :: ' . $_SESSION['schCode'] ?? "" . '
                            </h6>';
            $_SESSION['pageName'] = "School Facility Details";
            $_SESSION['pageDescription']  = "View and Validate  Facility Available in the Selected School";

            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }
    
 //******Compliance Records Ends */       


//Reset School Password 
elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "ResetPassword") {
    $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                    Working on Resetting School Portal Access Password</h6>';
    $_SESSION['pageName'] = "School Password Reset";
    $_SESSION['pageDescription']  = "Reset Password in the Selected School";
    $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
}


//******Enrolment Starts
            //Enrolment Page
            elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentTable") {
                $_SESSION['pageName'] = "School Enrolment Records";
                $_SESSION['pageDescription']  = "School Finance Portal";
                $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
            }


            //View School  Enrolment Term 
            elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "enrolmentbyTerm") {
                $_SESSION['schCode'] = $_GET['schCode'];
                $_SESSION['pageName'] = "Termly School Enrolment Record";
                $_SESSION['pageDescription']  = '
                                Termly Enrolment Record for School with Code :: ' . $_SESSION['schCode'] ?? "";

                $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
            }


            //School Termly Enrolment  Details 
            elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schEnrolmentDetails") {

                $_SESSION['termRef'] = $_GET['termRef'];
                $_SESSION['pageName'] = "School Enrolment Record - Class -Tuition Breakdown";
                $_SESSION['pageDescription']  =  'Termly Enrolment Record for School with Code :: '.$_SESSION['schCode'];
                $model->redirect('../pages/admin/index.php?pageid='.$_GET['pageid']);
            }

//******Enrolment Ends


//******Rebate Starts

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateManager") {
            $_SESSION['pageName'] = "School Rebate Application";
            $_SESSION['pageDescription']  = "School Finance Portal";
            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "rebateDetails") {
            $_SESSION['rebateRef'] = $_GET['rebateRef'];
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['pageName'] = "School Rebate Application  Details";
            $_SESSION['pageDescription']  = '
                            View and Validate Rebate Application  Details for School with Code :: ' . $_SESSION['schCode'] ?? "";
            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        } 

//******Rebate Ends


//******Invoice Manager Starts

        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "financeProfile") {
            $_SESSION['pageName'] = "School Invoice List";
            $_SESSION['pageDescription']  = "School Finance Portal";
            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }

        //School Invoice  Details 
        elseif ((isset($_GET['pageid'])) && base64_decode($_GET['pageid']) == "schInvoicePage") {
            $_SESSION['schCode'] = $_GET['schCode'];
            $_SESSION['pageName'] = "School Termly Remittance Invoice";
            $_SESSION['pageDescription']  = 'View and Validate Invoices of Selected School with Code :: ' . $_SESSION['schCode'] ?? "";
            $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
        }
//******Invoice Manager Ends
else {
    $_SESSION['pageName'] = "Admin Dashboard";
    $_SESSION['identifier']  = '<h6 class="font-weight-semibold text-lg mb-0">
                    signed in as :: ' . $_SESSION['activeAdmin'] ?? "" . '
                    </h6>';
    $_SESSION['pageDescription']  = "CRSM Admin portal";
    $model->redirect('../pages/admin/index.php?pageid=' . $_GET['pageid']);
}
?>