<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="mb-3 d-sm-flex align-items-center">
            <div>
                <h6 class="mb-0 text-lg font-weight-semibold">CRSM School Approval Records Form</h6>
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

        <form role="form" class="text-start" autocomplete="off" action="../../app/update.php" method="post"
            enctype="multipart/form-data">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">School code:</label>
                        <input type="text" class="form-control" value="<?php echo $_SESSION['active'] ?>" disabled />
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
                        <input type="text" class="form-control" name="sch_name"
                            value="<?php echo $sch_corporate_data['sch_name'] ?>" disabled />
                    </div>
                </div>

            </div>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Approval Type</label>
                        <select type="text" class="form-control" name="approval_type" id="approval_type" required="yes">
                            <option value="">select</option>
                            <?php
                            $option = $model->select_all('approval_type_tbl');
                            foreach ($option as $data) {
                                echo '<option value="' . $data['id'] . '">' . $data['approval_abbrv'] . ' - ' . $data['approval_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="example-text-input" class="form-control-label">Approval - Issued Date</i>:</label>

                    <div class="form-group">
                        <input type="date" class="form-control" name="approval_date" id="approval_date"
                            required="yes" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="example-text-input" class="form-control-label">Approval - Certificate</i>:</label>
                    <div class="form-group">
                        <input type="file" class="form-control" name="approval_cert" id="approval_cert" required="yes"
                            accept="image/png, image/gif, image/jpeg" size="524288" onchange="previewImage(this)" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-2">
                    <img id="preview" src="#" alt="Image Preview"
                        style="display:none; max-width: 100%; max-height: 100%;">
                </div>
            </div>

            <hr>
            <button type="submit" name="submit_approval_record" class="btn btn-dark active btn-lg w-100">Add Approval
                Details</button>

        </form>

    </div>
</div>
<br>

<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="my-4 row">
            <div class="col-lg-12 col-md-6">
                <div class="border shadow-xs card">
                    <div class="pb-0 card-header border-bottom">
                        <div class="mb-3 d-sm-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-lg font-weight-semibold">School Approval Details</h6>
                            </div>

                        </div>
                    </div>
                    <?php
                    if (!empty($sch_approval_data)) {
                        foreach ($sch_approval_data as $data) {
                            ?>
                            <div class="my-4 row">
                                <div class="col-lg-8 offset-2 col-md-6">
                                    <div class="card card-blog card-plain">
                                        <div class="position-relative">
                                            <a class="d-block blur-shadow-image">
                                                <img src="../<?php echo $data['approval_file'] ?>" alt="img-blur-shadow"
                                                    class="img-fluid shadow border-radius-lg">
                                            </a>
                                        </div>
                                        <div class="card-body px-0 pt-4">
                                            <p class="text-primary font-weight-bold text-sm text-uppercase">
                                                <?php echo $data['approval_date'] ?>
                                            </p>
                                            <?php
                                            echo ($data['vetted'] == 1) ?
                                                '<footer class="blockquote-footer text-gradient text-info text-sm ms-3">
                                                        <strong>Verified</strong> <cite title="Source Title">by admin</cite>
                                                    </footer>'
                                                :

                                                '<footer class="blockquote-footer text-gradient text-dark text-sm ms-3">
                                                        <strong>Pending Verification</strong> <cite title="Source Title">by admin</cite>
                                                    </footer>'
                                                ?>
                                            <a href="javascript:;">
                                                <h4>
                                                    <?php echo $data['approval_abbrv'] ?>
                                                </h4>
                                            </a>
                                            <p>
                                                <?php echo $data['approval_name'] ?>
                                            </p>
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-danger dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item"
                                                            href="../../app/delete.php?ref=<?php echo ($data['approval_rec_id']) ?>&type=approval_details">Remove</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>