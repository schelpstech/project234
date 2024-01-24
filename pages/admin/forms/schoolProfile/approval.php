<?php
//Select School Approval 
$tblName = '_tbl_approval_record';
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['schCode'],
    ],
    'joinx' => array(
        'approval_type_tbl' => ' on approval_type_tbl.id = _tbl_approval_record.approval_id',
    )
];
$sch_approval_data = $model->getRows($tblName, $conditions);
?>

<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="my-4 row">
            <div class="col-lg-12 col-md-6">
                <div class="border shadow-xs card">
                    <div class="pb-0 card-header border-bottom">
                        <div class="mb-3 d-sm-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-lg font-weight-semibold"> Submitted Approval Details for
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
                                            <div class="col-lg-4 col-md-4">
                                                <div class="dropdown">
                                                    <button class="btn bg-gradient-danger dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        <li>
                                                            <form action="../../app/validator.php" method="post">
                                                                <input type="text" class="form-control" name="validation"
                                                                    value="<?php echo ($data['vetted'] == 1) ? 0 : 1 ?>"
                                                                    hidden />
                                                                <input type="text" class="form-control" name="reference"
                                                                    value="<?php echo $data['approval_rec_id'] ?>" hidden />
                                                                <button type="submit" class="dropdown-item"
                                                                    name="Update_approval_form">
                                                                    <?php echo ($data['vetted'] == 1) ? "Invalidate" : "Validate" ?>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }else{
                        echo 'No Submitted Approval Record';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>