<?php

require_once "./lib/config.php";

if ( !is_logged_in() ) {
    logout(false);
} else {
    $uuid = $_SESSION['uuid'];
}

$sql = "SELECT * FROM users WHERE uuid = '$uuid' LIMIT 1";
$result = $link->query($sql);
if ( $result->num_rows ) {
    $user = $result->fetch_object();
} else {
    logout(false);
}
