<?php
include "connection/connect.php";
$id = (isset($_GET['id'])) ? $_GET['id'] : null;

$prod = mysqli_query($connect, "SELECT * FROM banner WHERE id = '$id'");
$data = mysqli_fetch_assoc($prod);
unlink("uploads/" . $data['image']);

$sql = "DELETE FROM banner WHERE id = $id";
$result = $connect->query($sql);

if ($result) {
  header('location: ?page=banner/index.php');
  exit;
}
