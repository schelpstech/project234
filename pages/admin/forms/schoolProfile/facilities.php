<?php
    //Select School Physical Address
    $tblName = '_sch_facility_record';
    $conditions = [
        'where' => [
            'sch_code' => $_SESSION['schCode'],
        ],
        'joinl' => [
            'facility_list' => ' on _sch_facility_record.facility_id = facility_list.fac_id',
        ]
    ];
    $facility_data = $model->getRows($tblName, $conditions);
?>
<div class="col-lg-10 offset-1 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                    <div>
                                <h6 class="mb-0 text-lg font-weight-semibold"> Submitted Available Facilities in
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
                                                    <a href="../<?php echo $data['image'] ?>"> <img src="../<?php echo $data['image'] ?>" alt="facility" height="200"
                                                        width="200"></a>
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
                                                        <li>
                                                            <form action="../../app/validator.php" method="post">
                                                                <input type="text" class="form-control" name="validation"
                                                                    value="<?php echo ($data['vetted'] == 1) ? 0 : 1 ?>"
                                                                    hidden />
                                                                <input type="text" class="form-control" name="reference"
                                                                    value="<?php echo $data['sch_fac_id'] ?>" hidden />
                                                                <button type="submit" class="dropdown-item"
                                                                    name="Update_facility_form">
                                                                    <?php echo ($data['vetted'] == 1) ? "Invalidate" : "Validate" ?>
                                                                </button>
                                                            </form>
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