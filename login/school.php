<?php
include "./inc/header.php";
?>

<body class="">
  <main class="main-content main-content-bg mt-0">
    <section>
      <div class="page-header min-vh-85">
        <div class="container">
          <div class="row">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
              <div class="mt-8 border-0 card card-plain">
                <div class="pb-0 card-header text-start">
                  <h3 class="font-weight-bolder text-dark">CRSM Schools :: Welcome back</h3>
                  <p class="mb-0">Enter your school code and password to sign in</p>
                  <?php
                  if (isset($_SESSION['msg'])) {
                    printf('<b>%s</b>', $_SESSION['msg']);
                    unset($_SESSION['msg']);
                  }
                  ?>
                </div>
                <div class="card-body">
                  <form role="form" class="text-start" action="../app/authenticator.php" method="post"
                    enctype="multipart/form-data">
                      <label>School Code</label>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Enter your school code"
                          aria-label="School Code" id="school_code" name="school_code" autocomplete="new-password"
                          onchange="formatInput()" minlength="8" maxlength="8">
                      </div>
                      <label>Password</label>
                      <div class="mb-3">
                        <input type="password" class="form-control" autocomplete="new-password" name="password"
                          placeholder="" aria-label="Password">
                      </div>
                      <div class="text-center">
                        <button type="submit" name="go_@head" value=" login _now_ "
                          class="mt-4 mb-0 btn btn-dark w-100">Sign in</button>
                      </div>
                  </form>
                </div>
                <div class="px-1 pt-0 text-center card-footer px-lg-2">
                  <p class="mx-auto mb-4 text-sm">
                    Don't have an account?
                    <a href="javascript:;" class="text-dark  font-weight-bold">Contact CRSM Secretariat</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="top-0 position-absolute w-45 h-100 d-md-block end-0 d-none">
                <div class="bg-cover position-absolute fixed-top me-n8 border-radius-lg ms-auto h-100 z-index-0"
                  style="background-image:url('../assets/img/attributes/school.jpg'); background-position: 50%;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php
  include "./inc/footer.php";
  ?>