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
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Corporate') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'No corporate information was updated for ' . $_SESSION['schCode']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Corporate') . '&schCode=' . $_SESSION['schCode']);
        }
    }

    //Contact Data
    elseif (
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
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Contact') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'No contact information was updated for ' . $_SESSION['schCode']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Contact') . '&schCode=' . $_SESSION['schCode']);
        }
    }

    //Approval Data
    elseif (isset($_POST['Update_approval_form'])) {
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
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Approval') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'Approval information was not updated for ' . $_SESSION['schCode']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Approval') . '&schCode=' . $_SESSION['schCode']);
        }
    }

    //Facility Data
    elseif (isset($_POST['Update_facility_form'])) {
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
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Facility') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'Facility information was not updated for ' . $_SESSION['schCode']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('Facility') . '&schCode=' . $_SESSION['schCode']);
        }
    }
    //Personnel Data
    elseif (isset($_POST['updatePersonnelRecord'])) {
        $tblName = 'tbl_personnel_record';
        $condition = [
            'tbl_personnel_record.schCode' => $_SESSION['schCode'],
            'tbl_personnel_record.record_id' => $_SESSION['personnelRef'],
        ];
        $personnel_data = [
            'vetted' => $_POST['validation']
        ];
        if ($model->upDate($tblName, $personnel_data, $condition) == true) {
            $user->recordLog($_SESSION['schCode'], 'Personnel Data Validation', 'A validation remark has been added on the Personnel information of a staff with record ID : ' . $_SESSION['personnelRef'] . ' in school with code : ' . $_SESSION['schCode']);
            $utility->notifier('success', 'You have Successfully submitted a validation remark for this staff in school with code : ' . $_SESSION['schCode']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('personnelInfoPage') . '&personnelRef=' . $_SESSION['personnelRef']);
        } else {
            $utility->notifier('dark', 'No Personnel Data Validation was updated for ' . $_SESSION['schCode']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('personnelInfoPage') . '&personnelRef=' . $_SESSION['personnelRef']);
        }
    }
    //Rebate Application
    elseif (isset($_POST['Update_rebate_application_form'])) {
        $tblName = '_tbl_rebate_record';
        $condition = [
            'rebateRef' => $_SESSION['rebateRef'],
            'schCode' => $_SESSION['schCode']
        ];
        $personnel_data = [
            'rebateStatus' => $_POST['validation']
        ];
        if ($model->upDate($tblName, $personnel_data, $condition) == true) {
            $user->recordLog($_SESSION['schCode'], 'Rebate Application', 'A validation remark has been added on the Rebate Application Reference  : ' . $_SESSION['rebateRef'] . ' in school with code : ' . $_SESSION['schCode']);
            $utility->notifier('success', 'You have Successfully submitted a validation remark for Rebate Application  with Reference code : ' . $_SESSION['rebateRef']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('rebateDetails') . '&rebateRef=' . $_SESSION['rebateRef'] . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'No Validation remark was recorded for Rebate Application  with Reference code : ' . $_SESSION['rebateRef']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('rebateDetails') . '&rebateRef=' . $_SESSION['rebateRef'] . '&schCode=' . $_SESSION['schCode']);
        }
    }
    //Invoice Validation
    elseif (isset($_POST['invoice_validation_remarks'])) {
        $tblName = '_tbl_termlyinvoice';
        $condition = [
            'termRef' => $_SESSION['termRef'],
            'schCode' => $_SESSION['schCode'],
            'invReference' => $_POST['invoice_validation_remarks']
        ];
        $invoice_data = [
            'vetting' => $_POST['validation']
        ];
        if ($model->upDate($tblName, $invoice_data, $condition) == true) {
            $user->recordLog($_SESSION['schCode'], 'Invoice Validation Remark', 'A validation remark has been added on Invoice with Reference  : ' . $_POST['invoice_validation_remarks'] . ' in school with code : ' . $_SESSION['schCode']);
            $utility->notifier('success', 'You have Successfully submitted a validation remark for Invoice with Reference code : ' . $_POST['invoice_validation_remarks']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('schInvoicePage') . '&schCode=' . $_SESSION['schCode']);
        } else {
            $utility->notifier('dark', 'No Validation remark was recorded for Invoice with Reference code : ' .$_POST['invoice_validation_remarks']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('schInvoicePage') . '&schCode=' . $_SESSION['schCode']);
        }
    } else {
        $utility->notifier('danger', 'We couldnt verify your request');
        $model->redirect('../pages/admin/index.php');
    }
} else {
    $utility->notifier('danger', 'Your request failed');
    $model->redirect('../pages/admin/index.php');
}
