<?php
include "layout/header.php";

$query = mysqli_query($connect, "SELECT MAX(price) as Maximum FROM product");
$max_price = mysqli_fetch_assoc($query);

$cate = isset($_GET['category']) ? $_GET['category'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$minPrice = !empty($_GET['minPrice']) ? $_GET['minPrice'] : 0;
$maxPrice = !empty($_GET['maxPrice']) ? $_GET['maxPrice'] : $max_price['Maximum'] + 1;

$sqlBanner = "SELECT * FROM banner WHERE status = 1";
$banners = $connect->query($sqlBanner);

$limit = 8;
$pages = !empty($_GET['pages']) ? $_GET['pages'] : 1;
$start = ($pages - 1) * $limit;
$sqlProd = "SELECT * FROM product WHERE name LIKE '%$keyword%' AND category_id LIKE '%$cate%' AND price BETWEEN '$minPrice' AND '$maxPrice'";
$queryRow =  mysqli_query($connect, $sqlProd);
$count = mysqli_num_rows($queryRow);

if (!empty($_GET['order'])) {
  $orderArr = explode('-', $_GET['order']);
  $field = isset($orderArr[0]) ? $orderArr[0] : '';
  $orderType = isset($orderArr[1]) ? $orderArr[1] : '';
  $sqlProd .= " Order By $field $orderType";
}

$totalPage = ceil($count / $limit);
$sqlProd .= " LIMIT $start, $limit";

$results = $connect->query($sqlProd);
?>

<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php foreach ($banners as $key => $banner) : ?>
      <li data-target="#carouselExampleCaptions" data-slide-to="<?= $key; ?>" class="<?= $key == 0 ? 'active' : ''; ?>"></li>
    <?php endforeach; ?>
  </ol>

  <div class="carousel-inner">
    <?php foreach ($banners as $key => $value) { ?>

      <div class="carousel-item <?= $key == 0 ? 'active' : ''; ?>">
        <img src="<?= $value['image'] ?>" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5><?= $value['name'] ?></h5>
          <p><?= $value['description'] ?></p>
        </div>
      </div>
    <?php } ?>
  </div>
  <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </button>
</div>

<div class="container">
  <div class="heading">
    <div class="text-center">
      <h1>Shop Page</h1>
      <hr>
      <small class="font-italic">everything here</small>
    </div>
  </div>


</div>
<div class="main container-fluid">
  <div class="row">
    <div class="col-lg-4">
      <div class="text-center">
        <p class="text-primary h5">Filter Bar</p>
      </div>
      <form method="GET">
        <?php if (!empty($_GET)) { ?>
          <a href="shop.php" class="btn btn-outline-danger">Clear All</a>
        <?php } ?>

        <div class="form-group">
          <select name="order" class="form-control">
            <option value="">Order By...</option>
            <option value="id-ASC">Id a - z</option>
            <option value="id-DESC">Id z - a</option>
            <option value="name-ASC">Name a - z</option>
            <option value="name-DESC">Name z - a</option>
            <option value="price-ASC">Price (Low - High)</option>
            <option value="price-DESC">Price (High - Low)</option>
            <option value="sale_price-ASC">Sale Price (Low - High)</option>
            <option value="sale_price-DESC">Sale Price (High - Low)</option>
          </select>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-lg-6">
              <label for="min">Min Price</label>
              <input type="text" class="form-control" placeholder="Min Price" name="minPrice" id="min">
            </div>
            <div class="col-lg-6">
              <label for="max">Max Price</label>
              <input type="text" class="form-control" placeholder="Max Price" name="maxPrice" id="max">
            </div>
          </div>
        </div>
        <div class="form-group">
          
        </div>
        <button type="submit" class="btn btn-outline-warning btn-block">
          Filter Now
        </button>
      </form>
    </div>
    <div class="col-lg-8">
      <?php if (!$cate) { ?>
        <div class="text-center">
          <h3 class="text-success">All Products</h3>
        </div>
        <div class="row">
          <?php if ($results->num_rows > 0) { ?>
            <?php foreach ($results as $key => $value) { ?>
              <div class="col-lg-3 mt-3">
                <div class="card" style="width: 16rem;">
                  <img src="../admin/uploads/<?= $value['image'] ?>" class="card-img" alt="...">
                  <div class="card-body">
                    <h5 class="card-title text-truncate" title="<?= $value['name'] ?>">
                      <?= $value['name'] ?>
                    </h5>
                    <p class="card-text">
                      <?php if ($value['sale_price'] > 0) { ?>
                        <span class="text-danger"><del><?= number_format($value['price'], 2, '.', ',') . "$" ?></del></span>
                        <strong class="text-success">
                          <?= number_format($value['sale_price'], 2, '.', ',') . "$" ?>
                        </strong>
                      <?php } else { ?>
                        <strong class="text-success">
                          <?= number_format($value['price'], 2, '.', ',') . "$" ?>
                        </strong>
                      <?php } ?>
                    </p>
                    <a href="detail.php?id=<?= $value['id'] ?>" class="btn btn-outline-dark">View Details</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <h3 class="text-danger"> 0 Data Returned </h3>
          <?php } ?>
        </div>
      <?php } else { ?>
        <div class="text-center">
          <h3 class="text-success">All Products Of:
            <?php foreach ($result as $key => $value) {
              if ($cate == $value['id']) {
                echo $value['name'];
              }
            } ?>
          </h3>
        </div>
        <div class="row">
          <?php if ($results->num_rows > 0) { ?>
            <?php foreach ($results as $key => $value) { ?>
              <div class="col-lg-3 mt-3">
                <div class="card" style="width: 16rem;">
                  <img src="../admin/uploads/<?= $value['image'] ?>" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title" title="<?= $value['name'] ?>">
                      <?= $value['name'] ?>
                    </h5>
                    <p class="card-text">
                      <span class="text-danger"><del><?= number_format($value['price'], 2, '.', ',') . "$" ?></del></span>
                      <strong class="text-success">
                        <?= number_format($value['sale_price'], 2, '.', ',') . "$" ?>
                      </strong>
                    </p>
                    <a href="detail.php?id=<?= $value['id'] ?>" class="btn btn-outline-dark">View Details</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <h3 class="text-danger"> 0 Data Returned </h3>
          <?php } ?>
        </div>
      <?php } ?>


      <div class="pagi">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="?pages=<?= ($pages > 1) ? $pages - 1 : $pages ?>">&laquo;</a></li>
          <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
            <li class="page-item <?= $i == $pages ? 'active' : ''; ?>">
              <a class="page-link" href="?pages=<?= $i; ?>"><?= $i; ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item"><a class="page-link" href="?pages=<?= ($pages < $totalPage) ? $pages + 1 : $pages ?>">&raquo;</a></li>
        </ul>

      </div>

    </div>
  </div>
</div>
<?php include "layout/footer.php" ?>