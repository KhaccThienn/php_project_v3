<?php
include "connection/connect.php";
session_start();

$errors = [];

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email)) {
    $errors['mail_required'] = "Email must not be empty";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['mail_invalid'] = "Invalid email address";
    }
  }

  if (empty($password)) {
    $errors['Pass_required'] = "Password must not be empty";
  }

  if (!$errors) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $query = mysqli_query($connect, $sql);

    if ($query -> num_rows == 1) {
      $user = $query -> fetch_assoc();
      if (password_verify($password, $user['password'])) {
        $_SESSION['user_login'] = $user;
        header('location: index.php');
      }
    } else{
      $errors['error_acc'] = "Invalid Account";
    }
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <?php include "layout/header.php" ?>

  <div class="container">
    <div class="row justify-content-around">
      <div class="col-lg-6">
        <form method="POST">
          <?php if ($errors) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <?php foreach ($errors as $key => $value) { ?>
                <strong>
                  <?= $value . "<br>" ?>
                </strong>
              <?php } ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>

          <div class="form-group">
            <label for="pass1">Password</label>
            <input type="password" class="form-control" id="pass1" name="password">
          </div>

          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <a href="register.php">Register</a>
          <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <?php include "layout/footer.php" ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>