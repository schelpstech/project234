<?php
require_once __DIR__ . '/../controller/start.inc.php';
require_once __DIR__ . '/../controller/PaystackPayment.class.php';
require_once __DIR__ . '/../controller/AdminFinance.class.php';

$reference = (string) ($_GET['reference'] ?? ($_GET['trxref'] ?? ''));
$paystack = new PaystackPayment($db_conn, $utility);

try {
    $result = $paystack->verifyReference($reference);
    if ($result['ok']) {
        $finance = new AdminFinance($db_conn);
        $receipt = $finance->issueReceiptForPaystackReference($reference, 'paystack');
        if (!$receipt['ok']) {
            error_log('Paystack receipt issue failed: ' . $receipt['message']);
        }
    }

    $utility->notifier($result['ok'] ? 'success' : 'danger', $result['message']);

    if ($result['ok']) {
        $user->recordLog($_SESSION['active'] ?? 'Paystack', 'Paystack Payment Verified', 'Paystack payment verified for reference: ' . $reference);
    }
} catch (Throwable $e) {
    error_log('Paystack callback failed: ' . $e->getMessage());
    $utility->notifier('danger', 'Unable to verify the Paystack payment. Please contact support with your payment reference.');
}

if (!empty($_SESSION['active'])) {
    $model->redirect('./router.php?pageid=' . base64_encode('transaction'));
}

$model->redirect('../login/school.php');

?>
