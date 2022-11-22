<?php
include "connection/connect.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;

$errors = [];

$sqls = "SELECT * FROM banner WHERE id = '$id'";
$result = $connect->query($sqls);
$row = $result->fetch_assoc();


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
  } else {
    $image = $row['image'];
  }

  if (empty($description)) {
    $errors['description'] = "Description is required";
  }

  if (!$errors) {
    $sql = "UPDATE banner SET name = '$name', image = '$image', description = '$description', status = $status WHERE id = '$id'";

    $query = $connect->query($sql);

    if ($query) {
      header('location: ?page=banner/index.php');
      exit;
    }
  }
}
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Update Banner</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">List</a></li>
          <li class="breadcrumb-item active">Update</li>
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
      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= $row['name'] ?>">
    </div>

    <div class="form-group">
      <label for="image">Banner's Image</label>
      <input type="file" name="image" id="image" class="form-control">
      <div class="old_image" style="width: 20%;">
        <img src="uploads/<?= $row['image']?>" alt="" class="card-img">
      </div>
    </div>

    <div class="form-group">
      <label for="desc">Banner's Description</label>
      <textarea name="description" id="desc" class="form-control" cols="30" rows="10" placeholder="Description"> <?= $row['description'] ?></textarea>
    </div>

    <div class="form-group">
      <label for="input">Choose Banner's Status</label>
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

    <div class="box-footer">
      <button type="submit" name="submit" class="btn btn-outline-primary">Submit</button>
    </div>
  </form>


</section>