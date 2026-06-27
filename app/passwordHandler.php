<?php
include '../model/query.php';

if (isset($_POST['changePassword']) && isset($_SESSION['current_page']) && $_SESSION['current_page'] == 'Authentication') {
    $oldpwd = (string) ($_POST['oldPassword'] ?? '');
    $newpwd = (string) ($_POST['newPassword'] ?? '');
    $confirmpwd = (string) ($_POST['confirmPassword'] ?? '');

    $user_details = $model->getRows('_tbl_sch_access', [
        'where' => [
            'user_name' => $_SESSION['active'],
        ],
        'return_type' => 'single',
    ]);

    if (!$user_details || !$utility->verifySchoolPassword($oldpwd, (string) $user_details['user_password'])) {
        $utility->notifier('dark', 'Requested operation can not be performed. Check your old password and try again.');
        $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
    }

    if ($newpwd !== $confirmpwd || strlen($newpwd) < 8 || strlen($newpwd) > 16) {
        $utility->notifier('dark', 'New password must be 8 to 16 characters and match the confirmation field.');
        $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
    }

    if (hash_equals($oldpwd, $newpwd)) {
        $utility->notifier('dark', 'You can not change your password to your existing password. Try again!');
        $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
    }

    $updated = $model->upDate('_tbl_sch_access', [
        'user_password' => $utility->hashPassword($newpwd),
    ], [
        'user_name' => $_SESSION['active'],
    ]);

    if ($updated !== false) {
        session_regenerate_id(true);
        $user->recordLog($_SESSION['active'], 'Password Change', 'A new password has been set for school with code : ' . $_SESSION['active']);
        $utility->notifier('success', 'You have Successfully changed password for School with code : ' . $_SESSION['active']);
        $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
    }

    $utility->notifier('dark', 'Ooops: We were unable to respond to your request for a change of password now. Try again!');
    $model->redirect('./router.php?pageid=' . base64_encode('accesscode'));
}

$utility->notifier('dark', 'Sorry we can not understand your request');
$model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
