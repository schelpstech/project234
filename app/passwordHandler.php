<?php
include '../model/query.php';
//Change Password
if (isset($_POST['changePassword']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Authentication') {

    $oldpwd = htmlspecialchars($_POST['oldPassword']);
    $newpwd = htmlspecialchars($_POST['newPassword']);
    $confirmpwd = htmlspecialchars($_POST['confirmPassword']);

    $tblName = '_tbl_sch_access';
    $conditions = [
        'where' => [
            'user_name' => $_SESSION['active'],
        ],
        'return_type'=> 'single',
    ];
    $user_details = $model->getRows($tblName, $conditions);

// Check if password is a new variable
    if(convert_uuencode($newpwd) != $user_details['user_password']){

    //Verify existing password
    if($user_details['user_password'] === 'abcd1234'){
        if($oldpwd === $user_details['user_password'] && $newpwd == $confirmpwd && strlen($newpwd) >= 8 && strlen($newpwd) <=16 ){
            $condition = [
                'user_name' => $_SESSION['active'],
            ];
            $password_data = [
                'user_password' => convert_uuencode($newpwd) ,
            ];

            if ($model->upDate($tblName, $password_data, $condition) == true) {
                $user->recordLog($_SESSION['active'], 'Password Change', 'A new password has been set for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully changed password for School with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
            } else {
                $utility->notifier('dark', 'Ooops: We were unable to respond to your request for a change of password now. Try again! ');
                $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
            }

        } else {
            $utility->notifier('dark', 'Requested operation can not be performed. Check to ensure old password is entered, new password matches the specifications and try again.');
            $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
        }
    }else{
        if(convert_uuencode($oldpwd) === $user_details['user_password'] && $newpwd == $confirmpwd && strlen($newpwd) >= 8 && strlen($newpwd) <=16 ){
            $condition = [
                'user_name' => $_SESSION['active'],
            ];
            $password_data = [
                'user_password' => convert_uuencode($newpwd) ,
            ];

            if ($model->upDate($tblName, $password_data, $condition) == true) {
                $user->recordLog($_SESSION['active'], 'Password Change', 'A new password has been set for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully changed password for School with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
            } else {
                $utility->notifier('dark', 'Ooops: We were unable to respond to your request for a change of password now. Try again! ');
                $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
            }

        } else {
            $utility->notifier('dark', 'Requested operation can not be performed. Check to ensure old password is entered, new password matches the specifications and try again.');
            $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
        }
    }
}else {
    $utility->notifier('dark', 'Ooops: You can not change your password to your existing password Try again! ');
    $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
}


}elseif (isset($_POST['resetSchPassword']) && isset($_SESSION['activeAdmin']) ) {
    require_once '../model/adminQuery.php';


    $tblName = '_tbl_sch_access';
    $conditions = [
        'where' => [
            'user_name' => $_POST['schCode'],
        ],
        'return_type'=> 'single',
    ];
    $user_details = $model->getRows($tblName, $conditions);

    if(!empty($user_details)){
        if($user_details['user_password'] !== "abcd1234"){

            $condition = [
                'user_name' => $_POST['schCode'],
            ];
            $password_data = [
                'user_password' => "abcd1234" ,
            ];

            if ($model->upDate($tblName, $password_data, $condition) == true) {
                $user->recordLog($_POST['schCode'], 'Password RESET', 'A password reset has been done for school with code : ' .$_POST['schCode']);
                $utility->notifier('success', 'You have Successfully RESET password for School with code : ' . $_POST['schCode']);
                $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('ResetPassword'));
            } else {
                $utility->notifier('dark', 'Ooops: We were unable to respond to your request for a reset of password now. Try again! ');
                $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('ResetPassword'));
            }
        
        }else {
            $utility->notifier('dark', 'Ooops: Default Password has not been changed! ');
            $model->redirect('../pages/admin/index.php?pageid='.base64_encode('ResetPassword'));
        }
    }else {
        $utility->notifier('danger', 'Ooops: School Code is Invalid! ');
        $model->redirect('../pages/admin/index.php?pageid='.base64_encode('ResetPassword'));
    }


}


else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}