<div class="px-5 py-4 container-fluid">
    <div class="mt-4 row">
        <div class="col-md-6 col-12">
            <div class="row">
                <div class="mb-4 col-lg-6 col-6">
                    <div class="border card">
                        <div class="p-4 text-start card-body">
                            <div class="mb-3 text-center shadow bg-dark icon icon-shape border-radius-md">
                                <i class="text-lg text-white fas fa-school opacity-10" aria-hidden="true"></i>
                            </div>
                            <div class="mb-1 numbers">
                                <h5 class="mb-0 text-lg text-dark font-weight-bolder">
                                    <?php echo $sch_count?>
                                </h5>
                            </div>
                            <div class="numbers">
                                <p class="mb-0 text-sm text-capitalize font-weight-bold opacity-7">
                                    CRSM Schools</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-lg-6 col-6">
                    <div class="border card">
                        <div class="p-4 text-start card-body">
                            <div class="mb-3 text-center shadow bg-dark icon icon-shape border-radius-md">
                                <i class="text-lg text-white fa-solid fa-address-card opacity-10" aria-hidden="true"></i>
                            </div>
                            <div class="mb-1 numbers">
                                <h5 class="mb-0 text-dark font-weight-bolder">
                                    22°C
                                </h5>
                            </div>
                            <div class="numbers">
                                <p class="mb-0 text-sm text-dark text-capitalize font-weight-bold opacity-7">
                                    Schools with Complete Profile</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-4 mb-lg-0 col-lg-6 col-6">
                    <div class="border card">
                        <div class="p-4 text-start card-body">
                            <div class="mb-3 text-center shadow bg-dark icon icon-shape border-radius-md">
                                <i class="text-lg text-white fas fa-graduation-cap opacity-10" aria-hidden="true"></i>
                            </div>
                            <div class="mb-1 numbers">
                                <h4 class="mb-0 text-xl text-dark font-weight-bolder">
                                    <?php echo $sch_count_primary?>
                                </h4>
                            </div>
                            <div class="numbers">
                                <p class="mb-0 text-sm text-dark text-capitalize font-weight-bold opacity-7">
                                    Profiled Primary Schools</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 mb-lg-0 col-lg-6 col-6">
                    <div class="border card">
                        <div class="p-4 text-start card-body">
                            <div class="mb-3 text-center shadow bg-dark icon icon-shape border-radius-md">
                                <i class="text-lg text-white fas fa-graduation-cap opacity-10" aria-hidden="true"></i>
                            </div>
                            <div class="mb-1 numbers">
                                <h5 class="mb-0 text-dark font-weight-bolder">
                                    <?php echo $sch_count_secondary?>
                                </h5>
                            </div>
                            <div class="numbers">
                                <p class="mb-0 text-sm text-dark text-capitalize font-weight-bold opacity-7">
                                    Profiled Secondary Schools</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-auto col-md-6 col-12">
            <img class="mx-auto w-lg-80 w-80 w-xl-70 d-none d-md-block" src="../../assets/img/attributes/crsmlogo.png"
                alt="car image">
        </div>
    </div>
</div>
    <div class="card-body px-0 py-0">
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7">School Code</th>
                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                            School Name</th>
                        <th class="text-secondary opacity-7">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($sch_details)) {
                        foreach ($sch_details as $data) {
                            ?>
                            <tr>
                                <td class="text-sm font-weight-normal">

                                    <div class="align-items-center">

                                        <img <?php echo (isset($data['schLogo']))
                                            ? 'src="../' . $data['schLogo'] . '" 
                                        style=" max-width: 50%; max-height: 100%;" ' :
                                            'src="../../assets/storage/logo/default_crsm_sch_logo_upload.png" alt="Image Preview"
                                        style="max-width: 50%; max-height: 50%;" ' ?>>
                                        <br>
                                        <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                            <?php echo $data['sch_code'] ?>
                                        </h6>
                                    </div>
                                </td>
                                <td class="text-sm font-weight-normal">
                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                        <?php echo $data['sch_name'] ?>
                                    </h6>
                                </td>
                                <td class="align-middle">
                                    <div class="dropdown">
                                        <button class="btn bg-gradient-info dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item"
                                                    href="./index.php?pageid=<?php echo base64_encode('Corporate') ?>&schCode=<?php echo ($data['sch_code']) ?>">Corporate Details</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="./index.php?pageid=<?php echo base64_encode('Contact') ?>&schCode=<?php echo ($data['sch_code']) ?>">Contact Details</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="./index.php?pageid=<?php echo base64_encode('Classes') ?>&schCode=<?php echo ($data['sch_code']) ?>">Available Classes</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="./index.php?pageid=<?php echo base64_encode('Approval') ?>&schCode=<?php echo ($data['sch_code']) ?>">Approval Details</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="./index.php?pageid=<?php echo base64_encode('Facility') ?>&schCode=<?php echo ($data['sch_code']) ?>">Facility Details</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="./index.php?pageid=<?php echo base64_encode('Profile') ?>&schCode=<?php echo ($data['sch_code']) ?>">View Profile</a>
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