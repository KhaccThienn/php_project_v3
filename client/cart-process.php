<?php
session_start();

include 'connection/connect.php';


$id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
$action = !empty($_GET['action']) ? $_GET['action'] : 'add';
$quantity = !empty($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

$query = mysqli_query($connect, "SELECT * FROM product WHERE id = $id");
$product = mysqli_fetch_assoc($query);

if ($product && $action == 'add') {

  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += $quantity;
  } else {
    $cart = [
      'id' => $product['id'],
      'name' => $product['name'],
      'image' => $product['image'],
      'price' => ($product['sale_price'] > 0) ? $product['sale_price'] : $product['price'],
      'quantity' => $quantity
    ];
    $_SESSION['cart'][$id] = $cart;
  }
}

if ($action == 'delete') {
  if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
  }
}

if ($action == 'update') {
  $quantity = $quantity >= 1 ? $quantity : 1; 
  if (isset($_SESSION['cart'][$id])) { 
    $_SESSION['cart'][$id]['quantity'] = $quantity;
  }
}

header('location: cart.php');
exit;