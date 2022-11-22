<?php
ob_start();
include "connection/connect.php";
$errors = [];

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $status = $_POST['status'];

  if (empty($name)) {
    $errors['name'] = "Name is required";
  }

  if (!empty($_FILES['image']['name'])) {
    $types = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp', 'image/svg'];
    $file = $_FILES['image'];
    if (!in_array($file['type'], $types)) {
      $errors['image_invalid'] = "Invalid image type";
    } else {
      $image = time() . $file['name'];
      move_uploaded_file($file['tmp_name'], "uploads/" . $image);
    }
  }
  if (empty($description)) {
    $errors['description'] = "Description is required";
  }

  if (!$errors) {
    $sql = "INSERT INTO banner (name, image, description, status) VALUES ('$name', '$image', '$description', $status)";

    $query = $connect->query($sql);

    if ($query) {
      header('location: ?page=banner/index.php');
      exit;
    } else {
      $errors['invalid_query'] = "Invalid query, please try again";
    }
  }
}
ob_end_flush();
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add New Banner</h1>
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
  <form method="POST" action="" enctype="multipart/form-data">
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
      <label for="name">Banner's Name</label>
      <input type="text" name="name" class="form-control" id="name" placeholder="Name">
    </div>

    <div class="form-group">
      <label for="image">Banner's Image</label>
      <input type="file" name="image" id="image" class="form-control">
    </div>

    <div class="form-group">
      <label for="desc">Banner's Description</label>
      <textarea name="description" id="desc" class="form-control" cols="30" rows="10" placeholder="Description"></textarea>
    </div>

    <div class="form-group">
      <label for="input">Choose Banner's Status</label>
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

    <div class="box-footer">
      <button type="submit" name="submit" class="btn btn-outline-primary">Submit</button>
    </div>
  </form>


</section>