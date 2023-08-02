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
                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Activity ID</th>
                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                        Description</th>
                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                        Initiated by</th>
                    <th class="text-secondary opacity-7">Activity Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($getallLog)) {
                    foreach ($getallLog as $data) {
                        ?>
                        <tr>
                            <td>
                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                    <?php echo $data['object'] . "-" . $data['id'] ?>
                                </p>
                            </td>
                            <td>
                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                    <?php echo $data['activity'] . " - " ?>
                                </p>
                                <i class="text-sm text-dark font-weight-semibold mb-0 ">
                                    
                                        <small>
                                            <?php
                                                echo $data['description']
                                            ?>
                                        </small>
                                </i>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                    <?php echo $data['user_name'] . "<br>" . $data['uip'] ?>
                                </p>
                            </td>
                            <td class="align-middle">
                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                    <?php echo $data['rectime'] ?>
                                </p>
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