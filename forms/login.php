<?php

require_once "./../lib/config.php";

validate_empty_fields($post);

$sql = $link->prepare("SELECT uuid, username, email, password FROM users WHERE username = ? or email = ? LIMIT 1");
$sql->bind_param("ss", $user, $user);
if ( $sql->execute() ) {
    $sql->bind_result($_uuid, $_username, $_email, $_password);
    $sql->fetch();
    if ( $_username || $_email ) {
        if ($_password === $password) {
            $_SESSION['uuid'] = $_uuid;
            isset($_GET['to_cart']) && $_GET['to_cart'] == 'true' ? on_success('cart') : on_success('index');
        }
    }
    array_push($errors, 'Invalid login');
}
$sql->close();

check_errors($errors);

array_push($errors, 'Something went wrong; retry');

check_errors($errors);
