<?php
include "connection/connect.php";

$errors = [];
$sql = "SELECT * FROM users";
$results = $connect->query($sql);

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $status = $_POST['status'];
  $role = $_POST['role'];



  if (empty($name)) {
    $errors['name_required'] = "Name is required";
  }

  if (empty($email)) {
    $errors['email_required'] = "Email is required";
  } else {
    $emailRgx = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    foreach ($results as $key => $value) {
      if ($value['email'] == $email) {
        $errors['email_exits'] = "Email " . $name . " already exists";
      }
    }
    if (!preg_match($email, $emailRgx)) {
      $errors['email_invaid'] = "Invalid Email Format";
    }
  }

  if (empty($phone)) {
    $errors['Phone_required'] = "Phone Number is required";
  } else {
    $PhoneRgx = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    foreach ($results as $key => $value) {
      if ($value['phone'] == $phone) {
        $errors['phone_exits'] = "Phone Number " . $phone . " already exists";
      }
    }
    if (!preg_match($phone, $PhoneRgx)) {
      $errors['email_invaid'] = "Invalid Email Format";
    }
  }

  $passRgx = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
  if (empty($password)) {
    $errors['password_required'] = "Password is required";
  } else {
    if (!preg_match($password, $passRgx)) {
      $errors['pass_invaid'] = "Invalid Password Format (at least 6 characters, maximum length is 8 characters, at least 1 special characters)";
    }
  }

  if (empty($role)) {
    $errors['role_required'] = "Role is required";
  } else {
    if ($role == 1) {
      echo
      "<script>
        return confirm('Are You Want To Create Account which Have Administrator Role?');
      </script>";
    }
  }



  if (!$errors) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (name, email, password, phone, status, role) VALUES ('$name', '$email', '$password', $status, $role)";

    $query = $connect->query($sql);

    if ($query) {
      header('location: ?page=user/index.php');
      exit;
    }
  }
}
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add New User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Add</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content container py-5">
  <?php if ($errors) { ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php foreach ($errors as $key => $value) { ?>
        <strong>
          <?= $value . '<br>' ?>
        </strong>
      <?php } ?>
    </div>
  <?php } ?>
  <form method="POST" action="">
    <div class="form-group">
      <label for="name">Username</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="User's Name">
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" class="form-control" id="email" name="email" placeholder="User's Email Address">
    </div>

    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input type="text" class="form-control" id="phone" name="phone" placeholder="User's Phone Address">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="text" class="form-control" id="password" name="password" placeholder="User's Password">
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" id="status" class="form-control">
            <option value="1">Default: Active (Online)</option>
            <option value="0">Banned (Offline)</option>
          </select>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="role">Role</label>
          <select name="role" id="role" class="form-control">
            <option value="">------Choose The Role------</option>
            <option value="1">Administrator</option>
            <option value="0">Customers</option>
          </select>
        </div>

      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-outline-primary btn-block" name="submit">Submit</button>
    </div>
  </form>


</section>