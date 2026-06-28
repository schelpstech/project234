<?php
include '../model/query.php';
require_once '../controller/AdminFinance.class.php';
require_once '../controller/PaystackPayment.class.php';

if (empty($_SESSION['activeAdmin'])) {
    $utility->notifier('danger', 'Access Denied! Please sign in again.');
    $model->redirect('../login/manager.php');
}

$returnUrl = '../pages/admin/index.php?pageid=' . base64_encode('transactionManager');
$postedCsrf = (string) ($_POST['financeCsrf'] ?? '');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['admin_finance_csrf']) || !hash_equals($_SESSION['admin_finance_csrf'], $postedCsrf)) {
    $utility->notifier('danger', 'Security check failed. Please reload the transaction manager and try again.');
    $model->redirect($returnUrl);
}

$finance = new AdminFinance($db_conn);

if (isset($_POST['confirmUploadedPayment'])) {
    $result = $finance->confirmUploadedPayment((string) ($_POST['schCode'] ?? ''), (string) ($_POST['invoiceReference'] ?? ''), $_SESSION['activeAdmin']);
    $utility->notifier($result['ok'] ? 'success' : 'danger', $result['message']);

    if ($result['ok']) {
        $user->recordLog($_POST['schCode'] ?? '', 'Payment Confirmed', 'Manual payment confirmed for invoice: ' . ($_POST['invoiceReference'] ?? ''));
    }

    $model->redirect($returnUrl);
}

if (isset($_POST['rejectUploadedPayment'])) {
    $result = $finance->rejectUploadedPayment((string) ($_POST['schCode'] ?? ''), (string) ($_POST['invoiceReference'] ?? ''), $_SESSION['activeAdmin']);
    $utility->notifier($result['ok'] ? 'warning' : 'danger', $result['message']);

    if ($result['ok']) {
        $user->recordLog($_POST['schCode'] ?? '', 'Payment Rejected', 'Manual payment evidence rejected for invoice: ' . ($_POST['invoiceReference'] ?? ''));
    }

    $model->redirect($returnUrl);
}

if (isset($_POST['verifyPaystackPayment'])) {
    $reference = (string) ($_POST['paystackReference'] ?? '');
    $paystack = new PaystackPayment($db_conn, $utility);
    $result = $paystack->verifyReference($reference);

    if ($result['ok']) {
        $receipt = $finance->issueReceiptForPaystackReference($reference, $_SESSION['activeAdmin']);
        $utility->notifier($receipt['ok'] ? 'success' : 'warning', $result['message'] . ' ' . $receipt['message']);
        $user->recordLog($_POST['schCode'] ?? '', 'Paystack Payment Verified', 'Paystack payment verified for reference: ' . $reference);
    } else {
        $utility->notifier('danger', $result['message']);
    }

    $model->redirect($returnUrl);
}

if (isset($_POST['issueReceipt'])) {
    $result = $finance->issueReceiptForInvoice((string) ($_POST['invoiceReference'] ?? ''), $_SESSION['activeAdmin']);
    $utility->notifier($result['ok'] ? 'success' : 'danger', $result['message']);

    if ($result['ok']) {
        $user->recordLog($_POST['schCode'] ?? '', 'Receipt Issued', 'Receipt issued for invoice: ' . ($_POST['invoiceReference'] ?? ''));
    }

    $model->redirect($returnUrl);
}

$utility->notifier('danger', 'We could not understand the finance request.');
$model->redirect($returnUrl);

?>
