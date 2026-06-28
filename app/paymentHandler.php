<?php
include '../model/query.php';
require_once '../controller/PaystackPayment.class.php';

if (isset($_POST['uploadPaymentEvidence']) || isset($_POST['initializePaystackPayment'])) {
    $postedCsrf = (string) ($_POST['paymentCsrf'] ?? '');
    if (empty($_SESSION['payment_csrf']) || !hash_equals($_SESSION['payment_csrf'], $postedCsrf)) {
        $utility->notifier('danger', 'Security check failed. Please reload the finance page and try again.');
        $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
    }
}

if (isset($_POST['initializePaystackPayment']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Finance') {
    $invoiceReference = (string) ($_POST['invReference'] ?? '');
    $paystack = new PaystackPayment($db_conn, $utility);

    try {
        $result = $paystack->initializeInvoicePayment($_SESSION['active'], $invoiceReference);

        if ($result['ok'] && !empty($result['authorization_url']) && filter_var($result['authorization_url'], FILTER_VALIDATE_URL)) {
            $user->recordLog($_SESSION['active'], 'Paystack Payment Initialized', 'Online payment initialized for invoice: ' . $invoiceReference);
            header('Location: ' . $result['authorization_url'], true, 302);
            exit;
        }

        $utility->notifier('danger', $result['message']);
    } catch (Throwable $e) {
        error_log('Paystack initialization failed: ' . $e->getMessage());
        $utility->notifier('danger', 'Unable to start online payment. Please try again or upload receipt evidence.');
    }

    $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
}

if (isset($_POST['uploadPaymentEvidence']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'Finance') {
    $invoiceReference = preg_replace('/[^A-Za-z0-9_.@-]/', '', (string) ($_POST['invReference'] ?? ''));
    $paymentType = (string) ($_POST['paymentType'] ?? '');
    if ($invoiceReference === '' || !in_array($paymentType, ['full'], true)) {
        $utility->notifier('danger', 'Invalid payment submission. Please try again from the finance page.');
        $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
    }

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
                'invReference' => $invoiceReference,
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
                'invoiceID' => $invoiceReference,
                'paymentEvidence' => $paymentEvidenceUploadPath . '/' . $_SESSION['fileName'],
                'paymentType' => $paymentType,
                'submittedOn' => date("Y-m-d"),
            ];
             //Update Invoice Status
             $invTblName = '_tbl_termlyinvoice';
             $invCondition = [
                 'schCode' => $_SESSION['active'],
                 'invReference' => $invoiceReference
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
