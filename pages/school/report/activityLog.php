<div class="card-header border-bottom pb-0">
    <div class="d-sm-flex align-items-center">
        <div>
            <h6 class="font-weight-semibold text-lg mb-0">Workforce Overview</h6>
            <p class="text-sm">See information about all personnel of the school</p>
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
                if (!empty($activityLog)) {
                    foreach ($activityLog as $data) {
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