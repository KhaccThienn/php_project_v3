<?php
ob_start();

include "connection/connect.php";

$errors = [];
$sql = "SELECT * FROM category";
$results = $connect->query($sql);

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $status = $_POST['status'];

  if (empty($name)) {
    $errors['name'] = "Name is required";
  } else {
    foreach ($results as $key => $value) {
      if ($value['name'] == $name) {
        $errors['name'] = "Category " . $name . " already exists";
      }
    }
  }

  if (!$errors) {
    $sql = "INSERT INTO category (name, status) VALUES ('$name', $status)";

    $query = $connect->query($sql);

    if ($query) {
      header('location: ?page=category/index.php');
      exit;
    }
  }
}
ob_end_flush();
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add New Category</h1>
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
  <!-- form start -->
  <form method="POST" action="">
    <div class="box-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Category's Name</label>
        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Name">
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
            <input type="radio" name="status" id="input" value="1" checked="checked">
            Show
          </label>
          <label>
            <input type="radio" name="status" id="input" value="0">
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