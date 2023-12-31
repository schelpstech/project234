<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Termly Remittance Bill Report for
                            <?php echo $sch_corporate_data['sch_name']?>
                        </h6>
                        <p class="text-sm">See information about all the Termly Class Enrolment Records submitted by the
                            selected school for the stated term</p>
                    </div>
                    <div class="ms-auto d-flex">
                        <a type="button"
                            href="../../app/adminRouter.php?pageid=<?php echo base64_encode('enrolmentbyTerm') ?>&schCode=<?php echo ($_SESSION['schCode']) ?>"
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
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">S/N</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Term</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Class Name</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Class Population</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Class Tuition Fee</th>
                                <th class="text-secondary opacity-7">Remittance Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if (!empty($enrolmentRecord)) {
                                foreach ($enrolmentRecord as $data) {
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
                                                echo $data['className']
                                                    ?>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php
                                            echo $data['population']
                                                ?>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php
                                            echo $utility->money($data['tuition'])
                                                ?>
                                        </td>
                                        <td class="align-middle">
                                            <strong>
                                                <?php
                                                echo $utility->money(($data['population'] * $data['tuition']) * 0.02)
                                                    ?>
                                            </strong>
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