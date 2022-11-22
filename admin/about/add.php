<?php
ob_start();
include "connection/connect.php";
$errors = [];
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
// if (empty($subject)) {
//   header('location: ?page=about/add.php');
// }

if (isset($_POST['submit'])) {
  if (empty($subject)) {
    $errors['subject_required'] = "Subject must not be empty !";
  }

  if (!$errors) {
    $sql = "INSERT INTO about_page(subject) VALUES ('$subject')";

    $query = mysqli_query($connect, $sql);

    if ($query) {
      header('location: ?page=about/index.php');
      exit;
    } else {
      $errors['invalid_query'] = "Invalid query, please try again ";
    }
  }
}
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add About Page Subject</h1>
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

<section class="content container-fluid py-5">
  <!-- form start -->
  <form method="POST" action="">
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
      <label for="subject">Add Subject Here</label>
      <textarea name="subject" id="subject" cols="30" rows="50" class="form-control"></textarea>
    </div>

    <div class="box-footer">
      <button type="submit" name="submit" class="btn btn-outline-primary">Submit</button>
    </div>
  </form>
</section>