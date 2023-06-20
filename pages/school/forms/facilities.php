<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School Facilities Records Form</h6>
                    <p class="mb-2 text-sm mb-sm-0">Information provided in this form will be vetted and will not be
                        editable
                        upon
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
                            <input type="text" class="form-control" name="sch_name"
                                value="<?php echo $sch_corporate_data['sch_name'] ?>" disabled />
                        </div>
                    </div>

                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Select School Facility</label>
                            <select type="text" class="form-control" name="facility_name" required="yes">
                                <option value="">select</option>
                                <?php
                                if (!empty($unselected_facility_list)) {
                                    foreach ($unselected_facility_list as $data) {
                                        echo '<option value="' . $data['fac_id'] . '">' . $data['facility'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">select</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Facility Ownership</label>
                            <select type="text" class="form-control" name="ownership" required="yes">
                                <option value="">select</option>
                                <option value="owned">School - Owned</option>
                                <option value="rent">School - Rented</option>
                                <option value="church">Church Premise</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="example-text-input" class="form-control-label">Facility Description</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="description" minlength="50" maxlength="150"
                                required="yes" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Picture</i>:</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="facility_image" required="yes"
                                accept="image/png, image/gif, image/jpeg" size="524288" onchange="previewImage(this)" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-2">
                        <img id="preview" src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;">
                    </div>
                </div>
                <hr>
                <button type="submit" name="submit_facility_record" class="btn btn-dark active btn-lg w-100">Add
                    Facility
                    Details</button>

            </form>
        </div>
    </div>
</div>

<br>

<div class="col-lg-10 offset-1 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Facility list</h6>
                            <p class="text-sm">See information about all Facilities available in the school</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-search">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Facility</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Description</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Verification</th>
                                    <th class="text-secondary opacity-7">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($facility_data)) {
                                    foreach ($facility_data as $data) {
                                        ?>
                                        <tr>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <img src="../<?php echo $data['image'] ?>" alt="facility" height="200"
                                                        width="200">
                                                    <br>
                                                    <br>
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $data['facility'] ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo ($data['ownership'] == 'owned') ?
                                                        '<p class="text-sm text-dark font-weight-semibold mb-0">
                                                            School Owned
                                                        </p>' :
                                                        '<p class="text-sm text-dark font-weight-semibold mb-0">
                                                            Rented
                                                        </p>';
                                                    ?>
                                                </p>
                                                <small>
                                                    <?php echo $data['description'] ?>
                                                </small>
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
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item"
                                                                href="../../app/delete.php?ref=<?php echo ($data['sch_fac_id']) ?>&type=facility_details">Remove</a>
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