<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School - Modify Termly Jesus Time Report</h6>
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
                                <option selected value="<?php echo $selectedJTRecords['termID'] ?>">
                                <?php echo $selectedJTRecords['termVariable'] ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">How many Jesus Time Sessions <br>were held in Selected Time?
                        <div class="form-group">
                            <input type="number" class="form-control" required="yes" min="0" max="1000" value="<?php echo $selectedJTRecords['numberSessions'] ?>" name="numberSessions" id="numberSessions" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Total Number of Souls <br>Won in Selected Term
                            :: </label>
                        <div class="form-group">
                            <input type="number" class="form-control" required="yes" min="0" max="1000" value="<?php echo $selectedJTRecords['numberSouls'] ?>" name="numberSouls" id="numberSouls" />
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                        <label for="example-text-input" class="form-control-label">Confirm Number of Souls - Write in Words
                            :: </label>
                        <div class="form-group">
                            <input type="text" class="form-control" required="yes" value="<?php echo $selectedJTRecords['numberinWords'] ?>" name="numberSoulsword" id="numberSoulsword" />
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="Update_jesusTime_form" class="btn btn-dark active btn-lg w-100">Update Termly 
                    Jesus Time Report </button>
            </form>
        </div>
    </div>
</div>
