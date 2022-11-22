<?php
include "connection/connect.php";

$sql = "SELECT * FROM about_page";

$result = mysqli_query($connect, $sql);
$data = $result->fetch_assoc();
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data About Page</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Data About</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
  <?php if ($result->num_rows <= 0) {  ?>
    <a href="?page=about/add.php" class="btn btn-outline-success">Add New About Page</a>
  <?php } else { ?>
    <a href="?page=about/update.php&id=<?= $data['id']?>" class="btn btn-outline-success">Edit About Page</a>
    <?= $data['subject'] ?>
  <?php } ?>
</section>