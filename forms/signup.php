<?php

include "./../lib/config.php";

validate_empty_fields($post);

$sql = $link->prepare("SELECT username FROM users WHERE username = ? LIMIT 1");
$sql->bind_param("s", $username);
if ( $sql->execute() ) {
    $sql->bind_result($_username);
    $sql->fetch();
    if ($_username) {
        array_push($errors, 'Username already taken');
    }
}
$sql->close();

if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
    array_push($errors, 'Email is invalid');

$sql = $link->prepare("SELECT email FROM users WHERE email = ? LIMIT 1");
$sql->bind_param("s", $email);

if ( $sql->execute() ) {
    $sql->bind_result($_email);
    $sql->fetch();
    if ($_email) {
        array_push($errors, 'Email already registered');
    }
}
$sql->close();

if ( strlen($password) < 8 )
    array_push($errors, 'Password must be up to eight characters');

if ( $password !== $confirm )
    array_push($errors, 'Passwords do not match');

check_errors($errors);

$uuid = md5($email . $username . '...');
$at = date('Y-m-d H:i:s');
$sql = $link->prepare("INSERT INTO `users`(uuid, username, email, password, fname, lname, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("ssssssss", $uuid, $username, $email, $password, $first, $last, $at, $at);
if ( $sql->execute() ) {
    $sql->close();
    $_SESSION['uuid'] = $uuid;
    on_success('index');
}
$sql->close();

array_push($errors, 'Something went wrong; retry.. '.$link->error);

check_errors($errors);
