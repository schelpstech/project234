<?php
include '../model/query.php';

if (isset($_GET['ref']) && isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'phone_delete';
            $tblName = '_tbl_phone_number';
            $delete_data = array(
                'sch_code' => $_SESSION['active'],
                'id' => base64_decode($_GET['ref']),
            );
            if ($model->delete($tblName, $delete_data) == true) {
                $user->recordLog($_SESSION['active'], 'Phone Data Delete', 'A phone number record was deleted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully deleted a phone contact details for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            } else {
                $utility->notifier('dark', 'There was an error deleting this phone contact details for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            }
            break;
        case 'email_delete';
            $tblName = '_tbl_email_address';
            $delete_data = [
                'sch_code' => $_SESSION['active'],
                'id' => base64_decode($_GET['ref']),
            ];
            if ($model->delete($tblName, $delete_data) == true) {
                $user->recordLog($_SESSION['active'], 'Email Data Delete', 'An Email address record was deleted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully deleted an Email address contact details for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            } else {
                $utility->notifier('dark', 'There was an error deleting this Email address contact details for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            }
            break;
        case 'address_delete';
            $tblName = '_tbl_sch_address';
            $delete_data = [
                'sch_code' => $_SESSION['active'],
                'id' => base64_decode($_GET['ref']),
            ];
            if ($model->delete($tblName, $delete_data) == true) {
                $user->recordLog($_SESSION['active'], 'Address Data Delete', 'A physical address record was deleted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully deleted a physical address contact details for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            } else {
                $utility->notifier('dark', 'There was an error deleting this physical address contact details for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('contact_form'));
            }
            break;
        case 'approval_details';
            $tblName = '_tbl_approval_record';
            $delete_data = [
                'sch_code' => $_SESSION['active'],
                'approval_rec_id' => ($_GET['ref']),
            ]; 
            if ($model->delete($tblName, $delete_data) == true) {
                $user->recordLog($_SESSION['active'], 'Approval Data Delete', 'Approval record was deleted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully deleted an Approval record for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('approval_record'));
            } else {
                $utility->notifier('dark', 'There was an error deleting this Approval record for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('approval_record'));
            }
            break;

        case 'facility_details';
            $tblName = '_sch_facility_record';
            $delete_data = [
                'sch_code' => $_SESSION['active'],
                'sch_fac_id' => ($_GET['ref']),
            ]; 
            if ($model->delete($tblName, $delete_data) == true) {
                $user->recordLog($_SESSION['active'], 'Facility Record Delete', 'Facility record was deleted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully deleted a Facility record for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('facility_record'));
            } else {
                $utility->notifier('dark', 'There was an error deleting this Facility record for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('facility_record'));
            }
            break;

        case 'enrolmentRecord';
            $tblName = '_tbl_termly_enrolment';
            $delete_data = [
                'schCode' => $_SESSION['active'],
                'recordid' => $_SESSION['enrolmentRef'],
                'termID' => ($_GET['ref']),
            ]; 
            if ($model->delete($tblName, $delete_data) == true) {
                $user->recordLog($_SESSION['active'], 'Class Termly Enrolment Record Delete', 'Class Termly Enrolment Record was deleted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully deleted a Class Termly Enrolment Record for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
            } else {
                $utility->notifier('dark', 'There was an error deleting this Class Termly Enrolment Record for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
            }
            break;

        case 'personnel_details';
            $tblName = 'tbl_personnel_record';
            $delete_data = [
                'schCode' => $_SESSION['active'],
                'record_id' => ($_GET['ref']),
            ]; 
            if ($model->delete($tblName, $delete_data) == true) {
                $user->recordLog($_SESSION['active'], 'Personnel Record Delete', 'Personnel Record was deleted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully deleted a Personnel Record for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('add_personnel'));
            } else {
                $utility->notifier('dark', 'There was an error deleting this Personnel Record for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('add_personnel'));
            }
            break;
    }

}