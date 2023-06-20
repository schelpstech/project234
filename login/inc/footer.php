<footer class="pt-5 pb-1 mt-auto footer">
    <div class="container">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6">
          <div class="text-sm text-center copyright text-md-start">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> <a href="https://www.creative-tim.com" class="text-sm text-body ms-1" target="_blank">CRSM Portal</a>
          </div>
        </div>
        <div class="col-lg-6">
          <ul class="text-white nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="text-sm nav-link text-body" target="_blank">Secretariat</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="text-sm nav-link text-body" target="_blank">Board</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/license" class="text-sm nav-link text-body" target="_blank">Admin</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

 

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Kanban scripts -->
  <script src="../assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../assets/js/plugins/jkanban/jkanban.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
    <!-- Custom scripts -->
    <script src="../assets/js/custom.js"></script>
</body>

</html>