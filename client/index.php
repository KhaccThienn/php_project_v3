<?php
include "layout/header.php";
$sqlBanner = "SELECT * FROM banner WHERE status = 1 ORDER BY name ASC";
$banners = $connect->query($sqlBanner);

$newProds = mysqli_query($connect, "SELECT * FROM product ORDER BY id DESC LIMIT 3");

$saleProds = mysqli_query($connect, "SELECT *, ( (1 - (sale_price / price)) * 100) as 'off' FROM product WHERE sale_price > 0 ORDER BY off DESC LIMIT 4");

?>
<?php if ($banners->num_rows > 0) { ?>
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <?php foreach ($banners as $key => $banner) : ?>
        <li data-target="#carouselExampleCaptions" data-slide-to="<?= $key; ?>" class="<?= $key == 0 ? 'active' : ''; ?>"></li>
      <?php endforeach; ?>
    </ol>

    <div class="carousel-inner">
      <?php foreach ($banners as $key => $value) { ?>

        <div class="carousel-item <?= $key == 0 ? 'active' : ''; ?>">
          <img src="../public/uploads/<?= $value['image'] ?>" class="d-block w-100" alt="..." style="height: 700px; object-fit: fill;">
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
<?php } else { ?>
  <div class="text-center text-danger h3">No Banner to Show</div>
<?php } ?>

<div class="container py-5">

  <div class="text-center h3 text-success">
    New Products
  </div>
  <div class="row  justify-content-between">
    <?php if ($newProds->num_rows > 0) { ?>
      <?php foreach ($newProds as $key => $value) { ?>
        <div class="col-lg-4">
          <div class="card" style="width: 16rem;">
            <img src="../public/uploads/<?= $value['image'] ?>" class="card-img" alt="...">
            <div class="card-body">
              <h5 class="card-title text-truncate" title="<?= $value['name'] ?>">
                <?= $value['name'] ?>
              </h5>
              <p class="card-text">
                <?php if ($value['sale_price'] > 0 || $value['sale_price'] !== $value['price']) { ?>
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
      <div class="text-center">
        No data to show
      </div>
    <?php } ?>
  </div>

  <div class="text-center h3 text-success mt-5">
    Best Saled Products
  </div>
  <div class="row">
    <?php if ($saleProds->num_rows > 0) { ?>
      <?php foreach ($saleProds as $key => $value) { ?>
        <div class="col-lg-3">
          <div class="card" style="width: 16rem;">
            <img src="../public/uploads/<?= $value['image'] ?>" class="card-img" alt="...">
            <div class="card-body">
              <h5 class="card-title text-truncate" title="<?= $value['name'] ?>">
                <?= $value['name'] ?>
              </h5>
              <p class="card-text">
                <span class="text-danger"><del><?= number_format($value['price'], 2, '.', ',') . "$" ?></del></span>
                <strong class="text-success">
                  <?= number_format($value['sale_price'], 2, '.', ',') . "$" ?>
                </strong>
              </p>
              <p class="text-primary"><?= "Sale: " . number_format($value['off'], 2, '.', ',') . " %" ?></p>
              <a href="detail.php?id=<?= $value['id'] ?>" class="btn btn-outline-dark">View Details</a>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="text-center">
        No data to show
      </div>
    <?php } ?>

  </div>
</div>


<?php include "layout/footer.php" ?>