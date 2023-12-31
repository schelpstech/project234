<?php
include '../model/query.php';
//Change Password
if (isset($_POST['submit_class_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'availableClasses') {

    $tblName = 'tbl_classes';
    $classData = [
        'schCode' => $_SESSION['active'],
        'className' => htmlspecialchars($_POST['className']),
        'classSection' => htmlspecialchars($_POST['classSection']),
        'classArm' => htmlspecialchars($_POST['classArms']),
    ];
    if ($model->insert_data($tblName, $classData) == true) {
        $user->recordLog($_SESSION['active'], 'New Class Created', 'A new class ' . $_POST['className'] . ' has been added to school with code : ' . $_SESSION['active']);
        $utility->notifier('success', 'A new class ' . $_POST['className'] . ' has been added to school with code : ' . $_SESSION['active']);
        $model->redirect('./router.php?pageid=' . base64_encode('availableClasses'));
    } else {
        $utility->notifier('danger', 'We are unable to create using the classname entered! Please try again');
        $model->redirect('./router.php?pageid=' . base64_encode('availableClasses'));
    }
} elseif (isset($_POST['submit_enrolment_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'availableClasses') {
    $tblName = '_tbl_termly_enrolment';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
            'termID' => htmlspecialchars($_POST['termID']),
            'classID' => htmlspecialchars($_POST['classID']),
        ],
        'return_type' => 'count',
    ];
    $ifExist = $model->getRows($tblName, $conditions);
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
            'termID' => htmlspecialchars($_POST['termID']),
            'filed' => 1,
        ],
        'return_type' => 'count',
    ];
    $filingStatus = $model->getRows($tblName, $conditions);
    if ($ifExist == 0) {
        if ($filingStatus == 0) {
            $classData = [
                'schCode' => $_SESSION['active'],
                'termID' => htmlspecialchars($_POST['termID']),
                'classID' => htmlspecialchars($_POST['classID']),
                'population' => htmlspecialchars($_POST['classPOP']),
                'tuition' => htmlspecialchars($_POST['tuition']),
            ];
            if ($model->insert_data($tblName, $classData) == true) {
                $user->recordLog($_SESSION['active'], 'Termly Enrolment Record', 'A termly class enrolment record has been added to school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'A new termly class enrolment record has been added to school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
            } else {
                $utility->notifier('danger', 'We are unable to submit enrolment record for selected class! Please try again');
                $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
            }
        } else {
            $utility->notifier('danger', 'Unauthorised! An Invoice has been generated for the selected term! Please contact secretariat');
            $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
        }
    } else {
        $utility->notifier('danger', 'Duplicate Record! An enrolment record has been submitted for selected class! Please delete and try again');
        $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
    }
} elseif (isset($_POST['update_enrolment_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'availableClasses') {

    $tblName = '_tbl_termly_enrolment';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
            'recordid' => $_SESSION['enrolmentRef'],
        ],
        'return_type' => 'count',
    ];
    $ifExist = $model->getRows($tblName, $conditions);

    if ($ifExist == 1) {
        $classData = [
            'schCode' => $_SESSION['active'],
            'termID' => htmlspecialchars($_POST['termID']),
            'classID' => htmlspecialchars($_POST['classID']),
            'population' => htmlspecialchars($_POST['classPOP']),
            'tuition' => htmlspecialchars($_POST['tuition']),
        ];
        $condition = [
            'schCode' => $_SESSION['active'],
            'recordid' => $_SESSION['enrolmentRef'],
        ];

        if ($model->upDate($tblName, $classData, $condition) == true) {
            $user->recordLog($_SESSION['active'], 'Updated Class Termly Enrolment Data ', 'An update has been made to the termly enrolment data for a class in school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'Update on Class Termly Enrolment Data has been successfully submitted for school with code : ' . $_SESSION['active']);
            $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
        } else {
            $utility->notifier('danger', 'We are unable to edit Class Termly Enrolment Data ! Please try again');
            $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
        }
    } else {
        $utility->notifier('danger', 'We are unable to find the submitted Class Termly Enrolment Data! Please try again');
        $model->redirect('./router.php?pageid=' . base64_encode('enrolment'));
    }
} elseif (isset($_POST['generateInvoice']) && !empty($_SESSION['current_page']) && ($_SESSION['current_page']) == 'availableClasses') {
    if (!empty($_SESSION['remittanceDue'])) {
        $tblName = '_tbl_termlyinvoice';
        $conditions = [
            'where' => [
                'schCode' => $_SESSION['active'],
                'termRef' => $_POST['termID'],
                'invType' => 'Termly Remittance',
            ],
            'return_type' => 'count',
        ];
        $ifExist = $model->getRows($tblName, $conditions);

        if ($ifExist == 0) {

            if (strlen($_POST['rebate']) > 1) {
                // Split the string at the hyphen ("-")
                $parts = explode("-", $_POST['rebate']);
                // Assign each part to separate variables
                $rebateRef = $parts[0];
                $rebateAmount = $parts[1];
            } else {
                $rebateRef = "N/A";
                $rebateAmount = 0;
            }
            $invoiceData = [
                'schCode' => $_SESSION['active'],
                'invReference' => $utility->generateRandomDigits(8),
                'invType' => 'Termly Remittance',
                'amountPayable' => (intval($_SESSION['remittanceDue']) - intval($rebateAmount)),
                'termRef' => htmlspecialchars($_POST['termID']),
                'rebate' => $rebateRef,
                'rebateAmount' => $rebateAmount,
                'invAmount' => intval($_SESSION['remittanceDue'])
            ];
            $tableName = '_tbl_termly_enrolment';
            $condition = [
                'schCode' => $_SESSION['active'],
                'termID' => htmlspecialchars($_POST['termID']),
            ];
            $classData = [
                'filed' => 1
            ];


            if (($model->upDate($tableName, $classData, $condition) == true) && ($model->insert_data($tblName, $invoiceData) == true)) {
                $user->recordLog($_SESSION['active'], 'Termly Invoice Generated ', 'A Termly Invoice has been generated for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'A Termly Invoice has been generated successfully for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('billGenerator'));
            } else {
                $utility->notifier('danger', 'We are unable to generate a termly invoice for selected school ! Please try again');
                $model->redirect('./router.php?pageid=' . base64_encode('billGenerator'));
            }
        } else {
            $utility->notifier('danger', 'An Invoice has already been generated for the selected term! Kindly create a support ticket for further assistance');
            $model->redirect('./router.php?pageid=' . base64_encode('billGenerator'));
        }
    } else {
        $utility->notifier('dark', 'Error! You can not generate an invoice without submitting enrolment and tuition data');
        $model->redirect('./router.php?pageid=' . base64_encode('billGenerator'));
    }
} else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}