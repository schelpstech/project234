<div class="col-lg-10 offset-1 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School - Billing Information</h6>
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

            <form role="form" class="text-start" autocomplete="off" action="../../app/classHandler.php" method="post"
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Term</label>
                            <select type="text" class="form-control" name="termID" id="termID" required="yes"
                                onchange="termlyInvoice();">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Rebate Applicable</label>
                            <select type="text" class="form-control" name="rebate" id="rebate" required="yes">
                            </select>
                        </div>
                    </div>
                </div>
                <div id="invoiceTable">
                </div>
                <hr>
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" required="yes" type="checkbox" value="" id="confirmInvoice"
                                onchange="toggleButton()">
                            <label class="custom-control-label" for="customCheck1">I affirm that the enrolment and
                                tuition information for all classes are correct and complete. </label>
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="generateInvoice" id="submitInvoice" disabled
                    class="btn btn-dark active btn-lg w-100">Generate
                    Termly Remittance
                    Invoice</button>
            </form>
        </div>
    </div>
</div>