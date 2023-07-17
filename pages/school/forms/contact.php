<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School Contact Details Form</h6>
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
                        <label for="example-text-input" class="form-control-label">School name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="sch_name"disabled
                                value="<?php echo $sch_corporate_data['sch_name'] ?>" />
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School Contact Type</label>
                            <select type="text" class="form-control" name="contact_type" id="contact_type"
                                onchange="switch_contact_type();">
                                <option value="">select</option>
                                <option value="phone"> Phone number</option>
                                <option value="email">Email address</option>
                                <option value="address"> Address</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8" id="show_phone" style="display:none;">
                        <label for="example-text-input" class="form-control-label">School Contact Data - Phone
                            number</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="contact_data_phone" id="phone" />
                        </div>
                    </div>
                    <div class="col-md-8" id="show_email" style="display:none;">
                        <label for="example-text-input" class="form-control-label">School Contact Data - Email Address
                            </i>:</label>
                        <div class="form-group">
                            <input type="email" class="form-control" name="contact_data_email" id="email" />
                        </div>
                    </div>
                    <div class="col-md-8" id="show_address" style="display:none;">
                        <label for="example-text-input" class="form-control-label">School Contact Data -
                            Address</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="contact_data_address" id="address" />
                        </div>
                    </div>
                </div>

                <div class="row" id="show_address1" style="display:none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Country</label>
                            <select type="text" class="form-control" id="country_type" onchange="select_region_type();">
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('country_tbl');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['country_id'] . '">' . $data['country'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select Region</label>
                            <select type="text" class="form-control" id="region_type" onchange="select_state_type();">
                                <option value="">select</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="show_address2" style="display:none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select State</label>
                            <select type="text" class="form-control" id="state_type" onchange="select_lga_type();">
                                <option value="">select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select LGA</label>
                            <select type="text" class="form-control" name="lga_type" id="lga_type">
                                <option value="">select</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="submit_contact_form" class="btn btn-dark active btn-lg w-100">Add School
                    Contact
                    Details</button>
            </form>
        </div>
    </div>
</div>

<br>
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
                                                    <button class="btn bg-gradient-danger dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item"
                                                                href="../../app/delete.php?ref=<?php echo base64_encode($data['id']) ?>&type=phone_delete">Remove</a>
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
                                                    <button class="btn bg-gradient-danger dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item"
                                                                href="../../app/delete.php?ref=<?php echo base64_encode($data['id']) ?>&type=email_delete">Remove</a>
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
                                                <a href="../../app/delete.php?ref=<?php echo base64_encode($data['id']) ?>&type=address_delete"
                                                    type="button" class="btn btn-danger btn-icon px-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <div class="dropdown">
                                                    <button class="btn bg-gradient-danger dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item"
                                                                href="../../app/delete.php?ref=<?php echo base64_encode($data['id']) ?>&type=address_delete">
                                                                Remove</a>
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