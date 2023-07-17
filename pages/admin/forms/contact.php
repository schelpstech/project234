<?php
//Select Corporate Data    
$tblPhone = '_tbl_phone_number';
$tblEmail = '_tbl_email_address';
$tblAddress = '_tbl_sch_address';
$condition = [
    'where' => [
        'sch_code' => $_SESSION['schCode'],
    ],
];
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['schCode'],
    ],
    'joinl' => [
        'lga_tbl' => ' on lga_tbl.lga_id = _tbl_sch_address.lga_id',
        'state_tb' => ' on state_tb.state_id = lga_tbl.state_id',
        'region_tbl' => ' on region_tbl.region_id = state_tb.region_id',
        'country_tbl' => ' on country_tbl.country_id = region_tbl.country_id',
    ]
];
$sch_phone_numbers = $model->getRows($tblPhone, $condition);
$sch_email_address = $model->getRows($tblEmail, $condition);
$sch_phy_address = $model->getRows($tblAddress, $conditions);
?>
<div class="col-lg-8 offset-2 col-md-8 offset-2 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">

                <div class="pb-0 card-header border-bottom">
                    <div class="mb-3 d-sm-flex align-items-center">
                        <div>
                            <h6 class="mb-0 text-lg font-weight-semibold">School Contact Details</h6>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="mb-0 btn btn-sm btn-dark me-2">
                                Print report
                            </button>
                        </div>
                    </div>
                </div>
                <div class="border shadow-xs card">
                    <div class="pb-0 card-header border-bottom">
                        <div class="card bg-gradient-default">
                            <div class="card-body">
                                <h3 class="card-title text-dark text-gradient">Phone Numbers</h3>
                                <hr>

                                <?php
                                if (!empty($sch_phone_numbers)) {
                                    foreach ($sch_phone_numbers as $data) {
                                ?>
                                        <blockquote class="blockquote text-white mb-0">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <a href="tel:<?php echo $data['phone_number'] ?>">
                                                        <p class="text-dark ms-3">
                                                            <?php echo $data['phone_number'] ?>
                                                        </p>
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="dropdown">
                                                        <button class="btn bg-gradient-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                            <li>
                                                                <form action="../../app/validator.php" method="post">
                                                                    <input type="text" class="form-control" name="validation" value="<?php echo ($data['vetted'] == 1) ? 0 : 1 ?>" hidden />
                                                                    <input type="text" class="form-control" name="reference" value="<?php echo $data['id'] ?>" hidden />
                                                                    <button type="submit" class="dropdown-item" name="Update_phone_form"><?php echo ($data['vetted'] == 1) ? "Invalidate" : "Validate" ?></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
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

                                        </blockquote>
                                        <hr>
                                <?php
                                    }
                                } else {
                                    echo '<blockquote class="blockquote text-white mb-0">
                                    <p class="text-dark ms-3"> None </p>
                                </blockquote>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border shadow-xs card">
                    <div class="pb-0 card-header border-bottom">
                        <div class="card bg-gradient-default">
                            <div class="card-body">
                                <h3 class="card-title text-dark text-gradient">Email Address</h3>
                                <hr>

                                <?php
                                if (!empty($sch_email_address)) {
                                    foreach ($sch_email_address as $data) {
                                ?>
                                        <blockquote class="blockquote text-white mb-0">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <a href="mailto:<?php echo $data['email_addrs'] ?>">
                                                        <p class="text-dark ms-3">
                                                            <?php echo $data['email_addrs'] ?>
                                                        </p>
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="dropdown">
                                                        <button class="btn bg-gradient-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <li>
                                                                <form action="../../app/validator.php" method="post">
                                                                    <input type="text" class="form-control" name="validation" value="<?php echo ($data['vetted'] == 1) ? 0 : 1 ?>" hidden />
                                                                    <input type="text" class="form-control" name="reference" value="<?php echo $data['id'] ?>" hidden />
                                                                    <button type="submit" class="dropdown-item" name="Update_email_form"><?php echo ($data['vetted'] == 1) ? "Invalidate" : "Validate" ?></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
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

                                        </blockquote>
                                        <hr>
                                <?php
                                    }
                                } else {
                                    echo '<blockquote class="blockquote text-white mb-0">
                                    <p class="text-dark ms-3"> None </p>
                                </blockquote>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border shadow-xs card">
                    <div class="pb-0 card-header border-bottom">
                        <div class="card bg-gradient-default">
                            <div class="card-body">
                                <h3 class="card-title text-dark text-gradient">Physical Address</h3>
                                <hr>

                                <?php
                                if (!empty($sch_phy_address)) {
                                    foreach ($sch_phy_address as $data) {
                                ?>
                                        <blockquote class="blockquote text-white mb-0">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <a href="#">
                                                        <p class="text-dark ms-3">
                                                            <?php echo $data['address'] ?>,<br>
                                                            <?php echo $data['lga'] ?>,
                                                            <?php echo $data['state'] ?>,<br>
                                                            <?php echo $data['region'] ?>,<br>
                                                            <?php echo $data['country'] ?>
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="dropdown">
                                                        <button class="btn bg-gradient-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <li>
                                                                <form action="../../app/validator.php" method="post">
                                                                    <input type="text" class="form-control" name="validation" value="<?php echo ($data['vetted'] == 1) ? 0 : 1 ?>" hidden />
                                                                    <input type="text" class="form-control" name="reference" value="<?php echo $data['id'] ?>" hidden />
                                                                    <button type="submit" class="dropdown-item" name="Update_address_form"><?php echo ($data['vetted'] == 1) ? "Invalidate" : "Validate" ?></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
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

                                        </blockquote>
                                        <hr>
                                <?php
                                    }
                                } else {
                                    echo '<blockquote class="blockquote text-white mb-0">
                                    <p class="text-dark ms-3"> None </p>
                                </blockquote>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>