<?php

require_once "./lib/config.php";
if ( !isset($_SESSION['admin']) || empty($_SESSION['admin']) ) {
    logout(false);
} else {
    $id = $_SESSION['admin'];
}

$sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
$result = $link->query($sql);
if ( $result->num_rows ) {
    $user = $result->fetch_object();
} else {
    logout(false);
}
