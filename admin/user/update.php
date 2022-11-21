<?php
include "connection/connect.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;

$errors = [];
$sql = "SELECT * FROM users WHERE id = '$id'";
$results = $connect->query($sql);
$row = mysqli_fetch_assoc($results);

if (isset($_POST['submit'])) {
  
  if (!$errors) {
    
  }
}
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Update Account: <?= $row['name'] ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=product/index.php">List</a></li>
          <li class="breadcrumb-item active">Update</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<form method="POST" action="" class="container">
  <div class="box-body">
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



    <div class="form-group">
      <label for="name">Username</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="User's Name" value="<?= $row['name'] ?>">
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" class="form-control" id="email" name="email" placeholder="User's Email Address" value="<?= $row['email'] ?>">
    </div>

    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input type="text" class="form-control" id="phone" name="phone" placeholder="User's Phone Address" value="<?= $row['phone'] ?>">
    </div>

    <div class="form-group">
      <label for="oldPassword">Old Password</label>
      <input type="text" class="form-control" id="oldPassword" name="oldPassword" placeholder="User's Old Password">
    </div>

    <div class="form-group">
      <label for="newPassword">New Password</label>
      <input type="text" class="form-control" id="newPassword" name="newPassword" placeholder="User's New Password">
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" id="status" class="form-control">
            <option value="1" <?= ($row['status'] == 1) ? "selected" : "" ?>>Active (Online)</option>
            <option value="0" <?= ($row['status'] == 0) ? "selected" : "" ?>>Banned (Offline)</option>
          </select>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="role">Role</label>
          <select name="role" id="role" class="form-control">
            <option value="1" <?= ($row['role'] == 1) ? "selected" : "" ?>>Administrator</option>
            <option value="0" <?= ($row['role'] == 0) ? "selected" : "" ?>>Customers</option>
          </select>
        </div>

      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-outline-primary btn-block" name="submit">Submit</button>
    </div>

  </div>
  <!-- /.box-body -->
</form>