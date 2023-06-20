<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">ADD Personnel to
                        <?php echo $sch_corporate_data['sch_name'] ?>
                    </h6>
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

            <form role="form" class="text-start" autocomplete="off" action="../../app/personnelHandler.php"
                method="post" enctype="multipart/form-data">
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
                            <label for="example-text-input" class="form-control-label">Select Position</label>
                            <select type="text" class="form-control" name="positionId" required="yes">
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('job_position_tbl');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['pos_id'] . '">' . $data['position'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Job Title</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="jobTitle" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Mode of Employment</label>
                            <select type="text" class="form-control" name="modeEmployment" required="yes">
                                <option value="">select</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Employment Start Date</i>:</label>
                        <div class="form-group">
                            <input type="date" class="form-control" name="dateEmployment" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="example-text-input" class="form-control-label">Title</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label"></i>Last Name:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lastName" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">First Name</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="firstName" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">Other Name</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="otherName" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Gender</label>
                            <select type="text" class="form-control" name="gender" required="yes">
                                <option value="">select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Date of Birth</i>:</label>
                        <div class="form-group">
                            <input type="date" class="form-control" name="dateBirth" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Phone Number</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phoneNumber" minlength="11" maxlength="11"
                                required="yes" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Email Address</i>:</label>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email_address" required="yes" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Highest Educational
                                Qualification</label>
                            <select type="text" class="form-control" name="qualification" required="yes">
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('qualification_tbl');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['qualification'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Means of Identifcation</label>
                            <select type="text" class="form-control" name="identity" required="yes">
                                <option value="">select</option>
                                <option value="NIMC_NIN">NIN</option>
                                <option value="FRSC_license">Drivers License</option>
                                <option value="NIS_passport">Internationl Passport</option>
                                <option value="INEC_card">Voters Card</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <img id="preview" src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;">
                        <label for="example-text-input" class="form-control-label">Passport Photograph</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="passport" required="yes"
                                accept="image/png, image/gif, image/jpeg" size="524288" onchange="previewImage(this)" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img id="preview_2nd" src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;">
                        <label for="example-text-input" class="form-control-label">Identity Card</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="idCard" required="yes"
                                accept="image/png, image/gif, image/jpeg" size="524288"
                                onchange="preview2ndImage(this)" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img id="preview_3rd" src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;">
                        <label for="example-text-input" class="form-control-label">Credential</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="credential" required="yes"
                                accept="image/png, image/gif, image/jpeg" size="524288"
                                onchange="preview3rdImage(this)" />
                        </div>
                    </div>

                </div>

                <hr>
                <button type="submit" name="submitPersonnelRecord" class="btn btn-dark active btn-lg w-100">Add
                    Personnel
                    Records</button>
            </form>
        </div>
    </div>
</div>

<br>
<hr class="my-0">

<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card border shadow-xs mb-4">

            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Workforce Overview</h6>
                        <p class="text-sm">See information about all personnel of the school</p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-search">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Personnel</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Employment</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Verification</th>
                                <th class="text-secondary opacity-7">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($personnel_data)) {
                                foreach ($personnel_data as $data) {
                                    ?>
                                    <tr>
                                        <td>

                                            <div class="align-items-center">
                                                <img src="../<?php echo $data['passportFile'] ?>" alt="facility" height="100"
                                                    width="100">
                                                <br>
                                                <br>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    <?php echo $data['title'] . " " . $data['lastName'] . " " . $data['firstName'] . " " . $data['otherName'] ?>
                                                    <br>
                                                    <strong> Gender : </strong><i>
                                                        <?php
                                                        echo $data['gender']
                                                            ?>
                                                    </i><br>
                                                    <strong> Age :</strong><i>
                                                        <?php
                                                        echo $utility->calculateAge($data['dateOfBirth'])
                                                            ?><i>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0 ">
                                                <strong> Highest Qualification:</strong>
                                                <i>
                                                    <?php
                                                    echo $data['qualification']
                                                        ?>
                                                </i>
                                                <br>
                                                <strong>Current Position:</strong>
                                                <i>
                                                    <?php
                                                    echo $data['position']
                                                        ?>
                                                </i>
                                                <br>
                                                <strong>Mode of Employment :</strong>
                                                <i>
                                                    <?php echo $data['modeOfEmployment'] ?>
                                                </i>
                                                <br>
                                                <strong>Years at Work : </strong>
                                                <i>
                                                    <?php
                                                    echo $utility->calculateAge($data['employmentStart'])
                                                        ?>
                                                </i>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php
                                            echo ($data['vetted'] == 1) ?
                                                '
                                                        <button class="btn btn-success me-2" type="button">Verified</button>
                                                    ' :
                                                '
                                                        <button class="btn btn-dark me-2" disabled type="button">Pending</button>
                                                    ';
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item"
                                                            href="../../app/router.php?pageid=<?php echo base64_encode('editPersonnel') ?>&personnelRef=<?php echo ($data['record_id']) ?>"><strong>Edit</strong></a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="../../app/router.php?pageid=<?php echo base64_encode('Personneldocs') ?>&personnelRef=<?php echo ($data['record_id']) ?>"><strong>Re-Upload
                                                                Documents</strong></a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="../../app/delete.php?ref=<?php echo ($data['record_id']) ?>&type=personnel_details"><strong
                                                                style="color: red;">Remove</strong></a>
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