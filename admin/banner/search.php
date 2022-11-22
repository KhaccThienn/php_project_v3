<?php
  $name = isset($_GET['banner_search']) ? $_GET['banner_search'] : '';
  $status = isset($_GET['status']) ? $_GET['status'] : '';
  header("location: ../?page=banner/index.php&name=$name&status=$status")
?>