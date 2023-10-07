<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <h6 class="font-weight-semibold text-lg mb-0">Termly Invoices of
                        <?php echo $sch_corporate_data['sch_name'] ?>
                    </h6>
                </div>
                <div class="ms-auto d-flex">
                    <a type="button"
                        href="../../app/adminRouter.php?pageid=<?php echo base64_encode('financeProfile') ?>"
                        class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Back</strong>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">

            <div class="table-responsive">
                <table class="table table-flush" id="datatable-search">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Invoice ID</th>
                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7 align-middle">
                                Invoice Type</th>
                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7 align-middle">
                                Bill Amount</th>
                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7 align-middle">
                                Rebate Amount</th>
                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7 align-middle">
                                 Amount Payable</th>
                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7 align-middle">
                                Status</th>
                            <th class="text-secondary opacity-7 align-middle">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($invoiceList)) {
                            foreach ($invoiceList as $data) {
                                ?>
                                <tr>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                            <?php echo $data['invReference'] ?>
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                            <?php echo $data['termVariable'] ?> -
                                            <?php echo $data['invType'] ?>
                                        </p>
                                    </td>
                                    <td class="text-center align-middle">
                                        <strong>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?php echo $utility->money($data['invAmount']) ?>
                                            </p>
                                        </strong>
                                    </td>
                                    <td class="text-center align-middle">
                                        <strong>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?php echo $utility->money($data['rebateAmount']) ?>
                                            </p>
                                        </strong>
                                    </td>
                                    <td class="text-center align-middle">
                                        <strong>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?php echo $utility->money($data['amountPayable']) ?>
                                            </p>
                                        </strong>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <?php
                                        $invType = $data['invType'];
                                        $invStatus = $data['invStatus'];
                                        $vetting = $data['vetting'];

                                        switch ($invType) {
                                            case "Termly Remittance":
                                                if ($invStatus == 0 && $vetting == 0) {
                                                    echo
                                                        '<a href="../../app/adminRouter.php?pageid=' . base64_encode("InvoiceDetails") . '&termRef=' . $data["termRef"] . '"
                                                                    class="btn btn-dark btn-sm me-1" type="button">
                                                                    Pending Validation. Click to Validate
                                                        </a>';
                                                } elseif ($invStatus == 0 && $vetting == 1) {
                                                    echo '<a href="#" class="btn btn-primary btn-sm me-1" type="button">Pending Payment</a>';
                                                } elseif ($invStatus == 1 && $vetting == 1) {
                                                    echo '<a href="#" class="btn btn-warning btn-sm me-1" type="button">Payment Awaiting Confirmation</a>';
                                                } elseif ($invStatus == 2 && $vetting == 1) {
                                                    echo '<a href="#" class="btn btn-success btn-sm me-1" type="button">Payment Confirmed. Download Receipt</a>';
                                                } else {
                                                    echo '<a href="#" class="btn btn-danger btn-sm me-1" type="button">Contact Support</a>';
                                                }
                                                break;

                                            default:
                                                echo '<a href="#" class="btn btn-danger btn-sm me-1" type="button">Contact Support</a>';
                                                break;
                                        }
                                        ?>




                                    </td>

                                    <td class="align-middle">
                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                            <?php echo $data['recordTime'] ?>
                                        </p>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>