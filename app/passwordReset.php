<?php
    include '../model/adminQuery.php';

if (isset($_POST['resetSchPassword']) && isset($_SESSION['activeAdmin'])) {

    $tblName = '_tbl_sch_access';
    $conditions = [
        'where' => [
            'user_name' => $_POST['schCode'],
        ],
        'return_type' => 'single',
    ];
    $user_details = $model->getRows($tblName, $conditions);

    if (!empty($user_details)) {
        if ($user_details['user_password'] !== "abcd1234") {

            $condition = [
                'user_name' => $_POST['schCode'],
            ];
            $password_data = [
                'user_password' =>  $utility->inputEncode("abcd1234"),
            ];

            if ($model->upDate($tblName, $password_data, $condition) == true) {
                $user->recordLog($_POST['schCode'], 'Password RESET', 'A password reset has been done for school with code : ' . $_POST['schCode']);
                $utility->notifier('success', 'You have Successfully RESET password for School with code : ' . $_POST['schCode']);
                $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('ResetPassword'));
            } else {
                $utility->notifier('dark', 'Ooops: We were unable to respond to your request for a reset of password now. Try again! ');
                $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('ResetPassword'));
            }
        } else {
            $utility->notifier('dark', 'Ooops: Default Password has not been changed! ');
            $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('ResetPassword'));
        }
    } else {
        $utility->notifier('danger', 'Ooops: School Code is Invalid! ');
        $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('ResetPassword'));
    }
} else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}
?>