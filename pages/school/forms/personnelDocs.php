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
                            <label for="example-text-input" class="form-control-label">Means of Identifcation</label>
                            <select type="text" class="form-control" name="identity" required="yes">
                                <option value="<?php echo ($ind_personnel_data['idCardType']) ?? "" ?>"><?php echo ($ind_personnel_data['idCardType']) ?? "" ?></option>
                                <option value="">select</option>
                                <option value="NIMC NIN">NIMC NIN</option>
                                <option value="FRSC Drivers License">FRSC Drivers License</option>
                                <option value="Internationl Passport">Internationl Passport</option>
                                <option value="INEC Voters Card">Voters Card</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Identity Card</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="idCard" required="yes"
                                accept="image/png, image/gif, image/jpeg" size="524288"
                                onchange="preview2ndImage(this)" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-2">
                        <img id="preview_2nd" <?php echo (isset($ind_personnel_data['idCardFile'])) ? 'src="../' . $ind_personnel_data['idCardFile'] . ' "
                             style="max-width: 100%; max-height: 100%;"' :
                            'src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;" ' ?>>
                    </div>
                </div>
                <hr>
                <button type="submit" name="updateIdentityPersonnelRecord" class="btn btn-dark active btn-lg w-100">Update
                    Personnel Identifcation
                    Records</button>
            </form>
        </div>
    </div>
</div>

<hr>
<br>
<br>

<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">Modify Personnel Credential Document for 
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
                            <label for="example-text-input" class="form-control-label">Highest Educational
                                Qualification</label>
                            <select type="text" class="form-control" name="qualification" required="yes">
                                <option value="<?php echo ($ind_personnel_data['id']) ?? "" ?>"><?php echo ($ind_personnel_data['qualification']) ?? "" ?></option>
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
                        <label for="example-text-input" class="form-control-label">Credential</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="credential" required="yes"
                                accept="image/png, image/gif, image/jpeg" size="524288"
                                onchange="preview3rdImage(this)" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-2">
                        <img id="preview_3rd" <?php echo (isset($ind_personnel_data['credentialFile'])) ? 'src="../' . $ind_personnel_data['credentialFile'] . ' "
                             style="max-width: 100%; max-height: 100%;"' :
                            'src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;" ' ?>>
                    </div>
                </div>
                <hr>
                <button type="submit" name="updatePersonnelCredentialRecord" class="btn btn-dark active btn-lg w-100">Update
                    Personnel Credential
                    Records</button>
            </form>
        </div>
    </div>
</div>

<hr>
<br>
<br>

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
                        <label for="example-text-input" class="form-control-label">Passport Photograph</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="passport" required="yes"
                                accept="image/png, image/gif, image/jpeg" size="524288" onchange="previewImage(this)" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img id="preview" <?php echo (isset($ind_personnel_data['passportFile'])) ? 'src="../' . $ind_personnel_data['passportFile'] . ' "
                             style="max-width: 100%; max-height: 100%;"' :
                            'src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;" ' ?>>
                    </div>
                </div>
                <hr>
                <button type="submit" name="updatePersonnelPassportRecord" class="btn btn-dark active btn-lg w-100">Update
                    Passport Photograph
                </button>
            </form>
        </div>
    </div>
</div>