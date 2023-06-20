<?php
include './inc/header.php';
include './inc/nav.php';
include './inc/navbar.php';
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
                        <span class="btn-inner--text">Session: 
                            <?php echo $currentTerm['termVariable']?>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-0"><br>
        <div class="col-lg-12 col-md-12 ">
            <?php
            include $_SESSION['include'];
            ?>
        </div>
        <?php
        include './inc/footer.php';
        ?>