<div class="col-lg-8 offset-2 col-md-12 ">
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
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('enrolment') ?>"
                        class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Back</strong>
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
                            <select type="text" class="form-control" name="termID" id="termID" <?php echo ($_SESSION['action'] == 1) ? 'disabled' : '' ?>>
                                <option value="<?php echo $enrolmentRecord['termID'] ?>"><?php echo $enrolmentRecord['termVariable'] ?></option>
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
                            <label for="example-text-input" class="form-control-label">Select Class</label>
                            <select type="text" class="form-control" name="classID" id="classID" <?php echo ($_SESSION['action'] == 1) ? 'disabled' : '' ?>>
                                <option value="<?php echo $enrolmentRecord['classID'] ?>"><?php echo $enrolmentRecord['className'] ?></option>
                                <option value="">select</option>
                                <?php
                                foreach ($availableClass as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['className'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Class Population
                            </i>:</label>
                        <div class="form-group">
                            <input type="number" min="1" class="form-control" <?php echo ($_SESSION['action'] == 1) ? 'disabled' : '' ?> value="<?php echo $enrolmentRecord['population'] ?>" name="classPOP"
                                id="classPOP" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Class Tuition Fee <i>(per
                                student)</i>
                            </i>:</label>
                        <div class="form-group">
                            <input type="number" min="1" class="form-control" <?php echo ($_SESSION['action'] == 1) ? 'disabled' : '' ?> value="<?php echo $enrolmentRecord['tuition'] ?>" name="tuition"
                                id="tuition" />
                        </div>
                    </div>
                </div>



                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo ($_SESSION['action'] == 1) ? '
                                            <button type="button"  data-bs-toggle="modal" data-bs-target="#modal-termly_enrolment" class="btn btn-danger active btn-lg w-100">Delete Termly Class
                                        Billing Information</button>'
                            : '<button type="submit" name="update_enrolment_form" class="btn btn-primary active btn-lg w-100">Update Termly Class
                                        Billing Information</button>' ?>
                    </div>
                    <div class="col-md-6">
                        <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('enrolment') ?>"
                            class="btn btn-dark active btn-lg w-100">
                            Back to List</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-termly_enrolment" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
    aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="py-3 text-center">
                    <i class="ni ni-bell-55 ni-3x"></i>
                    <h4 class="mt-4 text-gradient text-danger">You are about to delete a sensitive record!</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">No! Cancel</button>
                <a href="../../app/delete.php?ref=<?php echo ($enrolmentRecord['termID']) ?>&type=enrolmentRecord"
                    type="button" class="btn btn-danger">Yes! Delete</a>
            </div>
        </div>
    </div>
</div>