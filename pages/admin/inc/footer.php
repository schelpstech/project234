<footer class="footer pt-3  ">
  <div class="row align-items-center justify-content-lg-between">
    <div class="col-lg-6 mb-lg-0 mb-4">
      <div class="copyright text-center text-xs text-muted text-lg-start">
        Copyright
        ©
        <script>
          document.write(new Date().getFullYear())
        </script>
        CRSM Portal by
        <a href="https://www.schelps.com.ng" class="text-secondary" target="_blank">SCHELPS
        </a>.
      </div>
    </div>
    <div class="col-lg-6">
      <ul class="nav nav-footer justify-content-center justify-content-lg-end">
        <li class="nav-item">
          <a href="https://www.crsm.ng" class="nav-link text-xs text-muted" target="_blank">CRSM Website</a>
        </li>
      </ul>
    </div>
  </div>
</footer>
<div class="col-md-4">

  <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="py-3 text-center">
            <i class="ni ni-bell-55 ni-3x"></i>
            <h4 class="mt-4 text-gradient text-danger">You are about to Log out!</h4>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
          <form action="../../app/authenticator.php" method="post">
            <button type="submit" name="log_out_user" value="<?php echo base64_encode('log_out_user_form') ?>" class="btn btn-danger">Log me Out</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</main>

<script>
  if (document.getElementById('wysiwyg_editor')) {
    ClassicEditor
      .create(document.querySelector('#wysiwyg_editor'))
      .catch(error => {
        console.error(error);
      });
  }
</script>

<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
<script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
<script src="../../assets/js/plugins/chartjs.min.js"></script>
<script src="../../assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
<script src="../../assets/js/plugins/photoswipe.min.js"></script>
<script src="../../assets/js/plugins/photoswipe-ui-default.min.js"></script>
<script type="text/javascript">
  var swiper = new Swiper(".mySwiper", {
    effect: "cards",
    grabCursor: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>
<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="../../assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
<script src="../../assets/js/custom.js"></script>
<script src="../../assets/js/ajax_jquery.js"></script>
<script src="../../assets/js/validatePasswordInput.js"></script>
<script src="../../assets/js/plugins/photoswipe-ui-default.min.js"></script>
</body>

</html>