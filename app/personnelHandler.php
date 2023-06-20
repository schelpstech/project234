<?php
include '../model/query.php';
//Add Personnel
if (isset($_POST['submitPersonnelRecord']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'add_personnel') {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 524288; // 500kb
    $passportUploadPath = '../assets/storage/personnel/passport';

    //Handle passport Upload
    $result = $utility->handleUploadedFile('passport', $allowedTypes, $maxFileSize, $passportUploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $passportFileName = $passportUploadPath . '/' . $_SESSION['fileName'];
        unset($_SESSION['fileName']);

        // Handle Identity Card Upload
        $idCardUploadPath = '../assets/storage/personnel/idcards';
        $result = $utility->handleUploadedFile('idCard', $allowedTypes, $maxFileSize, $idCardUploadPath);
        if (isset($_SESSION['fileName']) && $result == 'success') {
            $idcardFileName = $idCardUploadPath . '/' . $_SESSION['fileName'];
            unset($_SESSION['fileName']);

            // Handle Credential Upload
            $credentialUploadPath = '../assets/storage/personnel/credentials';
            $result = $utility->handleUploadedFile('credential', $allowedTypes, $maxFileSize, $credentialUploadPath);
            if (isset($_SESSION['fileName']) && $result == 'success') {
                $credentialFileName = $credentialUploadPath . '/' . $_SESSION['fileName'];
                unset($_SESSION['fileName']);


                $tblName = 'tbl_personnel_record';
                $personnelData = [
                    'schCode' => $_SESSION['active'],
                    'lastName' => htmlspecialchars($_POST['lastName']),
                    'firstName' => htmlspecialchars($_POST['firstName']),
                    'otherName' => htmlspecialchars($_POST['otherName']),
                    'title' => htmlspecialchars($_POST['title']),
                    'gender' => htmlspecialchars($_POST['gender']),
                    'dateOfBirth' => htmlspecialchars($_POST['dateBirth']),
                    'phoneNumber' => htmlspecialchars($_POST['phoneNumber']),
                    'emailAddress' => htmlspecialchars($_POST['email_address']),
                    'credentialType' => htmlspecialchars($_POST['qualification']),
                    'idCardType' => htmlspecialchars($_POST['identity']),
                    'jobTitle' => htmlspecialchars($_POST['jobTitle']),
                    'positionRef' => htmlspecialchars($_POST['positionId']),
                    'modeOfEmployment' => htmlspecialchars($_POST['modeEmployment']),
                    'employmentStart' => htmlspecialchars($_POST['dateEmployment']),
                    'passportFile' => $passportFileName,
                    'idCardFile' => $idcardFileName,
                    'credentialFile' => $credentialFileName,
                ];
                if ($model->insert_data($tblName, $personnelData) == true) {
                    $user->recordLog($_SESSION['active'], 'New Personnel record', 'A new school Personnel record was submitted for school with code : ' . $_SESSION['active']);
                    $utility->notifier('success', 'Personnel record has been submitted for review.');
                    $model->redirect('./router.php?pageid=' . base64_encode('add_personnel'));
                } else {
                    $utility->notifier('danger', 'Your submission failed! Please try again');
                    $model->redirect('./router.php?pageid=' . base64_encode('add_personnel'));
                }

            } else {
                $utility->notifier('danger', $result);
                $model->redirect('./router.php?pageid=' . base64_encode('add_personnel'));
            }
        } else {
            $utility->notifier('danger', $result);
            $model->redirect('./router.php?pageid=' . base64_encode('add_personnel'));
        }
    } else {
        $utility->notifier('danger', $result);
        $model->redirect('./router.php?pageid=' . base64_encode('add_personnel'));
    }
} elseif (isset($_POST['updatePersonnelRecord']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'add_personnel') {

    $tblName = 'tbl_personnel_record';
    $personnelData = [
        'lastName' => htmlspecialchars($_POST['lastName']),
        'firstName' => htmlspecialchars($_POST['firstName']),
        'otherName' => htmlspecialchars($_POST['otherName']),
        'title' => htmlspecialchars($_POST['title']),
        'gender' => htmlspecialchars($_POST['gender']),
        'dateOfBirth' => htmlspecialchars($_POST['dateBirth']),
        'phoneNumber' => htmlspecialchars($_POST['phoneNumber']),
        'emailAddress' => htmlspecialchars($_POST['email_address']),
        'jobTitle' => htmlspecialchars($_POST['jobTitle']),
        'positionRef' => htmlspecialchars($_POST['positionId']),
        'modeOfEmployment' => htmlspecialchars($_POST['modeEmployment']),
        'employmentStart' => htmlspecialchars($_POST['dateEmployment']),
    ];
    $condition = [
        'schCode' => $_SESSION['active'],
        'record_id' => $_SESSION['personnelRef'],
    ];
    if ($model->upDate($tblName, $personnelData, $condition) == true) {
        $user->recordLog($_SESSION['active'], ' Personnel record Update', 'An update was made on school Personnel record  for school with code : ' . $_SESSION['active']);
        $utility->notifier('success', 'Personnel record has been updated successfully. Submission will be reviewed.');
        $model->redirect('./router.php?pageid=' . base64_encode('editPersonnel') . '&personnelRef=' . $_SESSION['personnelRef']);
    } else {
        $utility->notifier('danger', 'Your update failed! Please try again');
        $model->redirect('./router.php?pageid=' . base64_encode('editPersonnel') . '&personnelRef=' . $_SESSION['personnelRef']);
    }

} elseif (isset($_POST['updateIdentityPersonnelRecord']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'add_personnel') {

    // Handle Identity Card Modification
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 524288; // 500kb
    $idCardUploadPath = '../assets/storage/personnel/idcards';
    $result = $utility->handleUploadedFile('idCard', $allowedTypes, $maxFileSize, $idCardUploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $idcardFileName = $idCardUploadPath . '/' . $_SESSION['fileName'];
        unset($_SESSION['fileName']);

        $tblName = 'tbl_personnel_record';
        $personnelData = [
            'idCardType' => htmlspecialchars($_POST['identity']),
            'idCardFile' => $idcardFileName
        ];
        $condition = [
            'schCode' => $_SESSION['active'],
            'record_id' => $_SESSION['personnelRef'],
        ];
        if ($model->upDate($tblName, $personnelData, $condition) == true) {
            $user->recordLog($_SESSION['active'], ' Personnel ID Card Modification', 'An update was made to the Identity Card details of a personnel for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'Personnel Identity Card has been updated successfully. Submission will be reviewed.');
            $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
        } else {
            $utility->notifier('danger', 'Your update failed! Please try again');
            $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
        }
    } else {
        $utility->notifier('danger', $result);
        $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
    }

} elseif (isset($_POST['updatePersonnelCredentialRecord']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'add_personnel') {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 524288; // 500kb
    $credentialUploadPath = '../assets/storage/personnel/credentials';
    $result = $utility->handleUploadedFile('credential', $allowedTypes, $maxFileSize, $credentialUploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $credentialFileName = $credentialUploadPath . '/' . $_SESSION['fileName'];
        unset($_SESSION['fileName']);

        $tblName = 'tbl_personnel_record';
        $personnelData = [
            'credentialType' => htmlspecialchars($_POST['qualification']),
            'credentialFile' => $credentialFileName,
        ];
        $condition = [
            'schCode' => $_SESSION['active'],
            'record_id' => $_SESSION['personnelRef'],
        ];
        if ($model->upDate($tblName, $personnelData, $condition) == true) {
            $user->recordLog($_SESSION['active'], ' Personnel Credential Modification', 'An update was made to the Credential details of a personnel for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'Personnel Credential record has been updated successfully. Submission will be reviewed.');
            $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
        } else {
            $utility->notifier('danger', 'Your update failed! Please try again');
            $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
        }
    } else {
        $utility->notifier('danger', $result);
        $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
    }

} elseif (isset($_POST['updatePersonnelPassportRecord']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'add_personnel') {
    //Handle passport Modification
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 524288; // 500kb
    $passportUploadPath = '../assets/storage/personnel/passport';
    $result = $utility->handleUploadedFile('passport', $allowedTypes, $maxFileSize, $passportUploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $passportFileName = $passportUploadPath . '/' . $_SESSION['fileName'];
        unset($_SESSION['fileName']);
        $tblName = 'tbl_personnel_record';
        $personnelData = [
            'passportFile' => $passportFileName,
        ];
        $condition = [
            'schCode' => $_SESSION['active'],
            'record_id' => $_SESSION['personnelRef'],
        ];
        if ($model->upDate($tblName, $personnelData, $condition) == true) {
            $user->recordLog($_SESSION['active'], ' Personnel Passport Modification', 'An update was made to the Passport photograph of a personnel for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'Personnel Passport photograph has been updated successfully. Submission will be reviewed.');
            $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
        } else {
            $utility->notifier('danger', 'Your update failed! Please try again');
            $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
        }
    } else {
        $utility->notifier('danger', $result);
        $model->redirect('./router.php?pageid=' . base64_encode('Personneldocs') . '&personnelRef=' . $_SESSION['personnelRef']);
    }

} else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}