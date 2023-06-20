<?php
include '../model/query.php';
//Change Password
if (isset($_POST['uploadPaymentEvidence']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Finance') {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 524288; // 500kb
    $paymentEvidenceUploadPath = '../assets/storage/Paymentevidence';

    //Handle Payment Evidence Upload
    $result = $utility->handleUploadedFile('Paymentevidence', $allowedTypes, $maxFileSize, $paymentEvidenceUploadPath);
    if (isset($_SESSION['fileName']) && $result == 'success') {
        $tblName = '_tbl_termlyinvoice';
        $condition = [
            'where' => [
                'schCode' => $_SESSION['active'],
                'invReference' => $_POST['invReference'],
                'vetting' => 1
            ],
            'return_type' => 'count',
        ];
        $ifExist = $model->getRows($tblName, $condition);

        //If Invoice is Valid and Active
        if ($ifExist == 1) {
              //Create Transaction Record           
            $tblName = '_tbl_transaction';
            $paymentData = [
                'transactionRef' => $utility->generateRandomDigits(10),
                'schCode' => $_SESSION['active'],
                'invoiceID' => $_POST['invReference'],
                'paymentEvidence' => $paymentEvidenceUploadPath . '/' . $_SESSION['fileName'],
                'paymentType' => $_POST['paymentType'],
                'submittedOn' => date("Y-m-d"),
            ];
             //Update Invoice Status
             $invTblName = '_tbl_termlyinvoice';
             $invCondition = [
                 'schCode' => $_SESSION['active'],
                 'invReference' => $_POST['invReference']
             ];
             $invoiceData = [
                 'invStatus' => 1
             ];

            if ($model->insert_data($tblName, $paymentData) == true &&  $model->upDate($invTblName, $invoiceData, $invCondition)  == true ) {

                $user->recordLog($_SESSION['active'], 'Payment Evidence Upload', 'A Payment Evidence  has been uploaded for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'Payment Evidence has been submitted successfully for school with code : ' . $_SESSION['active']);
                $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
            } else {
                $utility->notifier('danger', 'Record Error! We are unable to upload Payment Evidence for selected school ! Please try again');
                $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
            }
        } else {
            $utility->notifier('danger', 'Invoice Reference Not Verified! Payment Evidence  can not be submitted for an invalid Invoice Reference! Kindly create a support ticket for further assistance');
            $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
        }
    } else {
        $utility->notifier('dark', 'Upload Error! Payment Evidence could not be uploaded. Check the file and Try again');
        $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
    }
} else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}