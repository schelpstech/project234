<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="my-4 row">
            <div class="col-lg-12 col-md-6">
                <div class="border shadow-xs card">
                    <div class="pb-0 card-header border-bottom">
                        <div class="mb-3 d-sm-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-lg font-weight-semibold">
                                    <?php echo $rebateView['termVariable'] ?> Rebate Application for
                                    <?php echo $sch_corporate_data['sch_name'] ?>
                                </h6>
                            </div>
                            <div class="ms-auto d-flex">
                                <a type="button"
                                    href="../../app/adminRouter.php?pageid=<?php echo base64_encode('rebateManager') ?>"
                                    class="mb-0 btn btn-sm btn-dark me-2">
                                    <strong>Back</strong>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-4 row">
                        <div class="col-lg-8 offset-2 col-md-6">
                            <div class="card card-blog card-plain">
                                <div class="position-relative">
                                    <a class="d-block blur-shadow-image">
                                        <iframe width="1200" height="800" src="../<?php echo $rebateView['rebateLetter'] ?>" 
                                                title="<?php echo $rebateView['termVariable'] ?> Rebate Application for <?php echo $sch_corporate_data['sch_name'] ?>" 
                                                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>
                                        </iframe>
                                    </a>
                                </div>
                                <div class="card-body px-0 pt-4">

                                    <p class="text-primary font-weight-bold text-sm text-uppercase">
                                        <?php echo $rebateView['recordTime'] ?>
                                    </p>
                                    <?php
                                    echo ($rebateView['rebateStatus'] == 1) ?
                                        '<footer class="blockquote-footer text-gradient text-info text-sm ms-3">
                                                        <strong>Approved</strong> <cite title="Source Title">by admin</cite>
                                                    </footer>'
                                        :

                                        '<footer class="blockquote-footer text-gradient text-dark text-sm ms-3">
                                                        <strong>Pending Approval</strong> <cite title="Source Title">by admin</cite>
                                                    </footer>'
                                        ?>
                                    <a href="javascript:;">
                                        <h4>
                                            Total Rebate Amount ::
                                            <?php echo $utility->money($rebateView['amountRebate']) ?>
                                        </h4>
                                    </a>
                                    <p>
                                        Total Number of Students Applied For ::
                                        <?php echo $rebateView['numLearners'] ?>
                                    </p>
                                    <p>
                                        Application Reference ::
                                        <?php echo $rebateView['rebateRef'] ?>
                                    </p>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-danger dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Remark
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <li>
                                                    <form action="../../app/validator.php" method="post">
                                                        <input type="text" class="form-control" name="validation"
                                                            value="<?php echo ($rebateView['rebateStatus'] == 1) ? 0 : 1 ?>"
                                                            hidden />

                                                        <input type="text" class="form-control" name="reference"
                                                            value="<?php echo $rebateView['rebateRef'] ?>" hidden />

                                                        <button type="submit" class="dropdown-item"
                                                            name="Update_rebate_application_form">
                                                            <?php echo ($rebateView['rebateStatus'] == 1) ? "Invalidate" : "Validate" ?>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>