<?php

include "./../lib/config.php";

$updated_at = date('Y-m-d H:i:s');

if ( !is_logged_in() ) {
    logout();
} else {
    $uuid = $_SESSION['uuid'];
}

validate_empty_fields($post);

if ( $tab == 'profile' ) {
    $sql = $link->prepare("SELECT phone FROM users WHERE phone = ? AND uuid != ? LIMIT 1");
    $sql->bind_param("ss", $phone, $uuid);
    if ( $sql->execute() ) {
        $sql->bind_result($_phone);
        $sql->fetch();

        if ( $_phone ) {
            array_push($errors, 'Phone number already registered');
        }
    }
    $sql->close();

    check_errors($errors);

    $sql = $link->prepare("UPDATE `users` SET fname=?, lname=?, country=?, state=?, city=?, phone=?, updated_at=? WHERE uuid=?");

    $sql->bind_param("ssssssss", $first, $last, $country, $state, $city, $phone, $updated_at, $uuid);

    if ( $sql->execute() ) {
        $_SESSION['success'] = ["Profile updated"];
        on_success('settings');
    }

    array_push($errors, 'Something went wrong; retry');

    check_errors($errors);
}

if ( $tab == 'password' ) {
    $sql = $link->prepare("SELECT uuid, password FROM users WHERE uuid = ? LIMIT 1");
    $sql->bind_param("s", $uuid);
    if ( $sql->execute() ) {
        $sql->bind_result($_id, $_password);
        $sql->fetch();
        if (!$_id) {
            array_push($errors, 'Something went wrong; please login');
            $_SESSION['errors'] = $errors;
            logout();
        }

        if ( $_password !== $current) {
            array_push($errors, 'Current password is wrong');
        }
    }
    $sql->close();

    if ( strlen($new) < 8 ) {
        array_push($errors, 'New password must be up to eight characters');
    }

    if ( $new !== $confirm ) {
        array_push($errors, 'Passwords do not match');
    }

    check_errors($errors);

    $sql = $link->prepare("UPDATE `users` SET password=?, updated_at=? WHERE uuid=?");
    $sql->bind_param("sss", $new, $updated_at, $uuid);
    if ( $sql->execute() ) {
        $_SESSION['success'] = ["Password updated"];
        $sql->close();
        on_success('settings');
    }

    array_push($errors, 'Something went wrong; retry');

    check_errors($errors);
}
