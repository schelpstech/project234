<?php
require_once __DIR__ . '/../../../../controller/AdminFinance.class.php';

$receiptNo = preg_replace('/[^A-Za-z0-9_.@-]/', '', (string) ($_SESSION['receiptNo'] ?? ($_GET['receiptNo'] ?? '')));
$finance = new AdminFinance($db_conn);
$receipt = $finance->getReceipt($receiptNo);
?>

<?php if (!$receipt): ?>
    <div class="alert bg-gradient-danger text-white">
        Receipt could not be found.
    </div>
<?php else: ?>
    <style>
        @media print {
            .no-print,
            .sidenav,
            .navbar,
            .footer {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .receipt-card {
                box-shadow: none !important;
                border: 0 !important;
            }
        }
    </style>

    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="border shadow-xs card receipt-card">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h5 class="font-weight-semibold mb-1">CRSM Payment Receipt</h5>
                            <p class="text-sm mb-0">Receipt No: <?php echo $utility->escape($receipt['receipt_number']); ?></p>
                        </div>
                        <div class="ms-auto no-print">
                            <button type="button" onclick="window.print()" class="btn btn-sm btn-dark">Print Receipt</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Christ the Redeemer's Schools Management (CRSM)</h6>
                            <p class="text-sm mb-0">
                                The CRSM Secretariat<br>
                                Km 46, The Redemption Camp<br>
                                Lagos - Ibadan Express Road, Ogun State
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end mt-4 mt-md-0">
                            <p class="text-sm mb-1"><strong>Issued:</strong> <?php echo $utility->escape($receipt['issued_at']); ?></p>
                            <p class="text-sm mb-1"><strong>Issued by:</strong> <?php echo $utility->escape($receipt['issued_by']); ?></p>
                            <p class="text-sm mb-0"><strong>Method:</strong> <?php echo $utility->escape($receipt['payment_method'] ?: 'manual'); ?></p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-sm mb-1 text-secondary">Received From</p>
                            <h6><?php echo $utility->escape($receipt['sch_code'] . ' - ' . ($receipt['sch_name'] ?? '')); ?></h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-1 text-secondary">Invoice</p>
                            <h6><?php echo $utility->escape($receipt['invoice_reference']); ?></h6>
                            <p class="text-sm mb-0"><?php echo $utility->escape(($receipt['termVariable'] ?? '') . ' - ' . ($receipt['invType'] ?? '')); ?></p>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bill Amount</td>
                                    <td class="text-end"><?php echo $utility->money((float) $receipt['invAmount']); ?></td>
                                </tr>
                                <tr>
                                    <td>Approved Rebate</td>
                                    <td class="text-end"><?php echo $utility->money((float) $receipt['rebateAmount']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Amount Paid</strong></td>
                                    <td class="text-end"><strong><?php echo $utility->money((float) $receipt['amount_paid']); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-sm text-secondary mt-4 mb-0">
                        This receipt confirms payment received against the invoice stated above.
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
