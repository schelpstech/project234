<?php
include '../model/query.php';

$tblName = '_tbl_sch_access';
$tablename = 'log';

// Check if log-in form is submitted from website
if (isset($_POST['go_@head']) && $_POST['go_@head'] === ' login _now_ ') {

    // Retrieve form input

    if (!isset($_POST["school_code"])) {
        $notification_message .= 'School Code field must not be empty!.<br/>';
    } else {
        $userid = htmlspecialchars($_POST["school_code"]);
    }

    if (!isset($_POST["password"])) {
        $notification_message .= 'Password field must not be empty!.<br/>';
    } else {
        $userpwd = htmlspecialchars($_POST["password"]);
    }

    //check if username exist 

    $conditions = array(
        'return_type' => 'count',
        'where' => array(
            'user_name' => $userid,
        )
    );
    $confirm_user = $model->getRows($tblName, $conditions);


    if ($confirm_user == 1) {

        //select password 
        $conditions = array(
            'return_type' => 'single',
            'where' => array(
                'user_name' => $userid,
            )
        );
        $login_details = $model->getRows($tblName, $conditions);

        //Check Password

        if (isset($login_details['user_password'])) {
            $password = $login_details['user_password'];
        }

        if ($password === "abcd1234" && $password == $userpwd) {
            //Check Active Status
            if (isset($login_details['access_status']) && $login_details['access_status'] == 1) {
                $_SESSION['active'] = $_POST["school_code"];
                $user->recordLog($_POST["school_code"], 'Login Attempt', 'Successful - Access Granted');
                $utility->notifier('success', 'You have been Successfully Logged in');
                $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
            } else {
                $user->recordLog($_POST["school_code"], 'Login Attempt', 'Unsuccessful - Access Denied');
                $utility->notifier('danger', 'Access Denied! Contact administrator');
                $model->redirect($_SERVER['HTTP_REFERER']);
            }
        } elseif ($password != "abcd1234" && $password == convert_uuencode($userpwd)) {
            //Check Active Status
            if (isset($login_details['access_status']) && $login_details['access_status'] == 1) {
                $_SESSION['active'] = $_POST["school_code"];
                $user->recordLog($_POST["school_code"], 'Login Attempt', 'Successful - Access Granted');
                $utility->notifier('success', 'You have been Successfully Logged in');
                $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
            } else {
                $user->recordLog($_POST["school_code"], 'Login Attempt', 'Unsuccessful - Access Denied');
                $utility->notifier('danger', 'Access Denied! Contact administrator');
                $model->redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            // Record Log Access for incorrect password
            $user->recordLog($_POST["school_code"], 'Login Attempt', 'Unsuccessful - Wrong Password');
            $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
            $model->redirect($_SERVER['HTTP_REFERER']);
        }
    } else {

        //invalid Username
        $user->recordLog($_POST["school_code"], 'Login Attempt', 'Unsuccessful - Invalid Username');
        $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
        $model->redirect($_SERVER['HTTP_REFERER']);
    }
}elseif (isset($_POST['adminAuthenticator']) && $_POST['adminAuthenticator'] === ' login _now_ ') {
    // Retrieve form input

    if (!isset($_POST["username"])) {
        $notification_message .= 'Username field must not be empty!.<br/>';
    } else {
        $userid = htmlspecialchars($_POST["username"]);
    }

    if (!isset($_POST["password"])) {
        $notification_message .= 'Password field must not be empty!.<br/>';
    } else {
        $userpwd = htmlspecialchars($_POST["password"]);
    }

     //check if username exist 
    $tblName = "_tbl_admin_access";
     $conditions = [
        'return_type' => 'count',
        'where' => [
            'accessName' => $userid,
        ]
    ];
    $confirm_user = $model->getRows($tblName, $conditions);


    if ($confirm_user == 1) {

        //select password 
        $conditions = [
            'return_type' => 'single',
            'where' => [
                'accessName' => $userid,
            ]
        ];
        $login_details = $model->getRows($tblName, $conditions);

        //Check Password

        if (isset($login_details['accessKey'])) {
            $password = $login_details['accessKey'];
        }
if ( $userpwd === convert_uudecode($password)) {
            //Check Active Status
            if (isset($login_details['accessStatus']) && $login_details['accessStatus'] == 1) {
                $_SESSION['activeAdmin'] = $_POST["username"];
                $user->recordLog($_POST["username"], 'Admin Login Attempt', 'Successful - Access Granted');
                $utility->notifier('success', 'Hi Admin! You have been Successfully Logged in');
                $model->redirect('../pages/admin');
            } else {
                $user->recordLog($_POST["username"], 'Admin Login Attempt', 'Unsuccessful - Access Denied');
                $utility->notifier('danger', 'Access Denied! Contact administrator');
                $model->redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            // Record Log Access for incorrect password
            $user->recordLog($_POST["username"], 'Admin Login Attempt', 'Unsuccessful - Wrong Password');
            $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
            $model->redirect($_SERVER['HTTP_REFERER']);
        }
    } else {

        //invalid Username
        $user->recordLog($_POST["username"], 'Admin Login Attempt', 'Unsuccessful - Invalid Username');
        $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
        $model->redirect($_SERVER['HTTP_REFERER']);
    }


}elseif (isset($_POST['log_out_user']) && base64_decode($_POST['log_out_user']) == 'log_out_user_form') {

    $user->recordLog($_SESSION['active'], 'Logout', 'Closed Session');
    $model->log_out_user();
    session_start();
    $utility->notifier('info', 'Logged out successfully!');
    $model->redirect('../login/school.php');
} else {
    $utility->notifier('danger', 'Access Denied! You are attempting login from an unsecured page!');
    $model->redirect('../view/index.php');
}