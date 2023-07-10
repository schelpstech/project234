<?php
include "./inc/header.php";
?>

<body class="">
    <main class="main-content  mt-0">
        <div class="pt-5 m-3 page-header align-items-start min-vh-50 pb-11 border-radius-lg"
            style="background-image: url('./inc/admin.avif');">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="mx-auto text-center col-lg-5">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="mx-auto col-xl-4 col-lg-6 col-md-7">
                    <div class="card z-index-0">
                        <div class="pt-4 text-center card-header">
                            <h5>CRSM Secretariat</h5>
                            <?php
                            if (isset($_SESSION['msg'])) {
                                printf('<b>%s</b>', $_SESSION['msg']);
                                unset($_SESSION['msg']);
                            }
                            ?>
                        </div>
                        <div class="px-4 card-body">
                            <form role="form" class="text-start" action="../app/authenticator.php" method="post"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="email" class="form-control" autocomplete="new-password" name="username"
                                        required="yes" placeholder="Enter your email address" aria-label="Email">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" autocomplete="new-password"
                                        name="password" required="yes" placeholder="Enter your password"
                                        aria-label="Password">
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="adminAuthenticator" value=" login _now_ "
                                        class="my-4 mb-2 btn btn-dark w-100">Sign in</button>
                                </div>
                                <div class="mb-2 text-center position-relative">
                                    <p
                                        class="px-3 mb-2 text-sm bg-white font-weight-bold text-secondary text-border d-inline z-index-2">
                                        or
                                    </p>
                                </div>
                                <div class="text-center">
                                    <a href="./school.php" type="button" class="mt-2 mb-4 btn btn-white w-100">Back to School
                                        Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    include "./inc/footer.php";
    ?>