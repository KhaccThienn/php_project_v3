<?php
include "layout/header.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;

$sqlProd = "SELECT * FROM product WHERE id = '$id'";
$prod = mysqli_query($connect, $sqlProd);
$data = mysqli_fetch_assoc($prod);

$user = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : [];

$qty = 1;

$off = number_format(((1 - ($data['sale_price'] / $data['price'])) * 100), 2, '.', ',');
?>

<div class="container p-5">
  <div class="row align-items-center">
    <div class="col-lg-6">
      <img src="../public/uploads/<?= $data['image'] ?>" class="card-img" alt="">
    </div>
    <div class="col-lg-6">
      <p>SKU: <?= $data['id'] ?></p>
      <h3 class="font-weight-bold"><?= $data['name'] ?></h3>
      <p class="h4">
        <?php if ($data['sale_price'] > 0) { ?>
          <span class="text-danger">
            <del><?= "$" . number_format($data['price'], 2, '.', ',') ?></del>
          </span>
          <span class="text-success"><?= "$" . number_format($data['sale_price'], 2, '.', ',') ?></span>
          <small class="text-primary"><?= $off . " %off" ?></small>
        <?php } else { ?>
          <span class="text-success"><?= "$" . number_format($data['price'], 2, '.', ',') ?></span>
        <?php } ?>
      </p>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?</p>
      <?php if (!$user) { ?>
        <p class="badge badge-warning">
          You must be logged in to add this item into your shopping cart !
        </p>
      <?php } else { ?>
        <?php if ($data['status'] == 0) { ?>
          <p class="badge badge-danger">
            This item is currently out of stock, please try again next time !
          </p>
        <?php } else { ?>
          <form action="cart-process.php" method="GET">

            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <div class="row">
              <div class="col-lg-6">
                <div class="d-flex">

                  <button type="button" class="btn btn-outline-primary">-</button>
                  <input type="text" class="form-control text-center" placeholder="Quantity" name="quantity" value="<?= $qty ?>">
                  <button type="button" class="btn btn-outline-primary">+</button>

                </div>
              </div>
              <div class="col-lg-6">

                <button type="submit" class="btn btn-outline-dark">Add To Cart <i class="fa fa-cart-plus" aria-hidden="true"></i></button>

              </div>
            </div>
          </form>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>

<?php include "layout/footer.php" ?>