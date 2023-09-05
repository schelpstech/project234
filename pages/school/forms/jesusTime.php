<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School - Termly Jesus Time Report</h6>
                    <p class="mb-2 text-sm mb-sm-0">Information provided in this form will be vetted and will not be
                        editable upon
                        approval by the secretariat</p>
                </div>
                <div class="ms-auto d-flex">
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('school_dashboard') ?>"
                        class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Home</strong>
                    </a>
                </div>
            </div>

            <form role="form" class="text-start" autocomplete="off" action="../../app/reportHandler.php" method="post"
                enctype="multipart/form-data">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['active'] ?>"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-4" style="display: none;" hidden="yes">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['active'] ?>"
                                name="sch_code" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="example-text-input" class="form-control-label">School name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="sch_name" disabled
                                value="<?php echo $sch_corporate_data['sch_name'] ?>" />
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Term</label>
                            <select type="text" class="form-control" name="termID" id="termID" required="yes">
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('tblcurrent_term');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['termVariable'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">How many Jesus Time Sessions <br>were
                            held in Selected Time?
                            <div class="form-group">
                                <input type="number" class="form-control" required="yes" min="0" max="1000"
                                    name="numberSessions" id="numberSessions" />
                            </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Total Number of Souls <br>Won in
                            Selected Term
                            :: </label>
                        <div class="form-group">
                            <input type="number" class="form-control" required="yes" min="0" max="1000"
                                name="numberSouls" id="numberSouls" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="example-text-input" class="form-control-label">Confirm Number of Souls - Write in
                            Words
                            :: </label>
                        <div class="form-group">
                            <input type="text" class="form-control" required="yes" name="numberSoulsword"
                                id="numberSoulsword" />
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="submit_jesusTime_form" class="btn btn-dark active btn-lg w-100">Submit
                    Termly
                    Jesus Time Report </button>
            </form>
        </div>
    </div>
</div>

<br>
<div class="col-lg-10 offset-1 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Submitted Jesus Time Report</h6>
                            <p class="text-sm">See information about all uploaded Termly Jesus Time Reports</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">

                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-search">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">S/N</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Term</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Number of Jesus
                                        Time Sessions</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Number of Souls
                                        Won</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Number in Words</th>
                                    <th class="text-secondary opacity-7">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                if (!empty($JTRecords)) {
                                    foreach ($JTRecords as $data) {
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
                                            <td class="text-sm font-weight-normal">
                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php
                                                        echo $data['numberSessions']
                                                            ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['numberSouls']
                                                        ?>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo $data['numberinWords']
                                                    ?>
                                            </td>
                                            <td class="align-middle">
                                                <a href="../../app/router.php?pageid=<?php echo base64_encode('editJTreport') ?>&reportRef=<?php echo ($data['JT_reportID']) ?>"
                                                    class="text-secondary font-weight-bold text-xs" data-bs-toggle="tooltip"
                                                    data-bs-title="Modify Report">
                                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32"
                                                        height="32" viewBox="0 0 64 64">
                                                        <path fill="none" stroke="#000" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"
                                                            d="M45.17,15.426L21.936,41.787c0,0,4.628,2.745,5.777,6.191c5.234-6.383,25.851-29.872,25.851-29.872	c4.117-4.404-5.745-14.362-11.362-8.426c-5.617,6.128-26.011,29.745-26.011,29.745l-3.415,15.83L20.149,52	c0,0-1.197-3.878-7.372-5.17">
                                                        </path>
                                                    </svg>
                                                </a>
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