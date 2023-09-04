<div class="card-body px-0 py-0">
    <div class="table-responsive">
        <table class="table table-flush" id="datatable-search">
            <thead class="thead-light">
                <tr>
                    <th class="text-secondary text-xs font-weight-semibold opacity-7">School Code</th>
                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                        School Name</th>
                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                        Number of Terms Filed</th>
                    <th class="text-secondary opacity-7">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($enrolmentReport)) {
                    foreach ($enrolmentReport as $data) {
                        ?>
                        <tr>
                            <td class="text-sm font-weight-normal">

                                <div class="align-items-center">

                                    <img <?php echo (isset($data['schLogo']))
                                        ? 'src="../' . $data['schLogo'] . '" 
                                        style=" max-width: 50%; max-height: 50%;" ' :
                                        'src="../../assets/storage/logo/default_crsm_sch_logo_upload.png" alt="Image Preview"
                                        style="max-width: 50%; max-height: 50%;" ' ?>>
                                    <br>
                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                        <?php echo $data['sch'] ?>
                                    </h6>
                                </div>
                            </td>
                            <td class="text-sm font-weight-normal">
                                <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                    <?php echo $data['sch_name'] ?>
                                </h6>
                            </td>
                            <td class="text-sm font-weight-normal">
                                <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                    <?php echo $data['num'] ?>
                                </h6>
                            </td>
                            <td class="align-middle">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item"
                                                href="./index.php?pageid=<?php echo base64_encode('enrolmentbyTerm') ?>&schCode=<?php echo ($data['sch']) ?>">View
                                                Terms</a>
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