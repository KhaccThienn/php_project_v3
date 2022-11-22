<?php
include "connection/connect.php";

$banner_search = isset($_GET['name']) ? $_GET['name'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$limit = 3;
$pages = !empty($_GET['pages']) ? $_GET['pages'] : 1;
$start = ($pages - 1) * $limit;

$sql = "SELECT * FROM banner WHERE name LIKE '%$banner_search%' AND status LIKE '%$status%'";

$queryRow =  mysqli_query($connect, $sql);
$count = mysqli_num_rows($queryRow);

$totalPage = ceil($count / $limit);
$sql .= " LIMIT $start, $limit";

$result = mysqli_query($connect, $sql);

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Table Banner</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">DataTables</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">


  <div class="box-header">
    <a href="?page=banner/add.php" class="btn btn-success">+ Add New Banner</a>
    <form class="form-group" method="GET" action="banner/search.php">
      <div class="row align-items-center">
        <div class="col-lg-6 p-0">
          <input type="text" name="banner_search" class="form-control pull-right" placeholder="Search">
        </div>
        <div class="col-lg-6 p-0">
          <select name="status" id="" class="form-control">
            <option value="">All</option>
            <option value="1">Show</option>
            <option value="0">Hide</option>
          </select>
        </div>
        <button type="submit" class="btn btn-outline-dark btn-block"><i class="fa fa-search"></i></button>
      </div>
    </form>

  </div>

  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table class="table table-hover table-bordered">
      <tbody>
        <tr>
          <th>STT</th>
          <th>ID</th>
          <th>Name</th>
          <th>Image</th>
          <th>Description</th>
          <th>Status</th>
          <th>Options</th>
        </tr>
        <?php if ($result->num_rows > 0) { ?>
          <?php foreach ($result as $key => $value) { ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><?= $value['id'] ?></td>
              <td><?= $value['name'] ?></td>
              <td style="width: 20%;">
                <img src="uploads/<?= $value['image'] ?>" class="card-img" alt="">
                
              </td>
              <td><?= $value['description'] ?></td>
              <td>
                <?php if ($value['status'] == 1) { ?>
                  <span class="badge badge-success">Show</span>
                <?php } else { ?>
                  <span class="badge badge-danger">Hide</span>

                <?php } ?>
              </td>
              <td>
                <a href="?page=banner/update.php&id=<?= $value['id'] ?>" class="btn btn-success">Update</a>
                <a href="?page=banner/delete.php&id=<?= $value['id'] ?>" class="btn btn-danger" onclick='return confirm("Are You Sure About That ? All Products which have this category  will be delete ! ")'>Delete</a>
              </td>
            </tr>

          <?php } ?>
        <?php } else { ?>
          <h3 class="text-danger" style="margin-left: 10px;">0 Data Returned</h3>
        <?php } ?>

      </tbody>
    </table>
  </div>
  <div class="pagi text-center">

    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="?page=banner/index.php&pages=<?= ($pages > 1) ? $pages - 1 : $pages ?>">&laquo;</a></li>
      <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
        <li class="page-item <?= $i == $pages ? 'active' : ''; ?>">
          <a class="page-link" href="?page=banner/index.php&pages=<?= $i; ?>"><?= $i; ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item"><a class="page-link" href="?page=banner/index.php&pages=<?= ($pages < $totalPage) ? $pages + 1 : $pages ?>">&raquo;</a></li>
    </ul>

  </div>
  <!-- /.box-body -->

</section>