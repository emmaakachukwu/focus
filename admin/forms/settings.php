<?php

include "./../lib/config.php";

if ( !isset($_SESSION['admin']) || empty($_SESSION['admin']) ) {
    logout();
} else {
    $id = $_SESSION['admin'];
}

if ( !isset($post['tab']) || empty(trim($post['tab'])) )
    array_push($errors, 'Something went wrong.. refresh');
check_errors($errors);
validate_empty_fields($post);

$bname = $bname ?? null;
$baddress = $baddress ?? null;
$recipient = $recipient ?? null;
$swift = $swift ?? null;
$updated_at = date('Y-m-d H:i:s');

if ( $tab != 'password' ) {
    foreach ( $post as $key => $value ) {
        try {
            $sql = $link->prepare("UPDATE `wallets` SET wallet_id=?, bank_name=?, bank_address=?, recipient_name=?, swift_code=?, updated_at=? WHERE type=?");
            // dd($link->error);
            $sql->bind_param("sssssss", $wid, $bname, $baddress, $recipient, $swift, $updated_at, $tab);
            $sql->execute();
            $sql->close();
        } catch (Exception $e) {
            array_push($errors, 'Something went wrong updating details');
            $sql->close();
            check_errors($errors);
        }
    }

    $_SESSION['success'] = ["Wallet info updated"];
    on_success('settings');
} else {
    $sql = $link->prepare("SELECT id, password FROM users WHERE id = ? AND role = 'admin' LIMIT 1");
    $sql->bind_param("s", $id);
    if ( $sql->execute() ) {
        $sql->bind_result($_id, $_password);
        $sql->fetch();
        if (!$_id) {
            array_push($errors, 'Something went wrong; please login again');
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

    $sql = $link->prepare("UPDATE `users` SET password=?, updated_at=? WHERE id=?");
    $sql->bind_param("sss", $new, $updated_at, $id);
    if ( $sql->execute() ) {
        $_SESSION['success'] = ["Password updated"];
        $sql->close();
        on_success('settings');
    }
}

array_push($errors, 'Something went wrong; retry');
    
check_errors($errors);