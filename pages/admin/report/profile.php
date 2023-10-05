<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">CRSM School Information Compliance Overview</h6>
                        <p class="text-sm">See information about all school</p>
                    </div>
                    <div class="ms-auto d-flex">
                        <button type="button" class="mb-0 btn btn-sm btn-dark me-2" id="print-button">
                            <strong>Print</strong>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-search">
                        <thead class="thead-light">
                            <tr>

                                <th class="text-secondary text-xs font-weight-semibold opacity-7">S/N</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">School Name</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Log In </th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Corporate Data</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Contact</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Available Classes</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Facility Records</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Approval Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if (!empty($complianceReport)) {
                                foreach ($complianceReport as $data) {
                                    ?>
                                    <tr>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <?php echo $count++ ?>
                                            </h6>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <?php echo $data['sch_code']." - ".$data['sch_name'] ?>
                                            </h6>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <?php echo $data['log_entries'] ?>
                                            </h6>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <a class="mb-0 btn btn-sm btn-default me-2"
                                                    href="../../app/adminRouter.php?pageid=<?php echo base64_encode('Corporate') ?>&schCode=<?php echo ($data['sch_code']) ?>">
                                                    <?php echo is_null($data['schLogo']) ? "No" : "Yes"?>
                                                </a>
                                            </h6>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <a class="mb-0 btn btn-sm btn-default me-2"
                                                    href="../../app/adminRouter.php?pageid=<?php echo base64_encode('Contact') ?>&schCode=<?php echo ($data['sch_code']) ?>">
                                                    Phone Contact : <?php echo $data['phone_entries']?><hr>
                                                    Email Contact : <?php echo $data['email_entries']?><hr>
                                                    Physical Address : <?php echo $data['address_entries']?>
                                                </a>
                                            </h6>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <a class="mb-0 btn btn-sm btn-default me-2"
                                                    href="../../app/adminRouter.php?pageid=<?php echo base64_encode('Classes') ?>&schCode=<?php echo ($data['sch_code']) ?>">
                                                    <?php echo $data['classes_entries']?>
                                                </a>
                                            </h6>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <a class="mb-0 btn btn-sm btn-default me-2"
                                                    href="../../app/adminRouter.php?pageid=<?php echo base64_encode('Approval') ?>&schCode=<?php echo ($data['sch_code']) ?>">
                                                    <?php echo $data['approval_entries']?>
                                                </a>
                                            </h6>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                <a class="mb-0 btn btn-sm btn-default me-2"
                                                    href="../../app/adminRouter.php?pageid=<?php echo base64_encode('Facility') ?>&schCode=<?php echo ($data['sch_code']) ?>">
                                                    <?php echo $data['facility_entries']?>
                                                </a>
                                            </h6>
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
</div>