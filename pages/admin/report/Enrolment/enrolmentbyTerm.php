<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Termly Enrolment Report for
                            <?php echo $sch_corporate_data['sch_name'] ?>
                        </h6>
                        <p class="text-sm">See information about all the Termly Class Enrolment Records submitted by the
                            selected school</p>
                    </div>
                    <div class="ms-auto d-flex">
                        <a type="button"
                            href="../../app/adminRouter.php?pageid=<?php echo base64_encode('enrolmentTable') ?>"
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
                                <th class="text-secondary opacity-7">S/N</th>
                                <th class="text-secondary opacity-7">Term</th>
                                <th class="text-secondary opacity-7">
                                    Number of Classes Filed</th>
                                <th class="text-secondary opacity-7">
                                    Number of Learners Filed</th>
                                <th class="text-secondary opacity-7">Remittance Due</th>
                                <th class="text-secondary opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if (!empty($enrolmentRecordbyTerm)) {
                                foreach ($enrolmentRecordbyTerm as $data) {
                                    ?>
                                    <tr>
                                        <td class="text-sm font-weight-normal">
                                            <div class="align-items-center">
                                                <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                    <?php echo $count++ ?>
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="text-sm font-weight-normal">

                                            <div class="align-items-center">
                                                <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                    <?php echo $data['termVariable'] ?>
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                            <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                <?php
                                                echo $data['RecordCount']
                                                    ?>
                                            </p>
                                        </td>
                                        <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                            <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                <?php
                                                echo $data['population']
                                                    ?>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php
                                            echo $utility->money($data['TotalAmount'])
                                                ?>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php
                                            echo '<a  href="../../app/adminRouter.php?pageid=' . base64_encode("schEnrolmentDetails") . '&termRef='.$data["termID"].'" class="btn btn-dark btn-sm me-1" type="button">View Breakdown</a>';
                                            ?>
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
</div>