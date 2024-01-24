<?php
include '../model/query.php';
//Upload Academic Report
if (isset($_POST['submit_academic_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Termly Academic Report') {

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

} elseif (isset($_POST['Update_academic_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Termly Academic Report') {
    
    $tblName = 'academicreport';
    $condition = [
            'schCode' => $_SESSION['active'],
            'acad_record_id' => $_SESSION['reportRef'],
    ];
    $updateData = [
        'examination' => htmlspecialchars($_POST['examination']),
        'examYear' => htmlspecialchars($_POST['examYear']),
        'classid' => htmlspecialchars($_POST['classid']),
        'numCandidates' => ($_POST['aboveCandidates'] + $_POST['avgCandidates'] + $_POST['belowCandidates']),
        'aboveCandidates' => htmlspecialchars($_POST['aboveCandidates']),
        'avgCandidates' => htmlspecialchars($_POST['avgCandidates']),
        'belowCandidates' => htmlspecialchars($_POST['belowCandidates'])
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
//Jesus Time Report
elseif (isset($_POST['submit_jesusTime_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'JT Termly Report') {

    $tblName = '_termly_report_jesustime';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
            'termRef' => htmlspecialchars($_POST['termID']),
        ],
        'return_type'=> 'single',
    ];
    $checker = $model->getRows($tblName, $conditions);

    if(empty($checker)){
    $jtimeData = [
        'schCode' => $_SESSION['active'],
        'termRef' => htmlspecialchars($_POST['termID']),
        'numberSessions' => htmlspecialchars($_POST['numberSessions']),
        'numberSouls' => htmlspecialchars($_POST['numberSouls']),
        'numberinWords' => htmlspecialchars($_POST['numberSoulsword'])
    ];
    if ($model->insert_data($tblName, $jtimeData) == true) {
        $user->recordLog($_SESSION['active'], 'New Jesus Time Report', 'A Jesus Time Report been added to your school with code : ' . $_SESSION['active']);
        $utility->notifier('success', 'New Jesus Time Report has been added to your school with code : ' . $_SESSION['active']);
        $model->redirect('./router.php?pageid=' . base64_encode('jesusTime'));
    } else {
        $utility->notifier('danger', 'We are unable to submit the Jesus Time Report! Please try again');
        $model->redirect('./router.php?pageid=' . base64_encode('jesusTime'));
    }
} else {
    $utility->notifier('danger', 'A Jesus Time Report for the selected term exist! Please modify existing record instead');
    $model->redirect('./router.php?pageid=' . base64_encode('jesusTime'));
}

}elseif (isset($_POST['Update_jesusTime_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'JT Termly Report') {
    
    $tblName = '_termly_report_jesustime';
    $condition = [
            'schCode' => $_SESSION['active'],
            'JT_reportID' => $_SESSION['reportRef'],
    ];
    $updateData = [
        'numberSessions' => htmlspecialchars($_POST['numberSessions']),
        'numberSouls' => htmlspecialchars($_POST['numberSouls']),
        'numberinWords' => htmlspecialchars($_POST['numberSoulsword'])
    ];
    
    if ($model->upDate($tblName, $updateData, $condition) == true) {
        $user->recordLog($_SESSION['active'], 'Jesus Time Report Update', 'An Update on the Jesus Time Report has been added to your school with code : ' . $_SESSION['active']);
        $utility->notifier('success', 'An Update on the Jesus Time Report has been added to your school with code : ' . $_SESSION['active']);
        $model->redirect('./router.php?pageid=' . base64_encode('jesusTime'));
    } else {
        $utility->notifier('danger', 'We are unable to submit an update for the  Jesus Time Report! Please try again');
        $model->redirect('./router.php?pageid=' . base64_encode('jesusTime'));
    }
}
else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}