<?php
ob_start();
session_start();

include "connection/connect.php";

$user = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : [];

$sqlCate = "SELECT * FROM category WHERE status = 1";
$result = $connect->query($sqlCate);
?>

<!doctype html>
<html lang="en">

<head>
  <title>Home</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
  
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>

    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-flex align-items-center justify-content-between" id="collapsibleNavId">
      <ul class="navbar-nav">

        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="about.php">About</a>
        </li>


        <li class="nav-item active dropdown">
          <a class="nav-link dropdown-toggle" href="shop.php" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Shop
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="shop.php">
              All Products
            </a>
            <?php foreach ($result as $key => $value) { ?>
              <a class="dropdown-item" href="shop.php?category=<?= $value['id'] ?>">
                <?= $value['name'] ?>
              </a>
            <?php } ?>
          </div>
        </li>

        <li class="nav-item active dropdown ">
          <a class="nav-link dropdown-toggle text-uppercase " href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= (!empty($user)) ? $user['name'] : 'Account' ?>
          </a>
          <div class="dropdown-menu ml-auto" aria-labelledby="dropdownId">
            <?php if (!empty($user)) { ?>
              <a class="dropdown-item" href="logout.php">Log Out</a>
            <?php } else { ?>
              <a class="dropdown-item" href="login.php">Login</a>
              <a class="dropdown-item" href="register.php">Register</a>
            <?php } ?>
          </div>
        </li>


      </ul>

      <form class="form-group d-flex my-2 my-lg-0" method="GET" action="shop.php">
        <input class="form-control" name="keyword" type="text" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>

    </div>
  </nav>