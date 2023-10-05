<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card border shadow-xs mb-4">

            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Workforce Overview</h6>
                        <p class="text-sm">See information about all personnel of the selected school</p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-search">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">S/N</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Personnel</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Employment</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Verification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if (!empty($schPersonnelList)) {
                                foreach ($schPersonnelList as $data) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="align-items-center">
                                                <?php
                                                echo $count++
                                                    ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="align-items-center">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    <?php echo $data['title'] . " " . $data['lastName'] . " " . $data['firstName'] . " " . $data['otherName'] ?>
                                                    <br>
                                                    <strong> Gender : </strong><i>
                                                        <?php
                                                        echo $data['gender']
                                                            ?>
                                                    </i><br>
                                                    <strong> Age :</strong><i>
                                                        <?php
                                                        echo $utility->calculateAge($data['dateOfBirth'])
                                                            ?><i>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0 ">
                                                <strong> Highest Qualification:</strong>
                                                <i>
                                                    <?php
                                                    echo $data['qualification']
                                                        ?>
                                                </i>
                                                <br>
                                                <strong>Current Position:</strong>
                                                <i>
                                                    <?php
                                                    echo $data['position']
                                                        ?>
                                                </i>
                                                <br>
                                                <strong>Mode of Employment :</strong>
                                                <i>
                                                    <?php echo $data['modeOfEmployment'] ?>
                                                </i>
                                                <br>
                                                <strong>Years at Work : </strong>
                                                <i>
                                                    <?php
                                                    echo $utility->calculateAge($data['employmentStart'])
                                                        ?>
                                                </i>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php
                                            if ($data['vetted'] == 1) {
                                                echo '
                                                        <a class="btn btn-success me-2"  type="button"
                                                            href="../../app/adminRouter.php?pageid=' . base64_encode('personnelInfoPage') . '&personnelRef=' . $data['record_id'] . '"><strong>Verified :: View Profile
                                                                </strong></a>
                                                    ';
                                            } else {
                                                echo '

                                                        <a class="btn btn-dark me-2"  type="button"
                                                            href="../../app/adminRouter.php?pageid=' . base64_encode('personnelInfoPage') . '&personnelRef=' . $data['record_id'] . '"><strong>Pending :: View Profile
                                                                </strong></a>
                                                    ';
                                            }
                                            ;
                                            ?>
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