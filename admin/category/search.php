<?php
  $name = isset($_GET['category_search']) ? $_GET['category_search'] : '';
  $status = isset($_GET['status']) ? $_GET['status'] : '';
  header("location: ../?page=category/index.php&name=$name&status=$status")
?>