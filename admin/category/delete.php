<?php
include "connection/connect.php";
$id = (isset($_GET['id'])) ? $_GET['id'] : null;

$prod = mysqli_query($connect, "SELECT * FROM product WHERE category_id = $id");
$data = mysqli_fetch_assoc($prod);
unlink("../public/uploads/" . $data['image']);

$sqls = "DELETE FROM product WHERE category_id = $id";
$result = $connect->query($sqls);

$sql = "DELETE FROM category WHERE id = $id";
$result = $connect->query($sql);

if ($result) {
  header('location: ?page=category/index.php');
  exit;
}
