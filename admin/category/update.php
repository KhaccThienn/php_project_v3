<?php
include "connection/connect.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;

$errors = [];


$sqls = "SELECT * FROM category WHERE id = '$id'";
$result = $connect->query($sqls);
$row = $result->fetch_assoc();
$oldName = $row['name'];
$sql = "SELECT * FROM category WHERE name not in ('$oldName')";
$results = $connect->query($sql);

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $status = $_POST['status'];

  if (empty($name)) {
    $errors['name'] = "Name is required";
  } else {
    foreach ($results as $key => $value) {
      if ($name == $value['name']) {
        $errors['name_haved'] = "Category $name already exists";
        
      }
    }
  }

  if (!$errors) {
    $sql = "UPDATE category SET name = '$name', status = $status WHERE id = '$id'";

    $query = $connect->query($sql);

    if ($query) {
      header('location: ?page=category/index.php');
      exit;
    }
  }
}
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Update Category: <?= $row['name'] ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=category/index.php">List</a></li>
          <li class="breadcrumb-item active">Update</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content container py-2">
  <!-- form start -->
  <form method="POST" action="">
    <div class="box-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Category's Name</label>
        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Name" value="<?= $row['name'] ?>">
        <?php if ($errors) { ?>
          <?php foreach ($errors as $key => $value) { ?>
            <p class="text-danger"><?= $value ?></p>
          <?php } ?>
        <?php } ?>
      </div>
      <div class="form-group">
        <label for="input">Choose Category's Status</label>
        <div class="radio">
          <label>
            <input type="radio" name="status" id="input" value="1" <?= ($row['status'] == 1) ? 'checked' : '' ?>>
            Show
          </label>
          <label>
            <input type="radio" name="status" id="input" value="0" <?= ($row['status'] == 0) ? 'checked' : '' ?>>
            Hide
          </label>
        </div>
      </div>

    </div>
    <!-- /.box-body -->

    <div class="box-footer">
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>

</section>