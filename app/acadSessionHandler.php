<?php
include '../model/query.php';
//Change Password
if (isset($_POST['CreateSession'])) {
    $tblName = 'academicsession_tbl';
    $conditions = [
        'where' => [
            'session' => $_POST['startYear']."/".$_POST['endYear']
        ],
        'return_type' => 'count',
    ];
    $ifExist = $model->getRows($tblName, $conditions);
    if ($ifExist == 0) {
        $sessionData = [
            'session' =>  $_POST['startYear']."/".$_POST['endYear']
        ];
        if ($model->insert_data($tblName, $sessionData) == true) {
            $user->recordLog($_SESSION['active'], 'Academic Session Created', 'A new academic session has been created by admin with ID : ' . $_SESSION['active']);
            $utility->notifier('success', 'A new academic session has been created with Session ID : ' . $_POST['startYear']."/".$_POST['endYear']);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('managesession'));
        } else {
            $utility->notifier('danger', 'We are unable to create the inputed session ! Please try again');
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('managesession'));
        }
    } else {
        $utility->notifier('danger', 'Duplicate Record! A record exist for the selected academic session');
        $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('managesession'));
    }
}elseif (isset($_POST['createNewTerm'])) {
    list($sessionid, $sessionvariable) = explode("-", $_POST['session']);
    list($termid, $termvalue) = explode("-", $_POST['acadTerm']);

    $tblName = 'tblcurrent_term';
    $conditions = [
        'where' => [
            'sessionID' => $sessionid,
            'termID' => $termid
        ],
        'return_type' => 'count',
    ];
    $ifExist = $model->getRows($tblName, $conditions);
    if ($ifExist == 0) {
        // Change all other terms to inactive
        $setData = [
            'termStatus' => 0,
        ];
        $condition = [
            'termStatus' => 1,
        ];
        $model->upDate($tblName, $setData, $condition);

        $sessionData = [
            'sessionID' => $sessionid,
            'termID' => $termid,
            'termVariable' => $termvalue." ".$sessionvariable,
            'termStatus' => 1
        ];
        if ($model->insert_data($tblName, $sessionData) == true) {
            $user->recordLog($_SESSION['active'], 'Academic Term Created', 'A new academic term with variable '.$termvalue." ".$sessionvariable.' has been created by admin with ID : ' . $_SESSION['active']);
            $utility->notifier('success', 'A new academic term has been created with term variable : ' . $termvalue." ".$sessionvariable);
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('managesession'));
        } else {
            $utility->notifier('danger', 'We are unable to create the selected term ! Please try again');
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('managesession'));
        }
    } else {
        $utility->notifier('danger', 'Duplicate Record! A record exist for the selected academic term');
        $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('managesession'));
    }


}else {
    $utility->notifier('danger', 'Ooops! You sent the request from a broken link');
    $model->redirect('../pages/admin/index.php');
}