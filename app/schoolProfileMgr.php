<?php
include '../model/adminQuery.php';

//Create New School Profile

if (isset($_POST['create_school_form']) && isset($_SESSION['pageName']) && ($_SESSION['pageName']) == 'Create New CRSM School Profile') {
    $_POST['sch_code'] = strtoupper($_POST['sch_code']);
    $_POST['sch_name'] = strtoupper($_POST['sch_name']);
    //Check access table
    $tableName = '_tbl_sch_access';
    $conditions = [
        'where' => [
            'user_name' => $_POST['sch_code'],
        ],
        'return_type' => 'count',
    ];
    $ifExisted = $model->getRows($tableName, $conditions);

    //check Corporate Data
    $tblName = '_tbl_sch_corporate_data';
    $conditions = [
        'where' => [
            'sch_code' => $_POST['sch_code'],
        ],
        'return_type' => 'count',
    ];
    $ifExist = $model->getRows($tblName, $conditions);

    //Check If School Code Exist
    if ($ifExist == 0 && $ifExisted == 0) {
        //access data
        $profileData = [
            'sch_code' => htmlspecialchars($_POST['sch_code']),
            'sch_name' => htmlspecialchars($_POST['sch_name'])
        ];
        //corporate data
        $accessData = [
            'user_name' => htmlspecialchars($_POST['sch_code']),
            'user_password' => 'abcd1234',
            'access_status' => '1'
        ];

        //If Entry Successful
        if ($model->insert_data($tblName, $profileData) == true  && $model->insert_data($tableName, $accessData) == true) {
            $user->recordLog($_POST['sch_code'], 'School Profile Creation', 'Log in profile has been created for school with code : ' . $_POST['sch_code']);
            $utility->notifier('success', 'You have Successfully created a school profile for school ' . $_POST['sch_name'] . ' with School code : ' . $_POST['sch_code']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('schoolCreate'));
        } else {
            $utility->notifier('dark', 'There was an error creating a profile for school with code: ' . $_POST['sch_code']);
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('schoolCreate'));
        }
    } else {
        $utility->notifier('dark', 'School Code not Unique! A school exist already with school code: ' . $_POST['sch_code']);
        $model->redirect('./adminRouter.php?pageid=' . base64_encode('schoolCreate'));
    }
} else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}
