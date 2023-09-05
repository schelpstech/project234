<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School Rebate Application Form</h6>
                    <p class="mb-2 text-sm mb-sm-0">Information provided in this form will be vetted and will not be
                        editable
                        upon
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
                            <input type="text" class="form-control" name="sch_name"
                                value="<?php echo $sch_corporate_data['sch_name'] ?>" disabled />
                        </div>
                    </div>

                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6">
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

                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Total Number of Learners Applied
                            for</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="numLearners" min="0" 
                                required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Total Amount of Rebate Applied
                            for</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="amountRebate" min="0" 
                                required="yes" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Rebate Application
                            Letter</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="rebateLetter" required="yes"
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
                <button type="submit" name="submit_rebate_letter" class="btn btn-dark active btn-lg w-100">Submit
                    Rebate Application
                    Form</button>

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
                            <h6 class="font-weight-semibold text-lg mb-0">Submitted Rebate Applications</h6>
                            <p class="text-sm">See information about all submitted rebate Applications</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-search">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Application Ref</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Term</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Number of Learners</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Total Amount</th>
                                    <th class="text-secondary opacity-7">Application Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($rebateRecords)) {
                                    foreach ($rebateRecords as $data) {
                                        ?>
                                        <tr>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $data['rebateRef'] ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['termVariable'] ?>
                                                </p>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['numLearners'] ?>
                                                </p>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['amountRebate'] ?>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo ($data['rebateStatus'] == 1) ?
                                                    '
                                                        <button class="btn btn-success me-2" type="button">Approved</button>
                                                    ' :
                                                    '
                                                        <button class="btn btn-dark me-2" disabled type="button">Pending</button>
                                                    ';
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