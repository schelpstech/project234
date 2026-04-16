<?php
    //Select Available Classes with Sections
    $tblName = 'tbl_classes';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['schCode'],
        ],
        'joinl' => [
            'approval_type_tbl' => ' on tbl_classes.classSection = approval_type_tbl.id ',
        ]
    ];
    $createdClass = $model->getRows($tblName, $conditions);
?>
<div class="col-lg-8 offset-2 col-md-8 offset-2 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Class list</h6>
                            <p class="text-sm">See information about all available classes</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">

                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-search">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">S/N</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Class Name</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Class Section</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Class Arms</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                if (!empty($createdClass)) {
                                    foreach ($createdClass as $data) {
                                        ?>
                                        <tr>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $count++ ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $data['className'] ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['approval_abbrv'] . ' - ' . $data['approval_name']
                                                        ?>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo $data['classArm']
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
</div>