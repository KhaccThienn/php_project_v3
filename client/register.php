<?php
include "connection/connect.php";
$errors = [];

$sql = "SELECT * FROM users";

$result = $connect->query($sql);

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if (empty($name)) {
    $errors['name_required'] = "Name must not be empty";
  }

  if (empty($email)) {
    $errors['mail_required'] = "Email must not be empty";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['mail_invalid'] = "Invalid email address";
    }
    foreach ($result as $key => $value) {
      if ($value['email'] === $email) {
        $errors['mail_haved'] = "Email: $email already exists";
      }
    }
  }
  $phoneRgx = "/^(84|0[3|5|7|8|9])+([0-9]{8})\b$/";
  if (empty($phone)) {
    $errors['mail_required'] = "Phone Number must not be empty";
  } else {

    if (!preg_match($phoneRgx, $phone)) {
      $errors['phone_invalid'] = "Invalid Phone number";
    }
    foreach ($result as $key => $value) {
      if ($value['phone'] === $phone) {
        $errors['phone_haved'] = "Phone Number: $phone already exists";
      }
    }
  }

  if (empty($password)) {
    $errors['Pass_required'] = "Password must not be empty";
  }

  if (empty($confirm)) {
    $errors['Pass_confirm_required'] = "Confirm Password must not be empty";
  }

  if ($confirm !== $password) {
    $errors['Pass_confirm'] = "Mat Khau khong khop";
  }

  if (!$errors) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = mysqli_query($connect, "INSERT INTO users (name, email, password, phone) VALUES ('$name', '$email', '$password', '$phone')");
    if ($query) {
      header('location: login.php');
      exit;
    }
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Register</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>

    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-flex align-items-center justify-content-between" id="collapsibleNavId">
      <ul class="navbar-nav">

        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="about.php">About</a>
        </li>


        <li class="nav-item active dropdown">
          <a class="nav-link dropdown-toggle" href="shop.php" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Shop
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="shop.php">
              All Products
            </a>
            <?php foreach ($result as $key => $value) { ?>
              <a class="dropdown-item" href="shop.php?category=<?= $value['id'] ?>">
                <?= $value['name'] ?>
              </a>
            <?php } ?>
          </div>
        </li>

        <li class="nav-item active dropdown ">
          <a class="nav-link dropdown-toggle text-uppercase " href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= (!empty($user)) ? $user['name'] : 'Account' ?>
          </a>
          <div class="dropdown-menu ml-auto" aria-labelledby="dropdownId">
            <?php if (!empty($user)) { ?>
              <a class="dropdown-item" href="logout.php">Log Out</a>
            <?php } else { ?>
              <a class="dropdown-item" href="login.php">Login</a>
              <a class="dropdown-item" href="register.php">Register</a>
            <?php } ?>
          </div>
        </li>


      </ul>

      <form class="form-group d-flex my-2 my-lg-0" method="GET">
        <input class="form-control" name="q" type="text" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>

    </div>
  </nav>

  <div class="container py-5">
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
            <label for="name">Username</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>

          <div class="form-group">
            <label for="phone">Phone Address</label>
            <input type="text" class="form-control" id="phone" name="phone">
          </div>

          <div class="form-group">
            <label for="pass1">Password</label>
            <input type="password" class="form-control" id="pass1" name="password">
          </div>

          <div class="form-group">
            <label for="pass2">Confirm Password</label>
            <input type="password" class="form-control" id="pass2" name="confirm_password">
          </div>

          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>

          <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>