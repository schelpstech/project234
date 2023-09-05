<?php
include '../model/query.php';

if (isset($_POST['submit_corporate_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'corporate_form') {
    //Update Corporate Data 
    if ($sch_corporate_data['vetting'] == 0) {
        
        //School Logo Upload Handler
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 524288; // 500kb
        $uploadPath = '../assets/storage/logo';

        $result = $utility->handleUploadedFile('schLogo', $allowedTypes, $maxFileSize, $uploadPath);
        if (isset($_SESSION['fileName']) && $result == 'success') {
            $tblName = '_tbl_sch_corporate_data';
            $condition = [
                'sch_code' => $_SESSION['active'],
            ];
            $corporate_data = [
                'sch_type_gender' => htmlspecialchars($_POST['sch_gender']),
                'sch_type_accom' => htmlspecialchars($_POST['sch_accom']),
                'date_established' => htmlspecialchars($_POST['date_established']),
                'available_classes' => htmlspecialchars($_POST['avail_class']),
                'schLogo' => $uploadPath . '/' . $_SESSION['fileName'],
            ];
            if ($model->upDate($tblName, $corporate_data, $condition) == true) {
                $user->recordLog($_POST['sch_code'], 'Corporate Data Modification', 'An update was done on the Corporate information of the school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully updated the corporate information for ' . $_POST['sch_name']);
                $model->redirect('./router.php?pageid=' . base64_encode('corporate_form'));
            } else {
                $utility->notifier('dark', 'No corporate information was updated for ' . $_POST['sch_name']);
                $model->redirect('./router.php?pageid=' . base64_encode('corporate_form'));
            }
        } else {
            $utility->notifier('danger', $result);
            $model->redirect('./router.php?pageid=' . base64_encode('corporate_form'));
        }
    } else {
        $utility->notifier('danger', 'You cannot modify corporate data for ' . $_POST['sch_name']);
        $model->redirect('./router.php?pageid=' . base64_encode('corporate_form'));
    }
} 

// Submit Contact Form
elseif (isset($_POST['submit_contact_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'contact_form') {

    switch ($_POST['contact_type']) {
        case 'phone';
            $tblName = '_tbl_phone_number';
            $contact_data = array(
                'sch_code' => $_SESSION['active'],
                'phone_number' => htmlspecialchars($_POST['contact_data_phone']),
            );
            if ($model->insert_data($tblName, $contact_data) == true) {
                $user->recordLog($_POST['sch_code'], 'Phone Data Entry', 'A new phone number was added for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully added a new phone contact details for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            } else {
                $utility->notifier('dark', 'There was an error adding phone contact details for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            }
            break;

        case 'email';
            $tblName = '_tbl_email_address';
            $contact_data = array(
                'sch_code' => $_SESSION['active'],
                'email_addrs' => htmlspecialchars($_POST['contact_data_email']),
            );
            if ($model->insert_data($tblName, $contact_data) == true) {
                $user->recordLog($_POST['sch_code'], 'Email Data Entry', 'A new Email address was added for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully added a new Email address contact details for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            } else {
                $utility->notifier('dark', 'There was an error adding Email address contact details for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            }
            break;

        case 'address';
            $tblName = '_tbl_sch_address';
            $contact_data = array(
                'sch_code' => $_SESSION['active'],
                'address' => htmlspecialchars($_POST['contact_data_address']),
                'lga_id' => htmlspecialchars($_POST['lga_type']),
            );
            if ($model->insert_data($tblName, $contact_data) == true) {
                $user->recordLog($_POST['sch_code'], 'Address Data Entry', 'A new school address was added for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully added a new school address contact details for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            } else {
                $utility->notifier('dark', 'There was an error adding school address contact details for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            }
            break;

        default:
            $utility->notifier('dark', 'Sorry we didnt understand your request');
            $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
    }

//Submit Approval Record
} elseif (isset($_POST['submit_approval_record']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'approval_record') {

    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
    $maxFileSize = 524288; // 500kb
    $uploadPath = '../assets/storage/approval';

    $result = $utility->handleUploadedFile('approval_cert', $allowedTypes, $maxFileSize, $uploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $tblName = '_tbl_approval_record';
        $approval_data = array(
            'sch_code' => $_SESSION['active'],
            'approval_id' => htmlspecialchars($_POST['approval_type']),
            'approval_date' => htmlspecialchars($_POST['approval_date']),
            'approval_file' => $uploadPath . '/' . $_SESSION['fileName'],
        );
        if ($model->insert_data($tblName, $approval_data) == true) {
            $user->recordLog($_POST['sch_code'], 'Approval record submission', 'A new school Approval record was submitted for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'School Approval record has been submitted for review.');
            $model->redirect('./router.php?pageid=' . base64_encode('approval_record'));
        } else {
            $utility->notifier('danger', 'Your submission failed! Please try again');
            $model->redirect('./router.php?pageid=' . base64_encode('approval_record'));
        }

    } else {
        $utility->notifier('danger', $result);
        $model->redirect('./router.php?pageid=' . base64_encode('approval_record'));
    }



}
//Add Faciility Record
elseif (isset($_POST['submit_facility_record']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'facility_record') {

    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
    $maxFileSize = 524288; // 500kb
    $uploadPath = '../assets/storage/facility';

    $result = $utility->handleUploadedFile('facility_image', $allowedTypes, $maxFileSize, $uploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $tblName = '_sch_facility_record';
        $approval_data = [
            'sch_code' => $_SESSION['active'],
            'facility_id' => $_POST['facility_name'],
            'ownership' => htmlspecialchars($_POST['ownership']),
            'description' => htmlspecialchars($_POST['description']),
            'image' => $uploadPath . '/' . $_SESSION['fileName'],
        ];
        if ($model->insert_data($tblName, $approval_data) == true) {
            $user->recordLog($_POST['sch_code'], 'Facility record submission', 'A new school facility record was submitted for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'School Facility record has been submitted for review.');
            $model->redirect('./router.php?pageid=' . base64_encode('facility_record'));
        } else {
            $utility->notifier('danger', 'Your submission failed! Please try again');
            $model->redirect('./router.php?pageid=' . base64_encode('facility_record'));
        }

    } else {
        $utility->notifier('danger', $result);
        $model->redirect('./router.php?pageid=' . base64_encode('facility_record'));
    }



}//Submit Rebate Application
elseif (isset($_POST['submit_rebate_letter']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'availableClasses') {
    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
    $maxFileSize = 524288; // 500kb
    $uploadPath = '../assets/storage/rebateDocument';

    $result = $utility->handleUploadedFile('rebateLetter', $allowedTypes, $maxFileSize, $uploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $tblName = '_tbl_rebate_record';
        $approval_data = [
            'schCode' => $_SESSION['active'],
            'rebateRef' => $utility->generateRandomString(8),
            'rebateTerm' => htmlspecialchars($_POST['termID']),
            'numLearners' => htmlspecialchars($_POST['numLearners']),
            'amountRebate' => htmlspecialchars($_POST['amountRebate']),
            'rebateLetter' => $uploadPath . '/' . $_SESSION['fileName'],
        ];
        if ($model->insert_data($tblName, $approval_data) == true) {
            $user->recordLog($_POST['sch_code'], 'Rebate application  submission', 'A new Rebate application  was submitted for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'Rebate application has been submitted for review.');
            $model->redirect('./router.php?pageid=' . base64_encode('reBate'));
        } else {
            $utility->notifier('danger', 'Your submission failed! Please try again');
            $model->redirect('./router.php?pageid=' . base64_encode('reBate'));
        }

    } else {
        $utility->notifier('danger', $result);
        $model->redirect('./router.php?pageid=' . base64_encode('reBate'));
    }

}else {
    $utility->notifier('dark', 'Sorry we didnt understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}