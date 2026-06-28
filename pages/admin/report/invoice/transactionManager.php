<?php
require_once __DIR__ . '/../../../../controller/AdminFinance.class.php';

if (empty($_SESSION['admin_finance_csrf'])) {
    $_SESSION['admin_finance_csrf'] = bin2hex(random_bytes(32));
}

$finance = new AdminFinance($db_conn);
$financeSummary = $finance->getSummary();
$financeTransactions = $finance->getTransactions();
$financeCsrf = $_SESSION['admin_finance_csrf'];

$statusBadge = function ($row) {
    $vetting = (int) $row['vetting'];
    $status = (int) $row['invStatus'];

    if ($vetting === 0) {
        return '<span class="badge badge-sm bg-gradient-dark">Pending invoice validation</span>';
    }
    if ($status === 0) {
        return '<span class="badge badge-sm bg-gradient-primary">Awaiting payment</span>';
    }
    if ($status === 1) {
        return '<span class="badge badge-sm bg-gradient-warning">Awaiting confirmation</span>';
    }
    if ($status === 2) {
        return '<span class="badge badge-sm bg-gradient-success">Paid</span>';
    }

    return '<span class="badge badge-sm bg-gradient-danger">Review</span>';
};

$evidenceLink = function ($path) use ($utility) {
    $path = trim((string) $path);
    if ($path === '') {
        return '-';
    }
    if (stripos($path, 'Paystack online payment:') === 0) {
        return $utility->escape($path);
    }

    $fileName = basename(str_replace('\\', '/', $path));
    return '<a href="../../assets/storage/Paymentevidence/' . rawurlencode($fileName) . '" target="_blank" rel="noopener noreferrer">View receipt upload</a>';
};

$receiptUrl = function ($receiptNumber) use ($utility) {
    return '../../app/adminRouter.php?pageid=' . base64_encode('paymentReceipt') . '&receiptNo=' . $utility->escape($receiptNumber);
};
?>

