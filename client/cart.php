<?php
include "layout/header.php";
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<div class="container p-5">
  <div class="text-center">
    <h3 class="text-success">Cart</h3>
  </div>

  <table class="table table-bordered">
    <tr>
      <th>STT</th>
      <th>ID</th>
      <th>Name</th>
      <th>Image</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
    <?php if (count($cart) > 0) { ?>
      <?php
      $n = 1;
      foreach ($cart as $key => $value) {
        $total = $value['price'] * $value['quantity'] ?>
        <tr>
          <td><?php echo $n; ?></td>
          <td><?= $value['id'] ?></td>
          <td><?= $value['name'] ?></td>
          <td class="w-25">
            <img src="../admin/uploads/<?= $value['image'] ?>" alt="" class="card-img">
          </td>
          <td><?= $value['price'] ?></td>
          <td>
            <form action="cart-process.php">
              <input type="hidden" name="id" value="<?= $value['id']; ?>">
              <input type="hidden" name="action" value="update">
              <input type="number" name="quantity" value="<?= $value['quantity']; ?>" style="width:60px">
              <input type="submit" value="Cập nhật" class="btn btn-xs btn-success">
            </form>
          </td>
          <td>
            <?= "$" . number_format($total, 2, '.', ',') ?>
          </td>
          <td>
            <a href="cart-process.php?id=<?php echo $item['id'] ?>&action=delete" class="btn btn-xs btn-danger">Delete</a>
          </td>
        </tr>
      <?php $n++; } ?>
    <?php } else { ?>
      <h3 class="text-center text-danger">0 Data Returned</h3>
    <?php } ?>
  </table>
</div>

<?php include "layout/footer.php" ?>