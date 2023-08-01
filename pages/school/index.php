<?php
include './inc/header.php';
include './inc/nav.php';
include './inc/navbar.php';
include '../../model/dashboard.php';
?>


<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="px-5 py-4 container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mx-2 mb-3 d-md-flex align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h5 class="mb-0 font-weight-bold">School code:
                            <?php echo $_SESSION['active'] ?>
                        </h5>

                    </div>
                    <button type="button"
                        class="mb-0 mb-2 btn btn-sm btn-white btn-icon d-flex align-items-center ms-md-auto mb-sm-0 me-2">
                        <span class="btn-inner--icon">
                            <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                <span class="visually-hidden">New</span>
                            </span>
                        </span>
                        <span class="btn-inner--text">Session: 2022/2023</span>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-0">
        <!--
        <div class="row">
            <div class="position-relative overflow-hidden">
                <div class="swiper mySwiper mt-4 mb-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div>
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../../assets/img/school/approved.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-5 mt-auto">
                                                <h4 class="text-dark font-weight-bolder"><br></h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <p class="text-dark font-weight-bolder">Nursery School</p>
                                            </div>
                                            <div class="col-sm-4 mt-auto">
                                                <h4 class="text-dark font-weight-bolder"><br></h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Status
                                                </p>
                                                <p class="text-dark font-weight-bolder">Provisional</p>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">
                                                    Date</p>
                                                <p class="text-dark font-weight-bolder">02-05-2023</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div>
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../../assets/img/school/approved.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-5 mt-auto">
                                                <h4 class="text-dark font-weight-bolder"><br></h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <p class="text-dark font-weight-bolder">Primary School</p>
                                            </div>
                                            <div class="col-sm-4 mt-auto">
                                                <h4 class="text-dark font-weight-bolder"><br></h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Status
                                                </p>
                                                <p class="text-dark font-weight-bolder">Provisional</p>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">
                                                    Date</p>
                                                <p class="text-dark font-weight-bolder">02-05-2023</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div>
                                <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover" style="background-image: url('../../assets/img/school/not_approved.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-5 mt-auto">
                                                <h4 class="text-dark font-weight-bolder"><br></h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <p class="text-dark font-weight-bolder">Secondary School</p>
                                            </div>
                                            <div class="col-sm-4 mt-auto">
                                                <h4 class="text-dark font-weight-bolder"><br></h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Status
                                                </p>
                                                <p class="text-dark font-weight-bolder">Denied</p>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">
                                                    Date</p>
                                                <p class="text-dark font-weight-bolder">02-05-2023</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div> -->
        <hr class="my-5 horizontal dark">


        <div class="row">
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">validation: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ($check_corporate['vetting'] == 1) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/access.svg" class="avatar avatar-md   me-3 "
                            alt="logo spotify">
                        <p class="mt-4 mb-0 font-weight-bold">Corporate details</p>
                        <span class="text-xs">submitted :
                            <?php echo (!empty($check_corporate['sch_type_gender']) && !empty($check_corporate['sch_type_accom'])) ? "<strong>YES</strong>" : "<strong>NO</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">validation: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ((!empty($check_phone['vetted'])) && (!empty($check_email['vetted'])) && $check_phone['vetted'] == 1 && $check_email['vetted'] == 1 && $check_address['vetted'] == 1) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/contact.svg" class="avatar avatar-md   me-3 "
                            alt="logo spotify">
                        <p class="mt-4 mb-0 font-weight-bold">Contact details</p>
                        <span class="text-xs">Phone contact:
                            <?php echo (!empty($check_phone['phone_number'])) ? "<strong>YES</strong>" : "<strong>NO</strong>" ?>
                        </span>
                        <br><span class="text-xs">Email Contact:
                            <?php echo (!empty($check_email['email_addrs'])) ? "<strong>YES</strong>" : "<strong>NO</strong>" ?>
                        </span>
                        <br><span class="text-xs">Contact Address:
                            <?php echo (!empty($check_address['address']) && !empty($check_address['lga_id'])) ? "<strong>YES</strong>" : "<strong>NO</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">validation: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ($count_approvals >= 1 && $vetted_approvals >= 1 && $count_approvals == $vetted_approvals) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/approval.svg" class="avatar avatar-md   me-3 "
                            alt="logo spotify">
                        <p class="mt-4 mb-0 font-weight-bold">Approval details</p>
                        <span class="text-xs">
                            <?php echo (!empty($count_approvals)) ? "<strong>" . $count_approvals . " Approval records submitted</strong>" : "<strong>No Approval record</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">validation: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ($count_facility >= 1 && $vetted_facility >= 1 && $count_facility == $vetted_facility) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/school.svg" width="150" height="150"
                            class="avatar avatar-lg" alt="logo spotify">
                        <p class="mt-4 font-weight-bold mb-0">Facility Records</p>
                        <span class="text-xs">
                            <?php echo (!empty($count_facility)) ? "<strong>" . $count_facility . " Facility records submitted</strong>" : "<strong>No Facility record</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-5 horizontal dark">
        <div class="row">
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">validation: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ($count_personnel >= 1 && $vetted_personnel >= 1 && $count_personnel == $vetted_personnel) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/personnel.svg" class="avatar avatar-md   me-3 "
                            alt="Personnel">
                        <p class="mt-4 mb-0 font-weight-bold">Personnel Record</p>
                        <span class="text-xs">
                            <?php echo (!empty($count_personnel)) ? "<strong>" . $count_personnel . " Personnel records submitted</strong>" : "<strong>No Personnel record</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">Active: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ($count_personnel >= 1 && $vetted_personnel >= 1 && $count_personnel == $vetted_personnel) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/vacancy.svg" class="avatar avatar-md   me-3 "
                            alt="Personnel">
                        <p class="mt-4 mb-0 font-weight-bold">Job Vacancy</p>
                        <span class="text-xs">
                            <?php echo (!empty($count_personnel)) ? "<strong>" . $count_personnel . " Job Vacancy  Posted</strong>" : "<strong>No Job Vacancy Post</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">validation: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ($count_personnel >= 1 && $vetted_personnel >= 1 && $count_personnel == $vetted_personnel) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/payment.svg" class="avatar avatar-md   me-3 "
                            alt="Personnel">
                        <p class="mt-4 mb-0 font-weight-bold">Annual Remittance</p>
                        <span class="text-xs">
                            <?php echo (!empty($count_personnel)) ? "<strong>" . $count_personnel . " Termly Remittance records submitted</strong>" : "<strong>No Termly Remittance record</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 col-lg-3 col-sm-6 mt-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <small class="mb-0">active: </small>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" disabled <?php echo ($count_personnel >= 1 && $vetted_personnel >= 1 && $count_personnel == $vetted_personnel) ? ' style="background-color:green;" checked ' : ' style="background-color:grey;" ' ?>
                                    type="checkbox" id="flexSwitchCheckHumidity">
                            </div>
                        </div>
                        <img src="../../assets/img/small-logos/ticket.svg" class="avatar avatar-md   me-3 "
                            alt="Personnel">
                        <p class="mt-4 mb-0 font-weight-bold">Support Ticket</p>
                        <span class="text-xs">
                            <?php echo (!empty($count_personnel)) ? "<strong>" . $count_personnel . " Support Ticket Created</strong>" : "<strong>No Support Ticket Created</strong>" ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-5 horizontal dark">
        <?php
        include './inc/footer.php';
        ?>