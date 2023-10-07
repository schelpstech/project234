<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <h6 class="font-weight-semibold text-lg mb-0">Transactions</h6>
                    <p class="text-sm">See information about all personnel of the school</p>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">

            <div class="table-responsive">
                <table class="table table-flush" id="datatable-search">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center text-xs font-weight-semibold ">Invoice ID</th>
                            <th class="text-center text-xs font-weight-semibold ">
                                Invoice Type</th>
                            <th class="text-center text-xs font-weight-semibold ">
                                Bill Amount</th>
                            <th class="text-center text-xs font-weight-semibold ">
                                Rebate Amount</th>
                            <th class="text-center text-xs font-weight-semibold ">
                                 Amount Payable</th>
                            <th class="text-center text-xs font-weight-semibold ">
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
                                    <td class=" text-center  align-middle">
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

                                    <td class="text-center align-middle text-center text-sm">
                                        <?php
                                        if ($data['invStatus'] == 0 && $data['vetting'] == 0) {
                                            echo '<a  href="#" class="btn btn-dark btn-sm me-1" type="button">Pending Validation</a>';
                                        } elseif ($data['invStatus'] == 0 && $data['vetting'] == 1) {
                                            echo '<a  href="../../app/router.php?pageid=' . base64_encode('uploadEvidenceofPayment') . '&invoiceNum=' . $data['invReference'] . '" class="btn btn-primary btn-sm me-1" type="button">Pending Payment: Upload Evidence of Payment</a>';
                                        } elseif ($data['invStatus'] == 1 && $data['vetting'] == 1) {
                                            echo '<a href="#" class="btn btn-warning btn-sm me-1" type="button">Payment Awaiting Confirmation</a>';
                                        } elseif ($data['invStatus'] == 2 && $data['vetting'] == 1) {
                                            echo '<a href="#" class="btn btn-success btn-sm me-1" type="button">Payment Confirmed. Download Receipt</a>';
                                        } else {
                                            echo '<a  href="#" class="btn btn-danger btn-sm me-1" type="button">Contact Support</a>';
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