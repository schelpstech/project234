<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School Corporate Information Form</h6>
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
                        <label for="example-text-input" class="form-control-label">School name(<i>as written on
                                registration
                                documents</i>):</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="sch_name" <?php echo (!empty($sch_corporate_data['sch_name'])) ? 'value="' . $sch_corporate_data['sch_name'] . '"' : 'placeholder="Enter School Name in Full"' ?> <?php echo ($sch_corporate_data['vetting'] == 1) ? 'disabled' : 'required="yes"' ?>>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Date of Establishment </label>
                            <input type="date" class="form-control" name="date_established" <?php echo (!empty($sch_corporate_data['date_established'])) ? 'value="' . $sch_corporate_data['date_established'] . '"' : 'placeholder="Enter date School was established"' ?> <?php echo ($sch_corporate_data['vetting'] == 1) ? 'disabled' : 'required="yes"' ?> />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Type of School</label>
                            <select type="text" class="form-control" name="avail_class" <?php echo ($sch_corporate_data['vetting'] == 1) ? 'disabled' : 'required="yes"' ?>>
                                <?php
                                switch ($sch_corporate_data['available_classes']) {
                                    case Null:
                                        echo '<option value="">select</option>';
                                        break;
                                    case '1':
                                        echo '<option value="1">Nursery and Primary School</option>';
                                        break;
                                    case '2':
                                        echo '<option value="2">Secondary School</option>';
                                        break;
                                    case '3':
                                        echo '<option value="3">Nursery, Primary and Secondary School</option>';
                                        break;
                                    default:
                                        echo '<option value="">select</option>';
                                }
                                ?>
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('available_classes');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['classes'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School Type - Gender</label>
                            <select type="text" class="form-control" name="sch_gender" <?php echo ($sch_corporate_data['vetting'] == 1) ? 'disabled' : 'required="yes"' ?>>
                                <?php
                                switch ($sch_corporate_data['sch_type_gender']) {
                                    case Null:
                                        echo '<option value="">select</option>';
                                        break;
                                    case 'boy':
                                        echo '<option value="boy">Boys Only</option>';
                                        break;
                                    case 'girl':
                                        echo '<option value="girl">Girls Only</option>';
                                        break;
                                    case 'mixed':
                                        echo '<option value="mixed">Mixed</option>';
                                        break;
                                    default:
                                        echo '<option value="">select</option>';
                                }
                                ?>
                                <option value="boy">Boys Only</option>
                                <option value="girl">Girls Only</option>
                                <option value="mixed">Mixed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School Type -
                                Accommodation</label>
                            <select type="text" class="form-control" name="sch_accom" <?php echo ($sch_corporate_data['vetting'] == 1) ? 'disabled' : 'required="yes"' ?>>
                                <?php
                                switch ($sch_corporate_data['sch_type_accom']) {
                                    case Null:
                                        echo '<option value="">select</option>';
                                        break;
                                    case 'day':
                                        echo '<option value="day">Day Only</option>';
                                        break;
                                    case 'boarding':
                                        echo '<option value="boarding">Boarding Only</option>';
                                        break;
                                    case 'mixed':
                                        echo '<option value="mixed">Day and Boarding </option>';
                                        break;
                                    default:
                                        echo '<option value="">select</option>';
                                }
                                ?>
                                <option value="day">Day Only</option>
                                <option value="boarding">Boarding Only</option>
                                <option value="mixed">Day and Boarding </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">School Logo</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="schLogo" id="schLogo" <?php echo ($sch_corporate_data['vetting'] == 1) ? 'disabled' : 'required="yes"' ?>
                                accept="image/png, image/gif, image/jpeg" size="524288" onchange="previewImage(this)" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img id="preview" <?php echo (isset($sch_corporate_data['schLogo'])) ? 'src="../' . $sch_corporate_data['schLogo'] . '"   style=" max-width: 50%; max-height: 100%;" ' :
                            'src="#" alt="Image Preview"
                    style="display:none; max-width: 100%; max-height: 100%;" ' ?>>
                    </div>
                </div>
                <hr>
                <button type="submit" name="submit_corporate_form" <?php echo ($sch_corporate_data['vetting'] == 1) ? 'disabled' : 'required="yes"' ?> class="btn btn-dark active btn-lg w-100">Update School Corporate
                    Data</button>
            </form>
        </div>
    </div>
</div>