<?php
include "connection/connect.php";

$user_search = isset($_GET['name']) ? $_GET['name'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$limit = 10;
$pages = !empty($_GET['pages']) ? $_GET['pages'] : 1;
$start = ($pages - 1) * $limit;
$sql = "SELECT * FROM users WHERE name LIKE '%$user_search%' AND status LIKE '%$status%'";

$queryRow =  mysqli_query($connect, $sql);
$count = mysqli_num_rows($queryRow);

if (!empty($_GET['order'])) {
  $orderArr = explode('-', $_GET['order']);
  $field = isset($orderArr[0]) ? $orderArr[0] : '';
  $orderType = isset($orderArr[1]) ? $orderArr[1] : '';
  $sql .= " Order By $field $orderType";
}

$totalPage = ceil($count / $limit);
$sql .= " LIMIT $start, $limit";
$result = mysqli_query($connect, $sql);



?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Table Users</h1>
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
<section class="content container-fluid">
  <div class="form-group">
    <a href="?page=user/add.php" class="btn btn-success">+ Add New User</a>
  </div>

  <form class="form-group" method="GET" action="user/search.php">
    <div class="form-group">
      <input type="text" name="product_search" class="form-control" placeholder="Search">
    </div>
    <div class="row">
      <div class="form-group col-lg-6">
        <select name="status" id="" class="form-control">
          <option value="">---Status---</option>
          <option value="1">Online</option>
          <option value="0">Banned</option>
        </select>
      </div>
      <div class="form-group col-lg-6">
        <select name="order" class="form-control">
          <option value="">Sắp xếp</option>
          <option value="id-ASC">Id a - z</option>
          <option value="id-DESC">Id z - a</option>
          <option value="name-ASC">Name a - z</option>
          <option value="name-DESC">Name z - a</option>
          <option value="role-ASC">Access Role (Low - High)</option>
          <option value="role-DESC">Access Role (High - Low)</option>
        </select>
      </div>

    </div>
    <button type="submit" class="btn btn-default btn-block"><i class="fa fa-search"></i></button>

  </form>


  <!-- /.box-header -->
  <div class="">
    <table class="table table-hover table-bordered">
      <tbody>
        <tr>
          <th>STT</th>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Role</th>
          <th>Options</th>
        </tr>
        <?php if ($result->num_rows > 0) { ?>
          <?php foreach ($result as $key => $value) { ?>
            <?php if ($value['role'] == 0) { ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $value['id'] ?></td>
                <td>
                  <?= $value['name'] ?>
                </td>
                <td><?= $value['email'] ?></td>
                <td style="width: 40%;"><?= $value['password'] ?></td>
                <td>
                  <?= $value['phone'] ?>
                </td>
                <td>
                  <?php if ($value['status'] == 1) { ?>
                    <span class="label label-success">Online</span>
                  <?php } else { ?>
                    <span class="label label-danger">Banned</span>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($value['role'] == 1) { ?>
                    <span class="label label-success">
                      Administrator
                    </span>
                  <?php } else { ?>
                    <span class="label label-danger">
                      Customers
                    </span>
                  <?php } ?>
                </td>
                <td>
                  <a href="?page=product/update.php&id=<?= $value['id'] ?>" class="btn btn-success">Update</a>
                  <a href="?page=product/delete.php&id=<?= $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Are You Sure About That ??')">Delete</a>
                </td>
              </tr>
            <?php } else { ?>
              <tr>
                <th><?= $key + 1 ?></th>
                <th><?= $value['id'] ?></th>
                <th>
                  <?= $value['name'] ?>
                </th>
                <th><?= $value['email'] ?></th>
                <th style="width: 40%;"><?= $value['password'] ?></th>
                <th>
                  <?= $value['phone'] ?>
                </th>
                <th>
                  <?php if ($value['status'] == 1) { ?>
                    <span class="label label-success">Online</span>
                  <?php } else { ?>
                    <span class="label label-danger">Banned</span>
                  <?php } ?>
                </th>
                <th>
                  <?php if ($value['role'] == 1) { ?>
                    <span class="label label-success">
                      Administrator
                    </span>
                  <?php } else { ?>
                    <span class="label label-danger">
                      Customers
                    </span>
                  <?php } ?>
                </th>
                <th>
                  <a href="?page=product/update.php&id=<?= $value['id'] ?>" class="btn btn-success">Update</a>
                  <a href="?page=product/delete.php&id=<?= $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Are You Sure About That ??')">Delete</a>
                </th>
              </tr>
            <?php } ?>
          <?php } ?>
        <?php } else { ?>
          <h3 class="text-danger" style="margin-left: 10px;">0 Data Returned</h3>
        <?php } ?>

      </tbody>
    </table>
  </div>
  <div class="pagi text-center">

    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="?page=user/index.php&pages=<?= ($pages > 1) ? $pages - 1 : $pages ?>">&laquo;</a></li>
      <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
        <li class="page-item <?= $i == $pages ? 'active' : ''; ?>">
          <a class="page-link" href="?page=user/index.php&pages=<?= $i; ?>"><?= $i; ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item"><a class="page-link" href="?page=user/index.php&pages=<?= ($pages < $totalPage) ? $pages + 1 : $pages ?>">&raquo;</a></li>
    </ul>

  </div>
  </div>
  <!-- /.box-body -->
</section>