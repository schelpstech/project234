<?php
include '../model/query.php';


//Change Password
if (isset($_POST['profileUpdate']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Authentication') {
    //Check Token
    if(isset($_SESSION['email_token']) && !empty($_SESSION['email_token']) && $_SESSION['email_token'] === $_POST['token'] ){

        $tblName = 'tbl_sch_portal_admin';
        $conditions = [
            'where' => [
                'schCode' => $_SESSION['active'],
            ],
            'return_type'=> 'count',
        ];
        $ifExist = $model->getRows($tblName, $conditions);

        switch ($ifExist){
            case 0 ;
            $profileData = array(
                'schCode' => $_SESSION['active'],
                'lastName' => htmlspecialchars($_POST['surName']),
                'firstName' => htmlspecialchars($_POST['firstName']),
                'otherName' => htmlspecialchars($_POST['otherName']),
                'gender' => htmlspecialchars($_POST['gender']),
                'phone' => htmlspecialchars($_POST['phone']),
                'jobTitle' => htmlspecialchars($_POST['jobTitle']),
                'email' => htmlspecialchars($_POST['emailAddress']),
            );
            if ($model->insert_data($tblName, $profileData) == true) {
                $user->recordLog($_POST['sch_code'], 'School Admin Data Entry', 'Details for the school portal admin has been added for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully added details for the school portal admin for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('userProfile'));
            } else {
                $utility->notifier('dark', 'There was an error adding details for the school portal admin for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('userProfile'));
            }
            break;

            case 1;

            $profileData = [
                'lastName' => htmlspecialchars($_POST['surName']),
                'firstName' => htmlspecialchars($_POST['firstName']),
                'otherName' => htmlspecialchars($_POST['otherName']),
                'gender' => htmlspecialchars($_POST['gender']),
                'phone' => htmlspecialchars($_POST['phone']),
                'jobTitle' => htmlspecialchars($_POST['jobTitle']),
                'email' => htmlspecialchars($_POST['emailAddress']),
            ];
            $condition = [
                'schCode' => $_SESSION['active'],
            ];
            if ($model->upDate($tblName, $profileData, $condition) == true) {
                $user->recordLog($_POST['sch_code'], 'School Admin Data Update', 'Details for the school portal admin has been updated for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully updated details for the school portal admin for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('userProfile'));
            } else {
                $utility->notifier('dark', 'There was an error updating details for the school portal admin for school with code: ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('userProfile'));
            }
            break;
            default:
            $utility->notifier('dark', 'Sorry we didnt understand your request');
            $model->redirect('./router.php?pageid=' . base64_encode('userProfile'));
        }
    }else {
        $utility->notifier('dark', 'Sorry you can not modify school portal admin without validating by email');
        $model->redirect('./router.php?pageid=' . base64_encode('userProfile'));
    }


}else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}