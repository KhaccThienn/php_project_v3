<?php

$name = isset($_GET['product_search']) ? $_GET['product_search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

header("location: ../?page=user/index.php&name=$name&status=$status&order=$order");
