<?php
include "connection/connect.php";
$id = (isset($_GET['id'])) ? $_GET['id'] : null;

$sql = "SELECT * FROM product WHERE id = '$id'";
$results = $connect->query($sql);
$row = mysqli_fetch_assoc($results);

unlink("uploads/".$row['image']);

$sql = "DELETE FROM product WHERE id = $id";
$result = $connect->query($sql);

if ($result) {
  header('location: ?page=product/index.php');
  exit;
}
