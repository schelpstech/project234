<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">
                        <?php echo $sch_corporate_data['sch_name'] ?> - Personnel Information Page
                    </h6>
                    <p class="mb-2 text-sm mb-sm-0">Information provided in this form is not 
                        editable upon
                        approval by the secretariat</p>
                </div>
                <div class="ms-auto d-flex">
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('add_personnel') ?>"class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Back</strong>
                    </a>

                </div>
            </div>

            <form role="form" class="text-start" autocomplete="off" action="../../app/validator.php"
                method="post" enctype="multipart/form-data">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['schCode'] ?>"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-4" style="display: none;" hidden="yes">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['schCode'] ?>"
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
                    
                    <div class="col-md-4 offset-4">
                        <img id="preview" <?php echo (isset($schPersonnelInfo['passportFile'])) ? 'src="../' . $schPersonnelInfo['passportFile'] . ' "
                             style="max-width: 100%; max-height: 100%;"' :
                            'src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;" '?>>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Position</label>
                            <select type="text" class="form-control" name="positionId" required="yes" disabled>
                                <option value="<?php echo $schPersonnelInfo['pos_id']?>"><?php echo $schPersonnelInfo['position']?></option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Job Title</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" disabled value="<?php echo ($schPersonnelInfo['jobTitle']) ?? "" ?>"   name="jobTitle" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Mode of Employment</label>
                            <select type="text" class="form-control" name="modeEmployment" disabled required="yes">
                                <option value="<?php echo ($schPersonnelInfo['modeOfEmployment']) ?? "" ?>"><?php echo ($schPersonnelInfo['modeOfEmployment']) ?? "" ?></option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Employment Start Date</i>:</label>
                        <div class="form-group">
                            <input type="date" class="form-control" name="dateEmployment" disabled value="<?php echo ($schPersonnelInfo['employmentStart']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="example-text-input" class="form-control-label">Title</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" disabled value="<?php echo ($schPersonnelInfo['title']) ?? "" ?>" name="title" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label"></i>Last Name:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" disabled name="lastName" value="<?php echo ($schPersonnelInfo['lastName']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">First Name</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" disabled name="firstName" value="<?php echo ($schPersonnelInfo['firstName']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">Other Name</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" disabled name="otherName" value="<?php echo ($schPersonnelInfo['otherName']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Gender</label>
                            <select type="text" class="form-control" name="gender" required="yes" disabled>
                                <option value="<?php echo ($schPersonnelInfo['gender']) ?? "" ?>"><?php echo ($schPersonnelInfo['gender']) ?? "" ?></option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Date of Birth</i>:</label>
                        <div class="form-group">
                            <input type="date" class="form-control" name="dateBirth" disabled value="<?php echo ($schPersonnelInfo['dateOfBirth']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Phone Number</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phoneNumber" disabled value="<?php echo ($schPersonnelInfo['phoneNumber']) ?? "" ?>" minlength="11" maxlength="11"
                                required="yes" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Email Address</i>:</label>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email_address" disabled value="<?php echo ($schPersonnelInfo['emailAddress']) ?? "" ?>" required="yes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Highest Educational Qualification</label>
                            <select type="text" class="form-control" name="identity" required="yes">
                                <option value="<?php echo ($schPersonnelInfo['id']) ?? "" ?>"><?php echo ($schPersonnelInfo['qualification']) ?? "" ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Means of Identifcation</label>
                            <select type="text" class="form-control" name="identity" required="yes">
                                <option value="<?php echo ($schPersonnelInfo['idCardType']) ?? "" ?>"><?php echo ($schPersonnelInfo['idCardType']) ?? "" ?></option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <img id="preview" <?php echo (isset($schPersonnelInfo['credentialFile'])) ? 'src="../' . $schPersonnelInfo['credentialFile'] . ' "
                             style="max-width: 100%; max-height: 100%;"' :
                            'src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;" '?>>
                    </div>
                    <div class="col-md-6">
                        <img id="preview" <?php echo (isset($schPersonnelInfo['idCardFile'])) ? 'src="../' . $schPersonnelInfo['idCardFile'] . ' "
                             style="max-width: 100%; max-height: 100%;"' :
                            'src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;" '?>>
                    </div>
                </div>
                <hr>
                        <div class="row"> 
                            <div class="col-md-6">
                               <h4 style="text-align:center;"> <?php
                               echo ($schPersonnelInfo['vetted'] == 1) ? '<br><strong style="color:green;"> VALIDATED </strong>' : 
                                '<br><strong style="color:red;"> NOT YET VALIDATED </strong>';
                                ?></h4>
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="form-control-label">Set data validation status</label>
                                <select type="text" class="form-control" name="validation">
                                    <option value="">select</option>
                                    <option value="0">Invalidate</option>
                                    <option value="1">Validate</option>
                                </select>
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