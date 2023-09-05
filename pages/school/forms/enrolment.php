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
                            <select type="text" class="form-control" name="termID" id="termID" required="yes">
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('tblcurrent_term');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['termVariable'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Class</label>
                            <select type="text" class="form-control" name="classID" id="classID">
                                <option value="">select</option>
                                <?php
                                foreach ($availableClass as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['className'].'</option>';
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
                            <input type="number" min="1" class="form-control" name="classPOP" id="classPOP" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Class Tuition Fee <i>(per student)</i>
                            </i>:</label>
                        <div class="form-group">
                            <input type="number" min="1" class="form-control" name="tuition" id="tuition" />
                        </div>
                    </div>
                </div>



                <hr>
                <button type="submit" name="submit_enrolment_form" class="btn btn-dark active btn-lg w-100">Submit Termly Class
                    Billing Information</button>
            </form>
        </div>
    </div>
</div>

<br>
<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Termly Remittance Bill</h6>
                            <p class="text-sm">See information about termly Remittance payable per class</p>
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
                                    <th class="text-secondary opacity-7">Remittance</th>
                                    <th class="text-secondary opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                if (!empty($enrolmentList)) {
                                    foreach ($enrolmentList as $data) {
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
                                            <strong> <?php
                                                echo $utility->money(($data['population'] * $data['tuition']) * 0.02)
                                                    ?></strong>
                                            </td>
                                            <td class="align-middle">
                                                <div class="dropdown">
                                                    <button class="btn bg-gradient-dark dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item"
                                                                href="../../app/router.php?pageid=<?php echo base64_encode('editEnrolment') ?>&enrolmentRef=<?php echo($data['recordid']) ?>&action=0">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                                href="../../app/router.php?pageid=<?php echo base64_encode('editEnrolment') ?>&enrolmentRef=<?php echo($data['recordid']) ?>&action=1">Remove</a>
                                                        </li>
                                                    </ul>
                                                </div>
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