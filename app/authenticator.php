<?php
include '../model/query.php';

$schoolLoginFallback = '../login/school.php';
$adminLoginFallback = '../login/manager.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $utility->notifier('danger', 'Access Denied! You are attempting login from an unsecured page!');
    $model->redirect($schoolLoginFallback);
}

if (isset($_POST['go_@head']) && $_POST['go_@head'] === ' login _now_ ') {
    $userid = strtoupper(trim((string) ($_POST['school_code'] ?? '')));
    $userpwd = (string) ($_POST['password'] ?? '');

    if ($userid === '' || $userpwd === '') {
        $utility->notifier('danger', 'School code and password are required.');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $schoolLoginFallback, $schoolLoginFallback);
    }

    $login_details = $model->getRows('_tbl_sch_access', [
        'return_type' => 'single',
        'where' => [
            'user_name' => $userid,
        ],
    ]);

    if (!$login_details) {
        $user->recordLog($userid, 'Login Attempt', 'Unsuccessful - Invalid Username');
        $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $schoolLoginFallback, $schoolLoginFallback);
    }

    $storedPassword = (string) ($login_details['user_password'] ?? '');
    if (!$utility->verifySchoolPassword($userpwd, $storedPassword)) {
        $user->recordLog($userid, 'Login Attempt', 'Unsuccessful - Wrong Password');
        $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $schoolLoginFallback, $schoolLoginFallback);
    }

    if (!isset($login_details['access_status']) || (int) $login_details['access_status'] !== 1) {
        $user->recordLog($userid, 'Login Attempt', 'Unsuccessful - Access Denied');
        $utility->notifier('danger', 'Access Denied! Contact administrator');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $schoolLoginFallback, $schoolLoginFallback);
    }

    session_regenerate_id(true);
    unset($_SESSION['activeAdmin']);
    $_SESSION['active'] = $userid;

    if ($utility->shouldMigratePassword($storedPassword)) {
        $model->upDate('_tbl_sch_access', [
            'user_password' => $utility->hashPassword($userpwd),
        ], [
            'user_name' => $userid,
        ]);
    }

    $user->recordLog($userid, 'Login Attempt', 'Successful - Access Granted');
    $utility->notifier('success', 'You have been Successfully Logged in');

    $nextPage = hash_equals($userpwd, 'abcd1234') ? 'accesscode' : 'school_dashboard';
    $model->redirect('./router.php?pageid=' . base64_encode($nextPage));
} elseif (isset($_POST['adminAuthenticator']) && $_POST['adminAuthenticator'] === ' login _now_ ') {
    $userid = strtolower(trim((string) ($_POST['username'] ?? '')));
    $userpwd = (string) ($_POST['password'] ?? '');

    if ($userid === '' || $userpwd === '') {
        $utility->notifier('danger', 'Username and password are required.');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $adminLoginFallback, $adminLoginFallback);
    }

    $login_details = $model->getRows('_tbl_admin_access', [
        'return_type' => 'single',
        'where' => [
            'accessName' => $userid,
        ],
    ]);

    if (!$login_details) {
        $user->recordLog($userid, 'Admin Login Attempt', 'Unsuccessful - Invalid Username');
        $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $adminLoginFallback, $adminLoginFallback);
    }

    $storedPassword = (string) ($login_details['accessKey'] ?? '');
    if (!$utility->verifyAdminPassword($userpwd, $storedPassword)) {
        $user->recordLog($userid, 'Admin Login Attempt', 'Unsuccessful - Wrong Password');
        $utility->notifier('danger', 'Access Denied! Invalid Login Credentials!');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $adminLoginFallback, $adminLoginFallback);
    }

    if (!isset($login_details['accessStatus']) || (int) $login_details['accessStatus'] !== 1) {
        $user->recordLog($userid, 'Admin Login Attempt', 'Unsuccessful - Access Denied');
        $utility->notifier('danger', 'Access Denied! Contact administrator');
        $model->redirect($_SERVER['HTTP_REFERER'] ?? $adminLoginFallback, $adminLoginFallback);
    }

    session_regenerate_id(true);
    unset($_SESSION['active']);
    $_SESSION['activeAdmin'] = $userid;

    if ($utility->shouldMigratePassword($storedPassword)) {
        $model->upDate('_tbl_admin_access', [
            'accessKey' => $utility->hashPassword($userpwd),
        ], [
            'accessName' => $userid,
        ]);
    }

    $user->recordLog($userid, 'Admin Login Attempt', 'Successful - Access Granted');
    $utility->notifier('success', 'Hi Admin! You have been Successfully Logged in');
    $model->redirect('../pages/admin');
} elseif (isset($_POST['log_out_user']) && base64_decode((string) $_POST['log_out_user'], true) === 'log_out_user_form') {
    $actor = $_SESSION['activeAdmin'] ?? $_SESSION['active'] ?? 'guest';
    $fallback = isset($_SESSION['activeAdmin']) ? $adminLoginFallback : $schoolLoginFallback;

    $user->recordLog($actor, 'Logout', 'Closed Session');
    $model->log_out_user();

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $utility->notifier('info', 'Logged out successfully!');
    $model->redirect($fallback);
}

$utility->notifier('danger', 'Access Denied! You are attempting login from an unsecured page!');
$model->redirect($schoolLoginFallback);
