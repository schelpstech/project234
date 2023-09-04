<?php
include '../model/query.php';
//Change Password
if (isset($_POST['submit_academic_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Termly Report') {

    $tblName = 'academicreport';
    $academicData = [
        'schCode' => $_SESSION['active'],
        'examination' => htmlspecialchars($_POST['examination']),
        'examYear' => htmlspecialchars($_POST['examYear']),
        'classid' => htmlspecialchars($_POST['classid']),
        'numCandidates' => ($_POST['aboveCandidates'] + $_POST['avgCandidates'] + $_POST['belowCandidates']),
        'aboveCandidates' => htmlspecialchars($_POST['aboveCandidates']),
        'avgCandidates' => htmlspecialchars($_POST['avgCandidates']),
        'belowCandidates' => htmlspecialchars($_POST['belowCandidates']),
    ];
    if ($model->insert_data($tblName, $academicData) == true) {
        $user->recordLog($_SESSION['active'], 'New Academic Performance Record', 'An Academic Performance Record for ' . $_POST['examination'] . ' has been added to your school with code : ' . $_SESSION['active']);
        $utility->notifier('success', 'New Academic Performance Record for ' . $_POST['examination'] . ' has been added to your school with code : ' . $_SESSION['active']);
        $model->redirect('./router.php?pageid=' . base64_encode('academic'));
    } else {
        $utility->notifier('danger', 'We are unable to submit the Academic Performance Record! Please try again');
        $model->redirect('./router.php?pageid=' . base64_encode('academic'));
    }

} elseif (isset($_POST['Update_academic_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Termly Report') {
    
    $tblName = 'academicreport';
    $condition = [
            'schCode' => $_SESSION['active'],
            'acad_record_id ' => $_SESSION['reportRef'],
    ];
    $updateData = [
        'schCode' => $_SESSION['active'],
        'examination' => htmlspecialchars($_POST['examination']),
        'examYear' => htmlspecialchars($_POST['examYear']),
        'classid' => htmlspecialchars($_POST['classid']),
        'numCandidates' => ($_POST['aboveCandidates'] + $_POST['avgCandidates'] + $_POST['belowCandidates']),
        'aboveCandidates' => htmlspecialchars($_POST['aboveCandidates']),
        'avgCandidates' => htmlspecialchars($_POST['avgCandidates']),
        'belowCandidates' => htmlspecialchars($_POST['belowCandidates']),
    ];
    
    if ($model->upDate($tblName, $updateData, $condition) == true) {
        $user->recordLog($_SESSION['active'], 'Academic Performance Record Update', 'An Update on the Academic Performance Record for ' . $_POST['examination'] . ' has been added to your school with code : ' . $_SESSION['active']);
        $utility->notifier('success', 'An Update on the Academic Performance Record for ' . $_POST['examination'] . ' has been added to your school with code : ' . $_SESSION['active']);
        $model->redirect('./router.php?pageid=' . base64_encode('academic'));
    } else {
        $utility->notifier('danger', 'We are unable to submit an update for the  Academic Performance Record! Please try again');
        $model->redirect('./router.php?pageid=' . base64_encode('academic'));
    }
}
else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}