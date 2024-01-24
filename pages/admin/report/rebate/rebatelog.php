<div class="col-lg-10 offset-1 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Submitted Rebate Applications</h6>
                            <p class="text-sm">See information about all submitted rebate Applications</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-search">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Application Ref</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Term</th>
                                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        School Details</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Number of Learners</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Total Amount</th>
                                    <th class="text-secondary opacity-7">Application Status</th>
                                    <th class="text-secondary opacity-9">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($rebateRecords)) {
                                    foreach ($rebateRecords as $data) {
                                        ?>
                                        <tr>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $data['rebateRef'] ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['termVariable'] ?>
                                                </p>
                                            </td>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $data['schCode'] ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['numLearners'] ?>
                                                </p>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $utility->money($data['amountRebate']) ?>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo ($data['rebateStatus'] == 1) ?
                                                    '
                                                        <button class="btn btn-success me-2" type="button">Approved</button>
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
                                                        View
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item"
                                                        href="../../app/adminRouter.php?pageid=<?php echo base64_encode('rebateDetails') ?>&rebateRef=<?php echo ($data['rebateRef']) ?>&schCode=<?php echo ($data['schCode']) ?>">
                                                            View Application</a>
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