<div class="row">
    <?php
    $cards = [
        ['label' => 'Total Invoices', 'value' => (int) ($financeSummary['total_invoices'] ?? 0)],
        ['label' => 'Pending Validation', 'value' => (int) ($financeSummary['pending_validation'] ?? 0)],
        ['label' => 'Awaiting Payment', 'value' => (int) ($financeSummary['awaiting_payment'] ?? 0)],
        ['label' => 'Awaiting Confirmation', 'value' => (int) ($financeSummary['awaiting_verification'] ?? 0)],
        ['label' => 'Paid', 'value' => (int) ($financeSummary['paid'] ?? 0)],
    ];
    foreach ($cards as $card):
    ?>
        <div class="col-lg col-md-4 col-sm-6 mb-4">
            <div class="border shadow-xs card h-100">
                <div class="card-body">
                    <p class="text-sm mb-1 text-secondary"><?php echo $utility->escape($card['label']); ?></p>
                    <h4 class="mb-0"><?php echo (int) $card['value']; ?></h4>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="border shadow-xs card h-100">
            <div class="card-body">
                <p class="text-sm mb-1 text-secondary">Validated Invoice Value</p>
                <h4 class="mb-0"><?php echo $utility->money((float) ($financeSummary['validated_amount'] ?? 0)); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="border shadow-xs card h-100">
            <div class="card-body">
                <p class="text-sm mb-1 text-secondary">Confirmed Payment Value</p>
                <h4 class="mb-0"><?php echo $utility->money((float) ($financeSummary['paid_amount'] ?? 0)); ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="border shadow-xs card">
    <div class="card-header border-bottom pb-0">
        <div class="d-sm-flex align-items-center">
            <div>
                <h6 class="font-weight-semibold text-lg mb-0">Transaction Manager</h6>
                <p class="text-sm">Verify uploaded receipts, re-check Paystack transactions, and issue printable receipts.</p>
            </div>
        </div>
    </div>
    <div class="card-body px-0 py-0">
        <div class="table-responsive">
            <table class="table table-flush js-datatable">
                <thead class="thead-light">
                    <tr>
                        <th>School</th>
                        <th>Invoice</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Receipt</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($financeTransactions as $row): ?>
                        <tr>
                            <td>
                                <strong><?php echo $utility->escape($row['schCode']); ?></strong><br>
                                <span class="text-sm"><?php echo $utility->escape($row['sch_name'] ?? ''); ?></span>
                            </td>
                            <td>
                                <strong><?php echo $utility->escape($row['invReference']); ?></strong><br>
                                <span class="text-sm"><?php echo $utility->escape(($row['termVariable'] ?? '') . ' - ' . ($row['invType'] ?? '')); ?></span>
                            </td>
                            <td>
                                <strong><?php echo $utility->money((float) $row['amountPayable']); ?></strong><br>
                                <span class="text-xs">Bill: <?php echo $utility->money((float) $row['invAmount']); ?></span>
                            </td>
                            <td><?php echo $statusBadge($row); ?></td>
                            <td class="text-sm">
                                <strong><?php echo $utility->escape($row['paymentType'] ?: ($row['paystack_status'] ? 'paystack' : '-')); ?></strong><br>
                                <?php echo $evidenceLink($row['paymentEvidence']); ?>
                                <?php if (!empty($row['paystack_reference'])): ?>
                                    <br><span class="text-xs">Paystack: <?php echo $utility->escape($row['paystack_status']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row['receipt_number'])): ?>
                                    <a href="<?php echo $receiptUrl($row['receipt_number']); ?>" class="btn btn-sm btn-success mb-0">
                                        Receipt
                                    </a>
                                <?php elseif ((int) $row['invStatus'] === 2): ?>
                                    <form action="../../app/adminFinanceHandler.php" method="post" class="mb-0">
                                        <input type="hidden" name="financeCsrf" value="<?php echo $utility->escape($financeCsrf); ?>">
                                        <input type="hidden" name="invoiceReference" value="<?php echo $utility->escape($row['invReference']); ?>">
                                        <input type="hidden" name="schCode" value="<?php echo $utility->escape($row['schCode']); ?>">
                                        <button type="submit" name="issueReceipt" class="btn btn-sm btn-dark mb-0">Issue</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-sm text-secondary">Not paid</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php if ((int) $row['vetting'] === 1 && (int) $row['invStatus'] === 1 && !empty($row['transactionRef'])): ?>
                                        <form action="../../app/adminFinanceHandler.php" method="post" class="mb-0">
                                            <input type="hidden" name="financeCsrf" value="<?php echo $utility->escape($financeCsrf); ?>">
                                            <input type="hidden" name="invoiceReference" value="<?php echo $utility->escape($row['invReference']); ?>">
                                            <input type="hidden" name="schCode" value="<?php echo $utility->escape($row['schCode']); ?>">
                                            <button type="submit" name="confirmUploadedPayment" class="btn btn-sm btn-success mb-0">Confirm</button>
                                        </form>
                                        <form action="../../app/adminFinanceHandler.php" method="post" class="mb-0">
                                            <input type="hidden" name="financeCsrf" value="<?php echo $utility->escape($financeCsrf); ?>">
                                            <input type="hidden" name="invoiceReference" value="<?php echo $utility->escape($row['invReference']); ?>">
                                            <input type="hidden" name="schCode" value="<?php echo $utility->escape($row['schCode']); ?>">
                                            <button type="submit" name="rejectUploadedPayment" class="btn btn-sm btn-outline-danger mb-0">Reject</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if (!empty($row['paystack_reference']) && $row['paystack_status'] !== 'success'): ?>
                                        <form action="../../app/adminFinanceHandler.php" method="post" class="mb-0">
                                            <input type="hidden" name="financeCsrf" value="<?php echo $utility->escape($financeCsrf); ?>">
                                            <input type="hidden" name="paystackReference" value="<?php echo $utility->escape($row['paystack_reference']); ?>">
                                            <input type="hidden" name="schCode" value="<?php echo $utility->escape($row['schCode']); ?>">
                                            <button type="submit" name="verifyPaystackPayment" class="btn btn-sm btn-info mb-0">Verify Paystack</button>
                                        </form>
                                    <?php endif; ?>

                                    <a href="../../app/adminRouter.php?pageid=<?php echo base64_encode('schInvoicePage'); ?>&schCode=<?php echo $utility->escape($row['schCode']); ?>" class="btn btn-sm btn-outline-dark mb-0">
                                        Invoices
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
