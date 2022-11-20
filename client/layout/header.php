<?php
include "connection/connect.php";
$user = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : [];
$sqlCate = "SELECT * FROM category WHERE status = 1";
$result = $connect->query($sqlCate);
?>
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

    <form class="form-group d-flex my-2 my-lg-0" method="GET">
      <input class="form-control" name="q" type="text" placeholder="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

  </div>
</nav>