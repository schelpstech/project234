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
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('add_personnel') ?>"class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Back</strong>
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
                                <option value="<?php echo $ind_personnel_data['pos_id']?>"><?php echo $ind_personnel_data['position']?></option>
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
                            <input type="text" class="form-control" value="<?php echo ($ind_personnel_data['jobTitle']) ?? "" ?>"   name="jobTitle" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Mode of Employment</label>
                            <select type="text" class="form-control" name="modeEmployment" required="yes">
                                <option value="<?php echo ($ind_personnel_data['modeOfEmployment']) ?? "" ?>"><?php echo ($ind_personnel_data['modeOfEmployment']) ?? "" ?></option>
                                <option value="">select</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Employment Start Date</i>:</label>
                        <div class="form-group">
                            <input type="date" class="form-control" name="dateEmployment"  value="<?php echo ($ind_personnel_data['employmentStart']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="example-text-input" class="form-control-label">Title</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" value="<?php echo ($ind_personnel_data['title']) ?? "" ?>" name="title" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label"></i>Last Name:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lastName" value="<?php echo ($ind_personnel_data['lastName']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">First Name</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="firstName" value="<?php echo ($ind_personnel_data['firstName']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">Other Name</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="otherName" value="<?php echo ($ind_personnel_data['otherName']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Gender</label>
                            <select type="text" class="form-control" name="gender" required="yes">
                                <option value="<?php echo ($ind_personnel_data['gender']) ?? "" ?>"><?php echo ($ind_personnel_data['gender']) ?? "" ?></option>
                                <option value="">select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Date of Birth</i>:</label>
                        <div class="form-group">
                            <input type="date" class="form-control" name="dateBirth" value="<?php echo ($ind_personnel_data['dateOfBirth']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Phone Number</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phoneNumber" value="<?php echo ($ind_personnel_data['phoneNumber']) ?? "" ?>" minlength="11" maxlength="11"
                                required="yes" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Email Address</i>:</label>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email_address" value="<?php echo ($ind_personnel_data['emailAddress']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="updatePersonnelRecord" class="btn btn-dark active btn-lg w-100">Update
                    Personnel
                    Records</button>
            </form>
        </div>
    </div>
</div>

<br>