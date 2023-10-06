<?php
    //Select Corporate Data    
    $tblName = '_tbl_sch_corporate_data';
    $conditions = array(
        'return_type' => 'single',
        'where' => array(
            'sch_code' => $_SESSION['schCode'],
        )
    );
    $sch_corporate_data = $model->getRows($tblName, $conditions);
?>
<div class="px-5 py-4 container-fluid">
    <div class="row gx-4">
        <div class="col-lg-8 offset-2 col-md-12 ">
            <div class="border shadow-xs card">
                <div class="pb-0 card-header border-bottom">
                    <div class="mb-3 d-sm-flex align-items-center">
                    <div>
                                <h6 class="mb-0 text-lg font-weight-semibold"> Corporate Information for
                                    <?php echo $sch_corporate_data['sch_name'] ?>
                                </h6>
                            </div>
                            <div class="ms-auto d-flex">
                                <a type="button"
                                    href="../../app/adminRouter.php?pageid=<?php echo base64_encode('schoolProfile') ?>"
                                    class="mb-0 btn btn-sm btn-dark me-2">
                                    <strong>Back</strong>
                                </a>
                            </div>
                    </div>
                    <form role="form" class="text-start" autocomplete="off" action="../../app/validator.php" method="post"
                        enctype="multipart/form-data">
                        <hr>
                        <div class="row"> 
                            <div class="col-md-6">
                                <img id="preview" <?php echo (isset($sch_corporate_data['schLogo'])) ? 'src="../' . $sch_corporate_data['schLogo'] . '"   style=" max-width: 50%; max-height: 100%;" ' :
                                    'src="#" alt="Image Preview"
                                    style="display:none; max-width: 100%; max-height: 100%;" ' ?>>
                            </div>
                        </div>
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
                                <label for="example-text-input" class="form-control-label">School name(<i>as written on
                                        registration
                                        documents</i>):</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="sch_name" 
                                    <?php echo (!empty($sch_corporate_data['sch_name'])) ? 'value="' . $sch_corporate_data['sch_name'] . '"' : 
                                    'placeholder="Not Yet Filled"' ?> disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Date of Establishment
                                    </label>
                                    <input type="date" class="form-control" name="date_established" 
                                    <?php echo (!empty($sch_corporate_data['date_established'])) ? 'value="' . $sch_corporate_data['date_established'] . '"' : 
                                    'placeholder="Not Yet Filled"' ?> 
                                    disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Type of School</label>
                                    <select type="text" class="form-control" name="avail_class" disabled>
                                        <?php
                                        switch ($sch_corporate_data['available_classes']) {
                                            case Null:
                                                echo '<option value="">Not Yet Filled</option>';
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
                                                echo '<option value="">Not Yet Filled</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">School Type -
                                        Gender</label>
                                    <select type="text" class="form-control" name="sch_gender" disabled>
                                        <?php
                                        switch ($sch_corporate_data['sch_type_gender']) {
                                            case Null:
                                                echo '<option value="">Not Yet Filled</option>';
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
                                                echo '<option value="">Not Yet Filled</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">School Type -
                                        Accommodation</label>
                                    <select type="text" class="form-control" name="sch_accom" disabled>
                                        <?php
                                        switch ($sch_corporate_data['sch_type_accom']) {
                                            case Null:
                                                echo '<option value="">Not Yet Filled</option>';
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
                                                echo '<option value="">Not Yet Filled</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row"> 
                            <div class="col-md-6">
                               <h4 style="text-align:center;"> <?php
                               echo ($sch_corporate_data['vetting'] == 1) ? '<br><strong style="color:green;"> VALIDATED </strong>' : 
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
                        <button type="submit" name="Update_corporate_form" 
                            class="btn btn-primary active btn-lg w-100">Update School Corporate
                            Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>