<?php

require_once "./../lib/config.php";

if ( !is_logged_in() ) {
    logout();
} else {
    $uuid = $_SESSION['uuid'];
}

if ( isset($post['type']) && !empty($post['type']) )
    $type = $post['type'];
else if ( isset($_GET['type']) && !empty($_GET['type']) )
    $type = $_GET['type'];
else
    array_push($errors, 'something went wrong; retry..');

if ( isset($_GET['transaction_id']) && !empty($_GET['transaction_id']) )
    $txn_id = $_GET['transaction_id'];
else 
    array_push($errors, 'missing transaction url');

check_errors($errors);

$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart']) : [];
$total = 0;
foreach ($cart as $c) {
    $total += $c->price * $c->quantity;
}

$sql = "SELECT * FROM users WHERE uuid = '$uuid' LIMIT 1";
$result = $link->query($sql);
if ( $result->num_rows ) {
    $user = $result->fetch_object();
} else {
    logout(false);
}

$hash = md5($uuid . time() . '...');
$order_id = substr($hash, 0, 5) . substr($hash, -5, 5);

if ( $type == '1' )
    if ( $user->balance < $total )
        array_push($errors, 'Your wallet balance is too low to place this order', 'Use the online payment option or go to deposit to top up your balance');
    else
        $order_id = substr($hash, 0, 5) . substr($hash, -5, 5);
else if ( $type == '2' )
    if ( !isset($_GET['status']) || $_GET['status'] !== 'successful' )
        array_push($errors, 'Payment not successful');
    else
        $order_id = $txn_id;

check_errors($errors);

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
    if ( $type == '1' ) {
        $sql = $link->prepare("UPDATE `users` SET balance=balance-?, updated_at=? WHERE id=?");
        $sql->bind_param("sss", $total, $at, $user->id);
        if ( !$sql->execute() )
            array_push($errors, 'something went wrong..');
        check_errors($errors);
        $sql->close();
    }

    clear_cookies('cart');
    $_GET['ccart'] = 'true';
    $_SESSION['success'] = ['Order has been saved'];
    on_success('index');
}

array_push($errors, 'Something went wrong; retry');
    
check_errors($errors);