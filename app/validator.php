<?php
include '../model/adminQuery.php';

if (!empty($_SESSION['activeAdmin']) && isset($_SESSION['schCode'])) {
    //Corporate Data
    if (isset($_POST['Update_corporate_form'])) {
        $tblName = '_tbl_sch_corporate_data';
        $condition = [
            'sch_code' => $_SESSION['schCode'],
        ];
        $corporate_data = [
            'vetting' => $_POST['validation']
        ];
        if ($model->upDate($tblName, $corporate_data, $condition) == true) {
            $user->recordLog($_SESSION['schCode'], 'Corporate Data Validation', 'A validation remark has been added on the Corporate information of the school with code : ' . $_SESSION['schCode']);
            $utility->notifier('success', 'You have Successfully submitted a validation remark for ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Corporate') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'No corporate information was updated for ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Corporate') . '&schCode=' . $_SESSION['schCode']);
        }
    }

    //Contact Data
    if (
        isset($_POST['Update_phone_form'])
        || isset($_POST['Update_email_form'])
        || isset($_POST['Update_address_form'])
    ) {

        if (isset($_POST['Update_email_form'])) {
            $tblName = '_tbl_email_address';
            $infoType = 'Email Address Contact ';
        } elseif (isset($_POST['Update_phone_form'])) {
            $tblName = '_tbl_phone_number';
            $infoType = 'Phone Number Contact ';
        } elseif (isset($_POST['Update_address_form'])) {
            $tblName = '_tbl_sch_address';
            $infoType = 'Physical Contact Address ';
        }

        $condition = [
            'id' => $_POST['reference']
        ];
        $contact_data = [
            'vetted' => $_POST['validation']
        ];
        if ($model->upDate($tblName, $contact_data, $condition) == true) {
            $user->recordLog($_SESSION['schCode'], 'Contact Data Validation', 'A validation remark has been added on the ' . $infoType . ' information of the school with code : ' . $_SESSION['schCode']);
            $utility->notifier('success', 'You have Successfully submitted a validation remark for the ' . $infoType . ' information of the school with Code :: ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Contact') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'No contact information was updated for ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Contact') . '&schCode=' . $_SESSION['schCode']);
        }
    }

    //Approval Data
    if (isset($_POST['Update_approval_form'])) {
        $tblName = '_tbl_approval_record';
        $infoType = 'School Approval ';
        $condition = [
            'approval_rec_id' => $_POST['reference']
        ];
        $contact_data = [
            'vetted' => $_POST['validation']
        ];
        if ($model->upDate($tblName, $contact_data, $condition) == true) {
            $user->recordLog($_SESSION['schCode'], 'Approval Data Validation', 'A validation remark has been added on the ' . $infoType . ' information of the school with code : ' . $_SESSION['schCode']);
            $utility->notifier('success', 'You have Successfully submitted a validation remark for the ' . $infoType . ' information of the school with Code :: ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Approval') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'Approval information was not updated for ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Approval') . '&schCode=' . $_SESSION['schCode']);
        }
    }

    //Facility Data
    if (isset($_POST['Update_facility_form'])) {
        $tblName = '_sch_facility_record';
        $infoType = 'School Facility ';
        $condition = [
            'sch_fac_id' => $_POST['reference']
        ];
        $contact_data = [
            'vetted' => $_POST['validation']
        ];
        if ($model->upDate($tblName, $contact_data, $condition) == true) {
            $user->recordLog($_SESSION['schCode'], 'Facility Data Validation', 'A validation remark has been added on the ' . $infoType . ' information of the school with code : ' . $_SESSION['schCode']);
            $utility->notifier('success', 'You have Successfully submitted a validation remark for the ' . $infoType . ' information of the school with Code :: ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Facility') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'Facility information was not updated for ' . $_SESSION['schCode']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('Facility') . '&schCode=' . $_SESSION['schCode']);
        }
    } else {
        $utility->notifier('danger', 'Your request failed');
        $model->redirect('../pages/admin/index.php');
    }
}