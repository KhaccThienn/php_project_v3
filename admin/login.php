<?php
session_start();
include 'connection/connect.php';

$error = [];
if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  do {
    if (empty($email) && empty($password)) {
      $error['required'] = 'Email and Password must be provided';
      break;
    }

    if (empty($email)) {
      $error['email_required'] = 'Email must be provided';
      break;
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['invalid_email'] = 'Invalid email address';
        break;
      }
    }
    if (empty($password)) {
      $error['pass_required'] = 'Password must be provided';
      break;
    }

    if (!$error) {
      $sql = "SELECT * FROM users WHERE email = '$email'";
      $query = mysqli_query($connect, $sql);

      if ($query->num_rows == 1) {
        $admin = $query->fetch_assoc();
        if (password_verify($password, $admin['password']) && $admin['role'] == 1) {
          $_SESSION['admin_login'] = $admin;
          header('location: index.php');
        }
      } else {
        $errors['error_acc'] = "Invalid Account";
      }
    }
  } while (false);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Control Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="container p-5">
    <div class="card">


      <div class="card-body login-card-body">
        <div class="text-center">
          <h2><span class="text-dark">AdminLTE</span> <span class="h4">Login Control Panel</span></h2>
        </div>
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="post">
          <?php if ($error) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <?php foreach ($error as $key => $value) { ?>
                <strong>
                  <?= $value . "<br>" ?>
                </strong>
              <?php } ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <div class="input-group mb-3">
            <input type="text" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>

        </form>

        <p class="mb-1">
          <a href="">I forgot my password</a>
        </p>
        <p class="mb-1">
          <a href="">SignUp New Password</a>
        </p>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="assets/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="assets/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="assets/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="assets/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="assets/plugins/moment/moment.min.js"></script>
  <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="assets/dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="assets/dist/js/pages/dashboard.js"></script>
</body>

</html>