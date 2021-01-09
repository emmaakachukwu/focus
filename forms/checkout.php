<?php

require_once "./../lib/config.php";

if ( !is_logged_in() ) {
    logout();
} else {
    $uuid = $_SESSION['uuid'];
}

if ( !isset($post['type']) || empty($post['type']) )
    array_push($errors, 'something went wrong; retry..');
else
    $type = $post['type'];

check_errors($errors);

$cart = json_decode($_COOKIE['cart']);
$total = 0;
foreach ($cart as $c) {
    $total += $c->price;
}

if ( $type == '1' ) {
    $sql = "SELECT * FROM users WHERE uuid = '$uuid' LIMIT 1";
    $result = $link->query($sql);
    if ( $result->num_rows ) {
        $user = $result->fetch_object();
    } else {
        logout(false);
    }

    if ( $user->balance < $total )
        array_push($errors, 'Your wallet balance is too low to place this order', 'Use the online payment option or go to deposit to top up your balance');

    check_errors($errors);

    $hash = md5($uuid . time() . '...');
    $order_id = substr($hash, 0, 5) . substr($hash, -5, 5);
    $at = date('Y-m-d H:i:s');
    $ok = false;
    foreach ( $cart as $c ) {
        try {
            $sql = $link->prepare("INSERT INTO `orders`(order_id, user_id, product_id, quantity, paid, created_at, updated_at) VALUES (?, ?, ?, ?, true, ?, ?)");
            $sql->bind_param("ssssss", $order_id, $user->id, $c->id, $c->quantity, $at, $at);
            if ( $sql->execute() ) {
                $sql->close();
                $ok = true;
            } else {
                $ok = false;
            }
            $sql->close();
        } catch ( \Exception $err ) {
            $ok = false;
        }
    }

    if ( $ok ) {
        $sql = $link->prepare("UPDATE `users` SET balance=balance-?, updated_at=? WHERE id=?");
        $sql->bind_param("sss", $total, $at, $user->id);
        if ( $sql->execute() ) {
            clear_cookies('cart');

            $_GET['ccart'] = 'true';
            $_SESSION['success'] = ['Order has been saved'];
            on_success('index');
        }
    }
}

array_push($errors, 'Something went wrong; retry');
    
check_errors($errors);