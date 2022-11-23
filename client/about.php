<?php include "layout/header.php" ?>
<?php
$sql = "SELECT * FROM about_page";

$result = mysqli_query($connect, $sql);
$data = $result->fetch_assoc();
?>
<section class="content">
  <?php if ($result->num_rows <= 0) {  ?>
    <div></div>
  <?php } else { ?>
    <?= $data['subject'] ?>
  <?php } ?>
</section>


<?php include "layout/footer.php" ?>