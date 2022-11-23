<?php
include "connection/connect.php";

$product_search = isset($_GET['name']) ? $_GET['name'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$limit = 3;
$pages = !empty($_GET['pages']) ? $_GET['pages'] : 1;
$start = ($pages - 1) * $limit;
$sql = "SELECT p.id, p.name, p.price, p.sale_price, p.image, c.name AS 'Name', p.status FROM product p INNER JOIN category c ON p.category_id = c.id WHERE p.name LIKE '%$product_search%' AND p.status LIKE '%$status%'";

$queryRow =  mysqli_query($connect, $sql);
$count = mysqli_num_rows($queryRow);

if (!empty($_GET['order'])) {
  $orderArr = explode('-', $_GET['order']);
  $field = isset($orderArr[0]) ? $orderArr[0] : '';
  $orderType = isset($orderArr[1]) ? $orderArr[1] : '';
  $sql .= " Order By p.$field $orderType";
}

$totalPage = ceil($count / $limit);
$sql .= " LIMIT $start, $limit";
$result = mysqli_query($connect, $sql);



?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Table Product</h1>
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
    <a href="?page=product/add.php" class="btn btn-success">+ Add New Product</a>
  </div>

  <form class="form-group" method="GET" action="product/search.php">
    <div class="form-group">
      <input type="text" name="product_search" class="form-control" placeholder="Search">
    </div>

    <div class="row">
      <div class="form-group col-lg-6">
        <select name="status" id="" class="form-control">
          <option value="">All</option>
          <option value="1">In Stock</option>
          <option value="0">Out Of Stock</option>
        </select>
      </div>
      <div class="form-group col-lg-6">

        <select name="order" class="form-control">
          <option value="">Sắp xếp</option>
          <option value="id-ASC">Id a - z</option>
          <option value="id-DESC">Id z - a</option>
          <option value="name-ASC">Name a - z</option>
          <option value="name-DESC">Name z - a</option>
          <option value="price-ASC">Price (Low - High)</option>
          <option value="price-DESC">Price (High - Low)</option>
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
          <th>Price ($)</th>
          <th>Sale Price ($)</th>
          <th>Image</th>
          <th>Category</th>
          <th>Status</th>
          <th>Options</th>
        </tr>
        <?php if ($result->num_rows > 0) { ?>
          <?php foreach ($result as $key => $value) { ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><?= $value['id'] ?></td>
              <td><?= $value['name'] ?></td>
              <td><?= number_format($value['price'], 2, ',', '.') ?></td>
              <td><?= number_format($value['sale_price'], 2, ',', '.') ?></td>
              <td style="width: 20%;">
                <img src="../public/uploads/<?= $value['image'] ?>" alt="" style="width: 100%;">
              </td>
              <td><?= $value['Name'] ?></td>

              <td>
                <?php if ($value['status'] == 1) { ?>
                  <span class="badge badge-success">In Stock</span>
                <?php } else { ?>
                  <span class="badge badge-danger">Out Of Stock</span>

                <?php } ?>
              </td>
              <td>
                <a href="?page=product/update.php&id=<?= $value['id'] ?>" class="btn btn-success">Update</a>
                <a href="?page=product/delete.php&id=<?= $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Are You Sure About That ??')">Delete</a>
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
      <li class="page-item"><a class="page-link" href="?page=product/index.php&pages=<?= ($pages > 1) ? $pages - 1 : $pages ?>">&laquo;</a></li>
      <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
        <li class="page-item <?= $i == $pages ? 'active' : ''; ?>">
          <a class="page-link" href="?page=product/index.php&pages=<?= $i; ?>"><?= $i; ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item"><a class="page-link" href="?page=product/index.php&pages=<?= ($pages < $totalPage) ? $pages + 1 : $pages ?>">&raquo;</a></li>
    </ul>

  </div>
  </div>
  <!-- /.box-body -->
</section>