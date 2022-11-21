<?php
include "layout/header.php";
$sqlBanner = "SELECT * FROM banner WHERE status = 1";
$banners = $connect->query($sqlBanner);
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

<?php include "layout/footer.php" ?>