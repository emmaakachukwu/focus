<?php

require_once "./../lib/config.php";

// confirm id availablity
if ( !isset($_GET['uid']) || empty(trim($_GET['uid'])) ) {
    array_push($errors, 'Something went wrong.. please refresh');
    check_errors($errors);
} else {
    $uid = $_GET['uid'];
}

$required = ['first_name, last_name'];
validate_empty_fields($post, $required);

if ( strlen($password) < 8 )
    array_push($errors, 'Password must be up to eight characters');
$balance = empty($balance) ? 0 : intval($balance);
$at = date('Y-m-d H:i:s');
$sql = $link->prepare("UPDATE `users` SET `fname`=?, lname=?, phone=?, `password`=?, city=?, `state`=?, country=?, balance=?, updated_at=? WHERE id=?");
$sql->bind_param("sssssssiss", $first, $last, $phone, $password, $city, $state, $country, $balance, $at, $uid);
if ( $sql->execute() ) {
    $_SESSION['success'] = ["User updated"];
    $sql->close();
    on_success('edit_user');
}

array_push($errors, 'Something went wrong; retry.. '.$link->error);

check_errors($errors);